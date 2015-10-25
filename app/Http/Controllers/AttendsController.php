<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Attends;
use App\User;
use App\Http\Requests;
//use App\Http\Requests\PostAttendRequest;
use Auth;
use Validator;

/**
 * Class AttendsController
 * @package App\Http\Controllers
 */
class AttendsController extends Controller
{

    const UPDATED_BY = 'SYSTEM';
    const MESSAGE_REGISTER_END = '勤怠を登録しました。';
    const MESSAGE_UPDATE_END = '勤怠を更新しました。';
    const MESSAGE_DELETE_END = '勤怠を削除しました。';
    const MESSAGE_NOT_FOUND = '対象の勤怠が存在しません。';
    const MESSAGE_OTHER_REPORT = '異なる勤怠は更新できません。';
    const MESSAGE_NOT_SEARCH = '抽出条件をYYYYMM形式で指定してください。';

    protected $attends;
    protected $users;
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

    private $page_limit = 25;
    private $data;

    /**
     * @param Attends|Attend $attend
     *
     */
    public function __construct(Attends $attend)
    {
        $this->middleware('auth');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->attends = $attend;
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
          'type'      => 'required',
          'attend_at' => 'required',
        ], [
          'type.required'      => '勤怠設定は必須項目です。',
          'attend_at.required' => '日付は必須項目です。',
        ]);
    }

    /**
     * @param $date
     *
     * @return $this
     * @internal param Request $request
     *
     */
    public function getJson(Request $request, $date)
    {
        $data["date"] = $date;
        $validator = \Validator::make($data, [
          'date' => 'required|date_format:Y-m',
        ], [
          'date.required'    => '抽出期間は必須項目です。',
          'date.date_format' => '抽出期間はYYYY-MM形式で指定してください。',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $start_date = date("Y-m-d", strtotime($date . '-01'));
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 month'));

        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;

        $attends = $this->_getAttendsList($data);

        if (!count($attends)) {
            return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);
        }

        return \Response::json($attends);
    }

    /**
     * @param $date
     *
     * @return $this
     * @internal param Request $request
     *
     */
    public function getCsv(Request $request, $date)
    {
        $data["date"] = $date;
        $validator = \Validator::make($data, [
          'date' => 'required|date_format:Y-m',
        ], [
          'date.required'    => '抽出期間は必須項目です。',
          'date.date_format' => '抽出期間はYYYY-MM形式で指定してください。',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $start_date = date("Y-m-d", strtotime($date . '-01'));
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 month'));

        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;

        $attends = $this->_getAttendsList($data);

        if (!count($attends)) {
            return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);
        }

        $stream = fopen('php://temp', 'r+b');
        foreach ($attends as $attend) {
            $attend["type"] = $this->attend_type[$attend["type"]];
            fputcsv($stream, $attend->toArray());
        }
        rewind($stream);

        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $headers = array(
          'Content-Type'        => 'text/csv',
          'Content-Disposition' => 'attachment; filename="attend_' . $date . '.csv"',
        );

        return \Response::make($csv, 200, $headers);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function getIndex(Request $request)
    {
        $data = $request->all();
        if (empty($data['user_key'])) {
            $data['user_key'] = '';
        }

        $attends = $this->_getAttendsList($data);
        $users = $this->users->OrderBy("kana", "asc")->get();

        return view('attends.index')->with(compact('attends', 'users', 'data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {

        $attend = (isset($attend)) ? $attend : $this->attends;
        $users = $this->users->OrderBy("kana", "asc")->get();

        return view('attends.create')->with(compact('attend', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function postCreate(Request $request)
    {

        $this->data = $request->all();

        $validator = $this->validator($this->data);

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $this->data['user_key'] = (isset($this->data['user_key'])) ? $this->data['user_key'] : $this->user_key;

        $this->data['updated_by'] = \Auth::user()->name;
        unset($this->data{'_token'});

        $this->attends->fill($this->data);
        $this->attends->save();

        \Log::info("register new attends record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('attends')->with('message', self::MESSAGE_REGISTER_END);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function getShow($id)
    {

        $attend = $this->_getAttendById($id);

        if (count($attend)) {
            return view('attends.show')->with(compact('attend'));
        }

        return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function getEdit($id)
    {

        $attend = $this->_getAttendById($id);
        $users = $this->users->OrderBy("kana", "asc")->get();

        if (count($attend)) {
            return view('attends.edit')->with(compact('attend', 'users'));

        }

        return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);

    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $id
     *
     */
    public function postStore(Request $request)
    {
        $this->data = $request->all();

        $validator = $this->validator($this->data);

        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $this->data['user_key'] = (isset($this->data['user_key'])) ? $this->data['user_key'] : $this->user_key;

        $this->data['updated_by'] = \Auth::user()->name;
        unset($this->data['_token']);
        unset($this->data['_method']);

        $updated = $this->_updateAttendById();

        if ($updated) {
            \Log::info("update attends." . $this->data['id'] . " record by " . $this->my_name,
              ['file' => __FILE__, 'line' => __LINE__]);

            return redirect()->to('attends')->with('message', self::MESSAGE_UPDATE_END);
        }

        return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);

    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDestroy($id)
    {

        $attend = $this->_getAttendById($id);

        if (count($attend)) {

            $attend->where('id', '=', $id)->delete();

            return redirect()->to('attends')->with('message', self::MESSAGE_DELETE_END);

        }

        return redirect()->to('attends')->with('message', self::MESSAGE_NOT_FOUND);

    }


    /////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param $data
     *
     * @return mixed
     * @internal param $request
     *
     */
    private function _getAttendsList($data)
    {

        $query = $this->attends->select('attends.*', 'u.name as uname', 'u.kana as ukana');
        $query->join('users as u', 'attends.user_key', '=', 'u.key', 'left outer');

        if (!$this->admin_user) {

            $query->where('user_key', $this->user_key);

        }

        if (isset($data['user_key']) && $data['user_key']) {

            $query->where('user_key', '=', $data['user_key']);

        }

        if (isset($data['start_date']) && $data['start_date']) {

            $query->whereBetween('attend_at', array($data['start_date'], $data['end_date']));

            return $query->OrderBy("attend_at", "desc")->OrderBy("ukana", "asc")->get();

        }

        return $query->OrderBy("attend_at", "desc")->OrderBy("ukana", "asc")->paginate($this->page_limit);

    }

    /**
     * @return mixed
     */
    private function _getSelectQuery()
    {

        $query = $this->attends->select('attends.*', 'u.name as uname');
        $query->join('users as u', 'attends.user_key', '=', 'u.key', 'left outer');

        return $query;
    }

    /**
     * @return Attend
     */
    private function _getLatestAttend()
    {

        $attend = $this->attends
          ->where('user_key', '=', $this->user_key)
          ->orderBy('attend_at', 'desc')
          ->first();

        $attend = (isset($attend)) ? $attend : $this->attends;

        return $attend;

    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    private function _getAttendById($id = 0)
    {

        $query = $this->_getSelectQuery();

        if (!$this->admin_user) {

            $query = $query->where('user_key', '=', $this->user_key);

        }

        $attend = $query->where('attends.id', '=', $id)->first();

        return $attend;
    }

    /**
     * @return mixed
     * @internal param $data
     *
     */
    private function _updateAttendById()
    {

        if (!$this->admin_user) {

            $this->attends->where('user_key', '=', $this->user_key);

        }

        return $this->attends->where('id', '=', $this->data['id'])->update($this->data);

    }


}

