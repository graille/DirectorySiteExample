<div class="section-body">
    <h2>Ajout d'une entrée dans l'annuaire</h2>

    <form action="manage.php">
        <fieldset>
            <legend>Informations personnelles</legend>
            <input type="text" name="firstName" placeholder="Prénom" class="form-control"/>
            <input type="text" name="firstName" placeholder="Nom" class="form-control"/>
            <input type="date" name="firstName" placeholder="Date de naissance" class="form-control"/>
            <input type="email" name="firstName" placeholder="Email" class="form-control"/>

            <select class="form-control" name="gender">
                <optgroup label="Sexe">
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </optgroup>
            </select>
        </fieldset>

        <fieldset>
            <legend>Image</legend>

            <table class="width-full">
                <tr>
                    <td style="width: 70%">
                        <input type="file" class="form-control"/>
                    </td>
                    <td>
                        Aperçu
                    </td>
                </tr>
            </table>

        </fieldset>

        <fieldset>
            <legend>Informations secondaires</legend>

            <input type="text" name="firstName" placeholder="Page personelle" class="form-control"/>
        </fieldset>

        <fieldset>
            <legend>Catégorie</legend>

            <table class="width-full">
                <tr>
                    <td style="width: 50%">
                        Ou créez en une nouvelle
                        <input type="text" name="category_str" class="form-control" placeholder="Nom de la catégorie">
                    </td>
                    <td style="width: 50%">
                        Séléctionnez une catégorie
                        <select class="form-control" name="category_select">
                            <optgroup label="Catégorie">
                                <?php
                                while ($data = CategoryModel::get())
                                    echo "<option value='{$data['id']}'>{$data['name']}</option>";
                                ?>
                            </optgroup>
                        </select>
                    </td>

                </tr>
            </table>
        </fieldset>
    </form>
</div>
