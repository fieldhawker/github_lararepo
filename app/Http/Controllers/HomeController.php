<?php namespace App\Http\Controllers;

use App\Information;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        // ゲストユーザは認証させてから
        $this->middleware('auth');

        // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
        Controller::beforeAuthPage();

        $this->informations = new Information;

    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $information = $this->_getLatestInformation();
        \Log::info("view home page by " . $this->my_name, ['file' => __FILE__, 'line' => __LINE__]);

        return view('home')->with(compact('information'));
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
