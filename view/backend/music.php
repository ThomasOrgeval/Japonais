<?php $title = 'Les musiques en japonais';
ob_start(); ?>

    <h1 class="h1-admin-left">Les musiques</h1>

    <p class="add"><a href="index.php?p=music_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-size">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Chanteur</th>
            <th>Anime</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['music'] as $music) : ?>
        <tr>
            <td><?= $music['titre'] ?></td>
            <td><?= $music['chanteur'] ?></td>
            <td><?= $music['anime'] ?></td>
            <td>
                <a href="index.php?p=music_edit&id=<?= $music['id']; ?>" class="btn btn-outline-dark btn-small">Edit</a>
                <a href="index.php?p=music_delete&id=<?= $music['id']; ?>"
                   class="btn btn-outline-danger btn-small"
                   onclick="return confirm('Voulez-vous vraiment supprimer ce mot ?')">Remove</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>