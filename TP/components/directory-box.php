<?php

function generateBox($data = []) {
    ?>
    <div class="head-box">
        <div class="box-header">
            <div class="background"></div>
            <div class="title">
                Elon MUSK
                <div class="subtitle">
                    PDG de SpaceX, 46 ans
                </div>
            </div>
            <div class="picture">
                <img src="https://specials-images.forbesimg.com/imageserve/59d552c74bbe6f37dd9fff97/416x416.jpg?background=000000&cropX1=0&cropX2=2259&cropY1=103&cropY2=2362"
                     alt="Profile image"/>
            </div>
        </div>

        <div>
            <table class="tbl">
                <tr>
                    <td>Courriel</td>
                    <td><a href="mailto:elon.musk@tesla.com">elon.musk@tesla.com</a></td>
                </tr>
                <tr>
                    <td>Page perso</td>
                    <td><a href="//tesla.com">Tesla Motors</a></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="icon-container">
                            <a href="https://twitter.com/elonmusk">
                                <img alt="Twitter"
                                     src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/c8/Twitter_Bird.svg/1259px-Twitter_Bird.svg.png"/>
                            </a>
                            <a href="https://www.facebook.com/Elon-Musk-19958149870/">
                                <img alt="Facebook"
                                     src="https://vignette.wikia.nocookie.net/thelorde/images/9/9d/Facebook-logo-png-image-76118.png/revision/latest?cb=20170428142744"/>
                            </a>
                            <a href="https://www.linkedin.com/showcase/elon-musk-newslines/?originalSubdomain=fr">
                                <img alt="LinkedIn"
                                     src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-linkedin-512.png"/>
                            </a>
                        </div>

                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php
}

function generateBoxList($isAdmin = false) {
    echo '<table class="width-full">';
    $i = 0;
    $entries = EntryModel::get();
    while ($data = $entries->fetch()) {
        if ($i % 3 === 0 && $i > 0)
            echo '</tr>';

        if ($i % 3 === 0)
            echo '<tr>';


        echo '<td>' . generateBox($data) . '</td>';

        if ($i === 8)
            echo '</tr>';

        $i++;
    }

    echo '</table>';

    if ($i === 0)
        echo '<h2>Rien à afficher :\'(</h2>';
}

?>