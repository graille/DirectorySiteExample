<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>TP Atelier - Un annuaire</title>

    <link rel="stylesheet" type="text/css" href="assets/css/box.css">
    <link rel="stylesheet" type="text/css" href="assets/css/nav.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>


<nav id="main-nav">
    <img src="./assets/images/icone_annuaire.png" alt="Annuaire" class="logo"/>
    <div class="h-line"></div>
    <ul>
        <li><a href="?action=homepage">Accueil</a></li>
        <li><a href="?action=directory">Annuaire</a></li>
        <li><a href="?action=stats">Statistiques</a></li>
    </ul>

    <div class="h-line"></div>
    <ul>
        <li style="
            background: url('assets/images/warning.png');
            text-shadow: 2px 0 0 #333, -2px 0 0 #333, 0 2px 0 #333, 0 -2px 0 #333, 1px 1px #333, -1px -1px 0 #333, 1px -1px 0 #333, -1px 1px 0 #333;">
            <a href="?action=admin.homepage" >Administration</a>
        </li>
    </ul>
</nav>

<section id="main-section">
    <?php
        autoloader();

        $action = (!empty($_GET['action'])) ? $_GET['action'] : 'user.directory';
        $action = explode('.', $action);

        if(count($action) === 2) {
            $page = $action[1];
            $section = $action[0];
        } else {
            $page = $action[0];
            $section = 'user';
        }

        require "pages/{$section}/{$page}.php";
    ?>
</section>

</body>
</html>