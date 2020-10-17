<?php $title = 'Les kanjis';
ob_start(); ?>
    <h1 class="h1-admin-left">Les kanjis</h1>

    <p class="add"><a href="index.php?p=word_edit" class="btn btn-success">Ajout</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th style="font-size: 24px">ID</th>
            <th style="font-size: 24px">Kanji</th>
            <th style="font-size: 24px">Grade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['kanji'] as $mot): ?>
            <tr>
                <td style="font-size: 24px"><?= $mot['id']; ?></td>
                <td style="font-size: 24px"><?= $mot['kanji']; ?></td>
                <td style="font-size: 24px"><?= $mot['grade']; ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>