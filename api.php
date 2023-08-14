<?php

require 'includes/_database.php';

header('Content-Type:application/json');


// data send by async js function "callAPI"
$data = json_decode(file_get_contents('php://input'), true);
$isOk = false;

if($data["action"] === "select") {

    // get the id send by the async function 
    $id =  intval($data["idRoom"]);

    $query = $dbCo-> prepare("SELECT * FROM ". $_ENV["ROOMS"] ." WHERE id_room = :id;");
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
    $listOfTracksWithPreview = checkIfTrackIsReadable($listOfTracks);
    // $listOfTracksWithPreview = checkIfTrackHasPreview($listOfTracks);

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

    $query = $dbCo->prepare("SELECT MAX(score_game) as bestscore FROM ". $_ENV["GAMES"] ." WHERE id_user=:id_user AND id_room=:id_room");
    $isOk = $query->execute([
        "id_user" => $data["idUser"],
        "id_room" => $data["idRoom"]
    ]);
    $currentBestScore = $query->fetch();

    $JSON["bestscore"] = $currentBestScore;


    echo json_encode([
        "result" => $isOk,
        "datas" => $JSON,
        "bestscore" => $currentBestScore
    ]);
    exit;
}


// function checkIfTrackHasPreview(array $array) :array{
//     $newArray = [];
//     foreach($array as $index => $track) {
//         if(!empty($track["preview"])) {
//             $newArray[$index] = $track;
//         }
//     }
//     return $newArray;
// };
function checkIfTrackIsReadable(array $array) :array{
    $newArray = [];
    foreach($array as $index => $track) {
        if($track["readable"]) {
            $newArray[$index] = $track;
        }
    }
    return $newArray;
};
?>


<?php

// send party data to database
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
if($data["action"] === "insertScore") {
    $query = $dbCo-> prepare("INSERT INTO ". $_ENV["GAMES"] ." (score_game, date_score_game, id_user, id_room) VALUES (:score, NOW(), :idUser, :idRoom)");
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

<?php
// ()
if($data["action"] === "getPartyScore") {
    $query = $dbCo-> prepare("
        SELECT id_room, id_user, pseudo_user, id_game, MAX(score_game) as score_max
        FROM ". $_ENV["GAMES"] ."
            JOIN ". $_ENV["USERS"] ." USING (id_user)
        WHERE id_room = :id_room
        GROUP BY id_user
        ORDER BY score_max DESC;
    ");
    $isOk = $query->execute([
        "id_room" => $data["idRoom"]
    ]);

    $dataRoom = $query->fetchAll();


    echo json_encode([
        "result" => $isOk,
        "ranking" =>  $dataRoom
    ]);
}


if($data["action"] === "getRanking") {
    $query = $dbCo-> prepare("
        SELECT id_room, id_user, pseudo_user, id_game, MAX(score_game) as score_max
        FROM ". $_ENV["GAMES"] ."
            JOIN ". $_ENV["USERS"] ." USING (id_user)
        WHERE id_room = :id_room
        GROUP BY id_user
        ORDER BY score_max DESC;
    ");
    $isOk = $query->execute([
        "id_room" => $data["idRoom"]
    ]);

    $dataRoom = $query->fetchAll();


    echo json_encode([
        "result" => $isOk,
        "ranking" =>  $dataRoom
    ]);
}




?>