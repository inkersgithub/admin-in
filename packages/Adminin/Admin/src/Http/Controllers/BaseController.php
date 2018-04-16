<?php

namespace Adminin\Admin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
   /**
     * Show view.
     *
     * @param $view
     * @param array $data
     * @param array $mergeData
     *
     * @return mixed
     */
    public function view($view, $data = array(), $mergeData = array())
    {
        return View::make('Admin::' . $view, $data, $mergeData);
    }

    /**
     * Redirect to a route.
     *
     * @param $route
     * @param array $parameters
     * @param int $status
     * @param array $headers
     *
     * @return mixed
     */
    public function redirect($route, $parameters = array(), $status = 302, $headers = array())
    {
        return Redirect::route('admin.' . $route, $parameters, $status, $headers);
    }

    /**
     * Get all input data.
     *
     * @return array
     */
    public function inputAll()
    {
        return Input::all();
    }

}