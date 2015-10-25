<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Events;
use Auth;
use Goutte\Client;

class UsersController extends Controller
{

    const UPDATED_BY = 'SYSTEM';
    const MESSAGE_REGISTER_END = '社員情報を登録しました。';
    const MESSAGE_UPDATE_END = '社員情報を更新しました。';
    const MESSAGE_DELETE_END = '社員情報を削除しました。';
    const MESSAGE_MEMBER_NOT_FOUND = '更新対象の社員が存在しません。';
    const MESSAGE_OTHER_MEMBER = '他の人の情報は更新できません。';

    protected $user;
    private   $page_limit = 25;
    private   $ins;
    private   $count;
    private   $events;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {

        $this->middleware('auth');
        // index show edit update 以外はADMINのみ接続可能
        $this->middleware('admin', ['except' => ['index', 'show', 'edit', 'update']]);

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->user = $user;
        $this->ins = array();
        $this->count = 0;
        $this->events = new Events();

    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
          'name' => 'required|max:12',
          'kana' => 'required|max:12',
        ], [
          'name.required' => '名前は必須項目です。',
          'name.max'      => '名前は１２文字以内で入力してください。',
          'kana.required' => 'カナは必須項目です。',
          'kana.max'      => 'カナは１２文字以内で入力してください。'
        ]);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator_ins(array $data)
    {
        return \Validator::make($data, [
          'name'     => 'required|max:12',
          'kana'     => 'required|max:12',
          'password' => 'required|alpha_dash',
          'email'    => 'required|email|unique:users',
        ], [
          'name.required'       => '名前は必須項目です。',
          'name.max'            => '名前は１２文字以内で入力してください。',
          'kana.required'       => 'カナは必須項目です。',
          'kana.max'            => 'カナは１２文字以内で入力してください。',
          'password.required'   => 'パスワードは必須項目です。',
          'password.alpha_dash' => 'パスワードは英数-_で入力してください。',
          'email.required'      => 'メールアドレスは必須項目です。',
          'email.email'         => 'メールアドレスを入力してください。',
          'email.unique'        => 'メールアドレスが重複しています。',
        ]);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $query = $this->user->select('users.*', 'g.name as gname');
        $query->join('groups as g', 'users.group', '=', 'g.group', 'left outer');

        if (!$this->admin_user) {

            $query = $query->where('status', true);

        }

        if (isset($data['name']) && $data['name']) {

            $query->where('name', 'like', '%' . $data['name'] . '%');

        }

        $users = $query->OrderBy("kana", "asc")->paginate($this->page_limit);

// GOUTTE TEST
//        $client = new Client();
//
//        // Get Data Source
//        $crawler = $client->request('GET', "http://se-project.co.jp/corp/info/date_title.php");
//
//        $crawler->filter('.short_list dl')->each(function ($node) {
//            $this->ins[$this->count]['start_date'] = $node->filter('dt')->text();
//            $this->ins[$this->count]['end_date'] = $this->ins[$this->count]['start_date'];
//            $this->ins[$this->count]['title'] = $node->filter('dd')->text();
//            $this->ins[$this->count]['article_url'] = 'http://http://se-project.co.jp'.$node->filter('dd a')->attr('href');
//            $this->ins[$this->count]['status'] = 1;
//            $this->ins[$this->count]['image_path'] = 'http://se-project.co.jp/images/logo_header.png';
//            $this->ins[$this->count]['site_id'] = 'SEP';
//            $this->ins[$this->count]['updated_by'] = 'CRON';
//            $this->count++;
//        });
//
//        \DB::transaction(function() {
//
//            $this->events->where('site_id', 'SEP')->delete();
//
//            foreach ($this->ins as $ins) {
//               $this->events->insert($ins);
//            }
//        });
//
//        \DB::commit();

        return view('users.index')->with(compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
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

        $data = $request->all();

        $validator = $this->validator_ins($data);
        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['key'] = sha1(uniqid(null, true));
        $data['password'] = \Hash::make($data['password']);
        $data['updated_by'] = $this->my_name;

        $this->user->fill($data);
        $this->user->save();

        \Log::info("regist new users record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('users/')->with('message', self::MESSAGE_REGISTER_END);
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
        $query = $this->user->select('users.*', 'g.name as gname');
        $query->join('groups as g', 'users.group', '=', 'g.group', 'left outer');

        if (!$this->admin_user) {

            $query = $query->where('key', '=', $this->user_key);

        }

        $users = $query->where('users.id', '=', $id)->get();

        if (count($users)) {
            return view('users.show')->with(compact('users'));
        }

        return redirect()->to('users')->with('message', self::MESSAGE_MEMBER_NOT_FOUND);
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
        $query = $this->user;

        if (!$this->admin_user) {

            $query = $query
              ->where('key', '=', $this->user_key);

        }

        $user = $query->where('id', '=', $id)->first();

        // TODO: 確認画面用にuser_keyをセッションに追加

        if (count($user)) {
            return view('users.edit')->with(compact('user'));
        }

        return redirect()->to('users')->with('message', self::MESSAGE_MEMBER_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // TODO: 確認画面用にuser_keyをセッションから取得

        $user = $this->user->where('id', '=', $id)->first();

        // TODO: 確認画面用にuser_keyをセッションに追加

        if (!count($user)) {
            return redirect()->to('users')->with('message', self::MESSAGE_MEMBER_NOT_FOUND);
        }

        if (!$this->admin_user && $user['key'] != $this->user_key) {
            return redirect()->to('users')->with('message', self::MESSAGE_OTHER_MEMBER);
        }

        $data = $request->all();

        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['updated_by'] = $this->my_name;
        unset($data['_method']);
        unset($data['_token']);

        $query = $this->user;

        if (!$this->admin_user) {
            $query = $query
              ->where('key', '=', $this->user_key);
        }
        $query->where('id', '=', $id)->update($data);

        \Log::info("update users." . $id . " record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('users/')->with('message', self::MESSAGE_UPDATE_END);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->user->where('id', '=', $id)->first();

        if (!count($user)) {
            return redirect()->to('users/')->with('message', self::MESSAGE_MEMBER_NOT_FOUND);
        }

        //$user->where('id', '=', $id)->delete();
        $data["status"] = 0;

        $query = $this->user;

        if (!$this->admin_user) {
            $query = $query
              ->where('key', '=', $this->user_key);
        }
        $query->where('id', '=', $id)->update($data);

        \Log::info("soft delete users." . $id . " record by " . $this->my_name,
          ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('users/')->with('message', self::MESSAGE_DELETE_END);
    }

}
