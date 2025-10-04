<?php
// general pages
$router->get('/','HomeController@home');
$router->get('/about-us','HomeController@about');
$router->get('/contact','HomeController@contact');

// register and login
$router->get('/register','AuthController@showRegisterForm')->only('guest');
$router->post('/register','AuthController@register')->only('guest');
$router->get('/login','AuthController@showLoginForm')->only('guest');
$router->post('/login','AuthController@login')->only('guest');
$router->post('/logout','AuthController@logout')->only(['auth','csrf']);



// admin control panel section

$router->get('/admin','Admin\\AdminController@dashboard')->only('admin');

// user section
$router->get('/admin/users','Admin\\UserController@index')->only('admin');
$router->get('/admin/user/edit/{username}','Admin\\UserController@edit')->only('admin');
$router->patch('/admin/user/update','Admin\\UserController@update')->only(['admin', 'csrf']);


// tag section

$router->get('/admin/tags','Admin\\TagController@index');
$router->get('/admin/tag/create','Admin\\TagController@create');
$router->post('/admin/tag/store','Admin\\TagController@store');


// post section
$router->get('/admin/posts','Admin\\PostController@index')->only('admin');

// comment section
$router->get('/admin/comments','Admin\\CommentController@index')->only('admin');
$router->patch('/admin/comment/update','Admin\\CommentController@update')->only(['admin','csrf']);

// user profile section
$router->get('/user/{username}','UserController@profile')->only('auth');
$router->get('/user/edit/{username}','UserController@edit')->only('auth');
$router->patch('/user/edit/{username}','UserController@update')->only(['auth','csrf']);
$router->get('/user/posts/{username}','UserController@show_posts')->only('auth');
$router->get('/user/followers/{username}','UserController@followers')->only('auth');
$router->get('/user/following/{username}','UserController@followings')->only('auth');


// post
$router->get('/posts','PostController@index');
$router->get('/post/create','PostController@create')->only('auth');
$router->post('/post/create','PostController@store')->only(['auth','csrf']);
$router->get('/post/edit/{id}','PostController@edit')->only('auth');
$router->patch('/post/update','PostController@update')->only(['auth','csrf']);
$router->get('/post/{id}','PostController@show');
$router->delete('/post/{id}','PostController@destroy')->only(['auth','csrf']);



// tag

$router->get('/admin/tags','TagController@index');
$router->get('/admin/tag/{slug}','TagController@show');


// comment section
$router->post('/comment/store','CommentController@store')->only(['auth','csrf']);
$router->patch('/comment/update/{id}','CommentController@update')->only(['auth','csrf']);
$router->delete('/comment/{id}','CommentController@destroy')->only(['auth','csrf']);

// like
$router->post('/like/store','LikeController@like_post')->only(['auth']);
$router->post('/comment/like/store','LikeController@like_comment')->only(['auth']);

//follow
$router->post('/user/{id}/follow','FollowController@follow')->only(['auth','csrf']);
$router->delete('/user/{id}/unfollow','FollowController@unfollow')->only(['auth','csrf']);



