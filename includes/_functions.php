<?php



function checkIfUserInSession (array $session) :void {
    if(empty($session)) {
        header("Location: index.php");
    }
}


function isValidHTTPReferer(string $path) :bool{
    require 'vendor/autoload.php'; #load les dependances de vendor
    $dotenv = Dotenv\Dotenv::createImmutable($path);
    $dotenv->load();

    if(array_key_exists('HTTP_REFERER', $_SERVER) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
        return true;
    } else {
        return false;
    }
}