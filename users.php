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
              <a class="nav-link active" href="admin.php">
                <i class="bi bi-house"></i>
                Général <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="games-list.php">
                <i class="bi bi-controller"></i>
                Parties
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users.php">
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
          <h1 class="h1">Général</h1>
          
        </div>

        <!-- <canvas class="my-4" id="myChart" width="900" height="380"></canvas> -->

<h2>Dernières parties</h2>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <?php foreach($keys as $key) :?>
        
        <th><?=$key?></th>
        <?php endforeach ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach($allGames as $index => $gameData) :?>
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