<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Exercice 5.2 - Afficher la Date et l’heure</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="result-box">
    <div class="box-body">
        Nous sommes le
        <span style="color: cornflowerblue">
            <?= date('d/m/Y') ?>
        </span>
        et il est
        <span style="color: indianred">
            <?= date('h:i:s') ?>
        </span>
    </div>
</div>
</body>
</html>