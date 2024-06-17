<?php 

# Applikationskonstanten definieren

define('HOST_URL', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
define('APP_PATH', rtrim(dirname($_SERVER['PHP_SELF']), '\/'));
define('APP_URL', HOST_URL . APP_PATH);
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT'] . APP_PATH);

// für den Fall, dass Assets in einem speziellen Unterverzeichnis gespeichert werden
// define('ASSET_PATH', APP_URL . '/assets');
define('ASSET_PATH', APP_URL);


# Funktionsbibliothek laden
require_once APP_ROOT . '/inc/action_functions.php';
require_once APP_ROOT . '/inc/database.inc.php';
require_once APP_ROOT . '/inc/User.php';

# Session starten
session_start();

# Datenbankverbindung herstellen

$db = connectDB();

# Datenbankverbindung an die User-Klasse binden

User::setDb($db);

## für die gewünschte Aktion benötigen wir die Request-URI aber ohne den Application-Path (Konstante APP_PATH)

$routePath = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen(APP_PATH));

switch ($routePath) {
    case '/user/list' : 
        // der User möchte die Seite mit der Auflistung bzw. Tabelle aller User sehen
        //require APP_ROOT . '/user_list.php';
        require APP_ROOT . '/src/Controllers/user_list.php';
        $data = userListAction();

        break;
    case '/user/edit/1' : 
        // der User möchte das Formular zum Editieren eines Users mit der id 1 laden
        // require APP_ROOT . '/user_edit.php';
        require APP_ROOT . '/src/Controllers/user_edit.php';
        $data = userEditAction();
        break;
    case '/login' :
        // der User möchte das Login-Formular laden
        //require APP_ROOT . '/user_login.php';
        require APP_ROOT . '/src/Controllers/login.php';
        $data = loginAction();
        break;
    case '/register' :
        // der User möchte das Registrierungsformular laden
        // require APP_ROOT . '/user_register.php';
        require APP_ROOT . '/src/Controllers/register.php';
        $data = registerAction();
        break;
    case '/logout' :
        // der User hat sich aktiv ausgelogged und wir auf die Login-Seite weitergeleitet
        require APP_ROOT . '/src/Controllers/logout.php';
        $data = logoutAction();
        exit;
    case '/loggedin' :
        // der User hat sich erfolgreich eingelogged und wird auf die geschützte Loggedin-Seite weitergeleitet
        require APP_ROOT . '/src/Controllers/loggedin.php';
        $data = loggedinAction();
        break;
    default: 
        // auf index-Seite umleiten oder ggf. Fehlerseite 404 ausgeben...
        // die('Seite existiert nicht');
        require APP_ROOT . '/src/Controllers/index.php';
}

extract($data);

require APP_ROOT . '/src/templates/' . $template;