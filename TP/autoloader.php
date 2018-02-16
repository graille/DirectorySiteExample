<?php
require_once './config.php';

function autoload() {
    foreach (glob("./functions/{**/*,*}.php", GLOB_BRACE) as $filename)
        require_once $filename;
}

?>