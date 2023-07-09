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
            require 'includes/_database.php';
            
            $query = $dbCo->prepare("
            SELECT * 
            FROM rooms 
                JOIN theme USING (id_theme) 
            WHERE id_theme = :id_theme");
            $query->execute([
                "id_theme" => $_GET["theme"]
            ]);
            $selectedTheme = $query->fetchAll();

            // $query = $dbCo->prepare("
            // SELECT t.id_theme, t.name_theme, r.id_room, r.name_room,u.id_user, u.pseudo_user, MAX(g.score_game) as current_bestscore, gp.games_played
            // FROM games g
            // JOIN users u ON g.id_user = u.id_user
            // JOIN theme t USING (id_theme)
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
            // ");
            // $query->execute();
            // $popularRooms = $query->fetchAll();








            // var_dump($selectedTheme);
            echo "<h2>" . $selectedTheme[0]["name_theme"] . "</h2>";
            foreach ($selectedTheme as $index => $room) {
                $numberRoom = $index +1;
                echo 
                "<li class='block__section__list__itm'>"
                    ."<article class='block__section__list__itm--wrapper'>"
                        ."<h4 class='block__section__list__itm__title'>$numberRoom</h4>"
                        ."<div>"
                        ."<div class='tile'>
                            <a href='index.php?room=" . $room["id_room"] ."' class='tile__left js-anchor' data-id='" . $room["id_room"] . "'>
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

        }
        ?>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="swiper.js"></script>
    <!-- <script src="home.js"></script> -->
</body>
</html>