<?php include "./components/directory-box.php"; ?>
<?php include "./components/directory-head-list.php"; ?>


<div class="section-body">

    <?= generateHeadList() ?>

    <table class="width-full">
        <?php
            for($i = 0; $i < 9; $i ++) {
                if($i % 3 === 0 && $i > 0)
                    echo '</tr>';

                if($i % 3 === 0)
                    echo '<tr>';


                echo '<td>'.generateBox().'</td>';

                if($i === 8)
                    echo '</tr>';
            }
        ?>
    </table>
</div>