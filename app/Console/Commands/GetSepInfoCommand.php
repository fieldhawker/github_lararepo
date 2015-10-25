<?php namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Log;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Goutte\Client;
use App\Events;

class GetSepInfoCommand extends Command
{
    const REQUEST_URL = "http://se-project.co.jp/corp/info/date_title.php";

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'batchGetSepInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'xxxxxxxxxxxxxxxxxx';

    protected $events;
    protected $client;

    private $ins;
    private $count;

    /**
     * Create a new command instance.
     *
     * @param Events $events
     */
    public function __construct(Events $events)
    {
        parent::__construct();
        $this->events = $events;
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

        $crawler->filter('.short_list dl')->each(function ($node) {

            $ins_time = date("Y-m-d H:i:s");

            $this->ins[$this->count]['start_date'] = $node->filter('dt')->text();
            $this->ins[$this->count]['end_date'] = $this->ins[$this->count]['start_date'];
            $this->ins[$this->count]['title'] = $node->filter('dd')->text();
            $this->ins[$this->count]['article_url'] = 'http://se-project.co.jp' . $node->filter('dd a')->attr('href');
            $this->ins[$this->count]['status'] = 1;
            $this->ins[$this->count]['image_path'] = 'http://se-project.co.jp/images/logo_header.png';
            $this->ins[$this->count]['place'] = 'SEP';
            $this->ins[$this->count]['site_id'] = 'SEP';
            $this->ins[$this->count]['created_at'] = $ins_time;
            $this->ins[$this->count]['updated_at'] = $ins_time;
            $this->ins[$this->count]['updated_by'] = 'CRON';
            $this->count++;

        });

        if (count($this->ins) > 0) {

            Log::info('GetSepInfoCommand import : ' . print_r($this->ins, true));

            DB::transaction(function () {

                $this->events->where('site_id', 'SEP')->delete();

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
}
