<?php


use Core\Validator;

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