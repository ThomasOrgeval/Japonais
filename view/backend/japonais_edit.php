<?php if (isset($_POST['id'])) {
    $title = $_POST['kanji'] . ' - Edition';
} else {
    $title = 'Mon nouveau groupe';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer un mot japonais</h1>

    <form action="index.php?p=japonais_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <?php if (isset($_GET['id'])): ?>
            <div class="form-group">
                <label for="id">ID</label>
                <?= inputReadonly('id'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="kanji">Mot en kanji</label>
            <?= input('kanji'); ?>
        </div>
        <div class="form-group">
            <label for="kana">Mot en kana</label>
            <?= input('kana'); ?>
        </div>
        <div class="form-group">
            <label for="romaji">Mot en romaji</label>
            <?= input('romaji'); ?>
        </div>
        <h3>Traduction :</h3>
        <?php if (isset($_GET['id'])) :
            $mots = listFrancaisToJaponais($_GET['id']);
        endif;
        if (!empty($mots)):
            $k = 1;
            foreach ($mots as $mot): ?>
                <div style="display: flex">
                    <div class="form-group col-1">
                        <label for="id_francais">ID</label>
                        <input type='text' class='form-control' id='id_francais<?= $k; ?>' name='id_francais<?= $k; ?>'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-7">
                        <label for="francais">Traduction française</label>
                        <input type='text' class='form-control' id='francais<?= $k; ?>' name='francais<?= $k; ?>'
                               value='<?= $mot['francais']; ?>'>
                    </div>
                    <div class="form-group col-4">
                        <label for="id_type<?= $k; ?>">Type du mot</label>
                        <?= selectFormListe($mot, 'id_type', $type_list, $k); ?>
                    </div>
                </div>
                <?php $k = $k + 1;
            endforeach; ?>
            <input class="invisible" name="nombre" value="<?= $k - 1; ?>">
        <?php else:?>
            <div style="display: flex">
                <div class="col-1">
                    <label for="id_francais1">ID</label>
                    <?= inputReadonly('id_francais1'); ?>
                </div>
                <div class="col-6">
                    <label for="francais1">Traduction française</label>
                    <?= input('francais1'); ?>
                </div>
                <div class="col-5">
                    <label for="id_type1">Type du mot</label>
                    <?= select('id_type1', $type_list); ?>
                </div>
            </div>
            <input class="invisible" name="nombre" value="1">
        <?php endif; ?>
        <br/>

        <?= csrfInput(); ?>
        <a type="submit" class="small btn btn-green">Ajouter une traduction</a>
        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>