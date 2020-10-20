<?php $title = 'Les récompenses';
ob_start(); ?>
    <h1 class="h1-admin-left">Les récompenses</h1>

    <p class="add"><a href="index.php?p=recompense_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped">
        <thead>
        <tr>
            <th style="font-size: 24px">ID</th>
            <th style="font-size: 24px">Libellé</th>
            <th style="font-size: 24px">Coût</th>
            <th style="font-size: 24px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['recompense'] as $value): ?>
            <tr>
                <td style="font-size: 24px"><?= $value['id'] ?></td>
                <td style="font-size: 24px"><?= $value['libelle'] ?></td>
                <td style="font-size: 24px"><?= $value['cout'] ?></td>
                <td>
                    <a href="index.php?p=recompense_edit&id=<?= $value['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=recompense_delete&id=<?= $value['id']; ?>"
                       class="btn btn-outline-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>