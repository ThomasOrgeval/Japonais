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
            <label for="trad_on_yomi">Traduction de la lecture phonétique</label>
            <?= input('trad_on_yomi') ?>
        </div>
        <div class="form-group">
            <label for="kun_yomi">Lecture japonaise (kun)</label>
            <?= input('kun_yomi') ?>
        </div>
        <div class="form-group">
            <label for="trad_kun_yomi">Traduction de la lecture japonais</label>
            <?= input('trad_kun_yomi') ?>
        </div>

        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>