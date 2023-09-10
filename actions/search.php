<?php

require '../vendor/autoload.php'; #load les dependances de vendor

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $dbCo = new PDO(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
    ' . $e->getMessage());
}




// require '../includes/_database.php';

header('Content-Type:application/json');


// data send by async js function "callAPI"
$data = json_decode(file_get_contents('php://input'), true);
$isOk = false;


if(!empty($data["request"])) {
    $request = " WHERE pseudo_user LIKE '%" . $data['request'] . "%' ";
} else $request = "";
$query = $dbCo->prepare("SELECT pseudo_user, id_game, date_score_game, name_room, score_game  FROM ". $_ENV["GAMES"] . " JOIN " . $_ENV["USERS"] . " USING(id_user) JOIN " . $_ENV["ROOMS"] . " USING(id_room) "
 . $request . " ORDER BY id_game DESC");
$isOk = $query->execute([]);
$searchGames = $query->fetchAll();


echo json_encode([
    "result" => $isOk,
    "datas" => $searchGames
]);