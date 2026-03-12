<?php

namespace App\Model;

use Core\App;
use Core\Database;

class User
{

    protected $table = 'users';

    public function __construct(
        protected Database $db
    ) {}


    public function create($attribute)
    {

        $query = "insert into {$this->table} (username,first_name,last_name,email,avatar,password)
            values(:username,:first_name,:last_name,:email,:avatar,:password)";


        $this->db->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'email' => $attribute['email'],
            'avatar' => $attribute['avatar'],
            'password' => $attribute['password'],
        ]);
        return $_SESSION['user'] = $attribute['username'];
    }

    public  function update($attribute)
    {

        $query = "UPDATE {$this->table} SET 
            username = :username,
            first_name = :first_name,
            last_name = :last_name,
            bio = :bio ,
            avatar = :avatar,
            status = :status
            WHERE id = :id";


        $this->db->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'bio' => $attribute['bio'],
            'avatar' => $attribute['avatar'],
            'status' => $attribute['status'],
            'id' => $attribute['id']
        ]);

        return $_SESSION['user'] = $attribute['username'];
    }


    public  function updateByAdmin($attribute)
    {

        $query = "UPDATE {$this->table} SET 
            username = :username,
            first_name = :first_name,
            last_name = :last_name,
            bio = :bio ,
            role = :role
            WHERE id = :id";

        $this->db->query($query, [
            'username' => $attribute['username'],
            'first_name' => $attribute['first_name'],
            'last_name' => $attribute['last_name'],
            'bio' => $attribute['bio'],
            'role' => $attribute['role'] ?? 'user',
            'id' => $attribute['id']
        ]);
    }


    public  function login($attributes)
    {
        $user = $this->findByEmail($attributes['email']);


        if (!$user || !password_verify($attributes['password'], $user['password'])) {
            $_SESSION['flash_errors']['login'] = 'Invalid email or password.';
            redirect('/login');
            exit;
        }
        $_SESSION['user'] = $user['username'];
    }


    public  function findByEmail($email, $attr = '*')
    {
        return $this->db->query("select {$attr} from users where email=:email", [
            'email' => $email,
        ])->fetch();
    }

    public  function findByUsername($username, $attr = '*')
    {

        return $this->db->query("select {$attr} from users where username=:username", [
            'username' => $username,
        ])->fetch();
    }

    public  function find($id)
    {
        return $this->db->query("select * from users where id=:id", [
            'id' => $id,
        ])->fetch();
    }

    public  function hasNewAvatar($file)
    {
        if ($file['name'][0] == null) {
            return false;
        }
        return true;
    }

    public  function isAdmin($username)
    {
        $user = $this->findByUsername($username);
        return ($user['role'] == 'admin');
    }

    public  function how_many_user()
    {

        return $this->db->query("select count(*) from  {$this->table}")->fetchCol();
    }

    public  function logged_in_user_avatar()
    {

        return ($this->findByUsername($_SESSION['user']))['avatar'];
    }

    public  function all()
    {

        $query = "select * from {$this->table}";

        return $this->db->query($query)->fetchAll();
    }
}
