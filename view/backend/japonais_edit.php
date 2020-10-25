<?php if (isset($_POST['id'])) {
    $title = $_POST['kanji'] . ' - Edition';
} else {
    $title = 'Mon nouveau mot';
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

        <h3>Traduction :</h3><br/>
        <h5>Français :</h5>
        <div style="display: flex">
            <div class="form-group col-2">
                <label for="id_francais[]">ID</label>
            </div>
            <div class="form-group col-6">
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
                    <div class="form-group col-2">
                        <input type='text' class='form-control' id='id_francais[]' name='id_francais[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-6">
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
                <div class="form-group col-2">
                    <?= inputReadonly('id_francais[]'); ?>
                </div>
                <div class="form-group col-6">
                    <?= input('francais[]'); ?>
                </div>
                <div class="form-group col-3">
                    <?= select('id_type[]', $type_list); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible" style="display: flex" id="duplicate">
            <div class="form-group col-2">
                <?= inputReadonly('id_francais[]'); ?>
            </div>
            <div class="form-group col-6">
                <?= input('francais[]'); ?>
            </div>
            <div class="form-group col-3">
                <?= select('id_type[]', $type_list); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark" id="duplicatebtn">Ajouter une traduction</a><br/><br/>

        <h5>Anglais :</h5>
        <div style="display: flex">
            <div class="form-group col-2">
                <label for="id_anglais[]">ID</label>
            </div>
            <div class="form-group col-6">
                <label for="anglais[]">Traduction anglaise</label>
            </div>
            <div class="form-group col-3">
                <label for="id_type_anglais[]">Type du mot</label>
            </div>
            <div class="form-group col-1">
                <label for="action">Action</label>
            </div>
        </div>

        <?php if (isset($_GET['id'])) :
            $mots = listAnglaisToJaponais($_GET['id']);
        endif;
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div style="display: flex">
                    <div class="form-group col-2">
                        <input type='text' class='form-control' id='id_anglais[]' name='id_anglais[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-6">
                        <input type='text' class='form-control' id='anglais[]' name='anglais[]'
                               value='<?= $mot['anglais']; ?>'>
                    </div>
                    <div class="form-group col-3">
                        <?= selectFormListe($mot['id_type'], 'id_type_anglais[]', $type_list); ?>
                    </div>
                    <div class="form-group col-1">
                        <a class="btn_delete btn-red"
                           href="index.php?p=anglais_delete_in_japonais&id=<?= $_GET['id']; ?>&id_anglais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else:
            $k = 1 ?>
            <div style="display: flex">
                <div class="form-group col-2">
                    <?= inputReadonly('id_anglais[]'); ?>
                </div>
                <div class="form-group col-6">
                    <?= input('anglais[]'); ?>
                </div>
                <div class="form-group col-3">
                    <?= select('id_type_anglais[]', $type_list); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible" style="display: flex" id="duplicate2">
            <div class="form-group col-2">
                <?= inputReadonly('id_anglais[]'); ?>
            </div>
            <div class="form-group col-6">
                <?= input('anglais[]'); ?>
            </div>
            <div class="form-group col-3">
                <?= select('id_type_anglais[]', $type_list); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark" id="duplicatebtn2">Ajouter une traduction</a><br/><br/>

        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form><br/><br/>

<?php if (!empty($_POST['kanjis'])): ?>
    <div>
        <h1>Kanji présent(s) :</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th style="font-size: 24px">Kanji</th>
                <th style="font-size: 24px">Lignes</th>
                <th style="font-size: 24px">Grade</th>
            </tr>
            </thead>
            <tbody>
        <?php foreach ($_POST['kanjis'] as $kanji) : ?>
            <tr>
                <td style="font-size: 24px"><a href="index.php?p=kanji_edit&id=<?= $kanji['id'] ?>"><?= $kanji['kanji'] ?></a></td>
                <td style="font-size: 24px"><?= $kanji['lignes'] ?></td>
                <td style="font-size: 24px"><?= $kanji['grade'] ?></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif ?>

    <script>
        (function ($) {
            $('#duplicatebtn').click(function (e) {
                e.preventDefault();
                var $clone = $('#duplicate').clone().attr('id', '').removeClass('invisible');
                $('#duplicate').before($clone);
            })
        })(jQuery);
        (function ($) {
            $('#duplicatebtn2').click(function (e) {
                e.preventDefault();
                var $clone = $('#duplicate2').clone().attr('id', '').removeClass('invisible');
                $('#duplicate2').before($clone);
            })
        })(jQuery);
    </script>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>