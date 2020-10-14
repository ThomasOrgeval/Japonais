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
        <div style="display: flex">
            <div class="form-group col-1">
                <label for="id_francais[]">ID</label>
            </div>
            <div class="form-group col-7">
                <label for="francais[]">Traduction française</label>
            </div>
            <div class="form-group col-3">
                <label for="id_type[]">Type du mot</label>
            </div>
            <div class="form-group col-1">
                <label for="action">Action</label>
            </div>
        </div>

        <?php if (isset($_GET['id'])) :
            $mots = listFrancaisToJaponais($_GET['id']);
        endif;
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div style="display: flex">
                    <div class="form-group col-1">
                        <input type='text' class='form-control' id='id_francais[]' name='id_francais[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-7">
                        <input type='text' class='form-control' id='francais[]' name='francais[]'
                               value='<?= $mot['francais']; ?>'>
                    </div>
                    <div class="form-group col-3">
                        <?= selectFormListe($mot['id_type'], 'id_type[]', $type_list); ?>
                    </div>
                    <div class="form-group col-1">
                        <a class="btn_delete btn-red"
                           href="index.php?p=francais_delete_in_japonais&id=<?= $_GET['id']; ?>&id_francais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else:
            $k = 1 ?>
            <div style="display: flex">
                <div class="form-group col-1">
                    <?= inputReadonly('id_francais[]'); ?>
                </div>
                <div class="form-group col-7">
                    <?= input('francais[]'); ?>
                </div>
                <div class="form-group col-3">
                    <?= select('id_type[]', $type_list); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible" style="display: flex" id="duplicate">
            <div class="form-group col-1">
                <?= inputReadonly('id_francais[]'); ?>
            </div>
            <div class="form-group col-7">
                <?= input('francais[]'); ?>
            </div>
            <div class="form-group col-3">
                <?= select('id_type[]', $type_list); ?>
            </div>
        </div>

        <?= csrfInput(); ?>
        <a class="small btn btn-green" id="duplicatebtn">Ajouter une traduction</a>
        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form>

    <script>
        (function ($) {
            $('#duplicatebtn').click(function (e) {
                e.preventDefault();
                var $clone = $('#duplicate').clone().attr('id', '').removeClass('invisible');
                $('#duplicate').before($clone);
            })
        })(jQuery);
    </script>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>