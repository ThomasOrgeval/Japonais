<?php $title = 'Mes listes';
ob_start(); ?>
    <h1 class="h1-admin-left">Mes listes</h1>

    <p class="add"><a href="index.php?p=liste_edit" class="btn btn-success">Ajout</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listes as $liste): ?>
            <tr>
                <td><?= $liste['nom']; ?></td>
                <td>
                    <a href="index.php?p=liste_edit&id=<?= $liste['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=liste_delete&id=<?= $liste['id']; ?>" class="btn btn-outline-danger"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce groupe ?')">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>