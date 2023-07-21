<?php

if(isset($_SESSION["user"])) {
    session_destroy();
}


session_start();
require 'includes/_database.php';
// Inscription
if(!empty($_POST) && $_POST['form-type'] === "sign-in") {
    var_dump("Formulaire sign-in");
    var_dump($_POST);
    // FILTER SANITIZE STRING est déprécié
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // extraire les données du post dans des variables nommées par le nom de la clé
    extract($post);
    
    $errors = [];
    
    
    if(empty($pseudo) || strlen($pseudo) < 3) {
        array_push($errors, 'Le nom est requis et doit contenir au moins 3 caractères.');
      }
    
    // filtre de validation du mail
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, 'L\'email n\'est pas une adresse email valide.');
    }

    // validation du mot de passe
    if(empty($password) || strlen($password) < 6) {
    array_push($errors, 'Le mot de passe est requis et doit contenir au moins 6 caractères.');
    }
    
    
    // vérifier si un nom et email d'utilisateur sont déjà présents
    if(empty($errors)) {
    // vérification name
    $req = $dbCo->prepare('SELECT * FROM users WHERE pseudo_user = :name');
    $req->bindValue(':name', $pseudo, PDO::PARAM_STR);
    $req->execute();
    
    // si le retour est de plus d'une ligne, ça veut dire qu'il y a déjà une entrée dans la BDD
    if($req->rowCount() > 0) {
        array_push($errors, "Un utilisateur est déjà enregistré avec ce nom");
    } 

    // vérification email
    $req = $dbCo->prepare('SELECT * FROM users WHERE mail_user = :email');
    $req->bindValue(':email', $email, PDO::PARAM_STR);
    $req->execute();

    if($req->rowCount() > 0) {
        array_push($errors, "Un utilisateur est déjà enregistré avec cet email");
    } 

    // var_dump($errors); exit;
    
    // si pas d'erreurs, insertion de l'utilisateur dans la BDD
    if(empty($errors)) {

        $req = $dbCo->prepare ("INSERT INTO users (pseudo_user, mail_user, password_user) VALUES (:pseudo, :email, :password)");
        $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->bindValue(':password', password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
        $req->execute();


        unset($pseudo, $email, $password);
        $success = 'Votre inscription est terminée, vous pouvez <a href="login.php">vous connecter</a>';
        }
    
    
    
      
    }
    // affichage dans le require des messages
    if(isset($success)) var_dump($success);
    var_dump($errors);
} 
else if (!empty($_POST) && $_POST["form-type"] === "log-in") {
    // $password = "";
    //LOG-IN
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    var_dump($post);
    extract($post);
    
    $errors = [];

    if(empty($pseudo) || !filter_var($pseudo, FILTER_SANITIZE_STRING)) {
        array_push($errors, "Le pseudo n'est pas valide");
    }
    
    if(empty($password)) {
        array_push($errors, "Le mot de passe est requis.");
    }
    
    if(empty($errors)) {
        $req = $dbCo -> prepare("SELECT * FROM users WHERE pseudo_user = :pseudo");
        $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->execute();
        
        $user = $req->fetch();
        // var_dump($user["password_user"]);
        // var_dump($password);
        // var_dump(password_verify($password, $user["password_user"]));
        // on vérifie les identifiants et on connecte le user si c'est bon
        if($user && password_verify($password, $user["password_user"])) {
            // pouvoir récupérer les infos du user courant
            $_SESSION['user'] = $user;
            header('Location: home.php');
        }
        // var_dump($user);
        // var_dump($_SESSION["user"]);

        array_push($errors, 'Mauvais identifiants.');
    }
    var_dump($errors);
}





// si la session ne comporte pas de user, redirection vers login.php

// if(empty($_SESSION['user'])) {
//     header("Location: login.php");
// }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musiquiz</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"> -->
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
            <?php require 'includes/_messages.php';?>
            <div class="forms">
                <!-- log in form -->
                <form class="form js-form" action="" method="post" data-form="log-in">
                    <h3>Connexion</h3>
                    <input type="hidden" name="form-type" value="log-in">
                    <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                    <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                    <!-- <input type="hidden" name="token" value=<?//=$token?>> -->
                    <button type="button" class="js-password-visibility">Rendre visible</button>
                    <input class="form-submit" type="submit" value="Se connecter">
                </form>
                
                
                
                <!-- sign in form -->
                <form class="form js-form" action="" method="post" data-form="sign-in">
                    <h3>S'inscrire</h3>
                    <input type="hidden" name="form-type" value="sign-in">
                    <input class="form-field" type="text" name="pseudo" placeholder="Pseudo" required>
                    <input class="form-field" type="text" name="email" placeholder="Email">
                    <input class="form-field js-password" type="password" name="password" placeholder="Mot de passe">
                    <input class="form-field js-password" type="password" name="password_confirmation" placeholder="Confirmez votre mot de passe">
                    <input class="form-submit" type="submit" value="S'inscrire">
                </form>

            </div>


        </div>
    </main>

    <script src="script.js"></script>
</body>

</html>