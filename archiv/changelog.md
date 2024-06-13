# Projekt Benutzerverwaltung

## Projektinitialisierung

&rArr; Zusammenstellung der initialen Projektdateien aus den Übungen und Workshops

Datei   |   Quelle   |   Beschreibung
----   |   ----   |   ----
`user_edit.php`   |   Aufgabe 12 `user_edit.php`   |   Formular zur Änderung der Benutzerdaten eines Benutzers
`user_register.php`   |   Aufgabe 12 `register.php`   |   Formular zur Registrierung
`user_list.php`   |   Aufgabe 11d `aufgabe11d.php`   |   Tabelle mit Ausagen aller Benutzer
`user_login.php`   |   Projekt Benutzerverwaltung `benutzverwaltung/login.php`   |   Formular zur Anmeldung/Login mit Session
`loggedin.php`   |   Projekt Benutzerverwaltung `benutzverwaltung/loggedin.php`   |   Bestätigungsseite User eingelogged
`logout.php`   |   Projekt Benutzerverwaltung `benutzverwaltung/logout.php`   |      PHP-Script zum Ausloggen
`inc/data.inc.php`   |   Aufgabe 21 `inc/data.inc.php`   |   User-Datenarray als Rückgabewert Funktion fetchData() 
`inc/database.inc.php`   |   Aufgabe 21 `inc/database.inc.php`   |   PDO-Datenbankverbindung durch Funktionsaufruf connectDB()
`inc/database_functions.inc.php`   |   Aufgabe 21 `database_functions.inc.php`   |   PDO CRUD-Operationen
`inc/User.php`   |   Aufgabe 23 `inc/User.php`   |   Klassenbibliothek Klasse User 
`inc/users.sql`   |   Aufgabe 21 `users.sql`   |   SQL-Script aus Dump Aufgabe 21 


&rArr; Versionierung `archiv/versions/benutzerverwaltung00.zip`

## Vorbereitende Anpassungen

&rArr; in allen Dateien, in denen wir mit Daten User-Daten gearbeitet hatten sollen diese jetzt aus der Datei `data.inc.php` eingelesen werden (später natürlich aus der Datenbank)

### Datei `user_login.php`

**Änderungen:** 
- einige Kommentare entfernt
- `$userData` aus Datei `inc/data.inc.php` durch Funktionsaufruf `fetchData()` laden
- der Key `'loginname'` muss durch `'email'` ersetzt werden - in der Datenstruktur ist die E-Mail als Anmeldename vorgesehen
- Anpassung auch im Formularbereich

### Datei `user_list.php`

**Änderungen:** 
- einige Kommentare entfernt - sonst keine Anpassung notwendig
- _Anmerkung:_ hier ist noch keine Sessionverwaltung implementiert

### Datei `user_edit.php`

**Änderungen:** 
- einige Kommentare entfernt
- keine Anpassung notwendig
- Id zum Testen geändert `$id = 1;`
- _Anmerkung:_ auch hier ist noch keine Sessionverwaltung implementiert
- _Anmerkung:_ noch kein Funktionalität bei Versenden des Formulars implementiert

### Datei `user_register.php`

**Änderungen:**
- einige Kommentare entfernt 
- keine Anpassung notwendig
- _Anmerkung:_ noch kein Funktionalität bei Versenden des Formulars implementiert
- _Anmerkung:_ auch hier ist noch keine Sessionverwaltung implementiert

### Datei `loggedin.php`

**Änderungen:** 
- einige Kommentare entfernt
- Headerweiterleitung anpassen auf Location `user_login.php`

### Datei `logout.php`

**Änderungen:** 
- einige Kommentare entfernt
- Headerweiterleitung anpassen auf Location `user_login.php`

### Datei ``inc/data.inc.php``

**Änderungen:** 
- einige Kommentare entfernt

&rArr; Versionierung `archiv/versions/benutzerverwaltung01.zip`

## Stylen

&rArr; ein bisschen CSS (quick&dirty aus bestehenden Dateien übernommen) sowie ein bisschen JavaScript für clientseitige Validierung und Verbesserung ui/ux

### Datei `user_login.php`

**Änderungen:**
- Web-Font eingebunden `css/fonts_sourcesanspro.css`
- Icon-Font eingebunden `css/material-icons.css`
- CSS-Datei eingebunden `css/login.css`
- Überschrift h1 hinzugefügt
- div-Elemente tw. entfernt
- fieldsets zwecks Formatierung hinzugefügt
- Reset-Button hinzugefügt
- Link-Button zur Seite 'user_register.php' hinzugefügt
- Attribut autocomplete den Input-Elementen hinzugefügt
- Attribut autofocus dem ersten Input hinzugefügt
- Passwordfeld um ein Icon für Umschaltung des Input-Typs erweitert (span-Elemente)
- Javascript zum Umschalten des Input-Typs (Sichtbarmachen der Password-Eingabe) hinzugefügt
- footer hinzugefügt

### Datei `user_register.php`

**Änderungen:**
- analog 'user_login' - jedoch zusätzlich
- CSS-Datei eingebunden `css/register.css`
- div-Elemente tw. entfernt
- fieldsets zwecks Formatierung hinzugefügt
- Reset-Button hinzugefügt
- Link-Button zur Seite 'user_login.php' hinzugefügt
- Attribut placeholder den Input-Elementen hinzugefügt
- Attribut size den Input-Elementen hinzugefügt
- Attribut autocomplete den Input-Elementen hinzugefügt
- Attribut tabindex den Input-Elementen hinzugefügt
- Attribut autofocus dem ersten Input hinzugefügt
- Passwordfeld um ein Icon für Umschaltung des Input-Typs erweitert (span-Elemente)
- Javascript zum Umschalten des Input-Typs (Sichtbarmachen der Password-Eingabe) hinzugefügt
- Detail-Icons für Benutzereingabeinformationen hinzugefügt (detail-summay-Elemente)
- Javascript für Detail-Anzeige der Benutzereingabeinformationen hinzugefügt
- Javascript für clientseitige Passwordvalidierung (Übereinstimmung der Passwörter) hinzugefügt
- footer hinzugefügt

### Datei `user_list.php`

**Änderungen:** 
- analog 'user_login' - jedoch zusätzlich
- CSS-Datei eingebunden `css/style.css`
- CSS-Datei eingebunden `css/table.css`
- main-Element hinzugefügt
- nav-Element mit menue 'logout.php' hinzugefügt
- section als Cardbox hinzugefügt
- footer hinzugefügt

### Datei `user_edit.php`

**Änderungen:** 
- analog 'user_login' - jedoch zusätzlich
- CSS-Datei eingebunden `css/style.css`
- CSS-Datei eingebunden `css/form.css`
- CSS-Datei eingebunden `css/edit.css`
- main-Element hinzugefügt
- nav-Element mit menue 'logout.php' und 'user_list.php' hinzugefügt
- section als Cardbox hinzugefügt
- footer hinzugefügt
  
### Datei `loggedin.php`

**Änderungen:** 
- analog 'user_login' - jedoch zusätzlich
- CSS-Datei eingebunden `css/style.css`
- CSS-Datei eingebunden `css/form.css`
- main-Element hinzugefügt
- nav-Element mit menue 'logout.php' und 'user_list.php' hinzugefügt
- section als Cardbox hinzugefügt
- random Content via JavaScript hinzugefügt (api.chucknorris.io)
- footer hinzugefügt

### zusätzliche Datei `index.php`

- hier Verlinkung der einzelnen Seiten

&rArr; Versionierung `archiv/versions/benutzerverwaltung02.zip`