<!DOCTYPE html>
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
                    <li><a href="<?= APP_URL?>/login">User Login</a></li>
                    <li><a href="<?= APP_URL?>/register">User Register</a></li>
                    <li><a href="<?= APP_URL?>/user/list">User Tabelle</a></li>
                    <li><a href="<?= APP_URL?>/user/edit/1">User Edit id=1</a></li>
                    <li><a href="<?= APP_URL?>/loggedin">geschützter Bereich</a></li>
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

</html>