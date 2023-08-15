<?php
session_start();
require 'includes/_functions.php';

if (!(isset($_SESSION['user'])) && !isValidHTTPReferer(__DIR__) && $_SESSION['user']['pseudo_user'] != "adminmusiquiz") {
  session_destroy();
  header("Location: index.php?error_referer");
  exit;
}

?>



<?php
require 'includes/_database.php';

$query = $dbCo->prepare("SELECT id_game, id_user, pseudo_user, id_room, name_room, score_game, date_score_game  FROM " . $_ENV["GAMES"] . " JOIN " . $_ENV["USERS"] . " USING (id_user) JOIN " . $_ENV["ROOMS"] . " USING (id_room) ORDER BY id_game DESC LIMIT 10");
$query->execute();
$lastGames = $query->fetchAll();
// var_dump($lastGames);

$lastGamesKeys = array_keys($lastGames[0]);

// var_dump($lastGamesKeys);


$query = $dbCo->prepare("SELECT id_user, pseudo_user, mail_user FROM " . $_ENV["USERS"] . " ORDER BY id_user DESC LIMIT 5");
$query->execute();
$lastRegisters = $query->fetchAll();
var_dump($lastRegisters);

$lastRegistersKeys = array_keys($lastRegisters[0]);


?>


<!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
  <title>Hello, world!</title>
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Musiquiz</a>

    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="actions/logout.php">Déconnexion</a>
      </li>
    </ul>
  </nav>





  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav d-flex flex-column custom-nav">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <i class="bi bi-house"></i>
                Général <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-controller"></i>
                Parties
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-person"></i>
                Utilisateurs
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-music"></i>
                Rooms
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-gear-fill"></i>
                Themes
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Général</h1>
          
        </div>

        <!-- <canvas class="my-4" id="myChart" width="900" height="380"></canvas> -->

        <h2>Dernières parties</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <?php foreach($lastGamesKeys as $key) :?>
                
                <th><?=$key?></th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lastGames as $index => $gameData) :?>
              <tr>
                <td>#</td>
                  <?php
                  foreach ($gameData as $data) {
                    echo '<td>' . $data .  '</td>';
                  }
                  ?>
              </tr>
              <?php endforeach?>

            </tbody>
          </table>
        </div>


        <h2>Derniers inscrits</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <?php foreach($lastRegistersKeys as $key) :?>
                <th><?=$key?></th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lastRegisters as $index => $userData) :?>
              <tr>
                <td>#</td>
                  <?php
                  foreach ($userData as $data) {
                    echo '<td>' . $data .  '</td>';
                  }
                  ?>
              </tr>
              <?php endforeach?>

            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>


  <!-- <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <a href="index.html" class="col-1">
                <i class="bi bi-piggy-bank-fill text-primary fs-1"></i>
            </a>
            <nav class="col-11 col-md-7">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link link-secondary" aria-current="page">Opérations</a>
                    </li>
                    <li class="nav-item">
                        <a href="summary.html" class="nav-link link-body-emphasis">Synthèses</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.html" class="nav-link link-body-emphasis">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a href="import.html" class="nav-link link-body-emphasis">Importer</a>
                    </li>
                </ul>
            </nav>
            <form action="" class="col-12 col-md-4" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher..."
                        aria-describedby="button-search">
                    <button class="btn btn-primary" type="submit" id="button-search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </header>
    </div> -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>