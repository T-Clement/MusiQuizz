<?php

require 'includes/_database.php';



header('Content-Type:application/json');


// data send by async js function callAPI
$data = json_decode(file_get_contents('php://input'), true);
$isOk = false;

// à terme sera remplacé par l'id présent dans l'url qui sera en lien avec la base de donnée
// $idRoom = $_GET["room"];

// get the id send by the async function 
$id =  $data["idRoom"];

$query = $dbCo-> prepare("SELECT * FROM rooms WHERE id_room = :id;");
$query->execute([
    "id" => $id
]);

$dataRoom = $query->fetch();

// store the api playlist id
$playlist_id = $dataRoom["api_id_playlist"];

// url wich will ba calling to API
$api_url = "https://api.deezer.com/playlist/".$playlist_id;



$JSON = [];


try {
    $callApi = file_get_contents($api_url);
    $playlistJSON = json_decode($callApi, true);
} catch (Exception $e) {
    // echo 'Something went wrong : '. $e;
    // see why exception never trigger
}





// check if call to API is made
if(!isset($playlistJSON["tracks"])) {
    echo json_encode([
        'result' => $isOk,
        'msg' => "Pas de playlist à cet ID"
        ]);
    exit;
}
$playlistTitle = $dataRoom["name_room"];
$JSON ["playlistName"] = $playlistTitle;
$listOfTracks = $playlistJSON["tracks"]["data"];
// check if playlist is > 40
$listOfTracksWithPreview = checkIfTrackHasPreview($listOfTracks);

if(!count($listOfTracksWithPreview) >= 40) {
    echo json_encode([
        'result' => $isOk,
        'msg' => "Pas assez de tracks dans cette playlist",
        'playlistLength' => count($listOfTracksWithPreview)
    ]);
    exit;
}

// set $isOk to true because whith this datas we can play
$isOk = true;
foreach($listOfTracksWithPreview as $track) {
    $tracks [] = [
        "artist" =>  $track["artist"]["name"],
        "track" => $track['title_short'],
        "preview" => $track["preview"]
    ];
}
    
// faire une structure de JSON pour mettre dans le localStorage et que ce soit récupérer par mon script de jeu JS

$JSON ["tracks"] = $tracks;
// var_dump($JSON);
echo json_encode([
    "result" => $isOk,
    "datas" => $JSON
]);
exit;



function checkIfTrackHasPreview(array $array) :array{
    $newArray = [];
    foreach($array as $index => $track) {
        if(!empty($track["preview"])) {
            $newArray[$index] = $track;
        }
    }
    return $newArray;
};

?>


