<?php


namespace App\Controllers;

use App\Model\User;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class AuthController
{


    public function __construct(
        protected User $user,
        protected Validator $validator,
        protected FileUploader $fileUploader,
    ) {}


    public function showRegisterForm()
    {
        view('users/register.view.php', [
            'errors' => $_SESSION['flash_errors'] ?? []
        ]);
    }

    public function showLoginForm()
    {
        view('users/sessions/signin.php');
    }


    public function register()
    {

        $attributes = Request::all();
        // this is for checking csrf

        //        if (!$this->validator->check_csrf($attributes['csrf_token'])) {
        //            dd('here');
        //        }
        unset($_SESSION['flash_errors']);



        $this->validator->validate([

            'email' => $attributes['email'],
            'username' => $attributes['username'],
            'password' => $attributes['password'],
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
        ], [
            'username' => 'unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|password',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:2',
        ]);
        $hasNewAvatar = false;
        if ($this->user->hasNewAvatar($attributes['avatar'])) {
            $hasNewAvatar = true;
            $this->fileUploader->validate($attributes['avatar'], 'avatar');
        }
        if ($hasNewAvatar) {

            $path = $this->fileUploader->upload($attributes['avatar'], 'avatar');
        }

        $attributes['avatar'] = $path;

        if (!$this->validator->confirmed($attributes['password'], $attributes['confirmation_password'])) {
            $_SESSION['flash_errors']['password'] = 'Password confirmation does not match.';
            redirect('/register');
        }
        $attributes['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
        $this->user->create($attributes);
        unset($_SESSION['flash_errors']);
        redirect('/');
    }


    public function login()
    {

        $attributes = Request::all();

        // this is for checking csrf - we have middle ware
        //        if (!$this->validator->check_csrf($_POST['csrf_token'])) {
        //            dd('here');
        //        }

        unset($_SESSION['csrf_token']);

        $this->validator->validate([

            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ], [
            'email' => 'required|email',
            'password' => 'required|password',
        ]);

        $this->user->login($attributes);
        unset($_SESSION['flash_errors']);
        redirect('/');
    }


    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        setcookie('PHPSESSID', time() - 3600);

        redirect('/');
    }
}
