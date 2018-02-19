<?php include "./components/directory-box.php"; ?>

<div class="section-body">
    <table class="tbl2 width-full">
        <tr>
            <td>
                <h2>Nombre de personnes dans l'annuaire</h2>

                <h3><?= EntryController::get()->rowCount() ?></h3>
            </td>
            <td>
                <h2>Nombre de consultations de l'annuaire</h2>

                <h3><?= StatsController::getVisit()->rowCount() ?></h3>
            </td>
        </tr>
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
            <td colspan="2">
                <h2>Temps moyens d'accès aux pages (en ms)</h2>

                <canvas id="page-time-graph"></canvas>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Dernière personne ajoutée</h2>

                <?php generateBox(EntryController::getLast()->fetch()); ?>
            </td>
            <td>
                <h2>Pages les plus visitées</h2>

                <canvas id="page-visits-graph" height="300px"></canvas>
            </td>
        </tr>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" type="application/javascript"></script>
<script type="application/javascript">
    // get doughnut chart canvas
    var genderGraph = document.getElementById("gender-graph").getContext("2d");
    var categoriesGraph = document.getElementById("categories-graph").getContext("2d");
    var pageTimeGraph = document.getElementById("page-time-graph").getContext("2d");
    var pageVisitsGraph = document.getElementById("page-visits-graph").getContext("2d");

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

    var backgrounds = [
        '#6496E9',
        'orange',
        'blue',
        'green',
        'red',
        'black'
    ];

    <?php
        $categoriesRepartition = StatsController::getCategoriesRepartition();
        $genderRepartition = StatsController::getGenderRepartition();
        $pageTimeRepartition = StatsController::getPageDisplayTimeStats();
        $pageVisitRepartition = StatsController::getPageVisitsStats();
    ?>

    new Chart(categoriesGraph, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?= DataManipulator::transformArrayToString($categoriesRepartition[1]) ?>,
                backgroundColor: backgrounds,
                label: 'Répartition par catégories'
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
                backgroundColor: backgrounds,
                label: 'Repartition par sexe'
            }],
            labels: <?= DataManipulator::transformArrayToString($genderRepartition[0]) ?>
        },
        options: chartOptions
    });

    new Chart(pageTimeGraph, {
        type: 'bar',
        data: {
            datasets: [{
                data: <?= DataManipulator::transformArrayToString($pageTimeRepartition[1]) ?>,
                backgroundColor: backgrounds,
                label: "Temps d'accès"
            }],
            labels: <?= DataManipulator::transformArrayToString($pageTimeRepartition[0]) ?>
        },
        options: chartOptions
    });


    new Chart(pageVisitsGraph, {
        type: 'horizontalBar',
        data: {
            datasets: [{
                data: <?= DataManipulator::transformArrayToString($pageVisitRepartition[1]) ?>,
                backgroundColor: backgrounds,
                label: 'Visites'
            }],
            labels: <?= DataManipulator::transformArrayToString($pageVisitRepartition[0]) ?>
        },
        options: chartOptions
    });


</script>
