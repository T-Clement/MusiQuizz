<?php
// à terme sera remplacé par l'id présent dans l'url qui sera en lien avec la base de donnée
// $playlist_id = $_GET["id"];


$playlist_id = "1306931615";
$api_url = "https://api.deezer.com/playlist/".$playlist_id;


// function makeAPICall ($api_url) {

$JSON = [];


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
    $JSON ["playlistName"] = $playlistTitle;
    // echo $playlistTitle;
    // echo "<br>";
    // echo "Nombre de chansons : ".$playlistJSON['nb_tracks'];
    // echo "<br>";
    $listOfTracks = $playlistJSON["tracks"]["data"];
    $listOfTracksWithPreview = checkIfTrackHasPreview($listOfTracks);
    // if ($listOfTracksWithPreview < 40) {
    //     echo "Il n'y a pas assez de chansons dans cette playlist";
    //     break;
    // }
    // echo 'Le nombre de chansons valide est de : '.count($listOfTracksWithPreview);
    // foreach($listOfTracksWithPreview as $track) {
    //     echo "<ul><li>Nom de l'artiste : ".$track["artist"]["name"]."</li>
    //             <li>Nom du titre : ".$track['title_short']."</li>"
    //             ."<li>Url de preview : ".$track["preview"]."</li></ul>";
    // }
    foreach($listOfTracksWithPreview as $track) {
        //  $JSON ["tracks"] = [
        //     ["artist" =>  $track["artist"]["name"]],
        //     ["track" => $track['title_short']],
        //     ["preview" => $track["preview"]]
        //  ];
        $tracks [] = [
                ["artist" =>  $track["artist"]["name"]],
                ["track" => $track['title_short']],
                ["preview" => $track["preview"]]
             ];
    }
} else {
    echo "Pas de playlist à cet ID";
}

$JSON ["tracks"] = $tracks;
var_dump($JSON);
$JSON = json_encode($JSON);

echo "<p>Ceci est une séparation</p>";
echo "<script>localStorage.setItem('playlistDATAJSON', JSON.stringify($JSON));</script>";
echo "<script>
    let playlistJSON = localStorage.getItem('playlistDATAJSON');
    console.log(playlistJSON);
   // log [object object]

   let playlistDATA = JSON.parse(playlistJSON);

   console.table(playlistDATA);

    
    
    
    
    </script>";





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

// }

?>