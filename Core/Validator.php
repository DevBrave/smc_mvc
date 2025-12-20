<?php

namespace Core;
class Validator
{

    public $errors = [];

    public static function username($data): bool
    {

        $trimmed_data = $data;
        if (!self::check_regex('username', $trimmed_data)) {

            return false;
        }

        return true;
    }

    public static function password($password): bool
    {

        if (!self::string($password, 8)) {
            return false;
        }
        return true;
    }


    public static function confirmed($original, $repeat): bool
    {
        return $original == $repeat;
    }

    public static function email($email): bool
    {


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;


    }

    public static function check_csrf($token): bool
    {
        $csrf_session = generate_csrf_token();
        if ($csrf_session != $token) {
            return false;
        }
        return true;
    }

    public static function required($data): bool
    {

        if (strlen($data) == 0) {
            return false;
        }
        return true;
    }


    public static function unique($data, $info): bool
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

        if (!empty($errors)) {
            foreach ($rules as $field => $rule_set) {
                $individual_rule = explode("|", $rule_set);
                $ruleWithArg = null;


                foreach ($individual_rule as $rule) {

                    $method = $rule;
                    // check that if we have a rule with : -> example : unique:users
                    if (strpos($rule, ':')) {
                        $ruleWithArg = explode(':', $rule);
                        $method = $ruleWithArg[0];
                    }


                    if (isset($ruleWithArg)) {
                        if (method_exists(self::class, $method)) {
                            $result = self::{$method}($data[$field], [$ruleWithArg[1], $field]); // call its function and poss arguments

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
            $_SESSION['flash_errors'] = $errors;
            redirect(previousurl());

        }


    }


}