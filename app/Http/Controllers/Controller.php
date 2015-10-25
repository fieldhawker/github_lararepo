<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    protected $user_key;
    protected $admin_user;
    protected $my_name;

    /**
     * @param string $path
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function beforeAuthPage($path = '/home')
    {

        if (\Auth::check()) {

            // 認証済画面の前処理 TODO: middleware化するかauthに統合するか
            \View::share('header_name', \Auth::user()->name);
            \View::share('header_id', \Auth::user()->id);
            \View::share('header_role', \Auth::user()->role);

            $this->admin_user = (\Auth::user()->role > 1) ? true : false;
            $this->my_name = \Auth::user()->name;

            $this->user_key = \Auth::user()->key;

            return;

        } else {

        }

        return redirect()->to($path);
    }

}
