<?php

require_once __DIR__ . '/inc/User.php';
require_once __DIR__ . '/inc/database.inc.php';

$db = connectDB();
// bind the db static to the class 
User::setDb($db);

/* $user = new User([
    'firstname' => 'Paula',
    'lastname' => 'Rich',
    'email' => 'rich@paula.com',
    'password' => 'fnkwh19i43',
    'role' => 'admin',

]);
var_dump($user);

$user->persist();

var_dump($user); */



$paula = User::findByEmail('rich@paula.com');

var_dump($paula);