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

$isOk = true;

// DELETE ALL GAMES from GAMES TABLE
$query = $dbCo-> prepare("DELETE FROM games WHERE id_user = (
    SELECT MAX(id_user) FROM users
);");


echo json_encode([
    'result' => $isOk,
    'msg' => "Votre compte et toutes vos parties ont été supprimées. Merci de m'avoir aidé à developper ce site !"
]);
exit;

// header('Location: dashboard.php?delete=true');
// exit;
?>