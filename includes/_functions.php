<?php



function checkIfUserInSession (array $session) :void {
    if(empty($session)) {
        header("Location: index.php");
    }
}