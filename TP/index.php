<?php 
$startTime = microtime(true); 
ini_set('display_errors', 'stdout');
ini_set('error_reporting', E_ALL);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>TP Atelier - Un annuaire</title>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/css/form.css">
    <link rel="stylesheet" type="text/css" href="assets/css/box.css">
    <link rel="stylesheet" type="text/css" href="assets/css/nav.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>


<nav id="main-nav">
    <img src="./assets/images/icone_annuaire.png" alt="Annuaire" class="logo"/>
    <div class="h-line"></div>
    <ul>
        <li><a href="?page=directory">Annuaire</a></li>
        <li><a href="?page=stats">Statistiques</a></li>
    </ul>

    <div class="h-line"></div>
    <ul>
        <li style="
            text-shadow: 2px 0 0 #333, -2px 0 0 #333, 0 2px 0 #333, 0 -2px 0 #333, 1px 1px #333, -1px -1px 0 #333, 1px -1px 0 #333, -1px 1px 0 #333;">
            <a href="?page=admin.homepage">Administration</a>
        </li>
    </ul>
</nav>

<section id="main-section">
    <?php
        include "autoloader.php";
        autoload();

        $action = (!empty($_GET['page'])) ? $_GET['page'] : 'user.directory';
        $action = explode('.', $action);

        if(count($action) === 2) {
            $page = $action[1];
            $section = $action[0];
        } else {
            $page = $action[0];
            $section = 'user';
        }

        if(file_exists("pages/{$section}/{$page}.php")) {
            require "pages/{$section}/{$page}.php";
            StatsController::addVisit($section . '.' . $page, microtime(true) - $startTime);
        }
        else
            echo "<h2 style='background-color: orangered; border-radius: 0'>ERREUR 404<br />La page demandée n'existe pas :/</h2>"
    ?>
</section>

</body>
</html>
