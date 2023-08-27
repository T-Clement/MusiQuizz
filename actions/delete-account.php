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




require '../includes/_functions.php';
session_start();



if(!(isset($_SESSION['user'])) && !isValidHTTPReferer(__DIR__)) {
    session_destroy();
    header("Location: index.php?error_referer");
    exit; 
} 

header('Content-Type:application/json');

$data = json_decode(file_get_contents('php://input'), true);
$isOk = true;



if(isset($data) && $data["action"] != "deleteUserDatas") return;

// DELETE ALL GAMES from GAMES TABLE
$query = $dbCo->prepare("DELETE FROM " . $_ENV['GAMES'] . " WHERE id_user = :id_user;");

$isOk = $query->execute([
    "id_user" => intval($data["idUser"])
]);

if($isOk) {
    $isOk = false;
    
    // DELETE user datas from table users
    $query = $dbCo->prepare("DELETE FROM " . $_ENV['USERS'] . " WHERE id_user = :id_user");
    $isOk = $query ->execute([
        "id_user" => intval($data["idUser"])
    ]);

}


$success = "Votre compte et toutes vos parties ont été supprimées. Merci de m'avoir aidé à developper ce site !";
$error = "La suppression a rencontrée une erreur";

if($isOk) {
    unset($_SESSION['user']);
    session_destroy();
}

echo json_encode([
    'result' => $isOk,
    'msg' => $isOk ? $success : $error
]);
exit;

// header('Location: dashboard.php?delete=true');
// exit;
?>