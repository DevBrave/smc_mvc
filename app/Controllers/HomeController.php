<?php


namespace App\Controllers;

use App\Model\Notification;
use App\Model\NotificationService;

class HomeController
{


    public function home()
    {

        NotificationService::createOrBump('like_commnet',[10],9,'comment',10,'post',10);
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