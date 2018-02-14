<?php include "./components/annuaire-box.php"; ?>

<div class="section-body">
    <div class="row width-full">
            <div class="col-6">
                <h2>Répartition par catégories</h2>
            </div>
            <div class="col-6">
                <h2>Répartition par sexe</h2>
            </div>
            <div class="col-6">
                <h2>Nombre de personnes dans l'annuaire</h2>
            </div>
            <div class="col-6">
                <h2>Nombre de consultations de l'annuaire</h2>
            </div>
            <div class="col-6">
                <h2>Dernière personne ajoutée</h2>

                <?= generateBox(); ?>
            </div>
    </div>
</div>