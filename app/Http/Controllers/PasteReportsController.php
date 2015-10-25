<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Report;
use App\User;

class PasteReportsController extends Controller
{

    const MESSAGE_REGISTER_END = '週報を登録しました。';
    const MESSAGE_ALREADY_END = 'その週は既に登録されています。';
    const PLACE_TITLE_MESSAGE = '1.出向場所（駅名等）';
    const WORK_TITLE_MESSAGE = '2.今週の作業内容';
    const REPORT_TITLE_MESSAGE = '3.報告事項';
    const SALES_TITLE_MESSAGE = '4.営業情報';
    const END_TITLE_MESSAGE = '以上よろしくお願いします。';

    protected $reports;
    protected $users;

    private $default_message = <<< EOF
1.出向場所（駅名等）
XXXX

2.今週の作業内容
XXXX

3.報告事項
XXXX

4.営業情報
XXXX

以上よろしくお願いします。
EOF;

    /**
     * @param Report $report
     *
     * @internal param Report $reports
     */
    public function __construct(Report $report)
    {
        $this->middleware('auth');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->reports = $report;
        $this->users = new User;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
          'week'    => 'required',
          'station' => 'required',
          'place'   => 'required',
          'work'    => 'required',
          'report'  => 'required',
          'sales'   => 'required',
        ], [
          'week.required'    => '週は必須項目です。',
          'station.required' => '最寄駅は必須項目です。',
          'place.required'   => '出向先は必須項目です。',
          'work.required'    => '業務内容は必須項目です。',
          'report.required'  => '報告事項は必須項目です。',
          'sales.required'   => '営業情報は必須項目です。',
        ]);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator_input(array $data)
    {
        return \Validator::make($data, [
          'week' => 'required',
          'work' => 'required',
        ], [
          'week.required' => '週は必須項目です。',
          'work.required' => '業務内容は必須項目です。',
        ]);
    }

//	/**
//	 * Display a listing of the resource.
//	 *
//	 * @return Response
//	 */
//	public function index()
//	{
//		//
//	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users = $this->users->OrderBy("kana", "asc")->get();
        $message = $this->default_message;

        return view('pastereports.create')->with(compact('users', 'message'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data["week"] = $this->_asWeek($data["week"]);

        $validator = $this->validator_input($data);
        if ($validator->fails()) {

            $this->throwValidationException(
              $request, $validator
            );
        }

        $start_point = mb_strpos($data["work"], self::PLACE_TITLE_MESSAGE);
        if ($start_point) {
            $data["work"] = mb_substr($data["work"], $start_point);
        }

        $end_point = mb_strpos($data["work"], self::END_TITLE_MESSAGE);
        if ($end_point) {
            $data["work"] = mb_substr($data["work"], 0, $end_point);
        }

        $tmp_str = $data["work"];
        $data["work"] = '';

        $place_num = mb_strpos($tmp_str, self::PLACE_TITLE_MESSAGE);
        $work_num = mb_strpos($tmp_str, self::WORK_TITLE_MESSAGE);
        $report_num = mb_strpos($tmp_str, self::REPORT_TITLE_MESSAGE);
        $sales_num = mb_strpos($tmp_str, self::SALES_TITLE_MESSAGE);


        $tmp_str = explode(self::SALES_TITLE_MESSAGE, $tmp_str);

        if ($sales_num !== false) {
            $data["sales"] = trim($tmp_str[1]);
        }

        $tmp_str = $tmp_str[0];

        $tmp_str = explode(self::REPORT_TITLE_MESSAGE, $tmp_str);

        if ($report_num !== false) {
            $data["report"] = trim($tmp_str[1]);
        }

        $tmp_str = $tmp_str[0];

        $tmp_str = explode(self::WORK_TITLE_MESSAGE, $tmp_str);

        if ($work_num !== false) {
            $data["work"] = trim($tmp_str[1]);
        }

        $tmp_str = $tmp_str[0];

        $tmp_str = explode(self::PLACE_TITLE_MESSAGE, $tmp_str);

        if ($place_num !== false) {
            $data["station"] = trim($tmp_str[1]);
            $data["place"] = trim($tmp_str[1]);
        }

        $validator = $this->validator($data);
        if ($validator->fails()) {

            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['user_key'] = (isset($data['user_key'])) ? $data['user_key'] : $this->user_key;

        if ($validator = $this->_checkSameReport($data)) {
            return redirect()->back()
              ->withErrors($validator)
              ->withInput();
        }

        $data['updated_by'] = \Auth::user()->name;
        unset($data{'_token'});

        $this->reports->fill($data);
        $this->reports->save();

        \Log::info("register new pastereports record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('pastereports/create')->with('message', self::MESSAGE_REGISTER_END);

    }

//	/**
//	 * Display the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function show($id)
//	{
//		//
//	}
//
//	/**
//	 * Show the form for editing the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function edit($id)
//	{
//		//
//	}
//
//	/**
//	 * Update the specified resource in storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function update($id)
//	{
//		//
//	}
//
//	/**
//	 * Remove the specified resource from storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function destroy($id)
//	{
//		//
//	}

    private function _asWeek($date)
    {
        return date('Y', strtotime($date)) . "-W" . date('W', strtotime($date));
    }

    /**
     * @param $data
     *
     * @return bool|\Illuminate\Validation\Validator
     */
    private function _checkSameReport($data)
    {

        $validator = \Validator::make($data, [
          'week' => 'unique:reports,week,null,week,user_key,' . $data['user_key'],
        ], [
          'unique' => self::MESSAGE_ALREADY_END,
        ]);

        if ($validator->fails()) {

            return $validator;
        }

        return false;

    }

}
