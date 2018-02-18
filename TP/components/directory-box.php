<?php

function generateBox($data = []) {
    if(!empty($data)) {
        ?>
        <div class="head-box">
            <div class="box-header">
                <div class="background"></div>
                <div class="title">
                    <?= ucfirst($data['firstname']) . ' ' . strtoupper($data['lastname']) ?>
                    <div class="subtitle">
                        <?= $data['category_name'] ?>
                    </div>
                </div>
                <div class="picture">
                    <img src="<?= $data['image_path'] ?>" alt="<?= $data["firstname"] ?> profile picture"/>
                </div>
            </div>

            <div>
                <table class="tbl">
                    <tr>
                        <td>Courriel</td>
                        <td><a href="mailto:<?= $data['email'] ?>"><?= $data['email'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Page perso</td>
                        <td><a href="//tesla.com"><?= $data['website'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td><a href="//tesla.com"><?= Utils::calculateAgeFromTimestamp($data['birthday']) ?></a></td>
                    </tr>
                    <tr>
                        <td>Date d'ajout</td>
                        <td><a href="//tesla.com"><?= $data['created'] ?></a></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="icon-container">
                                <a href="<?= $data['twitter'] ?>">
                                    <img alt="Twitter"
                                         src="assets/images/logo/twitter.png"/>
                                </a>
                                <a href="<?= $data['facebook'] ?>">
                                    <img alt="Facebook"
                                         src="assets/images/logo/facebook.png"/>
                                </a>
                                <a href="<?= $data['linkedin'] ?>">
                                    <img alt="LinkedIn"
                                         src="assets/images/logo/linkedin.png"/>
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
    }
    else
        echo '<h3>Aucune données à afficher</h3>';
}

function generateBoxList($nbPerRow = 3) {
    echo '<table class="width-full">';
    $i = 0;
    $entries = EntryController::get();
    while ($data = $entries->fetch()) {
        if ($i % $nbPerRow === 0 && $i > 0) echo '</tr>';
        if ($i % $nbPerRow === 0) echo '<tr>';

        echo '<td style="width: '.(100/$nbPerRow).'%">';
        generateBox($data);
        echo '</td>';

        $i++;
    }
    echo '</tr></table>';

    if ($i === 0)
        echo '<h2>Rien à afficher :\'(</h2>';
}

?>