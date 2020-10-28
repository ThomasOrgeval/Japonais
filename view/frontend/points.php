<?php $title = 'Points';
ob_start(); ?>

    <h1>Vous avez : <?= $_SESSION['points'] ?><img id="sakura-svg-points" src="./resources/svgs/sakura.svg"
                                                   alt="sakura"></h1>

    <h2>Voici ce que vous pouvez acheter :</h2><br/>
<?php if (!empty($_POST['recompenses'])) : ?>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Nom de la récompense</th>
            <th>Date de parution</th>
            <th>Coût</th>
            <th>Acheter</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['recompenses'] as $recompense) : ?>
            <td><?= $recompense['libelle'] ?></td>
            <td><?= $recompense['date_parution'] ?></td>
            <td><?= $recompense['cout'] ?></td>
            <td><a href="index.php?p=achat&id_recompense=<?= $recompense['id'] ?>"
                   class="btn-sm btn-outline-dark"
                   onclick="return confirm('Voulez-vous vraiment acheter ce lot ?')">Acheter</a></td>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Vous avez tout acheté :D</p>
<?php endif; ?>

<?php if (!empty($_POST['achats'])) : ?>
    <h2>Ce que vous avez déjà acheté :</h2><br/>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Nom de la récompense</th>
            <th>Date d'achat</th>
            <th>Coût</th>
            <th>Date de parution</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['achats'] as $achat) : ?>
            <td><?= $achat['libelle'] ?></td>
            <td><?= $achat['date_achat'] ?></td>
            <td><?= $achat['cout'] ?></td>
            <td><?= $achat['date_parution'] ?></td>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>