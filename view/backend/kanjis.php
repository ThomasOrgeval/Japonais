<?php $title = 'Les kanjis';
ob_start(); ?>
    <h1 class="h1-admin-left">Les kanjis</h1>

    <table id="db" class="table table-bordered table-size">
        <thead>
        <tr>
            <th class="hidden">ID</th>
            <th>Kanji</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['kanji'] as $mot): ?>
            <tr>
                <td class="hidden"><?= $mot['id'] ?></td>
                <td><?= $mot['kanji'] ?></td>
                <td><?= $mot['grade'] ?></td>
                <td>
                    <a href="index.php?p=kanji_edit&id=<?= $mot['id'] ?>" class="btn btn-outline-dark btn-small">Edit</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>