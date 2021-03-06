<?php $title = 'Les récompenses';
ob_start(); ?>
    <h1 class="h1-admin-left">Les récompenses</h1>

    <p class="add"><a href="index.php?p=recompense_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th class="hidden">ID</th>
            <th>Libellé</th>
            <th class="hidden">Coût</th>
            <th class="hidden">Date de sortie</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['recompense'] as $value): ?>
            <tr>
                <td class="hidden"><?= $value['id'] ?></td>
                <td><?= $value['libelle'] ?></td>
                <td class="hidden"><?= $value['cout'] ?></td>
                <td class="hidden"><?= $value['date_parution'] ?></td>
                <td>
                    <a href="index.php?p=recompense_edit&id=<?= $value['id'] ?>" class="btn btn-outline-dark btn-small">Edit</a>
                    <a href="index.php?p=recompense_delete&id=<?= $value['id'] ?>"
                       class="btn btn-outline-danger btn-small">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>