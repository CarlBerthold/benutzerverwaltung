<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierungsformular</title>
    <link href="<?= ASSET_PATH ?>/css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="<?= ASSET_PATH ?>/css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>/css/login.css" rel="stylesheet" type="text/css">
    <link href="<?= ASSET_PATH ?>/css/register.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Registrierungsformular</h1>
    <form action="<?= APP_URL ?>/register" method="post">
        <fieldset id="reg-data">
            <legend>Registrierung</legend>

            <label for="firstname">Vorname</label>
            <input type="text" name="firstname" id="firstname" placeholder="Vorname" autocomplete="firstname" size="12" tabindex="1" autofocus required>
            <details>
                <summary tabindex="6" title="Information zur Eingabe Vorname"></summary>
                <div>
                    <h4>Konvention:</h4>
                    <p>Namen dürfen nur aus (internationalen) Buchstaben (einschließlich Umlauten) bestehen.<br>
                        Leerzeichen und Bindestrich zur Worttrennung als auch das Apostroph in Namen sind erlaubt.</p>
                </div>
            </details>

            <label for="lastname">Nachname</label>
            <input type="text" name="lastname" id="lastname" placeholder="Nachname" autocomplete="lastname" size="12" tabindex="2" required>
            <details>
                <summary tabindex="7" title="Information zur Eingabe Nachname"></summary>
                <div>
                    <h4>Konvention:</h4>
                    <p>Namen dürfen nur aus (internationalen) Buchstaben (einschließlich Umlauten) bestehen.<br>
                        Leerzeichen und Bindestrich zur Worttrennung als auch das Apostroph in Namen sind erlaubt.</p>
                </div>
            </details>

            <label for="email">E-Mail</label>
            <input type="text" name="email" id="email" placeholder="E-Mail-Adresse für Login" autocomplete="email" size="12" tabindex="3" required>
            <details>
                <summary tabindex="8" title="Information zur Eingabe E-Mail-Adresse"></summary>
                <div>
                    <h4>Konvention:</h4>
                    <p>E-Mail-Adressen müssem nach <a href="https://www.rfc-editor.org/info/rfc2822" target="_blank">RFC
                            2822</a> angeben werden!
                        Wobei der Grundaufbau <code>local-part@domain-part</code> entspricht und der
                        <code>domain-part</code> zumindest aus einem Hostnamen, einem Punkt und einer Top-Level-Domain
                        bestehen muss.</p>
                </div>
            </details>

            <label for="password">Passwort</label>
            <span class="view-icon">
                <input type="password" name="password" id="password" placeholder="Passwort" autocomplete="password" size="12" tabindex="4" required>
                <span class="icon"></span>
            </span>
            <details>
                <summary tabindex="9" title="Information zur Eingabe Passwort"></summary>
                <div>
                    <h4>Konvention:</h4>
                    <p>Das Passwort muss aus mindesten 8 Zeichen
                        (maximal 25 Zeichen), einem Groß- und einen Kleinbuchstaben, einer Zahl
                        und einem der folgenden Sonderzeichen #?!@$ %^&amp;*- bestehen!</p>
                </div>
            </details>

            <label for="pwd_wdh">Passwort wdh</label>
            <span class="view-icon">
                <input type="password" id="pwd_wdh" required placeholder="Passwort wiederholen" autocomplete="password" size="12" tabindex="5">
                <span class="icon"></span>
            </span>
            <details>
                <summary tabindex="10" title="Information zur Passwort Wiederholung"></summary>
                <div id="details_pwdwdh">
                    <h4>Zur Überprüfung:</h4>
                    <p>Das Passwort sollte hier ein zweites mal zwecks Überprüfung auf Gleichheit eingegeben werden.</p>
                </div>
            </details>
            
        </fieldset>
        <fieldset>
            <legend>Aktion</legend>
            <div>
                <button type="submit" id="submit_button" tabindex="6">registrieren</button>
                <button type="reset" id="reset_button" tabindex="0">zurücksetzen</button>
                <a href="<?= APP_URL ?>/login" class="button spacer_left" tabindex="0">zum Login</a>
            </div>
        </fieldset>
    </form>
    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - register
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
    <script>
        (function () {
            "use strict";

            function init() {
                document.getElementById('reset_button').addEventListener("click", function (ev) {
                    const firstnameEl = document.getElementById('firstname');
                    const lastnameEl = document.getElementById('lastname');
                    const emailEl = document.getElementById('email');
                    const passwordEl = document.getElementById('password');
                    const pwdwdhEl = document.getElementById('pwd_wdh');
                    firstnameEl.value = '';
                    lastnameEl.value = '';
                    emailEl.value = '';
                    passwordEl.value = '';
                    pwdwdhEl.value = '';
                    firstnameEl.classList.remove('error');
                    lastnameEl.classList.remove('error');
                    emailEl.classList.remove('error');
                    passwordEl.classList.remove('error');
                    pwdwdhEl.classList.remove('error');
                });

                document.getElementById('submit_button').addEventListener("click", function (ev) {
                    const pwdwdhEl = document.getElementById('pwd_wdh');
                    const details_pwdwdhEl = document.getElementById('details_pwdwdh');
                    if (document.getElementById('password').value !== pwdwdhEl.value) {
                        ev.preventDefault();
                        pwdwdhEl.classList.add('error');
                        details_pwdwdh.innerHTML = details_pwdwdh.innerHTML +
                            `                    <hr>
                    <h4>Fehler:</h4>
                    <p class="error_message">Die Passwörter stimmen nicht überein!</p>`;
                    }
                });

                const detailsEls = document.querySelectorAll('details');
                detailsEls.forEach(function (el) {
                    el.addEventListener("toggle", function (ev) {
                        if (this.open) {
                            detailsEls.forEach(el => {
                                if (el != this && el.open) el.removeAttribute('open');
                            });
                        }
                    })
                });

                document.querySelectorAll('.view-icon .icon').forEach(function (el) {
                    el.addEventListener('click', function (ev) {
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