<?php $title = 'Les types';
ob_start(); ?>
    <h1 class="h1-admin-left">Les types</h1>

    <p class="add"><a href="index.php?p=type_edit" class="btn btn-success">Ajout</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($types as $type): ?>
            <tr>
                <td><?= $type['id']; ?></td>
                <td><?= $type['type']; ?></td>
                <td>
                    <a href="index.php?p=type_edit&id=<?= $type['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=type_delete&id=<?= $type['id']; ?>&<?= csrf(); ?>"
                       class="btn btn-outline-danger"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce mot ?')">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>