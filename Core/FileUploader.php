<?php

namespace Core;

class FileUploader
{

    public static function multipleUpload($file,$folder)
    {

        $files_path = [];
        $image_path = [];
        
        foreach ($file['name'] as $name) {
            // Create unique filename with proper extension
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $filename = uniqid($folder) . '.' . $extension;
            $targetPath = upload_dir($folder) . '/' . $filename;

            // Ensure upload directory exists
            if (!is_dir(upload_dir($folder))) {
                mkdir(upload_dir($folder), 0755, true);
            }

            $files_path[] = $targetPath;
        }
        foreach ($file['tmp_name'] as $key => $tmp) {

            // Move uploaded file
            if (!move_uploaded_file($tmp, $files_path[$key])) {
                $_SESSION['flash_errors']['file'] = 'Failed to upload your file. Please try again.';
                redirect(previousurl());
            }
            $image_path[] = $files_path[$key];


        }
            return $image_path;
    }

    public static function upload($file,$folder)
    {
            // Create unique filename with proper extension
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid($folder) . '.' . $extension;
            $targetPath = upload_dir($folder) . '/' . $filename;

            // Ensure upload directory exists
            if (!is_dir(upload_dir($folder))) {
                mkdir(upload_dir($folder), 0755, true);
            }

            $files_path = $targetPath;


            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $files_path)) {
                $_SESSION['flash_errors']['file'] = 'Failed to upload your file. Please try again.';
                redirect(previousurl());
            }


        return $files_path;
    }


    public static function validate($file,$field)
    {
        return Validator::validate([
            $field => $file
        ],[
            $field  => "file_uploaded|valid_file_type|max_file_size:".Config::MAX_FILE_SIZE,

        ]);


    }

}