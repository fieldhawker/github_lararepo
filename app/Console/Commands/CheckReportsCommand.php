<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\User;

class CheckReportsCommand extends Command
{

    // TODO:DB参照へ変更予定
//    const MAIL_TO = 'soft_grp2@se-project.co.jp';
    const MAIL_TO = 'soft_grp2_chief@se-project.co.jp';
//    const MAIL_TO = 'takano@se-project.co.jp';
    const MAIL_TARGET_GROUP = '50';

    const MAIL_TITLE = '[SEP][%s] 週報未提出者一覧';
    const MAIL_TITLE_PERSON = '[SEP][%s] 今週の週報を提出してください';
    const TARGET_NOT_FOUND = '対象者無し';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'batchCheckReports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    private $week;
    private $start_date;
    private $end_date;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->users = $user;
        $this->week = date("o", strtotime("-1 week")) . "-W" . (date("W", strtotime("-1 week"))); // TODO:外部パラメータへ切り出し予定
        $this->start_date = date("Y/m/d", strtotime("2 weeks ago Monday"));
        $this->end_date = date("Y/m/d", strtotime("last Sunday"));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        \Log::info('---------- ' . $this->name . ' start ----------');

//        $logdir = empty($_SERVER['OPENSHIFT_PHP_LOG_DIR']) ? storage_path() . '/logs/' : $_SERVER['OPENSHIFT_PHP_LOG_DIR'];
//        $logfile = 'check_reports.log';
//        $date = date('Y年m月d日 H時i分s秒') . ' CheckReportsCommand start ' . "\n";
//        file_put_contents("{$logdir}/{$logfile}", $date, FILE_APPEND);

        $comment = '';
        $users = $this->_getUnsentUsers();

        if (count($users) == 0) {
            $comment .= self::TARGET_NOT_FOUND;
        } else {
            foreach ($users as $user) {
                $comment .= $user->name . " : " . $user->email . chr(13);
                \Log::info(' ' . $user->name . " : " . $user->email);

                $data = array('start_date' => $this->start_date, 'end_date' => $this->end_date, 'name' => $user->name);

                \Mail::send([
                  'text'
                  => 'emails.check_reports_person'
                ], $data, function ($message) use ($user) {
                    $message->to($user->email)
                      ->cc(self::MAIL_TO)
                      ->subject(sprintf(self::MAIL_TITLE_PERSON, $this->week));
                });

            }
        }

        $data = array('start_date' => $this->start_date, 'end_date' => $this->end_date, 'comment' => $comment);

        \Mail::send([
          'text'
          => 'emails.check_reports'
        ], $data, function ($message) {
            $message->to(self::MAIL_TO)
              ->subject(sprintf(self::MAIL_TITLE, $this->week));
        });

        \Log::info('---------- ' . $this->name . ' end ----------');
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

    // ========================================================================================

    /**
     * @return mixed
     */
    private function _getUnsentUsers()
    {

        $users = $this->users
          ->leftJoin('reports', function ($join) {
              $join->on('users.key', '=', 'reports.user_key')
                ->where('reports.week', '=', $this->week);
          })
          ->where('users.group', '=', self::MAIL_TARGET_GROUP)
          ->where('users.role', '=', '1')
          ->whereNull('reports.week')
          ->get();

        return $users;
    }

}
