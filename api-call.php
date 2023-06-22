<?php
$playlist_id = "1306931615";
$api_url = "https://api.deezer.com/playlist/" . $playlist_id;

$response = file_get_contents($api_url);
$json_response = json_decode($response, true);

if (isset($json_response['tracks'])) {
    $tracks = $json_response['tracks']['data'];
    echo "Liste des pistes:\n";
    foreach ($tracks as $track) {
        echo "- " . $track['title'] . " par " . $track['artist']['name'] . "\n";
    }
} else {
    echo "Aucune playlist trouvée avec cet ID.\n";
}

?>




<?php
$playlist_id = "1306931615";
$api_url = "https://api.deezer.com/playlist/" . $playlist_id;

$response = file_get_contents($api_url);
$json_response = json_decode($response, true);

if (isset($json_response['tracks'])) {
    $tracks = $json_response['tracks']['data'];
    echo "Liste des pistes:\n";
    foreach ($tracks as $track) {
        echo "- " . $track['title'] . " par " . $track['artist']['name'] . "\n";
        echo "  Extrait sonore: " . $track['preview'] . "\n";
    }
} else {
    echo "Aucune playlist trouvée avec cet ID.\n";
}
?>
