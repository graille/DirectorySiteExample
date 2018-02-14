<?php $mS = microtime(true); ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Exercice 5.2 - Afficher la Date et l’heure en utilisant le mécanisme des compteurs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="result-box">
    <?php
    function echoImage($name, &$result) {
        $result .= "<img src=\"images/{$name}\" alt=\"{$name}\" width='20px' height='20px'/>";
    }

    function showWithImage($string) {
        $result = "";

        for ($k = 0; $k < strlen($string); $k++) {
            switch ($i = ord($item = $string[$k])) {
                case $i >= 48 && $i <= 57:
                    // Number
                    echoImage($item . ".gif", $result);
                    break;
                case 58:
                    echoImage("deux-points.png", $result);
                    break;
                case 47:
                    echoImage("slash.gif", $result);
                    break;
                default:
                    throw new Exception("Unknow symbol ({$item}, {$i})");
            }
        }

        return $result;
    }
    ?>

    <div class="box-body">
        Nous sommes le
        <span style="color: cornflowerblue">
            <?= showWithImage(date('d/m/Y')) ?>
        </span>
        <br />
        et il est
        <span style="color: indianred">
            <?= showWithImage(date('h:i:s')) ?>
        </span>
        <hr/>
        <span style="font-size: 12px">Cette page à été générée en <?= round(microtime(true) - $mS, 7) ?>s</span>
    </div>
</div>
</body>
</html>