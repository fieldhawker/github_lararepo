<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\User;
use App\Attends;

/**
 * Class CheckAttendsCommand
 * @package App\Console\Commands
 */
class CheckAttendsCommand extends Command
{

    // TODO:DB参照へ変更予定
    const MAIL_TO = 'soft_grp2_chief@se-project.co.jp';
//    const MAIL_TO = 'takano@se-project.co.jp';
    const MAIL_TITLE = '[SEP] 勤怠連絡情報一覧';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'batchCheckAttends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    protected $attend_type = array(
      '1' => '有給（全休）',
      '2' => '有給（午前半休）',
      '3' => '有給（午後半休）',
      '4' => '欠勤',
      '5' => '遅刻',
      '6' => '早退',
      '7' => '代休（全休）',
      '8' => '代休（午前半休）',
      '9' => '代休（午後半休）'
    );

    /**
     * @var Attends
     */
    private $attends;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->attends = new Attends;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        \Log::info('---------- ' . $this->name . ' start ----------');

        $comment = '';

        $argument = $this->argument();
        $end_date = (isset($argument['end_date']) && $argument['end_date']) ? $argument['end_date'] : date('Y-m-d H:i:s');
        $attends = $this->_getAttendsUsers($end_date);

        if (count($attends) == 0) {

            \Log::info('---------- ' . $this->name . ' not found ----------');
            exit;

        } else {
            foreach ($attends as $attend) {
                $comment .= "[" . date('Y-m-d',
                    strtotime($attend->attend_at)) . "] " . $attend->name . " : " . $this->attend_type[$attend->type] . chr(13);
                \Log::info(' ' . $attend->name);
            }
        }

        $data = array('comment' => $comment);

        \Mail::send([
          'text'
          => 'emails.check_attends'
        ], $data, function ($message) {
            $message->to(self::MAIL_TO)
              ->subject(sprintf(self::MAIL_TITLE));
        });

        \Log::info('---------- ' . $this->name . ' end ----------');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
          ['end_date', InputArgument::OPTIONAL, 'ここから２４時間前までを抽出する範囲とする(Y-m-d H:i:s)'],
          //          ['argument1', InputArgument::REQUIRED, '引数の説明・・・必須'],
        ];
    }

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

    // ========================================================================================

    /**
     * @return mixed
     */
    private function _getAttendsUsers($end_date)
    {

        $start_date = date('Y-m-d H:i:s', strtotime($end_date . ' -1 day'));

        $attends = $this->attends
          ->leftJoin('users', function ($join) {
              $join->on('users.key', '=', 'attends.user_key');
          })
          ->whereBetween('attends.updated_at', array($start_date, $end_date))
          ->orderBy('attends.attend_at', 'desc')
          ->orderBy('users.kana', 'asc')
          ->get();

        return $attends;
    }

}
