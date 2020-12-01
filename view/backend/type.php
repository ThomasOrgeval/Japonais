<?php $title = 'Les types';
ob_start(); ?>
    <h1 class="h1-admin-left">Les types</h1>

    <p class="add"><a href="index.php?p=type_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th class="hidden">ID</th>
            <th>Type</th>
            <th>En japonais</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['type'] as $type): ?>
            <tr>
                <td class="hidden"><?= $type['id']; ?></td>
                <td><?= $type['type']; ?></td>
                <td><?= $type['type_jp']; ?></td>
                <td>
                    <a href="index.php?p=type_edit&id=<?= $type['id']; ?>" class="btn btn-outline-dark btn-small">Edit</a>
                    <a href="index.php?p=type_delete&id=<?= $type['id']; ?>"
                       class="btn btn-outline-danger btn-small"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce mot ?')">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>