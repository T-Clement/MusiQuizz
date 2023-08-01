<?php

require 'includes/_database.php';
// EN FAIRE UNE VUE
// $query = $dbCo->prepare("
// SELECT r.id_room, r.name_room,u.id_user, u.pseudo_user, MAX(g.score_game) as current_bestscore, gp.games_played
// FROM games g
// JOIN users u ON g.id_user = u.id_user
// JOIN rooms r ON g.id_room = r.id_room
// JOIN (
//     SELECT id_room, COUNT(id_game) as games_played
//     FROM games
//     GROUP BY id_room
// ) gp ON r.id_room = gp.id_room
// WHERE g.score_game = (
//     SELECT MAX(score_game)
//     FROM games
//     WHERE id_room = r.id_room
// )
// GROUP BY r.id_room
// ORDER BY games_played DESC
// LIMIT 3;");

$query = $dbCo->prepare("SELECT * FROM view_room_scores ORDER BY games_played DESC LIMIT 3");

$query->execute();
$popularRooms = $query->fetchAll();

// var_dump($popularRooms);

?>

<section id="popular-rooms" class="block"> 
            <h2 class="block__title">Populaires
                <div class="elipse"></div>
            </h2>
            
            <ul class="block__list">

                <!--add list items for each room in popularRooms-->
                <!--retirer le section, mettre un truc qui a du sens en fonction de ce que c'est-->
               
                <?php
                foreach ($popularRooms as $index => $room) {
                    $numberRoom = $index +1;
                    echo 
                    "<li class='block__item'>"
                        ."<article class='block__content'>"
                            ."<h4 class='block__item--title'>$numberRoom</h4>"
                            ."<div>"
                                ."<div class='tile'>
                                    <a href='game.php?room=" . $room["id_room"] ."' class='tile__left js-anchor' data-id='" . $room["id_room"] . "'>
                                        <img class='tile__left__img js-img' src='img/player-icon.svg' alt=''>
                                    </a>
                                    <div class='tile__right'>
                                        <img class='tile__right__img' src='img/cup.svg' alt=''>"
                                        ."<div class='tile__right__content'>"
                                            ."<p>".$room["pseudo_user"]."</p>"
                                            ."<p>".$room["current_bestscore"]." pts"."</p>"
                                        ."</div>"
                                    ."</div>"
                                ."</div>"
                            ."<p class='tile__label'>".$room['name_room']."</p>"
                            ."</div>"
                        ."</article>"
                    ."</li>";}                
                ?>

                <!--model with php-->
                <!-- <li class="block__section__list__itm">
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">1</h4>
                        <div class="tile">
                            <a href='game-data.php?room=" . $room["id_room"] ."' class='tile__left js-anchor' data-id='" . $room["id_room"] . "'>
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

                
<!--rewriting css classes-->
<!-- <section id="popular-rooms" class="block">
    <h2 class="block__title">
        Popular Rooms<span class="block__subtitle">Top 3</span>
    </h2>
    <ul class="block__list">
        <li class="block__item">
            <article class="block__content">
                <h4 class="block__item-title">1</h4>
                <div class="tile">
                    <a href='#' class="tile__link">
                        <img class="tile__icon" src="img/player-icon.svg" alt="Player Icon">
                    </a>
                    <div class="tile__details">
                        <img class="tile__icon" src="img/cup.svg" alt="Cup Icon">
                        <div class="tile__content">
                            <span class="tile__username">User_1425</span>
                            <span class="tile__points">10000pts</span>
                        </div>
                    </div>
                </div>
            </article>
            <p class="block__label">Années 80</p>
        </li>
    </ul>
</section> -->

            </ul>
        </section>

