<?php

# aus Lektion 10 - active-recorde-Klasse

class User
{
    protected $id = NULL;
    protected $firstname = '';
    protected $lastname = '';
    protected $email = '';
    protected $password = '';
    protected $role = '';
    protected $createdAt = '';
    protected $updatedAt = '';

    // zusätzliches Attribut für die Datenbankverbindung
    protected static $db;


    # Methode zum statischen Binden der Datenbankverbindung an die Klasse
    public static function setDb(PDO $db)
    {
        self::$db = $db;
    }

    # constructor
    public function __construct(array $data = [])
    {
        if ($data) $this->setAttributes($data);
    }

    # Setter für das virtuelle Attribut User::$attributes
    public function setAttributes(array $data = [])
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $setterName = 'set' . ucfirst($key);
                if (method_exists($this, $setterName)) {
                    $this->$setterName($value); // Setteraufruf
                } elseif (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    # Getter für das virtuelle Attribut User::$attributes
    public function getAttributes(): array
    {
        $result = get_object_vars($this);
        return $result;
    }

    # mag. Methode __get für den Direktzugriff auf Attribute
    public function __get($name)
    {
        $getterName = 'get' . ucfirst($name);
        if (method_exists($this, $getterName)) {
            return $this->$getterName();
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return NULL;
    }

    # mag. Methode __set für den Direktzugriff auf Attribute
    public function __set($name, $value)
    {
        $setterName = 'set' . ucfirst($name);
        if (method_exists($this, $setterName)) {
            $this->$setterName($value);
        }
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    # mag. Methode __call - hier als Ersatz für die einfachen Getter und Setter, also die jeweils keine Logik implementiert haben und nur den unverändert Wert zurückgeben bzw. setzen
    public function __call($name, $arguments)
    {
        // getter
        if (str_starts_with($name, 'get')) {
            if (method_exists($this, $name)) {
                return $this->$name();
            } else {
                $attr = lcfirst(substr($name, 3));
                if (property_exists($this, $attr)) {
                    return $this->$attr;
                }
            }
            return NULL;
        }

        // setter
        if (str_starts_with($name, 'set')) {
            if (method_exists($this, $name)) {
                return $this->$name($arguments[0]);
            } else {
                $attr = lcfirst(substr($name, 3));
                if (property_exists($this, $attr)) {
                    $this->$attr = $arguments[0];
                    return $this;
                }
            }
            return $this;
        }
    }

    # verbleibende Getter und Setter
    public function setPassword($password)
    {
        $this->password = (password_get_info($password)['algo'] !== NULL) ? $password : password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    # Setter für 'virtuelle Attribute' der Timestamps in snake_case_Schreibweise
    public function setCreated_at($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdated_at($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    # Active Record Methoden

    ## Standard Daten-Operation - Acronym CRUD: create, read, update, and delete // es fehlt ein Teil im Acronym: alle Datensätze listen
    ## Varianten:
    ### CRUDL (create, read, update, delete, list)
    ### BREAD (browse, read, edit, add, delete)

    # Datenoperation 'read' in CRUDL / BREAD
    public static function find(int $id): self|NULL
    {
        // Datenbankverbindung 'holen'
        $db = self::$db;
        // SQL-Statement mit unbenannten Platzhaltern
        $sql = 'SELECT * FROM `users` where `id` = ?';

        try {
            $PDOStatement = $db->prepare($sql);
            $PDOStatement->execute([$id]);
            # Fetch-Mode auf PDO::FETCH_CLASS ändern
            $PDOStatement->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $PDOStatement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        return $user ?: NULL;
        # anstelle der Rückgabe des Datenarrays befüllen wir jetzt direkt die Attribute und geben die geänderte Insatz zurück
        /*         if($user) {
            // 
            return new User($user);
            // 2do - setAttibutes sollte die geänderte Instanz zurückgeben
            // return $this;
        }
        return NULL; */
    }


    # Datenoperation 'list' in CRUDL oder 'browse' in BREAD
    public static function findAll(): array|NULL
    {
        // Datenbankverbindung 'holen'
        $db = self::$db;

        $sql = 'SELECT * FROM `users`';

        try {
            // direkt als query ausführen
            $PDOStatement = $db->query($sql);

            // $PDOStatement->setFetchMode(PDO::FETCH_CLASS, 'User');
            // $data = $PDOStatement->fetchAll();

            # alternativ den Fetch direkt in der fetchAll-Methode setzen
            $data = $PDOStatement->fetchAll(PDO::FETCH_CLASS, 'User');
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        return $data ?: NULL;
    }

    # Method zum Persitieren, unabhängig davon ob ein Update oder Insert gemacht werden soll
    public function persist(): self|bool
    {
        return ($this->id === NULL) ? $this->insert() : $this->update();
    }

    # Datenoperation 'create' in CRUDL oder 'add' in BREAD
    public function insert(): self|bool
    {
        // Daten aus Attributen auslesen
        $data = $this->getAttributes();
        # die Id wird nicht benötigt (ist ohnehin NULL), da diese im DBMS vergeben wird
        # leere Arrayelemente sollen ebenfalls nicht persitiert werden
        $data = array_filter($data);

        /*         # Logik für eventuelle Defaultwerte oder fehlende Wert hinzufügen (sofern nicht im DBMS gehandhabt), z. B. die Timestamps und die Rolle
        $data['role'] = 'inactive';
        $data['created_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s'); */

        # optional - sicherstellen, dass alle key-value-Paare gelöscht werden, für die im DBMS automatisch ein Wert gesetzt wird
        unset($data['id']);
        unset($data['role']);
        unset($data['createdAt']);
        unset($data['updatedAt']);

        // Datenbankverbindung 'holen'
        $db = self::$db;

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
            $PDOStatement->execute($data);

            // id des Datensatzes abfragen
            $id = $db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        # geänderte Instanz zurückgeben bzw. die Instanz aktualisieren mit den persititen Daten
        // $data['id'] = $id ?? NULL;
        // $this->setAttributes($data);
        // wenn in der Datenbank irgendwelche Defaultwerte gesetzt werden, dann müsste der Datensatz neu eingelesen werden 

        # den erstellten Datensatz aus der Datenbanktabelle auslesen und die Instanz selbst aktualisieren
        // andere Lösungsansatz als in Aufgabenbeschreibung
        $newUser = self::find($id);
        if($newUser) {
            $this->setAttributes($newUser->getAttributes());
        }

        return $this;
    }

    # Datenoperation 'update' in CRUDL und 'edit' in BREAD
    public function update(): self|bool
    {
        $data = $this->getAttributes();

        // Falls nicht im DBMS gehandhabt, muss der Timestamp updated_at manuell gesetzt werden
        // der Timestamp createdAt macht Probleme wegen den unterschiedlichen Namenskonventionen, wird aber ohnehin nicht benötig und kann gelöscht werden
        unset($data['createdAt'], $data['updatedAt']);
        // $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');


        // wenn die Originaldaten bekannt sind, könnte auf nur geänderte Werte gefilter werden => wir speichern aber den kompletten Datensatz neu 

        // Datenbankverbindung 'holen'
        $db = self::$db;

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
            $PDOStatement->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        # geänderte Instanz zurückgeben bzw. die Instanz aktualisieren mit den persititen Daten

        // $this->setUdpatedAt($data['updated_at']);
        // wenn in der Datenbank irgendwelche Defaultwerte gesetzt werden, dann müsste der Datensatz neu eingelesen werden 

        # den aktualisierten Datensatz aus der Datenbanktabelle auslesen und die Instanz selbst aktualisieren
        // andere Lösungsansatz als in Aufgabenbeschreibung
        $newUser = self::find($this->id);
        if($newUser) {
            $this->setAttributes($newUser->getAttributes());
        }

        return $this;
    }

    # Datenoperation 'delete' in CRUDL und im BREAD
    ## zwei Varianten einmal eine nichtstatische Methode delete(), die ein bestehende Instanz löscht und eine statische Methode destroy() die einen Datensatz anhand seiner id löscht
    public function delete(): self|bool
    {
        $id = $this->id;
        // Datenbankverbindung 'holen'
        $db = self::$db;

        // SQL-Statement mit unbenannten Platzhaltern
        $sql = 'DELETE FROM `users` WHERE `id` = ?';

        try {
            // Prepared Statement vorbereiten
            $PDOStatement = $db->prepare($sql);

            // Prepared Statement ausführen - Rückgabe ist TRUE wenn erfolgreich
            $PDOStatement->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        # der Datensatz ist jetzt zwar gelöscht, aber das Objekt immer noch vorhanden => es ist besser hier dann die id auf NULL
        $this->id = NULL;
        $this->role = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;

        return $this;
    }

    public static function destroy(int $id): bool
    {
        // Datenbankverbindung 'holen'
        $db = self::$db;

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

    # weitere Datenbankoperationen
    # spezielle active-record-Methoden findByEmail - einen Datensatz anhand der E-Mail finden
    public static function findByEmail(string $email): self|NULL
    {
        // Datenbankverbindung 'holen'
        $db = self::$db;
        // SQL-Statement mit unbenannten Platzhaltern
        $sql = 'SELECT * FROM `users` where `email` = ?';

        try {
            $PDOStatement = $db->prepare($sql);
            $PDOStatement->execute([$email]);
            # Fetch-Mode auf PDO::FETCH_CLASS ändern
            $PDOStatement->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $PDOStatement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
            // hier ggf. Header-Weiterleitung auf Fehlerseite
            exit;
        }

        return $user ?: NULL;
        # anstelle der Rückgabe des Datenarrays befüllen wir jetzt direkt die Attribute und geben die geänderte Insatz zurück
        /*         if($user) {
            // 
            return new User($user);
            // 2do - setAttibutes sollte die geänderte Instanz zurückgeben
            // return $this;
        }
        return NULL; */
    }
}
