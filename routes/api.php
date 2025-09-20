<?php


$router->post('/api/v1/auth/register','Api\\AuthController@register')->only('guest');
$router->post('/api/v1/auth/login','Api\\AuthController@login')->only('guest');
$router->delete('/api/v1/auth/logout','Api\\AuthController@logout')->only('auth');




$router->get('/api/v1/posts','Api\PostController@index');
$router->post('/api/v1/posts','Api\PostController@store')->only('jwt');