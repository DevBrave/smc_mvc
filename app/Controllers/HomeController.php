<?php


namespace App\Controllers;

use App\Model\Notification;
use App\Model\NotificationService;

class HomeController
{


    public function home()
    {

        view('home.view.php');
    }


    public function about()
    {
        view('about.view.php');
    }


    public function contact()
    {
        view('contact.view.php');
    }


}