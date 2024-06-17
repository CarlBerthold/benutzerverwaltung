<?php

# Applikationskonstanten definieren

define('HOST_URL', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
define('APP_PATH', rtrim(dirname($_SERVER['PHP_SELF']), '\/'));
define('APP_URL', HOST_URL . APP_PATH);
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT'] . APP_PATH);

// für den Fall, dass Assets in einem speziellen Unterverzeichnis gespeichert werden
// define('ASSET_PATH', APP_URL . '/assets');
define('ASSET_PATH', APP_URL);

# Funktionsbibliothek, Klassenbibliotheken und Konfigurationen laden
// require_once APP_ROOT . '/inc/action_functions.php';
require_once APP_ROOT . '/inc/database.inc.php';
require_once APP_ROOT . '/src/Entities/User.php';
require_once APP_ROOT . '/src/Controllers/LoginController.php';
require_once APP_ROOT . '/src/Controllers/UserController.php';


# Session starten
session_start();

# Datenbankverbindung herstellen

$db = connectDB();

# Datenbankverbindung an die User-Klasse binden

User::setDb($db);


## für die gewünschte Aktion benötigen wir die Request-URI aber ohne den Application-Path (Konstante APP_PATH)

$routePath = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen(APP_PATH));

switch ($routePath) {
    case '/user/list':
        // der User möchte die Seite mit der Auflistung bzw. Tabelle aller User sehen
        // require APP_ROOT . '/user_list.php';
        // $requestController = new UserController();
        // $requestController->userListAction();
        # Refactoring - in den Cases werden nur die Controller-Klasse und die Action-Methode Variablen zugewiesen -> die Instanziierung und der Aufruf der Methode erfolgt nach dem switch
        // extract($data); // erzeugt die Variablen $users, $columnNamesDe, $template - besser nach dem switch ausführen - Codedublizierung
        $controller = 'UserController';
        $method = 'userListAction';
        break;
        // exit;
    case '/user/edit/1':
        // der User möchte das Formular zum Editieren eines Users mit der id 1 laden
        // require APP_ROOT . '/user_edit.php';
        // $requestController = new UserController();
        // $requestController->userEditAction();
        $controller = 'UserController';
        $method = 'userEditAction';
        // extract($data);
        break;
        // exit;
    case '/login':
        // der User möchte das Login-Formular laden
        // require APP_ROOT . '/user_login.php';
        // $requestController = new LoginController();
        // $requestController->loginAction();
        $controller = 'LoginController';
        $method = 'loginAction';
        break;
        // exit;
    case '/register':
        // der User möchte das Registrierungsformular laden
        // require APP_ROOT . '/user_register.php';
        // $requestController = new UserController();
        // $requestController->registerAction();
        $controller = 'UserController';
        $method = 'registerAction';
        break;
        // exit;
    case '/logout':
        // der User hat sich aktiv ausgelogged und wir auf die Login-Seite weitergeleitet
        // require APP_ROOT . '/logout.php';
        // $requestController = new LoginController();
        // $requestController->logoutAction();
        $controller = 'LoginController';
        $method = 'logoutAction';
        break;
        // exit;
    case '/loggedin':
        // der User hat sich erfolgreich eingelogged und wird auf die geschützte Loggedin-Seite weitergeleitet
        // require APP_ROOT . '/loggedin.php';
        // $requestController = new LoginController();
        // $requestController->loggedinAction();
        $controller = 'LoginController';
        $method = 'loggedinAction';
        break;
        // exit;
    default:
        // auf index-Seite umleiten oder ggf. Fehlerseite 404 ausgeben...
        die('Seite existiert nicht');
}

# hier jetzt die Instanziierung der Controllers und der Aufruf der Action-Methode
$requestController = new $controller();

$requestController->$method();

/* extract($data);
require APP_ROOT . '/src/templates/' . $template;  */