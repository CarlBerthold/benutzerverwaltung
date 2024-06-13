<?php

# Session starten
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: user_login.php', TRUE, 307); // Location angepasst
    exit;
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>geschützter Bereich</title>
    <link href="css/fonts_sourcesanspro.css" rel="stylesheet">
    <link href="css/material-icons.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/form.css" rel="stylesheet" type="text/css">
    <style>
        article {
            width: fit-content;
            margin: auto;
        }
        article img {
            filter: grayscale(0.75) opacity(0.5);
            max-width: 350px;
            min-width: 200px;
            width: 15vw;
        }
        hr {
            color: #d3d3d3;
        }
    </style>
</head>

<body>
    <main id="main">
        <nav id="nav">
            <ul>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="user_list.php">Benutzerverwaltung</a></li>
            </ul>
        </nav>
        <h1>geschützter Bereich</h1>
        <section class="cardbox">

            <p class="text-center">Hallo <?= $_SESSION['name'] ?>, Du bist eingeloggt!</p>
            <hr>
            <article class="text-center cardbox">
                <h2>Weisheit des Tages</h2>
                <a href="https://api.chucknorris.io/" title="Chuck Norris Jokes Api - JSON API for random Chuck Norris jokes">
                    <img alt="Chuck Norris Jokes Api - JSON API for random Chuck Norris jokes" src="https://api.chucknorris.io/img/chucknorris_logo_coloured_small@2x.png">
                </a>
                <blockquote id="random"></blockquote>
            </article>
        </section>
    </main>
    <footer class="footer text-center">
        <p>
            Benutzerverwaltung - geschützter Bereich
        </p>
        <p>
            Powered by <a href="index.php">lorem.io</a>.
        </p>
    </footer>
    <script>
        (function() {
            "use strict";

            function init() {
                const apiUrl = "https://api.chucknorris.io/jokes/random";
                fetch(apiUrl)
                    .then((response) => response.json())
                    .then((data) => {
                        const joke = data.value;
                        // Display the joke on your website or app
                        document.getElementById('random').innerHTML = joke;
                        console.log(joke, data);
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            }
            window.addEventListener('load', init);
        })();
    </script>


</body>

</html>