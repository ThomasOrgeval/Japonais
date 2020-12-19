<?php $title = 'Les groupes';
ob_start(); ?>

    <h1 class="h1-admin-left">Les groupes</h1>

    <p class="add"><a href="groupe_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th>Libelle</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['groupes'] as $groupe): ?>
            <tr>
                <td><?= $groupe['libelle']; ?></td>
                <td>
                    <a href="groupe_edit/<?= $groupe['id']; ?>" class="btn btn-outline-dark btn-small">Edit</a>
                    <a href="index.php?p=groupe_delete&id=<?= $groupe['id']; ?>"
                       class="btn btn-outline-danger btn-small">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>