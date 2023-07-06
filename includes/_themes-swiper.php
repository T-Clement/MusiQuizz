<?php
require 'includes/_database.php';
$query = $dbCo->prepare("SELECT id_theme, name_theme FROM theme;");
$query->execute();
$themes = $query->fetchAll();

// var_dump($themes);
?>


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
                        
                        foreach($themes as $index => $theme) {
                            echo "<div class='swiper-slide'>
                                <a class='swiper-theme-link' href='somewhere.php?theme={$themes[$index]['id_theme']}'>{$themes[$index]['name_theme']}</a>
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