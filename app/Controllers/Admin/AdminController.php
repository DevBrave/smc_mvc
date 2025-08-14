<?php


namespace Admin;

use app\Model\User;

class AdminController
{
    public function dashboard()
    {
        $user = User::findByUsername($_SESSION['user']);
        view('admin/dashboard.view.php',[
            'user' => $user,
        ]);
    }




}