<?php


namespace App\Controllers\Api;

use App\Model\User;
use Core\Jwt;

class AuthController extends ApiController
{
//    public function register()
//    {
//
//        SystemController::setCorsHeaders();
//        $in = json_decode(file_get_contents('php://input'), true) ?? [];
//        $u = trim($in['username'] ?? '');
//        $p = $in['password'] ?? '';
//        if ($u === '' || strlen($p) < 8) {
//            return $this->error('VALIDATION', 'username & password(>=8)', 422);
//        }
//        if (User::exists($u)) {
//            return $this->error('CONFLICT', 'username taken', 409);
//        }
//        $id = User::create(['username' => $u, 'password_hash' => password_hash($p, PASSWORD_DEFAULT)]);
//        return $this->json(['id' => $id, 'username' => $u], 201);
//    }

    public function login()
    {

        SystemController::setCorsHeaders();
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->error('INVALID_CREDENTIALS', 'Wrong username or password', 401);
        }
        $_SESSION['user'] = $user['username'];

        $token = Jwt::encode(['sub' => $user['id'], 'role' => $user['role'] ?? 'user'], 60 * 60 * 4); // 4h
        return $this->json(['token' => $token, 'token_type' => 'Bearer', 'expires_in' => 14400]);
    }


    public function logout()
    {

        $_SESSION = [];

        session_destroy();

        setcookie('PHPSESSID', time() - 3600);

        redirect('/');
    }

}

