<?php
function generateHeadListEntry($data = [], $isAdmin = false) {
    ob_start();
    ?>
    <td><img src="<?= $data['image_path']  ?>" /></td>
    <td><img src="<?= $data['firstname']  ?>" /></td>
    <td><img src="<?= $data['lastname']  ?>" /></td>
    <td><img src="<?= date("d-m-Y", $data['birthdate'])  ?>" /></td>
    <td><img src="<?= $data['category_name']  ?>" /></td>

    <?php if($isAdmin) { ?>
        <td><a href="?page=admin.manage&&action=delete&&id=<?= $data['id'] ?>">Supprimer</a></td>
        <td><a href="?page=admin.manage&&action=edit&&id=<?= $data['id'] ?>">Modifier</a></td>
    <?php } ?>
    <?php
    return ob_get_clean();
}


function generateHeadList($isAdmin = false) {
    ob_start();
    ?>
    <table class="tbl2">
        <tr>
            <th></th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Age</th>
            <th>Catégorie</th>

            <?php if($isAdmin) { ?>
                <th colspan="2">Actions</th>
            <?php } ?>
        </tr>

        <?php
            while($data = EntryModel::getEntries()->fetch())
                generateHeadListEntry($data);
        ?>
    </table>
<?php
    return ob_get_clean();
}
?>