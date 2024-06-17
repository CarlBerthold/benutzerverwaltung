<?php

# Session starten
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location:' . APP_URL . '/login', TRUE, 307); // Location angepasst
    exit;
}

require APP_ROOT . '/src/templates/loggedin.tpl.php';

