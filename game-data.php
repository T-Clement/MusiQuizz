<?php
require 'includes/_database.php';


// à terme sera remplacé par l'id présent dans l'url qui sera en lien avec la base de donnée
$idRoom = $_GET["room"];

$query = $dbCo-> prepare("SELECT * FROM rooms WHERE id_room = :id;");
$query->execute([
    "id" => $idRoom
]);

$dataRoom = $query->fetch();
var_dump($dataRoom);

$playlist_id = $dataRoom["api_id_playlist"];

// var_dump($playlist_id);

$api_url = "https://api.deezer.com/playlist/".$playlist_id;



$JSON = [];


try {
    $callApi = file_get_contents($api_url);
    $playlistJSON = json_decode($callApi, true);
} catch (Exception $e) {
    echo 'Something went wrong : '. $e;
    // see why exception never trigger
}
var_dump($playlistJSON);

// check if call to API is made
if(isset($playlistJSON["tracks"])) {
    $playlistTitle = $playlistJSON["title"];
    $JSON ["playlistName"] = $playlistTitle;
    $listOfTracks = $playlistJSON["tracks"]["data"];
    // check if playlist is > 40
    $listOfTracksWithPreview = checkIfTrackHasPreview($listOfTracks);
    
    if(count($listOfTracksWithPreview) >= 40) {
        foreach($listOfTracksWithPreview as $track) {
            $tracks [] = [
                ["artist" =>  $track["artist"]["name"]],
                ["track" => $track['title_short']],
                ["preview" => $track["preview"]]
            ];
        }
    } else {
        echo "Pas assez de tracks dans cette playlist";
        exit;
    } 
} else {
    echo "Pas de playlist à cet ID";
}





// faire une structure de JSON pour mettre dans le localStorage et que ce soit récupérer par mon script de jeu JS

$JSON ["tracks"] = $tracks;
// var_dump($JSON);
$JSON = json_encode($JSON);

echo "<p>Ceci est une séparation</p>";
echo "<script>localStorage.setItem('playlistDATAJSON_" . $idRoom . "', JSON.stringify($JSON));</script>";
echo "<script>
    let playlistJSON = localStorage.getItem('playlistDATAJSON');
    console.log(playlistJSON);
   // log [object object]

   let playlistDATA = JSON.parse(playlistJSON);

   console.table(playlistDATA);
   
    </script>";





function checkIfTrackHasPreview(array $array) :array{
    $newArray = [];
    foreach($array as $index => $track) {
        if(!empty($track["preview"])) {
            $newArray[$index] = $track;
        }
    }
    return $newArray;
}

// }

?>