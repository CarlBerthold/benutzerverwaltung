<?php

## Kommentare entfernt - sonst keine Anpassung notwendig

// require_once 'inc/data.inc.php';
require_once __DIR__ . '/inc/database.inc.php';
require_once __DIR__ . '/inc/User.php';

$db = connectDB();
User::setDb($db);
$users = User::findAll();

//var_dump($users);


// neues Array mit den deutschen Spaltenbezeichnern
$columnNamesDe = [
    'id' => 'Id',
    'firstname' => 'Vorname',
    'lastname' => 'Nachname',
    'email' => 'E-Mail',
    //'password' => 'Passwort',
    'role' => 'Rolle',
    'created_at' => 'registriert seit',
    'updated_at' => 'geändert am',
];

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerverwaltung</title>
    <link href="<?= ASSET_PATH ?>css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="<?= ASSET_PATH ?>css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>css/table.css" rel="stylesheet" type="text/css">
</head>

<body>
    <main id="main">
        <nav id="nav">
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <h1>Benutzerverwaltung</h1>
        <section class="cardbox">
            <table class="user_table">
                <thead>
                    <tr>
                        <?php foreach ($columnNamesDe as $columnName) { ?>
                            <th><?= $columnName ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <?php foreach ($user->getAttributes() as $key => $value) { ?>
                                <?php if($key !== 'password') : ?>
                                    <td><?= $value ?></td>
                                <?php endif; ?>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - Benutzertabelle
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
</body>

</html>