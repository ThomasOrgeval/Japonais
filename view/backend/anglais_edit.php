<?php $title = isset($_POST['id']) ? $_POST['anglais'] . ' - Edition' : 'Mon nouveau mot';
ob_start(); ?>

    <h1 class="h1-admin">Editer un mot anglais</h1>

    <form action="index.php?p=anglais_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <?php if (isset($_GET['id'])): ?>
            <div class="form-group">
                <label for="id">ID</label>
                <?= inputReadonly('id'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="anglais">Mot en anglais</label>
            <?= input('anglais'); ?>
        </div>
        <div class="form-group">
            <label for="id_type">Catégorie</label>
            <?= select('id_type', $type_list); ?>
        </div>

        <h3 class="font-weight-bold">Traduction :</h3><br/>
        <h5 class="font-weight-bold">Français :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-2">ID</div>
            <div class="form-group col-6">Traduction française</div>
            <div class="form-group col-3">Type du mot</div>
            <div class="form-group col-1">Action</div>
            </div>
        </div>

        <?php if (isset($_GET['id'])) {
            $mots = listFrancaisToAnglais($_GET['id']);
        }
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="small-screen" for="id_francais<?= $mot['id'] ?>">ID</label>
                        <input type='text' class='form-control' id='id_francais<?= $mot['id'] ?>' name='id_francais[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="small-screen" for="francais<?= $mot['id'] ?>">ID</label>
                        <input type='text' class='form-control' id='francais<?= $mot['id'] ?>' name='francais[]'
                               value='<?= $mot['francais']; ?>'>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small-screen" for="id_francais<?= $mot['id'] ?>">ID</label>
                        <?= selectFormListe($mot['id_type'], 'id_type' . $mot['id'], $type_list); ?>
                    </div>
                    <div class="form-group col-md-1">
                        <a class="btn btn-red btn-sm"
                           href="index.php?p=francais_delete_in_anglais&id=<?= $_GET['id']; ?>&id_francais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else:  ?>
            <div class="flexible">
                <div class="form-group col-md-2">
                    <label class="small-screen">ID</label>
                    <?= inputReadonly('id_francais[]'); ?>
                </div>
                <div class="form-group col-md-6">
                    <label class="small-screen">Français</label>
                    <?= input('francais[]'); ?>
                </div>
                <div class="form-group col-md-3">
                    <label class="small-screen">Type</label>
                    <?= select('id_type[]', $type_list); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible hidden row" id="duplicate1">
            <div class="form-group col-md-2">
                <label class="small-screen">ID</label>
                <?= inputReadonly('id_francais[]'); ?>
            </div>
            <div class="form-group col-md-6">
                <label class="small-screen">Français</label>
                <?= input('francais[]'); ?>
            </div>
            <div class="form-group col-md-3">
                <label class="small-screen">Type</label>
                <?= select('id_type[]', $type_list); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark" id="duplicatebtn1">Ajouter une traduction</a><br/><br/>

        <h5 class="font-weight-bold">Japonais :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-2">ID</div>
            <div class="form-group col-2">Kanji</div>
            <div class="form-group col-3">Kana</div>
            <div class="form-group col-4">Romaji</div>
            <div class="form-group col-1">Action</div>
        </div>

        <?php if (isset($_GET['id'])) {
            $mots = listJaponaisToAnglais($_GET['id']);
        }
        if (!empty($mots)):
            foreach ($mots as $mot):?>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="small-screen" for="id_jap<?= $mot['id'] ?>">ID</label>
                        <input type='text' class='form-control' id='id_jap<?= $mot['id'] ?>' name='id_jap[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="small-screen" for="kanji<?= $mot['id'] ?>">Kanji</label>
                        <input type='text' class='form-control' id='kanji<?= $mot['id'] ?>' name='kanji[]'
                               value='<?= $mot['kanji']; ?>'>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small-screen" for="kana<?= $mot['id'] ?>">Kana</label>
                        <input type='text' class='form-control' id='kana<?= $mot['id'] ?>' name='kana[]'
                               value='<?= $mot['kana']; ?>'>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="small-screen" for="romaji<?= $mot['id'] ?>">Romaji</label>
                        <input type='text' class='form-control' id='romaji<?= $mot['id'] ?>' name='romaji[]'
                               value='<?= $mot['romaji']; ?>'>
                    </div>
                    <div class="form-group col-md-1">
                        <a class="btn btn-red btn-sm"
                           href="index.php?p=japonais_delete_in_anglais&id=<?= $_GET['id']; ?>&id_japonais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="flexible">
                <div class="form-group col-md-2">
                    <label class="small-screen">ID</label>
                    <?= inputReadonly('id_jap[]'); ?>
                </div>
                <div class="form-group col-md-2">
                    <label class="small-screen">Kanji</label>
                    <?= input('kanji[]'); ?>
                </div>
                <div class="form-group col-md-3">
                    <label class="small-screen">Kana</label>
                    <?= input('kana[]'); ?>
                </div>
                <div class="form-group col-md-4">
                    <label class="small-screen">Romaji</label>
                    <?= input('romaji[]'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible hidden row" id="duplicate2">
            <div class="form-group col-md-2">
                <label class="small-screen">ID</label>
                <?= inputReadonly('id_jap[]'); ?>
            </div>
            <div class="form-group col-md-2">
                <label class="small-screen">Kanji</label>
                <?= input('kanji[]'); ?>
            </div>
            <div class="form-group col-md-3">
                <label class="small-screen">Kana</label>
                <?= input('kana[]'); ?>
            </div>
            <div class="form-group col-md-4">
                <label class="small-screen">Romaji</label>
                <?= input('romaji[]'); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark" id="duplicatebtn2">Ajouter une traduction</a><br/><br/>

        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form>

    <script>
        (function ($) {
            $('#duplicatebtn1').click(function (e) {
                e.preventDefault();
                var $clone = $('#duplicate1').clone().attr('id', '').removeClass('invisible').removeClass('hidden');
                $('#duplicate1').before($clone);
            })
        })(jQuery);
        (function ($) {
            $('#duplicatebtn2').click(function (e) {
                e.preventDefault();
                var $clone = $('#duplicate2').clone().attr('id', '').removeClass('invisible').removeClass('hidden');
                $('#duplicate2').before($clone);
            })
        })(jQuery);
    </script>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>