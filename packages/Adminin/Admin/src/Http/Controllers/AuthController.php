<?php


namespace Adminin\Admin\Http\Controllers;

use App\Common\Roles;
use Illuminate\Http\Request;
use Input;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\User;
use App\LogDetails;
use App\Loghistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    ######################################## Code to display the login pages ############################################
    public function adminGetLogin()
    {
     return $this->view('auth.login');
    }

    ######################################## Code for authentication post login ########################################
    public function adminPostLogin(Request $request)
    {

        $this->validate($request, [
            'user_name' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('user_name', 'password');
        $credentials['role'] = Roles::ROLE_ADMIN;
        $user = User::where('user_name', $credentials['user_name'])
            ->where('role', $credentials['role'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            return redirect(url('admin/dashboard'));
        }

        return redirect('admin/auth/login')
            ->withInput($request->only('user_name', 'password'))
            ->withErrors([
                'user_name' => "Authentication error ! Please check credentials .",
            ]);
    }

    ######################################## If login failed return the login pages view ################################
    protected function getFailedLoginMessage()
    {
        return $this->view('auth.login');

    }

    ######################################## If login failed return the login pages view ################################
    protected function dashboard()
    {
        return 'Dashboard';

    }

    ######################################## Code to redirect when the admin log-outs ##################################

}