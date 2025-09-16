<?php


$router->post('/api/v1/auth/register','Api\\AuthController@register')->only('guest');
$router->post('/api/v1/auth/login','Api\\AuthController@login')->only('guest');