<?php

namespace Adminin\Admin\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;
use App\User;
use Session;

use Illuminate\Http\Request;

class UserManagementController extends BaseController
{

    public function index()
    {
        return $this->view('pages.UserManagement.index');

    }

    public function fetchUserName(Request $request)
    {

     $userName=User::where('user_name','=',$request->username)->count();
        if($userName>0)
        {
           return  "User Name Already Taken";
        }

    }
    public function fetchUserNameEdit(Request $request)
    {

     $userName=User::where('user_name','=',$request->username)->count();

        if($userName>=1)
        {
           return  "User Name Already Taken";


        }

    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'name' => 'required',
                'username' => 'required|min:8|max:16',
                'role' => 'required',                
                'password' => 'required|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',

            ]);

        $addUsers = new User();
        $addUsers->name = $request->name;
        $addUsers->user_name = $request->username;
        $addUsers->password =  bcrypt($request->password);
        $addUsers->email = $request->email;
        $addUsers->mobile_no = $request->mobile;
        $addUsers->role = $request->role;
        $addUsers->status =1;

        $addUsers->save();

        Session::flash('saveMsg', 'This is a message!');
        return redirect('admin/users');
    }


    public function update(Request $request, $id)
    {

        $this->validate($request,
            [
                'editName' => 'required',
                'editUsername' => 'required|min:8|max:16',
                'editRole' => 'required',

            ]);
        $updateUser = User::findOrFail($request->editId);
        $updateUser->name=$request->editName;
        $updateUser->user_name=$request->editUsername;
        $updateUser->role=$request->editRole;
        $updateUser->email=$request->editEmail;
        $updateUser->mobile_no=$request->editMobile;
        $updateUser->save();

    }


    public function getUsers()
    {
        return $users=User::where('role','!=',1)->get();
    }

    public function disableUserStatus(Request $request)
    {
        $id=$request->user_id;

        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return 1;
    }

    public function enableUserStatus(Request $request)
    {
        $id=$request->user_id;

        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

         return 1;
    }

    public function resetPassword(Request $request)
    {
        $id=$request->userId;
        $user = User::findOrFail($id);
        $user->password=bcrypt($request->passwordInfo);
        $user->save();

        return 1;
    }

    public function deleteuser(Request $request)
    {
       $userId=$request->id;
       $delete = User::where('id','=',$userId)->delete();

       return $users = User::where('role','!=',1)->get();
    }
}
