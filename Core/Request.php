<?php

namespace Core;

use http\Encoding\Stream\Deflate;

class Request
{


    public static function post($key = null,$default = null)
    {
        if ($key){
            return trim(htmlspecialchars($_POST[$key])) ?? $default;
        }
        return $_POST;
    }

    public static function get($key = null,$default = null)
    {
        if ($key){
            return trim(htmlspecialchars($_GET[$ky])) ?? $default ;
        }
        return $_GET;

    }


    public static function only($key = [])
    {
        return array_filter($_POST, function ($k) use ($key) {
            return in_array($k, $key);
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function all()
    {
        $sanetized = [];
        foreach ($_POST as $key => $value){
            $sanetized[$key] = is_string($value)? trim(htmlspecialchars($value)) : $value;
        }

        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $sanetized[$key] = $file;
            }
        }
        return $sanetized;
    }




}