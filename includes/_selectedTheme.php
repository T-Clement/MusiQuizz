<?php

require 'includes/_database.php';
            
            // $query = $dbCo->prepare("
            // SELECT * 
            // FROM rooms 
            //     JOIN theme USING (id_theme) 
            // WHERE id_theme = :id_theme");
            // $query->execute([
            //     "id_theme" => $_GET["theme"]
            // ]);
            // $selectedTheme = $query->fetchAll();
            // var_dump($selectedTheme);


            $query = $dbCo->prepare("
            SELECT t.id_theme, t.name_theme, r.id_room, r.name_room,u.id_user, u.pseudo_user, MAX(g.score_game) as current_bestscore, gp.games_played
            FROM games g
                JOIN users u ON g.id_user = u.id_user
                JOIN rooms r ON g.id_room = r.id_room
                JOIN theme t ON  r.id_theme = t.id_theme
                JOIN (
                SELECT id_room, COUNT(id_game) as games_played
                FROM games
                GROUP BY id_room
                ) gp ON r.id_room = gp.id_room
            WHERE g.score_game = (
                SELECT MAX(score_game)
                FROM games
                WHERE id_room = r.id_room
                ) 
            GROUP BY r.id_room
            HAVING id_theme = :id_theme
            ORDER BY id_theme DESC
            ");
            $query->execute([
                "id_theme" => $searchTheme
            ]);
            $selectedThemeRooms = $query->fetchAll();
            // var_dump($selectedThemeRooms);







            // var_dump($selectedTheme);
            echo "<section id='popular-rooms' class='block__section'> 
            
            <ul class='block__section__list'>
            <div class='elipse'></div>";

             echo "<h2>" . $selectedThemeRooms[0]["name_theme"] . "</h2>";
            foreach ($selectedThemeRooms as $index => $room) {
                echo 
                "<li class='block__section__list__itm'>"
                    ."<article class='block__section__list__itm--wrapper'>"
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

            echo "</ul>";







?>