<?php
var_dump($_POST);
session_start();
var_dump($_SESSION);
extract($_SESSION["user"]);
require 'includes/_database.php';

// $query = $dbCo->prepare("");
// $query->execute([]);
// $rooms = $query->fetchAll();
$styleSheetCSS = "css/home_style.css";
require 'includes/_head.php';
require 'includes/_header.php';
?>


<main>
    <h2>Compte du joueur : <?=$pseudo_user?></h2>

    <section>
        <form class="form" action="dashboard.php" method="post" enctype="multipart/form-data">
            <div class="form-field">
                <label class="form-label" for="pseudo">Pseudo de l'utilisateur</label>
                <input class="form-input" type="text" name="pseudo" placeholder="Pseudo" value="<?=$pseudo_user ?? $_POST["pseudo"]?>">
            </div>
            <div class="form-field">
                <label for="email">Email de l'utilisateur</label>
                <input type="text" name="mail" placeholder="Email" value="<?=$mail_user?>">
            </div>
            
            <button class="form-submit-btn" type="submit">Mettre à jour</button>

        </form>

        <!-- <form action="dashboard.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom d'utilisateur</label>
            <input type="text" name="name" class="form-control" placeholder="Nom d'utilisateur" value="<?= $name ?? $user->name;?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $email ?? $user->email;?>">
        </div>
        <div class="form-group">
            <label for="photo">Photo au format jpeg, jpg ou png d'au moins 200x200px</label>
            <input type="file" name="photo" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Envoyer</button>
        </form> -->
    </section>







</main>







</body>
</html>