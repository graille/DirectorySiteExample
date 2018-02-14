<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Exercice 5.2 - Afficher la Date et l’heure</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="result-box">
    <div class="box-body">
        <h2>Formulaire</h2>
        <hr/>

        <form action="resultat-formulaire.php">
            <input name="lastname" type="text" class="form-control" placeholder="Nom"/>
            <input name="firstname" type="text" class="form-control" placeholder="Prénom"/>
            <input name="age" type="number" class="form-control" placeholder="Âge"/>

            <label>
                Sexe
                <select name="gender" class="form-control">
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </label>

            <label>
                Catégorie
                <select name="gender" class="form-control">
                    <option value="male">Enseignant</option>
                    <option value="female">Etudiant</option>
                </select>
            </label>

            <hr/>
            <button type="submit" class="btn" style="float: left">Envoyer</button>
            <button type="reset" class="btn" style="float: right; background-color: orangered">Effacer</button>
        </form>

    </div>
</div>
</body>
</html>