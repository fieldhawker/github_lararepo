<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Attends;

class ExportMonthlyAttendsCommand extends Command
{

    protected $mail_to = array(
      'takayama@se-project.co.jp ',
      'fukuishuuhei@se-project.co.jp',
      'soft_grp2_chief@se-project.co.jp',
      //      'takano@se-project.co.jp',
      //      'fieldhawker@gmail.com',
      //      'soft_grp2_chief@se-project.co.jp',
    );

    const MAIL_TITLE = '[SEP] 月次勤怠情報';

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

    private $attends;

    protected $name = 'batchExportMonthlyAttends';

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

        $argument = $this->argument();

        // 書式チェックして不正ならばNULLに

        $target_month = (isset($argument['yyyy-mm']) && $argument['yyyy-mm'])
          ? $argument['yyyy-mm'] : date('Y-m', strtotime(date('Y-m-1') . '-1 month'));

        $attends = $this->_getAttendsUsers($target_month);

        if (count($attends) == 0) {

            \Log::info('---------- ' . $this->name . ' not found ----------');
            exit;

        }

        $data = array();

        \Mail::send([
          'text'
          => 'emails.export_monthly_attends'
        ], $data, function ($message) use ($attends) {

            $csvPath = public_path() . '/report.csv';
            $stream = fopen($csvPath, 'w');

            $title = array('名前', '日付', '勤怠');
            mb_convert_variables('SJIS-win', 'UTF-8', $title);
            fputcsv($stream, $title);

            foreach ($attends as $attend) {
                $attend["type"] = $this->attend_type[$attend["type"]];
                $attend["attend_at"] = date('Y-m-d', strtotime($attend["attend_at"]));

                mb_convert_variables('SJIS-win', 'UTF-8', $attend);
                fputcsv($stream, $attend->toArray());

            }

            fclose($stream);

            $message->to($this->mail_to)
              ->attach($csvPath)
              ->subject(sprintf(self::MAIL_TITLE));
        });

        \Log::info('---------- ' . $this->name . ' export ----------');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
          ['yyyy-mm', InputArgument::OPTIONAL, '指定の月を抽出する範囲とする(Y-m)'],
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
     * @param $target_month
     *
     * @return mixed
     */
    private function _getAttendsUsers($target_month)
    {

        $firstDate = date('Y-m-d 00:00:00', strtotime('first day of ' . $target_month));
        $lastDate = date('Y-m-d 23:59:59', strtotime('last day of ' . $target_month));

        $attends = $this->attends
          ->select('users.name as uname', 'attends.attend_at', 'attends.type')
          ->leftJoin('users', function ($join) {
              $join->on('users.key', '=', 'attends.user_key');
          })
          ->whereBetween('attends.updated_at', array($firstDate, $lastDate))
          ->orderBy('attends.attend_at', 'asc')
          ->orderBy('users.kana', 'asc')
          ->get();

        return $attends;
    }

}
