<?php

require_once 'inc/data.inc.php';

$users = fetchData();

// eine User anhand seiner Id heraussuchen

// $id = 99;
$id = 1;

$idList = array_column($users, 'id');
$user = in_array($id, $idList) ? $users[array_search($id, $idList)] : exit("kein User mit der Id = $id gefunden!");


?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerdaten bearbeiten</title>
    <link href="css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/form.css" rel="stylesheet" type="text/css">
    <link href="css/edit.css" rel="stylesheet" type="text/css">
</head>

<body>
    <main id="main">
        <nav id="nav">
            <ul>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="user_list.php">Benutzerverwaltung</a></li>
            </ul>
        </nav>
        <h1>Benutzerdaten bearbeiten</h1>
        <section class="cardbox">
            <form action="#" method="post">
                <fieldset id="reg-data">
                    <legend>Benutzerdaten</legend>
                    <div>
                        <label for="id">Benutzer-Id: </label>
                        <input type="text" id="id" readonly class="readonly" value="<?= $user['id'] ?>">
                    </div>
                    <div>
                        <label for="firstname">Vorname: </label>
                        <input type="text" name="firstname" id="firstname" required value="<?= $user['firstname'] ?>">
                    </div>
                    <div>
                        <label for="lastname">Nachname: </label>
                        <input type="text" name="lastname" id="lastname" required value="<?= $user['lastname'] ?>">
                    </div>
                    <div>
                        <label for="email">E-Mail: </label>
                        <input type="email" name="email" id="email" required value="<?= $user['email'] ?>">
                    </div>
                    <div>
                        <label for="password">Passwort: </label>
                        <input type="password" name="password" id="password" required value="<?= $user['password'] ?>">
                    </div>
                    <div>
                        <label for="created_at">registriert seit: </label>
                        <input type="text" id="created_at" readonly class="readonly" value="<?= $user['created_at'] ?>">
                    </div>
                    <div>
                        <label for="updated_at">geändert am: </label>
                        <input type="text" name="updated_at" id="updated_at" readonly class="readonly" value="<?= $user['updated_at'] ?>">
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Aktion</legend>
                    <div>
                        <button type="submit">ändern</button>
                        <button type="reset">zurücksetzen</button>
                    </div>
                </fieldset>
            </form>
        </section>
    </main>
    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - Benutzer editieren
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
</body>

</html>