<?php include "./components/directory-box.php"; ?>
<?php include "./components/directory-head-list.php"; ?>

<?php
    if(!array_key_exists('style', $_GET))
        $style = "table";
    else
        $style = $_GET['style'];
?>

<div class="section-body">
    <table class="width-full">
        <tr>
            <td style="width: 50%">
                <a href="?page=directory&&style=table">
                    <button class="btn width-full <?= ($style === "table") ? 'btn-white': '' ?>">Affichage en liste</button>
                </a>
            </td>
            <td style="width: 50%">
                <a href="?page=directory&&style=box">
                    <button class="btn width-full <?= ($style === "box") ? 'btn-white': '' ?>">Affichage en trombinoscope</button>
                </a>
            </td>
        </tr>
    </table>
    <?php
    if ($style === "table")
        generateHeadList();
    else
        generateBoxList();
    ?>
</div>
