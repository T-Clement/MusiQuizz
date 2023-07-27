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
        <main class="">
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
            <section>
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
        </main>
    </div>
    
    <script src="game.js"></script>

</body>
</html>