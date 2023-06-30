<?php
// make API call and put it in locale storage to use it in JS

$playlist_id = "1306931615";
$api_url = "https://api.deezer.com/playlist/".$playlist_id;

// require 'api-call.js';

// makeAPICall($api_url);


try {
    $callApi = file_get_contents($api_url);
    $playlistJSON = json_decode($callApi, true);
} catch (Exception $e) {
    echo 'Something went wrong : '. $e;
    // see why exception never trigger
}
// var_dump($playlistJSON);

// check if playlist 
if(isset($playlistJSON["tracks"])) {
    $playlistTitle = $playlistJSON["title"];
    echo $playlistTitle;
    echo "<br>";
    echo "Nombre de chansons : ".$playlistJSON['nb_tracks'];
    echo "<br>";
    $listOfTracks = $playlistJSON["tracks"]["data"];
    $listOfTracksWithPreview = checkIfTrackHasPreview($listOfTracks);
    echo 'Le nombre de chansons valide est de : '.count($listOfTracksWithPreview);
    foreach($listOfTracksWithPreview as $track) {
        echo "<ul><li>Nom de l'artiste : ".$track["artist"]["name"]."</li>
                <li>Nom du titre : ".$track['title_short']."</li>"
                ."<li>Url de preview : ".$track["preview"]."</li></ul>";
    }
} else {
    echo "Pas de playlist à cet ID";
}


function checkIfTrackHasPreview(array $array) :array{
    //     return array_map(fn($array) => {
    // ;    }, $array);
    $newArray = [];
    foreach($array as $index => $track) {
        if(!empty($track["preview"])) {
            $newArray[$index] = $track;
        }
    }
    return $newArray;
}



?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <a href="home.php"><img class="header-cross" src="img/Cross.svg"></img></a>
            <h1 class="header-playlist-name js-playlist-name">Nom de playlist</h1>
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
                <audio id="musicplayer">
                    <source src="https://cdns-preview-e.dzcdn.net/stream/c-e77d23e0c8ed7567a507a6d1b6a9ca1b-11.mp3" />
                </audio>
                  

                <p class="player-score"><span id="score">0</span><span>pt</span></p>

                <!-- <div class="progress-circle">
                    <div class="progress-mask"></div>
                </div> -->
            </section>
            <section>
                <ul class="list">
                    <li class="list-itm">
                        <button data-meta="" class="list-btn js-button-responses">Artiste 1 - Chanson</button>
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
    </div><script src="https://e-cdns-files.dzcdn.net/js/min/dz.js"></script>
    <!-- <script src="https://e-cdn-files.dzcdn.net/js/min/dz.js"></script> -->
    <!-- <script src="api-call.js"></script> -->
    <script src="script.js"></script>

</body>
</html>