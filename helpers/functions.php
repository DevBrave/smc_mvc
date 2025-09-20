<?php


use App\Model\User;

function dd($data = null)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function base_path($path)
{
    return BASE_PATH . "$path";
}


function controller_path($path)
{
    return base_path('app/Controllers/' . $path);
}

function view($path, $param = [])
{
    extract($param);
    require(base_path('app/view/' . $path));
}

function layout($path)
{
    view('partials/' . $path);
}

function admin_path($path){
    return '/admin/'.$path;
}

function abort($code = 404)
{
    view('errors/' . $code . '.view.php');
    exit();
}

function redirect($url)
{

    header("Location:{$url}");
    exit();

}

function generateRandomUsername($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $username = '';

    for ($i = 0; $i < $length; $i++) {
        $username .= $chars[random_int(0, strlen($chars) - 1)];
    }

    return 'user_' . $username;
}

function generate_csrf_token()
{

    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_input()
{

    return '<input type="hidden" name="csrf_token" value="' . generate_csrf_token() . '">';
}

function url(){
    return $_SERVER['REQUEST_URI'];
}

function isUrl($uri){
    return url() == $uri;
}


function previousurl(){
    return $_SERVER['HTTP_REFERER'];
}


function asset_path($path){
    return base_path('public/assets/'.$path);
}

function upload_dir($path = null){
    return 'assets/uploads/img/'.$path;

}

function truncateText($text, $maxLength = 100, $suffix = '...') {
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength - strlen($suffix)) . $suffix;
    }
    return $text;
}


function username($id = null){
    return $id != null ? User::findByUsername($id)  : User::findByUsername($_SESSION['user']);
}

// hard code
function user($id = null)
{
    return $id != null ? User::find($id)  : User::findByUsername($_SESSION['user']);

}