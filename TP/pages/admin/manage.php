<?php
try {
    // Variable globales
    $validImageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'svg', 'bmp', 'ico', 'tif'];
    $completed = false;

    // Variables pour l'édition
    $editEntryMode = false;
    $editEntryData = null;

    /**
     * Si on veut editer une entrée existante, on la charge
     */
    if (!empty($_GET['id'])) {
        $loadedEntry = EntryController::getOne(intval($_GET['id']));

        if ($loadedEntry->rowCount() > 0) {
            $editEntryData = $loadedEntry->fetch();
            $editEntryMode = true;
        }
    }

    /**
     * Si le formulaire a été posté, on le traite
     */
    if (array_key_exists('form_token', $_POST)) {
        $data = $_POST;

        // Manage birthday
        if (!empty($_POST["birthday"]))
            $data['birthday'] = strtotime($data['birthday']);

        // Manage Image
        if (!empty($_FILES['image']) && file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            // Check errors
            if ($_FILES['image']['error'] > 0)
                throw new Exception("Erreur lors du transfert de l'image");

            // Check size
            if ($_FILES['image']['size'] > 512000)
                throw new Exception("Le fichier est trop gros : {$_FILES['image']['size']} octets");

            // Check extension
            $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
            if (!in_array($extension, $validImageExtensions))
                throw new Exception("Extension incorrecte, les extensions autorisées sont : " . DataManipulator::transformArrayToString($validImageExtensions));

            // Check type
            $type = mime_content_type($_FILES['image']['tmp_name']);
            $explodedType = explode('/', $type);

            if($explodedType[0] !== 'image') throw new Exception("Le fichier n'est pas une image");
            // Move image
            if (!file_exists('uploads/avatars'))
                mkdir('uploads/avatars', 0777, true);

            $name = md5(uniqid(rand(), true));
            $path = "uploads/avatars/{$name}.{$extension}";
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $path);
            if (!$result) throw new Exception("Le transfert de l'image à échoué");

            // Rewrite $_POST
            $data['image_path'] = $path;
        }
        else {
            if (!is_null($tmpPath = getValue('image_path')))
                $data['image_path'] = $tmpPath;
            else
                $data['image_path'] = null;
        }

        // Manage category
        if (!empty($_POST['category_str'])) {
            // Check that the category does not exist
            $finder = CategoryController::getOneByName($_POST['category_str']);
            if ($finder->rowCount() === 0) {
                $name = $_POST['category_str'];
                CategoryController::add($name);
                $category = CategoryController::getOneByName($name)->fetch();
                $data['category_id'] = $category['id'];
            } else
                $data['category_id'] = $finder->fetch()['id'];
        } else {
            if (empty($_POST['category_id']) || $_POST['category_id'] === "")
                throw new Exception("Vous devez choisir une catégorie ou un créer une nouvelle");
        }

        // On sauvegarde les résultats
        if(!$editEntryMode)
            $entryId = EntryController::addEntry($data);
        else
            $entryId = EntryController::updateEntry(intval($_GET['id']), $data);

        // On passe en mode edition sur la nouvelle entrée
        $editEntryData = EntryController::getOne(intval($entryId))->fetch();
        $editEntryMode = true;

        $completed = true;
    }
} catch (Exception $e) {
    // En cas d'erreur, on redirige tout vers la variable {$error}
    $error = $e->getMessage();
    $editEntryData = $data;
}

function getValue($parameter) {
    global $editEntryData;
    if (isset($editEntryData) && !empty($editEntryData) && !is_null($editEntryData))
        if (array_key_exists($parameter, $editEntryData))
            return $editEntryData[$parameter];

    return null;
}

$actionPath = "?page=admin.manage";
if($editEntryMode) $actionPath .= "&&id={$editEntryData['id']}";
?>

<div class="section-body">
    <?php if(isset($error) && !empty($error)) { ?>
        <div class="width-full" style="background-color: orangered; color: white; padding: 20px">
            Une erreur est survenue : <?= $error ?>
        </div>
    <?php } ?>

    <?php if(isset($completed) && $completed === true) { ?>
        <div class="width-full" style="background-color: green; color: white; padding: 20px">
            <?php if($editEntryMode && !empty($_GET['id'])) { ?>
                Modification de <?= getValue('firstname').' '.getValue('lastname') ?> efféctuée
            <?php } else { ?>
                Ajout de <?= getValue('firstname').' '.getValue('lastname') ?> efféctué
            <?php } ?>
        </div>
    <?php } ?>

    <?php if(!$editEntryMode) { ?>
        <h2>Ajout d'une entrée dans l'annuaire</h2>
    <?php } else { ?>
        <a href="?page=admin.manage">
            <button class="width-full btn">Ajouter une nouvelle entrée</button>
        </a>

        <h2 style="background-color: orangered">Modification d'une entrée dans l'annuaire</h2>
    <?php } ?>

    <form action="<?= $actionPath ?>" method="post" enctype="multipart/form-data">
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
                    <td style="width: <?= (!is_null(getValue('image_path')) && $editEntryMode) ? '70%': '100%' ?>">
                        <input type="file" class="form-control" name="image"/>
                    </td>
                    <?php if(!is_null(getValue('image_path')) && $editEntryMode) { ?>
                    <td style="text-align: center">
                        <img src="<?= getValue('image_path') ?>"
                             alt="<?= getValue('firstname').getValue('lastname') ?>"
                             style="width: 80%; border-radius: 10px"
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
                            $categories = CategoryController::get();
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
