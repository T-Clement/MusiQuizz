<?php
require 'includes/_database.php';

// request to database to get the current list of tasks sort by priority
$query = $dbCo->prepare("SELECT * FROM rooms");
$query->execute();
$rooms = $query->fetchAll();

// var_dump($rooms);



?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
    <!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="css/home_style.css">
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <div class="header__brand">
                <img class='header__brand__img' src="img/logo-l.png" alt="">
                <h1 class="header__brand__title">Musiquiz</h1>
            </div>
        
        <!--mettre <nav>-->
        
        <!-- <ul class="header__nav">
            <li class="header__nav__itm"><a href ="#">Toutes les rooms</a></li>
            <li class="header__nav__itm"><a href="#">Mon Compte</a></li>
        </ul> -->
            <nav class="header__nav">
                <ul class="header__nav__list">
                    <li class="header__nav__itm"><a href ="#">Toutes les rooms</a></li>
                    <li class="header__nav__itm"><a href="#">Mon Compte</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- array of most popular rooms wit all details comming from database--> <!--need to take link / id of the room-->
    <?php
    $popularRooms = [
        ["idRoom" => '1243', "style" => "Années", "nameRoom" => "Années 80", "nameBestUser" => "User_1425", "scoreBestUser" => 10000, "numberOfParties" => 82],
        ["idRoom" => '2548', "style" => "Rock", "nameRoom" => "Légendes du Rock", "nameBestUser" => "User_89", "scoreBestUser" => 7812, "numberOfParties" => 67],
        ["idRoom" => '9845', "style" => "Rap", "nameRoom" => "Classiques du Rap US", "nameBestUser" => "User_5", "scoreBestUser" => 8875,  "numberOfParties" => 43] 
    ];
    ?>

    <main class="main container">
        <section id="popular-rooms" class="block__section"> 
            <h2 class="block__section__title">Top 3
                <div class="elipse"></div>
            </h2>
            
            <ul class="block__section__list">

                <!--add list items for each room in popularRooms-->
                <!--retirer le section, mettre un truc qui a du sens en fonction de ce que c'est-->
                <?php
                foreach ($popularRooms as $index => $room) {
                    $numberRoom = $index +1;
                    echo 
                    "<li class='block__section__list__itm'>"
                        ."<article class='block__section__list__itm--wrapper'>"
                            ."<h4 class='block__section__list__itm__title'>$numberRoom</h4>"
                            ."<div>"
                            ."<div class='tile'>
                                <a href='#' class='tile__left'>
                                    <img class='tile__left__img' src='img/player-icon.svg' alt=''>
                                </a>
                                <div class='tile__right'>
                                    <img class='tile__right__img' src='img/cup.svg' alt=''>"
                                    ."<div class='tile__right__content'>"
                                        ."<p>".$room["nameBestUser"]."</p>"
                                        ."<p>".$room["scoreBestUser"]." pts"."</p>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                            ."<p class='tile__label'>".$room['nameRoom']."</p>"
                            ."</div>"
                        ."</article>"
                    ."</li>";}                
                ?>

                <!--model with php-->
                <!-- <li class="block__section__list__itm">
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">1</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/player-icon.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <?php
                                        // echo "<p>".$popularRooms[0]["nameBestUser"]."</p>"
                                    ?>
                                    <?php
                                        // echo "<p>".$popularRooms[0]["scoreBestUser"]." pts"."</p>"
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php //echo "<p class='tile__label'>".$popularRooms[0]["nameRoom"]."</p>"?>
                </li> -->

               


                <!--model to test css-->
                <!-- <li class="block__section__list__itm">
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__left__img" src="img/player-icon.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <img class="tile__right__img" src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>10000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>
                </li> -->
                <!-- <li class="block__section__list__itm">
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div>
                            <div class="tile">
                                <a href='#' class="tile__left">
                                    <img class="tile__left__img" src="img/player-icon.svg" alt="">
                                </a>
                                <div class="tile__right">
                                    <img class="tile__right__img" src="img/cup.svg" alt="">
                                    <div class="tile__right__content">
                                        <p>User_1425</p>
                                        <p>10000pts</p>
                                    </div>
                                </div>
                            </div>
                            <p class="tile__label-dev">Années 80</p>
                        </div>
                    </article>
                </li> -->

            </ul>
        </section>

        <section id="music-style">
            <h3 class="block__section__title">Genre Musical
                <div class="elipse"></div>
            </h3>
            <!-- Slider main container -->
                <div class="swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php
                        // add color ?, link to the page with all playlist link to style
                        $listOfStyle = [
                            ["style" => "Rock", "link" => "link/rock"],
                            ["style" => "Pop", "link" => "link/pop"],
                            ["style" => "Rap", "link" => "link/rap"],
                            ["style" => "Variété", "link" => "link/variete"]
                        ];
                        
                        for($i = 0; $i < count($listOfStyle); $i++) {
                            echo "<div class='swiper-slide'>
                                <a class='swiper-theme-link' href='#{$listOfStyle[$i]['link']}'>{$listOfStyle[$i]['style']}</a>
                                </div>";
                        };
                            
                        ?>
                        <!-- <div class="swiper-slide"><a class="swiper-theme-link" href="#">Rock</a></div>
                        <div class="swiper-slide"><a class="swiper-theme-link" href="#">Pop</a></div>
                        <div class="swiper-slide"><a class="swiper-theme-link" href="#">Rap</a></div>
                        <div class="swiper-slide"><a class="swiper-theme-link" href="#">Variété</a></div> -->
                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                </div>
        </section>


        <section>
            
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="swiper.js"></script>
</body>
</html>