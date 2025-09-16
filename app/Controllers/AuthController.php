<?php


use app\Model\User;
use Core\App;
use Core\Config;
use Core\Database;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class AuthController
{
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

//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }
        unset($_SESSION['flash_errors']);



        Validator::validate([

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
        if (User::hasNewAvatar($attributes['avatar'])){
            $hasNewAvatar = true;
            FileUploader::validate($attributes['avatar'],'avatar');
        }
        if ($hasNewAvatar){

            $path = FileUploader::upload($attributes['avatar'],'avatar');

        }

        $attributes['avatar'] = $path;

        if (!Validator::confirmed($attributes['password'], $attributes['confirmation_password'])) {
            $_SESSION['flash_errors']['password'] = 'Password confirmation does not match.';
            redirect('/register');
        }
        $attributes['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
        User::create($attributes);
        unset($_SESSION['flash_errors']);
        redirect('/');


    }


    public function login()
    {

        $attributes = Request::all();

        // this is for checking csrf - we have middle ware
//        if (!Validator::check_csrf($_POST['csrf_token'])) {
//            dd('here');
//        }

        unset($_SESSION['csrf_token']);

        Validator::validate([

            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ], [
            'email' => 'required|email',
            'password' => 'required|password',
        ]);

        User::login($attributes);
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

