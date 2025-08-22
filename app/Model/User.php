<?php

namespace app\Model;

use Core\App;
use Core\Database;

class User
{
    protected $connection = [];
    protected $table = 'users';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function create($attribute)
    {
        $instantiate = new static();
        $query ="insert into {$instantiate->table} (username,first_name,last_name,email,avatar,password)
            values(:username,:first_name,:last_name,:email,:avatar,:password)";


        $instantiate->connection->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'email' => $attribute['email'],
            'avatar' => $attribute['avatar'],
            'password' => $attribute['password'],
        ]);
        return $_SESSION['user'] = $attribute['username'];

    }

    public static function update($attribute)
    {
        $instantiate = new static();
        $query = "UPDATE {$instantiate->table} SET 
            username = :username,
            first_name = :first_name,
            last_name = :last_name,
            bio = :bio ,
            role = :role,
            avatar = :avatar,
            status = :status
            WHERE id = :id";


        $instantiate->connection->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'bio' => $attribute['bio'],
            'avatar' => $attribute['avatar'],
            'status' => $attribute['status'],
            'role' => $attribute['role'] ?? 'user',
            'id' => $attribute['id']
        ]);

        return $_SESSION['user'] = $attribute['username'];

    }


    public static function updateByAdmin($attribute)
    {
        $instantiate = new static();
        $query = "UPDATE {$instantiate->table} SET 
            username = :username,
            first_name = :first_name,
            last_name = :last_name,
            bio = :bio ,
            role = :role
            WHERE id = :id";

        $instantiate->connection->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'bio' => $attribute['bio'],
            'role' => $attribute['role'] ?? 'user',
            'id' => $attribute['id']
        ]);
    }


    public static function login($attributes)
    {
        $user = self::findByEmail($attributes['email']);


        if (!$user || !password_verify($attributes['password'], $user['password'])) {
            $_SESSION['flash_errors']['login'] = 'Invalid email or password.';
            redirect('/login');
            exit;
        }
        $_SESSION['user'] = $user['username'];
    }


    public static function findByEmail($email,$attr = '*')
    {
        return App::resolve(Database::class)->query("select {$attr} from users where email=:email", [
            'email' => $email,
        ])->fetch();
    }

    public static function findByUsername($username,$attr = '*')
    {

        return App::resolve(Database::class)->query("select {$attr} from users where username=:username", [
            'username' => $username,
        ])->fetch();
    }

    public static function find($id)
    {
        return App::resolve(Database::class)->query("select * from users where id=:id", [
            'id'=> $id,
        ])->fetch();
    }

    public static function hasNewAvatar($file)
    {
        if ($file['name'][0] == null){
            return false;
        }
        return true;
    }

    public static function isAdmin($username)
    {
        $user = User::findByUsername($username);
        return ($user['role'] == 'admin');

    }

    public static function how_many_user()
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}")->fetchCol();

    }

    public static function logged_in_user_avatar(){

        return  (User::findByUsername($_SESSION['user']))['avatar'] ;
    }

    public static function all()
    {
        $instantiate = new static();
        $query = "select * from {$instantiate->table}";

        return $instantiate->connection->query($query)->fetchAll();
    }



}