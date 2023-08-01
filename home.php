<?php
session_start();
// check HTTP REFERER and USER in $_SESSION
require 'vendor/autoload.php'; #load les dependances de vendor
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'includes/_functions.php';

if(!(isset($_SESSION['user'])) && !isValidHTTPReferer(__DIR__)) {
    session_destroy();
    header("Location: index.php?error_referer");
    exit; 
} 
?>

<?php

// get user infos in session
// var_dump($_SESSION);

// Create and put token in $_SESSION
// $token = md5(uniqid(mt_rand(), true));
// $_SESSION['token'] = $token;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musiquiz</title>
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
    <!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="css/home_style.css">
</head>
<body>
    
    <?php require 'includes/_header.php'; ?>


    <main class="main container">
       
        <?php
        // if $_GET empty -> display TOP 3, themes, random room and latest room played,
        // else, display what is in url params
        // -> async ?
        // if no params in url, display themes swiper
        if(empty($_GET)) {
            require 'includes/_top3.php';
            require 'includes/_themes-swiper.php';
        } else if (isset($_GET["search"]) && $_GET['search'] === 'all') {
            echo '<a href="'. $_SERVER["HTTP_REFERER"] .'">revenir en arrière</a>';
            require 'includes/_all-rooms.php';
        } else if (isset($_GET['theme'])) {
            $searchTheme = $_GET['theme'];
            echo '<a href="'. $_SERVER["HTTP_REFERER"] .'">revenir en arrière</a>';
            require 'includes/_selectedTheme.php';

        }
        ?>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="swiper.js"></script>
    <!-- <script src="home.js"></script> -->
</body>
</html>