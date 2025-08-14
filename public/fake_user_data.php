<?php
require('../functions.php');
header("Content-Type: application/json");

echo json_encode([
    'first_name' => 'Hamidreza',
    'last_name' => 'Rmaezani',
    'username' => generateRandomUsername(),
    'email' => 'test.user@example.com',
    'password' => 'password',
    'confirmation_password' => 'password'
]);
