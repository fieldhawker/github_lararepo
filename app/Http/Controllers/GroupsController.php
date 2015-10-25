<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Groups;

/**
 * Class GroupsController
 * @package App\Http\Controllers
 */
class GroupsController extends Controller
{

    const MESSAGE_REGISTER_END = 'グループを登録しました。';
    const MESSAGE_UPDATE_END = 'グループを更新しました。';
    const MESSAGE_DELETE_END = 'グループを削除しました。';
    const MESSAGE_NOT_FOUND = 'グループが存在しません。';

    protected $groups;

    private $page_limit = 25;

    /**
     * @param Groups $groups
     */
    public function __construct(Groups $groups)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->groups = $groups;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
          'name'  => 'required',
          'group' => 'required|unique:groups|digits_between:1,5|numeric',
        ], [
          'name.required'        => '名称は必須項目です。',
          'group.required'       => '管理番号は必須項目です。',
          'group.unique'         => '管理番号は使用済みです。',
          'group.digits_between' => '管理番号は５文字までです。',
          'group.numeric'        => '管理番号は数値で入力してください。',
        ]);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator_update(array $data)
    {
        return \Validator::make($data, [
          'name'  => 'required',
          'group' => 'required|digits_between:1,5|numeric',
        ], [
          'name.required'        => '名称は必須項目です。',
          'group.required'       => '管理番号は必須項目です。',
          'group.digits_between' => '管理番号は５文字までです。',
          'group.numeric'        => '管理番号は数値で入力してください。',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
//		$data = $request->all();

        $query = $this->groups->query();
        $groups = $query->OrderBy("group", "asc")->paginate($this->page_limit);

        return view('groups.index')->with(compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('groups.create');
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

        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['updated_by'] = $this->my_name;

        $this->groups->fill($data);
        $this->groups->save();

        \Log::info("regist new groups record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('groups')->with('message', self::MESSAGE_REGISTER_END);
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
        $groups = $this->groups->where('id', '=', $id)->get();

        if (count($groups)) {
            return view('groups.show')->with(compact('groups'));
        }

        return redirect()->to('groups')->with('message', self::MESSAGE_NOT_FOUND);
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
        $query = $this->groups;
        $group = $query->where('id', '=', $id)->first();

        if (count($group)) {
            return view('groups.edit')->with(compact('group'));
        }

        return redirect()->to('groups')->with('message', self::MESSAGE_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int    $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $groups = $this->groups->where('id', '=', $id)->first();

        if (!count($groups)) {
            return redirect()->to('groups')->with('message', self::MESSAGE_NOT_FOUND);
        }

        $data = $request->all();

        $validator = $this->validator_update($data);
        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['updated_by'] = $this->my_name;
        unset($data['_method']);
        unset($data['_token']);

        $query = $this->groups;
        $query->where('id', '=', $id)->update($data);

        \Log::info("update groups." . $id . " record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('groups')->with('message', self::MESSAGE_UPDATE_END);
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
        $groups = $this->groups->where('id', '=', $id)->first();

        if (!count($groups)) {
            return redirect()->to('groups')->with('message', self::MESSAGE_NOT_FOUND);
        }

        $groups->where('id', '=', $id)->delete();

        return redirect()->to('groups')->with('message', self::MESSAGE_DELETE_END);
    }

}
