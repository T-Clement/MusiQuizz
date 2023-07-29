<?php

session_start();
// Create and put token in $_SESSION
$token = md5(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;


require 'includes/_database.php';
// Inscription
if (!empty($_POST) && $_POST['form-type'] === "sign-in") {
    // var_dump("Formulaire sign-in");
    // var_dump($_POST);
    if(!(isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"])) {
        die("Jeton CSRF non valide");
    }
    //  // FILTER SANITIZE STRING est déprécié
    //  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // ADD TRIM
    $filters = [
        "pseudo" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "email" => FILTER_SANITIZE_EMAIL,
        "password" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
      ];
    $post = filter_input_array(INPUT_POST, $filters);
    // extract post datas and put it in variables with names as the keys of the POST
    extract($post);

    $errors = [];


    if (empty($pseudo) || strlen($pseudo) < 3) {
        array_push($errors, 'Le nom est requis et doit contenir au moins 3 caractères.');
    }

    // filter of mail validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, 'L\'email n\'est pas une adresse email valide.');
    }

    // password validation
    if (empty($password) || strlen($password) < 6) {
        array_push($errors, 'Le mot de passe est requis et doit contenir au moins 6 caractères.');
    }


    // check in database if a user is already register with this pseudo an this mail
    if (empty($errors)) {
        // vérification name
        $req = $dbCo->prepare('SELECT * FROM users WHERE pseudo_user = :pseudo');
        $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->execute();

        // if more than one row, it means there is already an entry une database
        if ($req->rowCount() > 0) {
            array_push($errors, "Un utilisateur est déjà enregistré avec ce nom");
        }

        // mail verification
        $req = $dbCo->prepare('SELECT * FROM users WHERE mail_user = :email');
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() > 0) {
            array_push($errors, "Un utilisateur est déjà enregistré avec cet email");
        }

        // var_dump($errors); exit;

        // if no errors, insertion of new user in database
        if (empty($errors)) {

            $req = $dbCo->prepare("INSERT INTO users (pseudo_user, mail_user, password_user) VALUES (:pseudo, :email, :password)");
            $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $req->bindValue(':email', $email, PDO::PARAM_STR);
            $req->bindValue(':password', password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
            $req->execute();


            unset($pseudo, $email, $password);
            // $success = 'Votre inscription est terminée, vous pouvez <a href="login.php">vous connecter</a>';
        }
    }
    // affichage dans le require des messages
    if (isset($success)) var_dump($success);
    // var_dump($errors);

} else if (!empty($_POST) && $_POST["form-type"] === "log-in") {
    //LOG-IN
    
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // var_dump($post);
    // extract($post);

    // check csrf token
    if(!(isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"])) {
        die("Jeton CSRF non valide");
    }
    $filters = [
        "pseudo" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "password" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
      ];
    $post = filter_input_array(INPUT_POST, $filters);
    // extract post datas and put it in variables with names as the keys of the POST
    extract($post);





    $errors = [];

    if (empty($pseudo) || !filter_var($pseudo, FILTER_SANITIZE_FULL_SPECIAL_CHARS,)) {
        array_push($errors, "Le pseudo n'est pas valide");
    }

    if (empty($password)) {
        array_push($errors, "Le mot de passe est requis.");
    }

    // get all infos of user with pseudo put in POST
    if (empty($errors)) {
        $req = $dbCo->prepare("SELECT * FROM users WHERE pseudo_user = :pseudo");
        $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->execute();

        $user = $req->fetch();
        
        // compare password hash of database and password in POST an connect user if OK
        // on vérifie les identifiants et on connecte le user si c'est bon
        if ($user && password_verify($password, $user["password_user"])) {
            // pouvoir récupérer les infos du user courant
            $_SESSION['user'] = $user;
            header('Location: home.php');
        }
        

        array_push($errors, 'Mauvais identifiants.');
    }
    // var_dump($errors);
}


?>
<?php
$styleSheetCSS = "css/login.css";
require "includes/_head.php";
?>




<body>
    <header class="header">
        <div class="header__wrapper">
            <div class="header__brand" href="home.php">
                <img class='header__brand__img' src="img/logo-l.png" alt="">
                <h1 class="header__brand__title">Musiquiz</h1>
            </div>
        </div>
    </header>
    <main class="content">
        <div class="banner">
            <img class="banner__img" src="img/albums-covers.png" alt="patchwork d'albums musicaux">
            <div class="banner__content">
                <h2 class="banner__title">Le site parfait pour tester<br>sa <span class="banner__title--gradient">culture musicale</span></h2>
                <p class="banner__sub">Venez jouer entres amis et comparez vos scores</p>


                <div class="form-triggers">
                    <button class="form-btn btn-active" type="button" data-btn="log-in">Connexion</button>
                    <button class="form-btn" type="button" data-btn="sign-in">Inscription</button>
                </div>
                <?php require 'includes/_messages.php'; ?>
                <div class="forms">
                    <!-- log in form -->
                    <form class="form js-form active" action="" method="post" data-form="log-in">
                        <h3>Connexion</h3>
                        <input type="hidden" name="form-type" value="log-in">
                        <input type="hidden" name="token" value=<?=$token?>>
                        <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                        <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                        <!-- <input type="hidden" name="token" value=<? //=$token
                                                                        ?>> -->
                        <button type="button" class="js-password-visibility">Rendre visible</button>
                        <input class="form-submit" type="submit" value="Se connecter">
                    </form>



                    <!-- sign in form -->
                    <form class="form js-form" action="" method="post" data-form="sign-in">
                        <h3>S'inscrire</h3>
                        <input type="hidden" name="form-type" value="sign-in">
                        <input type="hidden" name="token" value=<?=$token?>>
                        <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                        <input class="form-field" type="text" name="email" placeholder="Email">
                        <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                        <input class="form-field js-password" type="password" name="password_confirmation" placeholder="Confirmez votre mot de passe">
                        <input class="form-submit" type="submit" value="S'inscrire">
                    </form>

                </div>


            </div>
        </div>
    </main>

    <script src="index.js"></script>
</body>

</html>