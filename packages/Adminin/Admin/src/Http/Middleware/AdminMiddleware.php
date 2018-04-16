<?php

namespace Adminin\Admin\Http\Middleware;

use App\Common\Roles;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Session;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->guest() || (!$this->auth->guest() && $this->auth->user()->role== Roles::ROLE_ADMIN)) {


            if ($this->auth->check() && $this->auth->user()->role== Roles::ROLE_ADMIN && $this->auth->user()->status==1) {

                Log::info(Auth::user()->name);
                return $next($request);

            } else
                {
                    Session::flash('saveMsg', 'This is a message!');
                    return redirect('admin/auth/login');

            }

        }
    }
}
