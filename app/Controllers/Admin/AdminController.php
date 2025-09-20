<?php


namespace App\Controllers\Admin;

use App\Model\User;

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