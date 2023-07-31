<?php
session_start();

if(empty($_SESSION['user']) || $_SESSION['user'] === "null") {
    header("Location: index.php");
    exit;
}

$token = md5(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;
?>


<?php 
$styleSheetCSS = "css/style.css";
require "includes/_head.php";
?>
<body>
    <div class="container">
        <header class="header">
            <a href="home.php"><img class="header-cross" src="img/Cross.svg"></img></a>
            <h1 class="header-playlist-name js-playlist-name js-game-data" data-id-room="<?=$_GET["room"]?>" data-id-user="<?=$_SESSION["user"]["id_user"]?>"
            data-token=<?=$token?>>
            Nom de playlist
            </h1>
            <div class="songs-progress"><span class="current-round">1</span>/<span class = "total-round">10</span></div>
        </header>
        <main class="main js-main">
            <section id="player" class = "section-player"> 
                <div class="player-progression">
                    <div class="progress-bar">
                        <div data-progress="10" class="progress-bar-value js-progress-value"></div>
                    </div>
                    <p class="player-progress-timer"><span id="timer">10</span>"</p>
                </div>
                <audio id="musicplayer" class="js-musicplayer">
                    <source src="" />
                </audio>
                  
                <p class="player-score"><span id="score">0</span><span>pt</span></p>

            </section>
            <section class="js-list">
                <ul class="list">
                    <li class="list-itm">
                        <button class="list-btn js-button-responses">Artiste 1 - Chanson</button>
                    </li>
                    <li class="list-itm">
                        <button class="list-btn js-button-responses">Artiste 2 - Chanson</button>
                    </li>
                    <li class="list-itm">
                        <button class="list-btn js-button-responses">Artiste 3 - Chanson</button>
                    </li>
                    <li class="list-itm">
                        <button class="list-btn js-button-responses">Artiste 4 - Chanson</button>
                    </li>
                </ul>
            </section>



            <template id="datas-player-game">
                <section class="scores-section">
                    <div class= "scores-wrapper">
                        <p class="party-score">6400</p>
                        <p class="party-bestscore">Ton meilleur score : 7000</p>
                    </div>
                    <div class="scores-buttons">
                        <button class="score-button btn">Accueil</button>
                        <button class="score-button btn">Rejouer</button>
                    </div>
                </section>

                
                <div class="display-buttons">
                    <button class="display-button btn btn-active js-display-btn" data-btn="songlist">Détails</button>
                <button class="display-button btn js-display-btn" data-btn="ranking">Classement</button>
                </div>
            </template>

            <template id="datas-ranking">
                <section class="ranking tab-display js-tab-display" data-tab-content="ranking">
                    <ul class="ranking-list">
                        <!-- model -->
                        <!-- <li class="ranking-list-item">
                            <div class="rank">
                                <span>1 |</span>
                                <span>Clement</span>
                            </div>
                            <span>6000pts</span>
                        </li> -->
                    </ul>
                </section>
            </template>

            <template id="datas-songlist">
                <section class="party-songs tab-display js-tab-display active" data-tab-content="songlist">
                    <ul class="song-list">
                        <!-- <li class="song-list-item">
                            <div class="song-data">
                                <span class="song-artist">Daft Punk</span>
                                <span class="song-track">One More Time</span>
                            </div>
                            <span class="song-points js-points-earned">350 pts</span>
                        </li> -->
                    </ul>
                </section>
            </template>
            
            
            





        </main>
    </div>
    
    <script src="game.js"></script>
    <!-- <script src="game-end.js"></script> -->

</body>
</html>