<?php include "./components/directory-box.php"; ?>
<?php include "./components/directory-head-list.php"; ?>


<div class="section-body">
    <a href="?page=admin.add">
        <button class="btn width-full">Ajouter une entrée</button>
    </a>


    <?php
        generateHeadList(true);
    ?>
</div>
