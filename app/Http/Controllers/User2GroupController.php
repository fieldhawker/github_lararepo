<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use DB;

class User2GroupController extends Controller
{

    const MESSAGE_PARAMETER_ERROR_END = '入力内容に不正な値が含まれています。';
    const MESSAGE_UPDATE_END = 'グループを更新しました。';

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {

        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['index']]);

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->user = $user;

    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
          'key'   => 'required',
          'group' => 'required|digits_between:1,5',
        ], [
          'key.required'         => 'ユーザーキーは必須項目です。',
          'group.required'       => '管理番号は必須項目です。',
          'group.digits_between' => '管理番号は5桁以内で入力してください。',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->_getUserList();

        return view('user2group.index')->with(compact('users'));
    }

    /**
     * @return Response
     */
    public function create()
    {
        $users = $this->_getUserList();

        return view('user2group.create')->with(compact('users'));
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
        $keys = $data["key"];
        $groups = $data["group"];

        $users = array();

        if (count($keys) != count($groups)) {
            return redirect()->to('user2group/')->with('message', self::MESSAGE_PARAMETER_ERROR_END);
        }

        foreach ($keys as $num => $value) {

            $check_user = array();
            $check_user["key"] = $value;
            $check_user["group"] = $groups[$num];

            $validator = $this->validator($check_user);
            if ($validator->fails()) {
                $this->throwValidationException(
                  $request, $validator
                );
            }

            $user = $this->user
              ->where('key', '=', $check_user['key'])
              ->where('group', '=', $check_user['group'])
              ->get();

            if (!count($user)) {
                $users[] = $check_user;
            }

        }

        DB::transaction(function () use ($users) {

            foreach ($users as $user) {

                $this->user->where('key', '=', $user['key'])->update($user);
                \Log::info("update users record to group by " . $this->my_name,
                  ['file' => __FILE__, 'line' => __LINE__]);

            }

        });

        DB::commit();

        return redirect()->to('user2group/create')->with('message', self::MESSAGE_UPDATE_END);
    }

    private function _getUserList()
    {

        $users = $this->user
          ->select('users.*', 'g.name as gname')
          ->join('groups as g', 'users.group', '=', 'g.group', 'left outer')
          ->OrderBy("group", "asc")
          ->OrderBy("role", "desc")
          ->OrderBy("kana", "asc")->get();

        return $users;
    }
}
