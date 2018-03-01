<?php
$pdo = new PDO('mysql:host=localhost;dbname=web230_main', 'web230_main', 'we3h9bE2');

$stmt = $pdo->query("SELECT * FROM people");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$fields = array('lastname', 'firstname', 'age', 'gender', 'category');

?>
<html>
<table style="border: 0.1cm inset;">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Age</th>
        <th>Sexe</th>
        <th>Catégorie</th>
        <!--<th>E-Mail</th>-->
    </tr>
    <tr style="border: 0.1cm inset;">
        <?php if (empty($results)): ?>
        <td style="border: 0.1cm inset;"><span>Empty dataset.</span></td>
        <?php else: ?>
        <?php
        foreach ($results as $result) {

            foreach ($fields as $field) {
                echo "<td style=\"border: 0.1cm inset;\">" . $result[$field] . "</td>";
            }
            //echo "<td a='mailto:" . $calculated_email . "'>" . $calculated_email . "</a></td>";
        }
        ?>
        <?php endif; ?>
    </tr>
</table>
</html>