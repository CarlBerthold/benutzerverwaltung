<?php

# aus Aufgabe 21 `inc/database_functions.inc.php`

function find(int $id, PDO $db): array|NULL
{
    // SQL-Statement mit unbenannten Platzhaltern
    $sql = 'SELECT * FROM `users` where `id` = ?';

    try {
        $PDOStatement = $db->prepare($sql);
        $PDOStatement->execute([$id]);
        $user = $PDOStatement->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage(), PHP_EOL;
        // hier ggf. Header-Weiterleitung auf Fehlerseite
        exit;
    }

    return $user ?: NULL;
}


function findAll(PDO $db): array|NULL
{
    $sql = 'SELECT * FROM `users`';

    try {
        // direkt als query ausführen
        $PDOStatement = $db->query($sql);

        // alle Datensätze abholen und direkt zurückgeben
        return $PDOStatement->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage(), PHP_EOL;
        // hier ggf. Header-Weiterleitung auf Fehlerseite
        exit;
    }
}


function insert(array $data, PDO $db): bool
{
    // eine Liste mit den Array-Keys für die columns erstellen
    $columnList = array_keys($data);
    // => an sich müsste noch überprüft werden, ob es die entsprechenden columns auch gibt

    // eine Liste für die Platzhalter erstellen - kann auf Basis der $columnList erfolgen
    $placeholderList = array_map(fn ($el) => ':' . $el, $columnList);
    // var_dump($placeholderList); exit;


    // SQL-Statement mit benannten Platzhaltern aus den Listen
    $sql = 'INSERT INTO `users`(' . implode(', ', $columnList) .  ') VALUES (' . implode(', ', $placeholderList) . ')';
    // var_dump($sql); exit;

    try {
        // Prepared Statement vorbereiten
        $PDOStatement = $db->prepare($sql);
        
        // Prepared Statement ausführen - Rückgabe ist TRUE wenn erfolgreich
        return $PDOStatement->execute($data);
    } catch (PDOException $e) {
        echo $e->getMessage(), PHP_EOL;
        // hier ggf. Header-Weiterleitung auf Fehlerseite
        exit;
    }
}


function update(array $data, PDO $db): bool
{
    // Assignmentliste mit den key-value-Paaren für die SET-Klausel erstellen
    // Anmerkung: die Id muss/darf nicht als Wert geändert werden
    // => Kopie des Datenarrays erstellen und die id löschen
    $temp = $data;
    unset($temp['id']);
    // ein Array mit den Keys als Basis für die Assignmentliste erstellen
    $keyList = array_keys($temp);
    $assignmentList = array_map(fn ($key) => "$key = :$key", $keyList);
    // var_dump($assignmentList, implode(', ', $assignmentList)); exit;

    // SQL-Statement mit benannten Platzhaltern in der Assignmentliste
    $sql = 'UPDATE `users` SET ' . implode(', ', $assignmentList) . ' WHERE `id` = :id';

    try {
        // Prepared Statement vorbereiten
        $PDOStatement = $db->prepare($sql);

        // Prepared Statement ausführen - Rückgabe ist TRUE wenn erfolgreich
        return $PDOStatement->execute($data);
    } catch (PDOException $e) {
        echo $e->getMessage(), PHP_EOL;
        // hier ggf. Header-Weiterleitung auf Fehlerseite
        exit;
    }
}


function delete(int $id, PDO $db): bool
{
    // SQL-Statement mit unbenannten Platzhaltern
    $sql = 'DELETE FROM `users` WHERE `id` = ?';

    try {
        // Prepared Statement vorbereiten
        $PDOStatement = $db->prepare($sql);

        // Prepared Statement ausführen - Rückgabe ist TRUE wenn erfolgreich
        return $PDOStatement->execute([$id]);
    } catch (PDOException $e) {
        echo $e->getMessage(), PHP_EOL;
        // hier ggf. Header-Weiterleitung auf Fehlerseite
        exit;
    }
}
