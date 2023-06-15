<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="home_style.css">
</head>
<body>
    <header class="header">
        <div class="header__brand">
            <img class='header__brand__img' src="img/logo-l.png" alt="">
            <h1 class="header__brand__title">Musiquiz</h1>
        </div>
        <!--mettre <nav>-->
        <ul class="header__nav">
            <li class="header__nav__itm">Toutes les rooms</li>
            <li class="header__nav__itm">Mon Compte</li>
        </ul>
    </header>

    <!-- array of most popular rooms wit all details comming from database-->
    <?php
    $popularRooms = [
        ["nameRoom" => "Années 80", "nameBestUser" => "User_1425", "scoreBestUser" => 1000],
        ["nameRoom" => "Rock", "nameBestUser" => "User_89", "scoreBestUser" => 7812],
        ["nameRoom" => "Rap", "nameBestUser" => "User_5", "scoreBestUser" => 8875] 
    ];
    ?>

    <main class="main container">
        <section id="popular-rooms" class="block__section">
            <h2 class="block__section__title">Top 3</h2>
            <ul class="block__section__list">


                <?php
                foreach ($popularRooms as $index => $room) {
                    $numberRoom = $index +1;
                    echo 
                    "<li class='block__section__list__itm'>"
                        ."<article class='block__section__list__itm--wrapper'>"
                            ."<h4 class='block__section__list__itm__title'>$numberRoom</h4>"
                            ."<div class='tile'>
                                <a href='#' class='tile__left'>
                                    <img class='tile__img' src='img/Icone Player.svg' alt=''>
                                </a>
                                <div class='tile__right'>
                                    <div class='tile__right--layer'>    
                                    </div>
                                    <img src='img/cup.svg' alt=''>"
                                    ."<div class='tile__right'>"
                                        ."<p>".$room["nameBestUser"]."</p>"
                                        ."<p>".$room["scoreBestUser"]." pts"."</p>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</article>"
                        ."<p class='tile__label'>".$room['nameRoom']."</p>"
                    ."</li>";};                
                ?>



                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">1</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <?php
                                        echo "<p>".$popularRooms[0]["nameBestUser"]."</p>"
                                    ?>
                                    <!-- <p>User_1425</p> -->
                                    <?php
                                        echo "<p>".$popularRooms[0]["scoreBestUser"]." pts"."</p>"
                                    ?>
                                    <!-- <p>1000pts</p> -->
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php echo "<p class='tile__label'>".$popularRooms[0]["nameRoom"]."</p>"?>
                </li>

                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">2</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php echo "<p class='tile__label'>".$popularRooms[1]["nameRoom"]."</p>"?>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php echo "<p class='tile__label'>".$popularRooms[2]["nameRoom"]."</p>"?>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
                <li class="block__section__list__itm">
                    <!--article ?-->
                    <article class="block__section__list__itm--wrapper">
                        <h4 class="block__section__list__itm__title">3</h4>
                        <div class="tile">
                            <a href='#' class="tile__left">
                                <img class="tile__img" src="img/Icone Player.svg" alt="">
                            </a>
                            <div class="tile__right">
                                <div class="tile__right--layer">    
                                </div>
                                <img src="img/cup.svg" alt="">
                                <div class="tile__right__content">
                                    <p>User_1425</p>
                                    <p>1000pts</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <p class="tile__label">Années 80</p>

                </li>
            </ul>
        </section>
    </main>
</body>
</html>