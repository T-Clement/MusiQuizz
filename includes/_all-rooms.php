<?php
require "includes/_database.php";

// get list of themes in database
$query = $dbCo->prepare("SELECT id_theme, name_theme FROM ". $_ENV["THEMES"] ."");
$query->execute();
$themes = $query->fetchAll();
// var_dump($themes);



$arrayOfData = [];
// get in array all the rooms linked to a theme
foreach($themes as $theme) {
    // var_dump($theme);
    $arrayOfData[$theme["name_theme"]] = getRoomsDataPerThemes($dbCo, $theme["id_theme"]);
}

// var_dump($token);
// var_dump($_SESSION["token"]);
// var_dump($rooms);
?>

<section id="all-rooms" class="block__section">
    <h2 class="block__title">Toutes les rooms
        <div class="elipse"></div>
    </h2>


        <!-- Loop to display swiper-slide's -->
        <?php foreach ($arrayOfData as $theme => $rooms) : ?>
            <!-- name of theme -->
            <article class="themes-container">

                <h3 class="theme-title"><?=$theme?></h2>
                
                <!-- Swiper -->
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($rooms as $room) :?>
                        <div class="swiper-slide">
                            <div class="tile-all-container">
                                <div class="tile">
                                    <a href='game.php?room=<?=$room["id_room"]?>' class='tile__left js-anchor' data-id='" . $room["id_room"] . "'>
                                        <img class="tile__img" src="img/player-icon.svg" alt="">
                                    </a>
                                    <div class="tile__right">
                                        <img src="img/cup.svg" alt="">
                                        <div class="tile__right__content">
                                            <p><?= $room["pseudo_user"]?></p>
                                            <p><?= $room["current_bestscore"]?> pts</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="room-title"><?= $room["name_room"]?></p>
                                <p class="room-description"><?= $room["description_room"]?></p>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </article>
        <?php endforeach?>
        <!-- </ul> -->
</section>