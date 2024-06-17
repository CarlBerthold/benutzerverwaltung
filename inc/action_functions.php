<?php

function loggedinAction()
{
    if (empty($_SESSION['loggedin'])) {
        header('Location: ' . APP_URL . '/login', TRUE, 307); // Location angepasst
        exit;
    }

    $template = 'loggedin.tpl.php';

    return [
        'template' => $template,
    ];

    // require APP_ROOT . '/src/templates/loggedin.tpl.php';
}

function logoutAction() 
{
    ## Session zurücksetzen
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {  // Auslesen aus php.ini, ob die Session Cookie-basiert arbeitet
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    header('Location: ' . APP_URL . '/login', TRUE, 307); // Location angepasst

    return $_SESSION;

}

function userEditAction()
{
    // einen User anhand seiner Id heraussuchen

    // $id = 99;
    $id = 25;

    $user = User::find($id) ?? exit("kein User mit der Id = $id gefunden!");

    $template = 'user_edit.tpl.php';

    return [
        'user' => $user,
        'template' => $template,
    ];

    // require APP_ROOT . '/src/templates/user_edit.tpl.php';
}

function userListAction()
{
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

    $template = 'user_list.tpl.php';

    return [
        'users' => $users,
        'columnNamesDe' => $columnNamesDe,
        'template' => $template,
    ];

    // require APP_ROOT . '/src/templates/user_list.tpl.php';
}

function loginAction()
{
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

    $template = 'user_login.tpl.php';

    return [
        'user' => $user ?? NULL,
        'message' => $message ?? NULL,
        'template' => $template,
    ];

    //require APP_ROOT . '/src/templates/user_login.tpl.php';
}

function registerAction()
{

    // wir haben die Logik noch nicht implementiert

    $template = 'user_register.tpl.php';

    return [
        'template' => $template,
    ];

    // require APP_ROOT . '/src/templates/user_register.tpl.php';
}
