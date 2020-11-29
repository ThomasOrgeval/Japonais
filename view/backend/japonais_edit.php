<?php $title = isset($_POST['id']) ? $title = $_POST['kanji'] . ' - Edition' : 'Mon nouveau mot';
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

        <h3 class="font-weight-bold">Traduction :</h3><br/>
        <h5 class="font-weight-bold">Français :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-2">ID</div>
            <div class="form-group col-6">Traduction française</div>
            <div class="form-group col-3">Type du mot</div>
            <div class="form-group col-1">Action</div>
        </div>

        <?php if (isset($_GET['id'])) {
            $mots = listFrancaisToJaponais($_GET['id']);
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
                           href="index.php?p=francais_delete_in_japonais&id=<?= $_GET['id']; ?>&id_francais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
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

        <h5 class="font-weight-bold">Anglais :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-md-2">ID</div>
            <div class="form-group col-md-6">Traduction anglaise</div>
            <div class="form-group col-md-3">Type du mot</div>
            <div class="form-group col-md-1">Action</div>
        </div>

        <?php if (isset($_GET['id'])) {
            $mots = listAnglaisToJaponais($_GET['id']);
        }
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="small-screen" for="id_anglais<?= $mot['id'] ?>">ID</label>
                        <input type='text' class='form-control' id='id_anglais<?= $mot['id'] ?>' name='id_anglais[]'
                               value='<?= $mot['id']; ?>' readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="small-screen" for="anglais<?= $mot['id'] ?>">Anglais</label>
                        <input type='text' class='form-control' id='anglais<?= $mot['id'] ?>' name='anglais[]'
                               value='<?= $mot['anglais']; ?>'>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small-screen" for="id_type_anglais<?= $mot['id'] ?>">Type</label>
                        <?= selectFormListe($mot['id_type'], 'id_type_anglais' . $mot['id'], $type_list); ?>
                    </div>
                    <div class="form-group col-md-1">
                        <a class="btn btn-red btn-sm"
                           href="index.php?p=anglais_delete_in_japonais&id=<?= $_GET['id']; ?>&id_anglais=<?= $mot['id']; ?>">-</a>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="small-screen">ID</label>
                    <?= inputReadonly('id_anglais[]'); ?>
                </div>
                <div class="form-group col-md-6">
                    <label class="small-screen">Anglais</label>
                    <?= input('anglais[]'); ?>
                </div>
                <div class="form-group col-md-3">
                    <label class="small-screen">Type</label>
                    <?= select('id_type_anglais[]', $type_list); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible hidden row" id="duplicate2">
            <div class="form-group col-md-2">
                <label class="small-screen">ID</label>
                <?= inputReadonly('id_anglais[]'); ?>
            </div>
            <div class="form-group col-md-6">
                <label class="small-screen">Anglais</label>
                <?= input('anglais[]'); ?>
            </div>
            <div class="form-group col-md-3">
                <label class="small-screen">Type</label>
                <?= select('id_type_anglais[]', $type_list); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark wide-screen" id="duplicatebtn2">Ajouter une traduction</a><br/><br/>

        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form><br/><br/>

<?php if (!empty($_POST['kanjis'])): ?>
    <div>
        <h1>Kanji présent(s) :</h1>

        <table class="table table-striped table-size">
            <thead>
            <tr>
                <th>Kanji</th>
                <th>Lignes</th>
                <th>Grade</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_POST['kanjis'] as $kanji) : ?>
                <tr>
                    <td><a href="index.php?p=kanji_edit&id=<?= $kanji['id'] ?>"><?= $kanji['kanji'] ?></a></td>
                    <td><?= $kanji['lignes'] ?></td>
                    <td><?= $kanji['grade'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif ?>

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