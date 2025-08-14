<?php

namespace Core;
class Validator
{

    public $errors = [];

    public static function string($data, $min, $max = 255): bool
    {

        if (strlen($data) < $min || strlen($data) > $max) {
            return false;
        }

        return true;
    }


    public static function min($data, $info)
    {
        return Validator::string($data, $info[0]);
    }

    public static function max($data, $info)
    {
        return Validator::string($data, 0, $info[0]);

    }

    public static function check_regex($type, $data)
    {

        $username_regex = '/^[a-zA-Z0-9_]+$/';
        $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if ($type == 'username') {
            if (!preg_match($username_regex, $data)) {
                return false;
            }
        } elseif ($type == 'password') {

            if (!preg_match($password_regex, $data)) {
                return false;
            }
        }
        return true;
    }


    public static function username($data)
    {

        $trimmed_data = $data;
        if (!self::check_regex('username', $trimmed_data)) {

            return false;
        }

        return true;
    }

    public static function password($password)
    {

        if (!self::string($password, 8)) {
            return false;
        }
        return true;
    }


    public static function confirmed($original, $repeat)
    {
        return $original == $repeat;
    }

    public static function email($email)
    {


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;


    }

    public static function check_csrf($token)
    {
        $csrf_session = generate_csrf_token();
        if ($csrf_session != $token) {
            return false;
        }
        return true;
    }

    public static function required($data)
    {

        if (strlen($data) == 0) {
            return false;
        }
        return true;
    }


    public static function unique($data, $info)
    {

        $query = "select * from {$info[0]} where {$info[1]}=:{$info[1]}";
        $result = App::resolve(Database::class)->query($query, [
            $info[1] => $data
        ])->fetch();


        if ($result) {
            return false;
        }
        return true;

    }

    public static function formatValidationMessage($template, $params = [])
    {
        foreach ($params as $key => $value) {
            $template = str_replace("{" . $key . "}", $value, $template);
        }
        return $template;
    }

    public static function valid_file_type($files)
    {

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];


        if (is_array($files['type'])) {
            foreach ($files['type'] as $type) {
                if (!in_array($type, $allowed)) {
                    return false;
                }
            }
        } else {
            if (!in_array($files['type'], $allowed)) {
                return false;
            }
        }

        return true;

    }


    public static function max_file_size($files, $size)
    {

        if (is_array($files['size'])) {
            foreach ($files['size'] as $file) {
                if ($file > $size) {
                    return false;
                }
            }
        } else {
            if ($files['size'] > $size) {
                return false;
            }
        }

        return true;
    }

    public static function file_uploaded($files)
    {
        if (!isset($files)) {
            return false;
        }

        if (is_array($files['error'])) {
            foreach ($files['error'] as $error) {
                if ($error !== UPLOAD_ERR_OK) {
                    return false;
                }
            }
        } else {
            if ($files['error'] !== UPLOAD_ERR_OK) {
                return false;
            }
        }


        return true;
    }

    public static function validate($data, $rules = [])
    {

        $errors = [];

        $main_rules = require(base_path('app/Validations/validationRules.php'));

        foreach ($rules as $field => $rule_set) {
            $indivisualRule = explode("|", $rule_set);
            $ruleWithArg = null;


            foreach ($indivisualRule as $rule) {

                $method = $rule;
                // check that if we have a rule with : -> exp : unuiqe:users
                if (strpos($rule, ':')) {
                    $ruleWithArg = explode(':', $rule);
                    $method = $ruleWithArg[0];
                }


                if (isset($ruleWithArg)) {
                    if (method_exists(self::class, $method)) {
                        $result = self::{$method}($data[$field], [$ruleWithArg[1], $field]);

                    }
                } else if (method_exists(self::class, $method)) {
                    $result = self::{$method}($data[$field]);
                }

                if (!$result) {
                    $message = Validator::formatValidationMessage($main_rules[$method], ['field' => $field]);
                    $errors[$field] = $message;
                    break;

                }
            }

        }
        if (!empty($errors)) {
            $_SESSION['flash_errors'] = $errors;
            redirect(previousurl());

        }


    }


}