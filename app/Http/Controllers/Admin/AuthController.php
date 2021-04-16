<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;

class AuthController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(){
      return view('admin.auth.login');
    }

    public function postLogin(AdminLoginRequest $request){
      $data = $request->getData();
      $remember = $request->get('remember');
      
      if (auth('admin')->attempt($data, $remember)) {
        return redirect()->route('admin.dashboard');
      }

      return redirect()->back()->withErrors("Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại!");
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth('admin')->logout();

        return redirect()->route('admin.login');
    }
}
