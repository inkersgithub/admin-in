<?php

namespace Adminin\Admin\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\User;

class AdminController extends BaseController
{
    public function adminLogout()
    {

        Auth::logout();

        return redirect(url('admin/auth/login'));
    }

    public function index()
    {

        return $this->view('pages.dashboard');
    }


}