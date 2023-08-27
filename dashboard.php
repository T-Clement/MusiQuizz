<?php
// var_dump($_POST);
require 'includes/_database.php';
require 'includes/_functions.php';
session_start();

if(!(isset($_SESSION['user'])) && !isValidHTTPReferer(__DIR__)) {
    session_destroy();
    header("Location: index.php?error_referer");
    exit; 
} 


// var_dump($_SESSION);
// extract($_SESSION["user"]);

// $query = $dbCo->prepare("");
// $query->execute([]);
// $rooms = $query->fetchAll();
$styleSheetCSS = "css/home_style.css";
require 'includes/_head.php';
require 'includes/_header.php';
// if(!(empty($_POST))) var_dump($_POST);

// delete user password from $_SESSION



if(isset($_POST["form-action"])) {
    $errors = [];
    if($_POST["form-action"] == "update") {
    
        // if values are the same as in $_SESSION, add to feedback in errors array
        if($_POST["pseudo"] == $_SESSION["user"]["pseudo_user"] && $_POST["mail"] == $_SESSION["user"]["mail_user"]) {
            array_push($errors, "Les informations que vous avez rentrés sont identiques à celles présentes précédemment.");
        }
    

        // --------
        // --------
        // !!!!! --- need to check if the new pseudo or new mail is already in database --- !!!!!
        // --------
        // --------

        // vérification name
        $req = $dbCo->prepare('SELECT * FROM '. $_ENV["USERS"] .' WHERE pseudo_user = :pseudo AND pseudo_user!= :pseudo');
        $req->bindValue(':pseudo', $_POST["pseudo"], PDO::PARAM_STR);
        $req->execute();

        // if more than one row, it means there is already an entry une database
        if ($req->rowCount() > 0) {
            array_push($errors, "Un utilisateur est déjà enregistré avec ce nom");
        }

        // mail verification
        $req = $dbCo->prepare('SELECT * FROM '. $_ENV["USERS"] .' WHERE mail_user = :email AND mail_user != :email');
        $req->bindValue(':email', $_POST["mail"], PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() > 0) {
            array_push($errors, "Un utilisateur est déjà enregistré avec cet email");
        }

        // if(!(empty($_POST))) var_dump($_POST);
        if(empty($errors) && isset($_POST) && $_POST["form-action"] == "update") {
            // update user infos in database
            $query = $dbCo->prepare("UPDATE ". $_ENV["USERS"] ." SET pseudo_user = :pseudo, mail_user= :mail_user WHERE id_user = :id_user");
            $isOk = $query->execute([
                "pseudo" => trim(htmlspecialchars($_POST["pseudo"])),
                "mail_user"=> trim(htmlspecialchars($_POST["mail"])),
                "id_user" => intval($_POST["id-user"])
            ]);
            
            
            if ($isOk) {

                // $req = $dbCo->prepare("SELECT * FROM ". $_ENV["USERS"] ." WHERE pseudo_user = :pseudo");
                // $req->bindValue(":pseudo", $_POST["pseudo"], PDO::PARAM_STR);
                $req = $dbCo->prepare("SELECT * FROM ". $_ENV["USERS"] ." WHERE id_user = :id");
                $req->bindValue(":id", $_POST["id-user"], PDO::PARAM_INT);
                $req->execute();
        
                $updatedUser = $req->fetch();
                // var_dump($updatedUser);
                $success = "Votre compte a bien été mis à jour.";
                unset($_SESSION["user"]);
                $_SESSION["user"] = $updatedUser;
                

                // need to fix the issue in index.php
                
                
            }
        };

    }


}
?>


<main>
    
    <h2>Compte du joueur : <?=$_SESSION["user"]["pseudo_user"]?></h2>

    <!-- display feedback when same from infos are send in form -->
    <!--  -->
    <?php 
        require 'includes/_messages.php';
    ?>
    <section>
        <form class="form" action="dashboard.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="form-action" value="update">
            <input type="hidden" name="id-user" value=<?=$_SESSION["user"]["id_user"]?>>
            <div class="form-field">
                <label class="form-label" for="pseudo">Pseudo de l'utilisateur</label>
                <input class="form-input" type="text" name="pseudo" placeholder="Pseudo" value="<?=$_SESSION["user"]["pseudo_user"] ?? $_POST["pseudo"]?>">
            </div>
            <div class="form-field">
                <label for="email">Email de l'utilisateur</label>
                <input type="text" name="mail" placeholder="Email" value="<?=$_SESSION["user"]["mail_user"] ?? $_POST["mail"]?>">
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
    <section>
        <p>
            Vous souhaitez supprimer vos données ?
        </p>
        <form action="post" action="dashboard.php">
    <!-- <input type="hidden" name="acion" value=""> -->
    <input class="js-delete-id-user" type="hidden" name="id-user" value=<?=$_SESSION["user"]["id_user"]?>>
            <button class="form-submit-btn js-delete-account">Supprimer mon compte</button>
        </form>
    </section>







</main>



<?php 
// require footer where links are + link to script
?>


<script src="dashboard.js"></script>
</body>
</html>