<?php

require 'includes/_database.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musiquiz</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <header class="header">
        <div class="header__wrapper">
            <a class="header__brand" href="home.php">
                <img class='header__brand__img' src="img/logo-l.png" alt="">
                <h1 class="header__brand__title">Musiquiz</h1>
            </a>
        </div>
    </header>
    <main>
        <div class = "banner">
            <img class="banner__img" src="img/albums-covers.png" alt="">
            <div class="banner__txt">
                <h2 class="banner__title">Le site parfait pour tester<br>sa <span class="banner__title--gradient">culture musicale</span></h2>
                <p class="banner__sub">Venez jouer entres amis et comparez vos scores</p>
            </div>

            <!--switch toggle section-->

            <!-- <div class="container">
                <div class="columns">
                    <div class="column is-12">
                        <div class="up-in-toggle">
                            <input type="radio" id="switch_left" name="switch_2" value="yes" checked/>
                            <label for="switch_left">Inscription</label>
                            <input type="radio" id="switch_right" name="switch_2" value="no"/>
                            <label for="switch_right">Connexion</label>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="form-triggers">
                <button class="form-btn" type="button" data-btn="log-in">Connexion</button>
                <button class="form-btn" type="button" data-btn="sign-in">Inscription</button>
            </div>

            <div class="forms">
                <!-- log in form -->
                <form class="form js-form" action="" method="post" data-form="log-in">
                    <h3>Connexion</h3>
                    <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                    <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                    <button type="button" class="js-password-visibility">Rendre visible</button>
                    <!-- <input type="submit" value="Se connecter"> -->
                    <input class="form-submit" type="submit" value="Se connecter">
                </form>



                <!-- sign in form -->
                <form class="form js-form" action="" method="post" data-form="sign-in">
                    <h3>S'inscrire</h3>
                    <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                    <input class="form-field" type="text" name="mail" placeholder="Email">
                    <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                    <input class="form-field js-password" type="password" name="password_confirmation" placeholder="Confirmez votre mot de passe">

                    <!-- <input type="submit" value="Se connecter"> -->
                    <input class="form-submit" type="submit" value="Se connecter">
                </form>

                <!-- <form action="" method="get" class="form-example">
                    <div class="form-example">
                        <label for="name">Enter your name: </label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-example">
                        <label for="email">Enter your email: </label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-example">
                        <input type="submit" value="Subscribe!">
                    </div>
                </form> -->






                <form class="form js-form-signup" action="" method></form>
            </div>





        </div>
    </main>

    <script src="script.js"></script>
</body>

</html>