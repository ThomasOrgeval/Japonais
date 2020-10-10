<?php $title = 'Les mots';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots</h1>

    <p class="add">
        <a href="index.php?p=word_edit" class="btn btn-success">Ajout</a>
        <a href="index.php?p=exportxml" class="btn btn-grey">Export XML</a>
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th>Kana</th>
            <th>Romaji</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($words as $word): ?>
            <tr>
                <td><?= $word['fr']; ?></td>
                <td><?= $word['kanji']; ?></td>
                <td><?= $word['kana']; ?></td>
                <td><?= $word['romaji']; ?></td>
                <td>
                    <a href="index.php?p=word_edit&id=<?= $word['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=word_delete&id=<?= $word['id']; ?>&<?= csrf(); ?>"
                       class="btn btn-outline-danger"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce mot ?')">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>