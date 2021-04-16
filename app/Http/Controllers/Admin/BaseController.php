<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
