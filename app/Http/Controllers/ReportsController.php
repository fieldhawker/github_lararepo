<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Report;
use App\User;
use App\Http\Requests;
use App\Http\Requests\PostReportRequest;
use Auth;
use Validator;

/**
 * Class ReportsController
 * @package App\Http\Controllers
 */
class ReportsController extends Controller
{

    const UPDATED_BY = 'SYSTEM';
    const MESSAGE_REGISTER_END = '週報を登録しました。';
    const MESSAGE_UPDATE_END = '週報を更新しました。';
    const MESSAGE_DELETE_END = '週報を削除しました。';
    const MESSAGE_REPORT_NOT_FOUND = '更新対象の週報が存在しません。';
    const MESSAGE_OTHER_REPORT = '異なる週報は更新できません。';

    protected $reports;
    protected $users;

    private $page_limit = 25;
    private $data;

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
          //            'language' => 'required',
          'report'  => 'required',
          'sales'   => 'required',
        ], [
          'week.required'    => '週は必須項目です。',
          'station.required' => '最寄駅は必須項目です。',
          'place.required'   => '出向先は必須項目です。',
          'work.required'    => '業務内容は必須項目です。',
          //            'language.required' => '使用言語は必須項目です。',
          'report.required'  => '報告事項は必須項目です。',
          'sales.required'   => '営業情報は必須項目です。',
        ]);
    }

    /**
     * @return bool
     */
    protected function _isMonday()
    {
        $datetime = new \DateTime($this->data["week"]);
        $week = $datetime->format('w');

        return ($week != '1') ? true : false;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (empty($data['user_key'])) {
            $data['user_key'] = '';
        }
        if (empty($data['week'])) {
            $data['week'] = '';
        }

        $reports = $this->_getReportsList($data);
        $users = $this->users->OrderBy("kana", "asc")->get();
        $weeks = $this->reports->select('reports.week')->distinct()->OrderBy("week", "desc")->get();

        return view('reports.index')->with(compact('reports', 'users', 'data', 'weeks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $report = $this->_getLatestReport();
        $users = $this->users->OrderBy("kana", "asc")->get();

        return view('reports.create')->with(compact('report', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->data = $request->all();

        $validator = $this->validator($this->data);

        $validator->after(function ($validator) {
            if ($this->_isMonday()) {
                $validator->errors()->add('week', '週は月曜日を指定してください。');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $this->data["week"] = $this->_asWeek($this->data["week"]);
        $this->data['user_key'] = (isset($this->data['user_key'])) ? $this->data['user_key'] : $this->user_key;

        if ($validator = $this->_checkSameReport()) {

            return redirect()->back()
              ->withErrors($validator)
              ->withInput();

        }

        $this->data['updated_by'] = \Auth::user()->name;
        unset($this->data{'_token'});

        $this->reports->fill($this->data);
        $this->reports->save();

        \Log::info("register new reports record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('reports')->with('message', self::MESSAGE_REGISTER_END);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $report = $this->_getReportById($id);

        if (count($report)) {
            return view('reports.show')->with(compact('report'));
        }

        return redirect()->to('reports')->with('message', self::MESSAGE_REPORT_NOT_FOUND);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $report = $this->_getReportById($id);
        $users = $this->users->OrderBy("kana", "asc")->get();

        if (count($report)) {
            return view('reports.edit')->with(compact('report', 'users'));

        }

        return redirect()->to('reports')->with('message', self::MESSAGE_REPORT_NOT_FOUND);

    }


    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->data = $request->all();

        $validator = $this->validator($this->data);

        $validator->after(function ($validator) {
            if ($this->_isMonday()) {
                $validator->errors()->add('week', '週は月曜日を指定してください。');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $this->data["week"] = $this->_asWeek($this->data["week"]);
        $this->data['user_key'] = (isset($this->data['user_key'])) ? $this->data['user_key'] : $this->user_key;

//        if ($validator = $this->_checkSameReport($data)) {
//
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//
//        }

        $this->data['updated_by'] = \Auth::user()->name;
        $this->data['id'] = $id;
        unset($this->data['_token']);
        unset($this->data['_method']);

        $updated = $this->_updateReportById();

        if ($updated) {
            \Log::info("update reports." . $id . " record by " . $this->my_name,
              ['file' => __FILE__, 'line' => __LINE__]);

            return redirect()->to('reports')->with('message', self::MESSAGE_UPDATE_END);
        }

        return redirect()->to('reports')->with('message', self::MESSAGE_REPORT_NOT_FOUND);

    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->to('reports');

//        $report = $this->_getReportById($id);
//
//        if (count($report)) {
//
//            $report->where('id', '=', $id)->delete();
//            return redirect()->to('reports')->with('message', self::MESSAGE_DELETE_END);
//
//        }
//        return redirect()->to('reports')->with('message', self::MESSAGE_REPORT_NOT_FOUND);

    }


    /////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param $date
     *
     * @return string
     */
    private function _asWeek($date)
    {
        return date('Y', strtotime($date)) . "-W" . date('W', strtotime($date));
    }

    /**
     * @param $week
     *
     * @return bool|string
     */
    private function _asDate($week)
    {
        $weeks = explode("-W", $week);

        $date_string = $weeks[0] . "-01-01";
        $add_day = ((int)$weeks[1] * 7) - (int)date_format(date_create($date_string), 'w') - 6;
        $date_string = $date_string . " +" . $add_day . " day";

        return date('Y-m-d', strtotime($date_string));
    }

    /**
     * @param $data
     *
     * @return mixed
     * @internal param $request
     *
     */
    private function _getReportsList($data)
    {

        $query = $this->reports->select('reports.*', 'u.name as uname', 'u.kana as ukana');
        $query->join('users as u', 'reports.user_key', '=', 'u.key', 'left outer');

        if (!$this->admin_user) {

            $query->where('user_key', $this->user_key);

        }

        if (isset($data['user_key']) && $data['user_key']) {

            $query->where('user_key', '=', $data['user_key']);

        }

        if (isset($data['week']) && $data['week']) {

            $query->where('week', '=', $data['week']);

        }

        return $query
          ->OrderBy("week", "desc")
          ->OrderBy("status", "asc")
          ->OrderBy("ukana", "asc")
          ->paginate($this->page_limit);

    }

    /**
     * @return mixed
     */
    private function _getSelectQuery()
    {

        $query = $this->reports->select('reports.*', 'u.name as uname');
        $query->join('users as u', 'reports.user_key', '=', 'u.key', 'left outer');

        return $query;
    }

    /**
     * @return Report
     */
    private function _getLatestReport()
    {

        $report = $this->reports
          ->where('user_key', '=', $this->user_key)
          ->orderBy('week', 'desc')
          ->first();

        $report = (isset($report)) ? $report : $this->reports;
//        $report["week"] = date("o") . "-W" . (date("W") - 1);
        $report["week"] = date("Y-m-d", strtotime("last Monday"));

        return $report;

    }

    /**
     * @return bool|\Illuminate\Validation\Validator
     * @internal param $data
     *
     */
    private function _checkSameReport()
    {

        $validator = Validator::make($this->data, [
          'week' => 'unique:reports,week,null,week,user_key,' . $this->data['user_key'],
        ], [
          'unique' => 'その週は既に登録されています。',
        ]);

        if ($validator->fails()) {

            return $validator;
        }

        return false;

    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    private function _getReportById($id = 0)
    {

        $query = $this->_getSelectQuery();

        if (!$this->admin_user) {

            $query = $query->where('user_key', '=', $this->user_key);

        }

        $report = $query->where('reports.id', '=', $id)->first();

        $report["week"] = $this->_asDate($report["week"]);

        return $report;
    }

    /**
     * @return mixed
     * @internal param $data
     *
     */
    private function _updateReportById()
    {

        if (!$this->admin_user) {

            $this->reports->where('user_key', '=', $this->user_key);

        }

        return $this->reports->where('id', '=', $this->data['id'])->update($this->data);

    }


}

