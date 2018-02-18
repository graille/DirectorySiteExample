<?php
function generateHeadListEntry($data = [], $isAdmin = false) {
    ?>
    <td><img src="<?= $data['image_path'] ?>" alt="<?= $data["firstname"] ?> profile picture" style="max-height: 200px; border-radius: 10px;"/></td>
    <td><?= $data['firstname'] ?></td>
    <td><?= $data['lastname'] ?></td>
    <td><?= Utils::calculateAgeFromTimestamp($data['birthday']) ?> ans</td>
    <td><?= $data['created'] ?></td>
    <td><?= $data['category_name'] ?></td>

    <?php if ($isAdmin) { ?>
        <td>
            <a href="?page=admin.homepage&&action=delete&&id=<?= $data['id'] ?>">
                <button class="btn width-full">Supprimer</button>
            </a>
        </td>
        <td>
            <a href="?page=admin.manage&&id=<?= $data['id'] ?>">
                <button class="btn width-full">Modifier</button>
            </a>
        </td>
    <?php } ?>

    <?php
}

function generateHeadList($isAdmin = false) {
    ?>
    <table class="tbl2">
        <tr>
            <th style="width: 1px"></th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Age</th>
            <th>Date d'ajout</th>
            <th>Catégorie</th>

            <?php if ($isAdmin) { ?>
                <th colspan="2">Actions</th>
            <?php } ?>
        </tr>

        <?php
        $i = 0;
        $entries = EntryController::get();
        while ($data = $entries->fetch()) {
            echo '<tr>';
            generateHeadListEntry($data, $isAdmin);
            echo '</tr>';
            $i++;
        }

        if ($i === 0)
            echo '<h2>Rien à afficher :\'(</h2>';
        ?>
    </table>
    <?php
}

?>