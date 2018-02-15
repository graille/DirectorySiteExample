<?php include "./components/directory-box.php"; ?>

<div class="section-body">
    <table class="tbl width-full">
        <tr>
            <td style="width: 50%">
                <h2>Répartition par catégories</h2>
                <canvas id="categories-graph"></canvas>
            </td>
            <td>
                <h2>Répartition par sexe</h2>
                <canvas id="gender-graph"></canvas>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Nombre de personnes dans l'annuaire</h2>

                <?= StatsController::getNumber() ?>
            </td>
            <td>
                <h2>Nombre de consultations de l'annuaire</h2>

                <?= StatsController::getVisit() ?>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Dernière personne ajoutée</h2>

                <?= generateBox(); ?>
            </td>
            <td></td>
        </tr>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" type="application/javascript"></script>
<script type="application/javascript">
    // get doughnut chart canvas
    var genderGraph = document.getElementById("gender-graph").getContext("2d");
    var categoriesGraph = document.getElementById("categories-graph").getContext("2d");
    var chartOptions = {
        responsive: true,
        legend: {
            position: 'top'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    <?php
        $categoriesRepartition = StatsController::getCategoriesRepartition();
        $genderRepartition = StatsController::getGenderRepartition();
    ?>

    new Chart(categoriesGraph, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?= DataManipulator::transformArrayToString($categoriesRepartition[1]) ?>,
                backgroundColor: [
                    '#6496E9',
                    'orange'
                ],
                label: 'Dataset 1'
            }],
            labels: <?= DataManipulator::transformArrayToString($categoriesRepartition[0]) ?>
        },
        options: chartOptions
    });

    new Chart(genderGraph, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?= DataManipulator::transformArrayToString($genderRepartition[1]) ?>,
                backgroundColor: [
                    '#6496E9',
                    'orange'
                ],
                label: 'Dataset 1'
            }],
            labels: <?= DataManipulator::transformArrayToString($genderRepartition[0]) ?>
        },
        options: chartOptions
    });
</script>