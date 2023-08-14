<?php
require 'includes/_database.php';
            


    $selectedTheme = strip_tags($_GET["theme"]);
    // function define in "_functions.php", get all the datas needed to display tiles of the theme
    $datas = getRoomsDataPerThemes($dbCo ,$selectedTheme);
    ?>

    <section id="all-rooms" class="block__section">
        <h2 class="block__title"><?=$datas[0]["name_theme"]?>
            <div class="elipse"></div>
        </h2>    
        <!-- Swiper -->
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($datas as $index => $room) :?>
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
    </section>











<?php
    // get all the theme not included the one selected
    $query = $dbCo->prepare("SELECT id_theme, name_theme FROM ". $_ENV["THEMES"] ." WHERE id_theme != :theme_selected");
    $query->execute([
        "theme_selected" => trim(strip_tags($_GET["theme"]))
    ]);
    $otherThemes = $query->fetchAll();

?>
    <!-- Swiper of themes -->
    <section id="music-style">
    <h2 class="block__title">Les autres genres
        <!-- <div class="elipse"></div> -->
    </h2>
    <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php
                
                // loop to create a swiper-slide for each theme
                foreach($otherThemes as $index => $theme) {
                    echo "<div class='swiper-slide'>
                        <a class='swiper-theme-link' href='home.php?theme={$otherThemes[$index]['id_theme']}'>{$otherThemes[$index]['name_theme']}</a>
                        </div>";
                };
                    
                ?>
            </div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
</section>

