<?php

// require_once __DIR__ . '/inc/database.inc.php';
// require_once __DIR__ . '/inc/User.php';
// require APP_ROOT . '/inc/database.inc.php';
// require APP_ROOT . '/inc/User.php';

# Datenbankverbindung herstellen

// $db = connectDB();

# Datenbankverbindung an die User-Klasse binden

// User::setDb($db);

// einen User anhand seiner Id heraussuchen

// $id = 99;
$id = 25;

$user = User::find($id) ?? exit("kein User mit der Id = $id gefunden!");

require APP_ROOT . '/src/templates/user_edit.tpl.php';