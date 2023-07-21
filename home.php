<?php
session_start();
var_dump($_SESSION);
if(isset($_SESSION['user'])) {
    var_dump($_SESSION['user']);
} else {
    session_destroy();
    header("Location: index.php");
}

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
            require 'includes/_all-rooms.php';
        } else if (isset($_GET['theme'])) {
            $searchTheme = $_GET['theme'];
            require 'includes/_selectedTheme.php';

        }
        ?>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="swiper.js"></script>
    <!-- <script src="home.js"></script> -->
</body>
</html>