<?php
    // If we want to edit an existing entry
    if(!empty($_GET['id'])) {
        $editEntry = EntryModel::getOne(intval($_GET['id']));

        if($editEntry->rowCount() > 0)
            $loadedEntry = $editEntry->fetch();
    }

    $validExtensions = array('jpg', 'jpeg', 'gif', 'png');
    if(array_key_exists('form_token', $_POST)) {
        try {
            $data = $_POST;

            // Manage birthday
            if(!empty($_POST["birthday"]))
                $data['birthday'] = strtotime($data['birthday']);

            // Manage Image
            if (!empty($_FILES['image'])) {
                // Check errors
                if ($_FILES['image']['error'] > 0)
                    throw new Exception("Erreur lors du transfert de l'image");

                // Check size
                if ($_FILES['image']['size'] > 512000)
                    throw new Exception("Le fichier est trop gros : {$_FILES['image']['size']} octets");

                // Check extension
                $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                if (!in_array($extension, $validExtensions)) throw new Exception("Extension incorrecte");

                // Move image
                if(!file_exists('uploads/avatars'))
                    mkdir('uploads/avatars', 0777, true);

                $name = md5(uniqid(rand(), true));
                $path = "uploads/avatars/{$name}.{$extension}";
                $result = move_uploaded_file($_FILES['image']['tmp_name'], $path);
                if (!$result) throw new Exception("Le transfert de l'image à échoué");

                // Rewrite $_POST
                $data['image_path'] = $path;
            }

            // Manage category
            if(!empty($_POST['category_str'])) {
                // Check that the category does not exist
                $finder = CategoryModel::getOneByName($_POST['category_str']);
                if($finder->rowCount() === 0) {
                    $name = $_POST['category_str'];
                    CategoryModel::add($name);
                    $data['category_id'] = CategoryModel::getOneByName($name)['id'];
                }
                else
                    $data['category_id'] = $finder->fetch()['id'];
            }
            else {
                if(empty($_POST['category_id']) || $_POST['category_id'] === "")
                    throw new Exception("Vous devez choisir une catégorie ou un créer une nouvelle");
            }

            EntryModel::addEntry($data);
        }
        catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    function getValue($parameter) {
        global $loadedEntry;
        if(isset($loadedEntry) && !empty($loadedEntry)) {

            if (array_key_exists($parameter, $loadedEntry))
                return $loadedEntry[$parameter];
        }

        return null;
    }
?>

<div class="section-body">
    <?php if(isset($error) && !empty($error)) { ?>
        <div class="width-full" style="background-color: orangered; color: white; padding: 20px">
            Une erreur est survenue : <?= $error ?>
        </div>
    <?php } ?>

    <h2>Ajout d'une entrée dans l'annuaire</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Informations personnelles</legend>
            <input type="text" name="firstname" value="<?= getValue('firstname') ?>" placeholder="Prénom" class="form-control"/>
            <input type="text" name="lastname" value="<?= getValue('lastname') ?>" placeholder="Nom" class="form-control"/>
            <input type="date" name="birthday" value="<?= date('Y-m-d', getValue('birthday')) ?>" placeholder="Date de naissance" class="form-control"/>
            <input type="email" name="email" value="<?= getValue('email') ?>" placeholder="Email" class="form-control"/>

            <select class="form-control" name="gender" title="Choix du sexe">
                <option value="male" <?= (getValue('gender') === 'male') ? 'selected' : '' ?>>Homme</option>
                <option value="female" <?= (getValue('gender') === 'female') ? 'selected' : '' ?>>Femme</option>
            </select>
        </fieldset>

        <fieldset>
            <legend>Image</legend>

            <table class="width-full">
                <tr>
                    <td style="width: <?= (getValue('image_path')) ? '70%': '100%' ?>">
                        <input type="file" class="form-control" name="image"/>
                    </td>
                    <?php if(getValue('image_path') !== null) { ?>
                    <td style="text-align: center">
                        <img src="<?= getValue('image_path') ?>"
                             alt="<?= getValue('firstname').getValue('lastname') ?>"
                             width="80%"
                        />
                    </td>
                    <?php } ?>
                </tr>
            </table>

        </fieldset>

        <fieldset>
            <legend>Informations secondaires</legend>

            <input type="text" name="website" value="<?= getValue('website') ?>" placeholder="Page personelle" class="form-control"/>
            <input type="text" name="twitter" value="<?= getValue('twitter') ?>" placeholder="Twitter" class="form-control"/>
            <input type="text" name="facebook" value="<?= getValue('facebook') ?>" placeholder="Facebook" class="form-control"/>
            <input type="text" name="linkedin" value="<?= getValue('linkedin') ?>" placeholder="LinkedIn" class="form-control"/>
        </fieldset>

        <fieldset>
            <legend>Catégorie</legend>

            <table class="width-full">
                <tr>
                    <td style="width: 50%">
                        Séléctionnez une catégorie
                        <select class="form-control" name="category_id" title="Choix de la catégorie">
                            <option>Aucune</option>
                            <?php
                            $categories = CategoryModel::get();
                            while ($data = $categories->fetch())
                                echo "<option value='{$data['id']}' ".
                                    ((getValue('category_id') === $data['id']) ? 'selected' : '').
                                    ">{$data['name']}</option>";
                            ?>
                        </select>
                    </td>
                    <td style="width: 50%">
                        Ou créez-en une nouvelle
                        <input type="text" name="category_str" class="form-control" placeholder="Nom de la catégorie">
                    </td>
                </tr>
            </table>
        </fieldset>

        <input type="hidden" name="form_token" />

        <table class="width-full">
            <tr>
                <td style="width: 50%">
                    <a href="?page=directory&&style=table">
                        <button type="submit" class="btn width-full">Enregister</button>
                    </a>
                </td>
                <td style="width: 50%">
                    <a href="?page=directory&&style=box">
                        <button type="reset" class="btn width-full btn-reset">Réinitialiser</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>
</div>
