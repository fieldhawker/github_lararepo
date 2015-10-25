<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Information;
use Log;

class InformationsController extends Controller
{

    const MESSAGE_REGISTER_END = '週報を登録しました。';

    /**
     * Create a new controller instance.
     *
     * @param Information $information
     */
    public function __construct(Information $information)
    {
        // ゲストユーザは認証させてから
        $this->middleware('auth');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->informations = $information;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $information = $this->_getLatestInformation();

        return view('informations/create')->with(compact('information'));
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
        $data['updated_by'] = $this->my_name;
        unset($data{'_token'});

        $this->informations->fill($data);
        $this->informations->save();

        Log::info("register new information record by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return redirect()->to('home')->with('message', self::MESSAGE_REGISTER_END);
    }

    /**
     * @return Information
     */
    private function _getLatestInformation()
    {

        $information = $this->informations
          ->orderBy('id', 'desc')
          ->first();

        $information = (isset($information)) ? $information : $this->informations;

        return $information;

    }

}
