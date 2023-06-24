<?php
// à terme sera remplacé par l'id présent dans l'url qui sera en lien avec la base de donnée
// $playlist_id = $_GET["id"];
$playlist_id = "1306931615";
$api_url = "https://api.deezer.com/playlist/".$playlist_id;

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
// faire une structure de JSON pour mettre dans le localStorage et que ce soit récupérer par mon script de jeu JS



?>