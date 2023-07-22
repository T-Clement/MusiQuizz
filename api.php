<?php

require 'includes/_database.php';



header('Content-Type:application/json');


// data send by async js function callAPI
$data = json_decode(file_get_contents('php://input'), true);
$isOk = false;
if($data["action"] === "select") {

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

    $JSON ["tracks"] = $tracks;

    echo json_encode([
        "result" => $isOk,
        "datas" => $JSON
    ]);
    exit;
}


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


<?php
session_start();
if(!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    echo json_encode([
        "result" => $isOk,
        "error" => "Error referer"
    ]);
    exit;
}
if(!array_key_exists('token', $_SESSION) || !array_key_exists("token", $data) || $_SESSION["token"] !== $data["token"]) {
    echo json_encode([
        "result" => $isOk,
        "error" => "Error CSRF"
    ]);
    exit;
}
// HTTP REFERER pour être sûr que ça vient de chez moi ?
// plusieurs vérifications : être sûr que la requête vient bien de la page game.php, être sûr que le token correspond
// est ce que la correspondance token passé et token en session permet de s'assurer qu'on a bien le bon user ?
// comment faire passer les infos idUser et idRoom ? -> attributs data ?
// comment s'assurer que quelqu'un ne triche pas sur le score ?
// if ($_SERVER["REQUEST_METHOD"] == "POST") -> vérifier que la méthode est bien POST
if($data["action"] === "newScore") {
    // echo json_encode([
    //     "result" => "j'ai bien reçu les infos",
    //     "datas" => $data
    // ]);
    $query = $dbCo-> prepare("INSERT INTO games (score_game, date_score_game, id_user, id_room) VALUES (:score, NOW(), :idUser, :idRoom)");
    $isOk = $query->execute([
        "score" => $data["score"],
        "idUser" => $data["idUser"],
        "idRoom" => $data["idRoom"]
    ]);

    echo json_encode([
        "result" => $isOk,
        "msg" => $isOk ? "Votre partie a été enregistrée, merci d'avoir joué" : "Une erreur a été rencontrée, votre partie n'est pas enregistrée"
    ]);
    
    exit;
}



?>