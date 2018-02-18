<?php
function generateHeadListEntry($data = [], $isAdmin = false) {
    ?>
    <td><img src="<?= $data['image_path'] ?>" style="max-height: 200px;"/></td>
    <td><?= $data['firstname'] ?></td>
    <td><?= $data['lastname'] ?></td>
    <td><?= date("d-m-Y", $data['birthdate']) ?></td>
    <td><?= $data['category_name'] ?></td>

    <?php if ($isAdmin) { ?>
        <td>
            <a href="?page=admin.manage&&action=delete&&id=<?= $data['id'] ?>">
                <button class="btn width-full">Supprimer</button>
            </a>
        </td>
        <td>
            <a href="?page=admin.manage&&action=edit&&id=<?= $data['id'] ?>">
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
            <th></th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Age</th>
            <th>Catégorie</th>

            <?php if ($isAdmin) { ?>
                <th colspan="2">Actions</th>
            <?php } ?>
        </tr>

        <?php
        $i = 0;
        $entries = EntryModel::get();
        while ($data = $entries->fetch()) {
            generateHeadListEntry($data, $isAdmin);
            $i++;
        }

        if ($i === 0)
            echo '<h2>Rien à afficher :\'(</h2>';
        ?>
    </table>
    <?php
}

?>