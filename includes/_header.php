<?php



?>

<header class="header">
    <div class="header__wrapper">
        <a class="header__brand" href="home.php">
            <img class='header__brand__img' src="img/logo-l.png" alt="Logo Musiquiz">
            <h1 class="header__brand__title">Musiquiz</h1>
        </a>
    
    <!--mettre <nav>-->
    
    <!-- <ul class="header__nav">
        <li class="header__nav__itm"><a href ="#">Toutes les rooms</a></li>
        <li class="header__nav__itm"><a href="#">Mon Compte</a></li>
    </ul> -->
        <nav class="header__nav">
            <ul class="header__nav__list js-nav">
                <li class="header__nav__itm">
                    <a href ="home.php"><img class="nav__itm__icon" src="img/home.svg"><span class="nav__itm__text">Home</span></a>
                </li>
                <li class="header__nav__itm">
                    <a href ="home.php?search=all"><img class="nav__itm__icon" src="img/list.svg"><span class="nav__itm__text">Toutes les rooms</span></a>
                </li>
                <li class="header__nav__itm">
                    <a href="dashboard.php"><img class="nav__itm__icon" src="img/account.svg"><span class="nav__itm__text">Mon Compte</span></a>
                </li>
                <li class="header__nav__itm">
                    <a href="actions/logout.php"><img class="nav__itm__icon" src="img/logout.svg"><span class="nav__itm__text">Se déconnecter</span></a>
                </li>
            </ul>
        </nav>
    </div>
</header>

