<?php

# Änderungen: $userData aus Datei data.inc.php laden
# der Key 'loginname' muss durch 'email' ersetzt werden - in der Datenstruktur ist email als Anmeldename vorgesehen
require_once __DIR__ . '/inc/database.inc.php';
require_once __DIR__ . '/inc/User.php';

# Session starten
session_start();


$db = connectDB();
User::setDb($db);

if($_POST) {
    $user = User::findByEmail($_POST['email']);

    if($user && password_verify($_POST['password'], $user->password)) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $user->firstname;
        session_regenerate_id();
        header('Location: loggedin.php', TRUE, 307);
        exit;
    } else {
        $message = 'Die Kombination Benutzername und Kennwort stimmen nicht überein!';
    }
}


/* array(5) {
    ["firstname"]=>
    string(6) "Marija"
    ["lastname"]=>
    string(5) "Block"
    ["email"]=>
    string(20) "miroslaw94@posteo.de"
    ["password"]=>
    string(12) "hVeD'[^+U1Ik"
    ["role"]=>
    string(4) "user"
  } */


# $userData = fetchData();



/* $userData = [
    [
        'name' => 'Oli',
        'loginname' => 'oliver.vogt@d-taube.de',
        'password' => 'ganzgeheim', // absolutes no-go - Passwörter dürfen nie nie nie in Klartext verfügbar sein
    ],
    [
        'name' => 'Hans',
        'loginname' => 'hans@wurst.de',
        'password' => 'Pa$$w0rd', // absolutes no-go - Passwörter dürfen nie nie nie in Klartext verfügbar sein
    ],
]; */

// $userData = fetchData();

// $loginNames = array_column($userData, 'password', 'loginname');
# notwendige Anpassung - unsere Keys müssen jetzt die E-Mailadressen sein
// $loginNames = array_column($userData, 'password', 'email');

/* if ($_POST) {
    if (array_key_exists($_POST['email'], $loginNames) && $_POST['password'] === $loginNames[$_POST['email']]) {
        $_SESSION['loggedin'] = TRUE;
        # Benutzernamen auslesen - z. Z. aufwändiger, das liegt an unserer Vorgehensweise und auch der Datenstruktur

        $_SESSION['name'] = array_reduce($userData, fn ($carry, $user) => ($user['email'] === $_POST['email']) ? $user['name'] : $carry);
        // aus Sicherheitsgründen neue Session-Id vergeben
        session_regenerate_id();
        header('Location: loggedin.php', TRUE, 307);
        exit;
    }

    
} */



?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?= ASSET_PATH ?>css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="<?= ASSET_PATH ?>css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>css/login.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
    <h1>Login</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset id="reg-data">
            <legend>Login</legend>

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" placeholder="Bitte die E-Mail-Adresse eingeben" value="<?= $_POST['email'] ?? '' ?>" autocomplete="email" autofocusrequired>

            <label for="password">Passwort</label>
            <span class="view-icon">
                <input type="password" name="password" id="password" placeholder="Bitte das Passwort eingeben" value="<?= $_POST['password'] ?? '' ?>" autocomplete="current-password" required>
                <span class="icon"></span>
            </span>

        </fieldset>
        <fieldset>

            <legend>Aktion</legend>
            <button type="submit">anmelden</button>
            <button type="reset">zurücksetzen</button>
            <a href="user_register.php" class="button spacer_left">registrieren</a>

        </fieldset>
    </form>
    <?php if (isset($message)) : ?>
        <p id="message">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - login
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
    <script>
        (function() {
            "use strict";

            function init() {
                document.querySelectorAll('.view-icon .icon').forEach(function(el) {
                    el.addEventListener('click', function(ev) {
                        ev.target.classList.toggle('show');
                        const inputEl = ev.target.parentElement.firstElementChild;
                        inputEl.type = (inputEl.type === "password") ? "text" : "password";
                    })
                })

            }
            window.addEventListener('load', init);
        })();
    </script>
</body>

</html>