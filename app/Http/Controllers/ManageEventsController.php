<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Events;

class ManageEventsController extends Controller
{

    protected $events;


    const MESSAGE_REGISTER_END = 'イベント情報を登録しました。';
    const MESSAGE_NOT_FOUND = 'イベントが存在しません。';
    const MESSAGE_UPDATE_END = 'イベントを更新しました。';
    const MESSAGE_DELETE_END = 'イベントを削除しました。';

    private $page_limit = 25;

    /**
     * @param Events $events
     */
    public function __construct(Events $events)
    {
        $this->middleware('auth');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->events = $events;
    }

    protected function validator(array $data)
    {
        $border_date = date('Y-m-d H:i:s', strtotime($data['start_date'] . " -1 second"));

        return \Validator::make($data, [
          'title'      => 'required|max:50',
          'image_path' => 'required|max:256',
          'start_date' => 'required|date',
          'end_date'   => 'required|date|after:' . $border_date,
        ], [
          'title.required'      => 'タイトルは必須項目です。',
          'title.max'           => 'タイトルは50文字以内で入力してください。',
          'image_path.required' => '画像パスは必須項目です。',
          'image_path.max'      => '画像パスは256文字以内で入力してください。',
          'start_date.required' => '開始日は必須項目です。',
          'start_date.date'     => '開始日は日付を入力してください。',
          'end_date.required'   => '終了日は必須項目です。',
          'end_date.date'       => '終了日は日付を入力してください。',
          'end_date.after'      => '終了日は開始日より未来日を入力してください。',
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
        $data = $request->all();

        $query = $this->events->query();

        if (isset($data['title']) && $data['title']) {

            $query->where('title', 'like', '%' . $data['title'] . '%');

        }

        $events = $query->OrderBy("start_date", "desc")->paginate($this->page_limit);

        return view('manage_events.index')->with(compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('manage_events.create');
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
        $this->events->fill($data);
        $this->events->save();

        \Log::info("register new events record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('mevents/')->with('message', self::MESSAGE_REGISTER_END);
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
        $events = $this->events->where('id', '=', $id)->get();

        if (count($events)) {
            return view('manage_events.show')->with(compact('events'));
        }

        return redirect()->to('mevents/')->with('message', self::MESSAGE_NOT_FOUND);
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
        $query = $this->events;

        $event = $query->where('id', '=', $id)->first();

        if (count($event)) {
            return view('manage_events.edit')->with(compact('event'));
        }

        return redirect()->to('mevents')->with('message', self::MESSAGE_NOT_FOUND);
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

        $event = $this->events->where('id', '=', $id)->first();

        if (!count($event)) {
            return redirect()->to('mevents')->with('message', self::MESSAGE_NOT_FOUND);
        }

        $data = $request->all();

        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
            );
        }

        $data['updated_by'] = $this->my_name;

        if (!$data['end_date']) {
            $data['end_date'] = $data['start_date'];
        }
        unset($data['_method']);
        unset($data['_token']);

        $query = $this->events;
        $query->where('id', '=', $id)->update($data);

        \Log::info("update events." . $id . " record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('mevents/')->with('message', self::MESSAGE_UPDATE_END);
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
        $event = $this->events->where('id', '=', $id)->first();

        if (!count($event)) {
            return redirect()->to('users/')->with('message', self::MESSAGE_NOT_FOUND);
        }

        $data["status"] = 0;

        $query = $this->events;

        $query->where('id', '=', $id)->update($data);

        \Log::info("soft delete events." . $id . " record by " . $this->my_name,
          ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('mevents/')->with('message', self::MESSAGE_DELETE_END);

    }

}
