<?php
if (isset($_POST['id'])) {
    $title = $_POST['kanji'] . ' - Edition';
} else {
    $title = 'Mon nouveau groupe';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer un kanji</h1>

    <form action="index.php?p=kanji_save<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <?php if (isset($_GET['id'])): ?>
            <div class="form-group">
                <label for="id">ID</label>
                <?= inputReadonly('id') ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="kanji">Kanji</label>
            <?= inputReadonly('kanji') ?>
        </div>
        <div class="form-group">
            <label for="lignes">Nombre de lignes</label>
            <?= inputReadonly('lignes') ?>
        </div>
        <div class="form-group">
            <label for="grade">Grade du kanji</label>
            <?= inputReadonly('grade') ?>
        </div>
        <div class="form-group">
            <label for="on_yomi">Lecture phonétique/sino-japonaise (on)</label>
            <?= input('on_yomi') ?>
        </div>
        <div class="form-group">
            <label for="kun_yomi">Lecture japonaise (kun)</label>
            <?= input('kun_yomi') ?>
        </div>
        <div class="form-group">
            <label for="sens">Sens du kanji</label>
            <?= input('sens') ?>
        </div>
        <div class="form-group">
            <label for="sens_en">Sens en anglais du kanji</label>
            <?= input('sens_en') ?>
        </div>

        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form><br/><br/>

<?php if (!empty($_POST['japonais'])): ?>
    <div>
        <h1>Mot japonais contenant ce kanji :</h1>

        <table class="table table-striped table-size">
            <thead>
            <tr>
                <th>Kanji</th>
                <th>Kana</th>
                <th>Romaji</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_POST['japonais'] as $item) : ?>
                <tr>
                    <td><a href="index.php?p=japonais_edit&id=<?= $item['id'] ?>"><?= $item['kanji'] ?></a></td>
                    <td><?= $item['kana'] ?></td>
                    <td><?= $item['romaji'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif;
$content = ob_get_clean();
require('./view/template/template.php'); ?>