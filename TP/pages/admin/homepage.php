<?php include "./components/directory-box.php"; ?>
<?php include "./components/directory-head-list.php"; ?>

<?php
try {
    if (!empty($_GET['action'])) {
        if ($_GET['action'] === 'delete' && !empty($_GET['id'])) {
            $idToDelete = intval($_GET['id']);
            EntryController::delete($idToDelete);
        }
    }
}
catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<div class="section-body">
    <?php if(isset($error) && !empty($error)) { ?>
        <div class="width-full" style="background-color: orangered; color: white; padding: 20px">
            Une erreur est survenue : <?= $error ?>
        </div>
    <?php } ?>

    <a href="?page=admin.manage">
        <button class="btn width-full">Ajouter une entrée</button>
    </a>

    <?php
        generateHeadList(true);
    ?>
</div>
