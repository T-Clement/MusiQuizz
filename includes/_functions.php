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

/**
 * Get the rooms datas associated to a specific id_theme passed in parameter
 */
function getRoomsDataPerThemes(PDO $dbCo, int $idTheme) :array{

    $query = $dbCo->prepare("
    SELECT id_theme, name_theme, r.id_room, r.name_room,u.id_user, u.pseudo_user, MAX(g.score_game) as current_bestscore, description_room
    FROM ". $_ENV["GAMES"] ." g
    JOIN ". $_ENV["USERS"] ." u ON g.id_user = u.id_user
    JOIN ". $_ENV["ROOMS"] ." r ON g.id_room = r.id_room
    JOIN ". $_ENV["THEMES"] ." USING (id_theme)
    
    WHERE g.score_game = (
        SELECT MAX(score_game)
        FROM ". $_ENV["GAMES"] ."
        WHERE id_room = r.id_room
    )
    GROUP BY r.id_room
    HAVING id_theme = :id_theme");
    $query->execute([
        "id_theme" => $idTheme
    ]);
    return $query->fetchAll();
    
}
