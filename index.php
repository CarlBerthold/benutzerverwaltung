<?php

# Applikationskonstanten definieren

define('HOST_URL', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
define('APP_PATH', rtrim(dirname($_SERVER['PHP_SELF']), '\/'));
define('APP_URL', HOST_URL . APP_PATH);
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT'] . APP_PATH);
define('ASSET_PATH', APP_PATH . '/assets');

$path = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen(APP_PATH));


var_dump($path);

?>


<!-- <!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht Benutzerverwaltung</title>
    <link href="css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/form.css" rel="stylesheet" type="text/css">
</head>

<body>
    <main id="main">
        <h1>Übersicht Benutzerverwaltung</h1>
        <section class="cardbox">
            <h2>Startseite</h2>
            <nav>
                <ul>
                    <li><a href="user_login.php">User Login</a></li>
                    <li><a href="user_register.php">User Register</a></li>
                    <li><a href="user_list.php">User Tabelle</a></li>
                    <li><a href="user_edit.php?id=1">User Edit id=1</a></li>
                    <li><a href="loggedin.php">geschützter Bereich</a></li>
                </ul>
            </nav>
        </section>
    </main>
    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - Startseite
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
</body>

</html> -->