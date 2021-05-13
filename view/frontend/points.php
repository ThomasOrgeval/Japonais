<?php $title = 'Points';
ob_start(); ?>

    <h3>Vous avez : <?= $_SESSION['Account']['points'] ?>
        <img id="sakura-svg-points" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
    </h3>

    <h4>Voici ce que vous pouvez acheter :</h4><br/>
<?php if (!empty($_POST['recompenses'])) : ?>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Nom de la récompense</th>
            <th>Date de parution</th>
            <th>Coût</th>
            <th>Type</th>
            <th>Acheter</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['recompenses'] as $recompense) : ?>
            <tr>
                <td><?= $recompense['libelle'] ?></td>
                <td><?= $recompense['date_parution'] ?></td>
                <td><?= $recompense['cout'] ?></td>
                <td><?= $recompense['type'] ?></td>
                <td><a href="index.php?p=achat&id_recompense=<?= $recompense['id'] ?>"
                       class="btn-sm btn-outline-dark"
                       onclick="return confirm('Voulez-vous vraiment acheter ce lot ?')">Acheter</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Vous avez tout acheté :D</p><br/>
<?php endif; ?>

<?php if (!empty($_POST['achats'])) : ?>
    <h4>Ce que vous avez déjà acheté :</h4><br/>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Nom de la récompense</th>
            <th>Date d'achat</th>
            <th>Coût</th>
            <th>Type</th>
            <th>Date de parution</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['achats'] as $achat) : ?>
            <tr>
                <td><?= $achat['libelle'] ?></td>
                <td><?= $achat['date_achat'] ?></td>
                <td><?= $achat['cout'] ?></td>
                <td><?= $achat['type'] ?></td>
                <td><?= $achat['date_parution'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>