<?php $title = 'Les groupes';
ob_start(); ?>
    <h1 class="h1-admin-left">Les groupes</h1>

    <p class="add"><a href="index.php?p=groupe_edit" class="btn btn-success">Ajout</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Libelle</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($groupes as $groupe): ?>
            <tr>
                <td><?= $groupe['id']; ?></td>
                <td><?= $groupe['libelle']; ?></td>
                <td>
                    <a href="index.php?p=groupe_edit&id=<?= $groupe['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=groupe_delete&id=<?= $groupe['id']; ?>&<?= csrf(); ?>" class="btn btn-outline-danger"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce groupe ?')">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>