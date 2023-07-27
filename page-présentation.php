<?php
session_start();
// Create and put token in $_SESSION
$token = md5(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;


require 'includes/_database.php';
// Inscription
if (!empty($_POST) && $_POST['form-type'] === "sign-in") {
    var_dump("Formulaire sign-in");
    var_dump($_POST);
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

}