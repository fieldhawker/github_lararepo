<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;
use Log;

use Goutte\Client;
use App\Events;


class GetArmyInfoCommand extends Command
{

    protected $events;
    protected $client;

    private $ins;
    private $count;

    const REQUEST_URL = "http://www.mod.go.jp/j/publication/events/map/index.html";

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'batchGetArmyInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->events = new Events();
        $this->client = new Client();

        $this->ins = array();
        $this->count = 0;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        Log::info('---------- ' . $this->name . ' start ----------');

        $crawler = $this->client->request('GET', self::REQUEST_URL);

        $crawler->filter('#ibaraki tbody tr')->each(function ($node) {
            $this->_getEventParam($node);
        });
        $crawler->filter('#chiba tbody tr')->each(function ($node) {
            $this->_getEventParam($node);
        });
        $crawler->filter('#tokyo tbody tr')->each(function ($node) {
            $this->_getEventParam($node);
        });
        $crawler->filter('#kanagawa tbody tr')->each(function ($node) {
            $this->_getEventParam($node);
        });

        if (count($this->ins) > 0) {

            Log::info('GetArmyInfoCommand import : ' . print_r($this->ins, true));

            DB::transaction(function () {

                $this->events->where('site_id', 'ARMY')->delete();

                foreach ($this->ins as $ins) {
                    $this->events->insert($ins);
                }
            });

            DB::commit();
        }

        Log::info('---------- ' . $this->name . ' end ----------');
    }

//	/**
//	 * Get the console command arguments.
//	 *
//	 * @return array
//	 */
//	protected function getArguments()
//	{
//		return [
//			['example', InputArgument::REQUIRED, 'An example argument.'],
//		];
//	}

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
          ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    /**
     * @param $node
     *
     */
    private function _getEventParam($node)
    {
        $ins_time = date("Y-m-d H:i:s");

        $string_date = $node->filter('.e_date')->text();
        preg_match("/^([0-9]*)月([0-9]*)日.*/", $string_date, $data); //TODO:期間が範囲のものは別途対応が必要

        $this->ins[$this->count]['start_date']
          = sprintf("%04.4d-%02.2d-%02.2d 00:00:00", date("Y"), $data[1], $data[2]);    // TODO:年をまたいだらアウト

        $this->ins[$this->count]['end_date'] = $this->ins[$this->count]['start_date'];
        $this->ins[$this->count]['title'] = $node->filter('.e_name')->text();
        $this->ins[$this->count]['place'] = $node->filter('.e_place')->text();

        $anchors = $node->filter('.e_name a');
        $cnt = count($anchors);
        if ($cnt !== 0) {
            for ($i = 0; $i < $cnt; $i++) {
                $anchor = $anchors->eq($i);
                $this->ins[$this->count]['article_url'] = $anchor->attr('href');
            }
        }
        //$this->ins[$this->count]['article_url'] = $node->filter('.e_name a')->attr('href');
        $this->ins[$this->count]['status'] = 1;
        $this->ins[$this->count]['image_path'] = 'http://placehold.jp/800x200.png';
        $this->ins[$this->count]['site_id'] = 'ARMY';
        $this->ins[$this->count]['created_at'] = $ins_time;
        $this->ins[$this->count]['updated_at'] = $ins_time;
        $this->ins[$this->count]['updated_by'] = 'CRON';
        $this->count++;

        return;
    }
}
