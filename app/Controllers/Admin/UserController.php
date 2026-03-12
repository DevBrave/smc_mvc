<?php


namespace App\Controllers\Admin;

use App\Model\User;
use Core\Request;
use Core\Validator;

class UserController
{

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->all();
        view('admin/users/index.view.php', [
            'users' => $users,
        ]);
    }

    public function edit($username)
    {
        $user = $this->user->findByUsername($username);
        view('admin/users/edit.view.php', [
            'user' => $user
        ]);
    }

    public function update()
    {
        $attributes = Request::all();
        $user = $this->user->findByUsername($attributes['username']);
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
        $this->user->updateByAdmin($attributes);

        unset($_SESSION['flash_errors']);
        redirect(admin_path('users'));
    }
}
