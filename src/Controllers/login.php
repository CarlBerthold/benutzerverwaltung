<?php

//require_once __DIR__ . '../../inc/database.inc.php';
//require_once __DIR__ . '../../inc/User.php';

//require APP_ROOT . '/inc/database.inc.php';
//require APP_ROOT . '/inc/User.php';

# Session starten
//session_start();

# Datenbankverbindung herstellen

//$db = connectDB();

# Datenbankverbindung an die User-Klasse binden

//User::setDb($db);

if ($_POST) {
    $user = User::findByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user->password)) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $user->firstname;

        // aus Sicherheitsgründen neue Session-Id vergeben
        session_regenerate_id();
        header('Location: ' . APP_URL . '/loggedin', TRUE, 307);
        exit;
    } else {
        $message = 'Die Kombination Benutzername und Kennwort stimmen nicht überein!';
    }
}


require APP_ROOT . '/src/templates/user_login.tpl.php';
