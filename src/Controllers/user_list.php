<?php

// require_once __DIR__ . '../../inc/database.inc.php';
// require_once __DIR__ . '../../inc/User.php';
// require APP_ROOT . '/inc/database.inc.php';
// require APP_ROOT . '/inc/User.php';

# Datenbankverbindung herstellen

// $db = connectDB();

# Datenbankverbindung an die User-Klasse binden

// User::setDb($db);

## Userdaten einlesen

$users = User::findAll();

// neues Array mit den deutschen Spaltenbezeichnern
$columnNamesDe = [
    'id' => 'Id',
    'firstname' => 'Vorname',
    'lastname' => 'Nachname',
    'email' => 'E-Mail',
    // 'password' => 'Passwort',
    'role' => 'Rolle',
    'created_at' => 'registriert seit',
    'updated_at' => 'geändert am',
];

require APP_ROOT . '/src/templates/user_list.tpl.php';