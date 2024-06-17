<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?= ASSET_PATH ?>/css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="<?= ASSET_PATH ?>/css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>/css/login.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
    <h1>Login</h1>
    <form action="<?= APP_URL ?>/login" method="post">
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
            <a href="<?= APP_URL ?>/register" class="button spacer_left">registrieren</a>

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