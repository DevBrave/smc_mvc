<?php


namespace App\Controllers\Admin;

use App\Model\User;
use Core\Request;
use Core\Validator;

class UserController
{


    public function index()
    {
        $users = User::all();
        view('admin/users/index.view.php',[
            'users' => $users,
        ]);
    }

    public function edit($username)
    {
        $user = User::findByUsername($username);
        view('admin/users/edit.view.php', [
            'user' => $user
        ]);
    }

    public function update()
    {

        $attributes = Request::all();
        $user = User::findByUsername($attributes['username']);
        $attributes['id'] = $user['id'];

//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }


//        unset($_SESSION['csrf_token']);


        $validationFields = [
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'bio' => $attributes['bio']
        ];

        $validationRules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:2',
            'bio' => 'max:100'
        ];

        if ($user['username'] != $attributes['username']) {
            $validationFields['username'] = $attributes['username'];
            $validationRules['username'] = 'unique:users';
        }

        Validator::validate($validationFields, $validationRules);
        User::updateByAdmin($attributes);

        unset($_SESSION['flash_errors']);
        redirect(admin_path('users'));

    }

}