<?php if (isset($_POST['id'])) {
    $title = $_POST ['francais'] . ' - Edition';
} else {
    $title = 'Mon nouveau mot';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer un mot</h1>

    <form action="index.php?p=word_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <div style="display: flex;">
            <div class="col-sm-8">
                <?php if (isset($_GET['id'])): ?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <?= inputReadonly('id'); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="fr">Mot en français</label>
                    <?= input('francais'); ?>
                </div>
                <div class="form-group">
                    <label for="id_type">Catégorie</label>
                    <?= select('id_type', $type_list); ?>
                </div>
            </div>

            <div class="col-sm-4">
                <p>Les groupes associés :</p>
                <?php if (isset($_GET['id'])) :
                    foreach ($groupes as $groupe) : ?>
                        <p>
                            <label>-</label> <?= $groupe['libelle']; ?>
                            <a href="index.php?p=word_groupe&id=<?= $_GET['id']; ?>&id_groupe=<?= $groupe['id']; ?>&bool=0&<?= csrf(); ?>"
                               class="btn btn-danger btn-sm" style="margin: 0; float: right">-</a>
                        </p>
                    <?php endforeach;
                endif; ?>

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="background-color: #00C851 !important;">
                        Ajouter un groupe
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <?php if (isset($_GET['id'])) :
                            foreach ($otherGroupes as $groupe) : ?>
                                <a href="index.php?p=word_groupe&id=<?= $_GET['id']; ?>&id_groupe=<?= $groupe['id']; ?>&bool=1&<?= csrf(); ?>"
                                   class="dropdown-item" type="button"><?= $groupe['libelle']; ?></a>
                            <?php endforeach;
                        else :
                            foreach ($otherGroupes as $groupe) : ?>
                                <a href="index.php?p=word_groupe&id=<?= $_GET['id']; ?>&id_groupe=<?= $groupe['id']; ?>&bool=1&<?= csrf(); ?>"
                                   class="dropdown-item" type="button"><?= $groupe['libelle']; ?></a>
                            <?php endforeach;
                        endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <h3>Traduction :</h3>
        <div style="display: flex">
            <div class="col-6">
                <h5>Japonais :</h5>
                <div style="display: flex">
                    <div class="form-group col-2">
                        <label for="id_jap[]">ID</label>
                    </div>
                    <div class="form-group col-2">
                        <label for="kanji[]">Kanji</label>
                    </div>
                    <div class="form-group col-3">
                        <label for="kana[]">Kana</label>
                    </div>
                    <div class="form-group col-4">
                        <label for="romaji[]">Romaji</label>
                    </div>
                    <div class="form-group col-1">
                        <label for="action">Action</label>
                    </div>
                </div>

                <?php if (isset($_GET['id'])) :
                    $mots = listJaponaisToFrancais($_GET['id']);
                endif;
                if (!empty($mots)):
                    foreach ($mots as $mot):?>
                        <div style="display: flex">
                            <div class="form-group col-2">
                                <input type='text' class='form-control' id='id_jap[]' name='id_jap[]'
                                       value='<?= $mot['id']; ?>' readonly>
                            </div>
                            <div class="form-group col-2">
                                <input type='text' class='form-control' id='kanji[]' name='kanji[]'
                                       value='<?= $mot['kanji']; ?>'>
                            </div>
                            <div class="form-group col-3">
                                <input type='text' class='form-control' id='kana[]' name='kana[]'
                                       value='<?= $mot['kana']; ?>'>
                            </div>
                            <div class="form-group col-4">
                                <input type='text' class='form-control' id='romaji[]' name='romaji[]'
                                       value='<?= $mot['romaji']; ?>'>
                            </div>
                            <div class="form-group col-1">
                                <a class="btn_delete btn-red"
                                   href="index.php?p=japonais_delete_in_francais&id=<?= $_GET['id']; ?>&id_japonais=<?= $mot['id']; ?>">-</a>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <div style="display: flex">
                        <div class="form-group col-2">
                            <?= inputReadonly('id_jap[]'); ?>
                        </div>
                        <div class="form-group col-2">
                            <?= input('kanji[]'); ?>
                        </div>
                        <div class="form-group col-3">
                            <?= input('kana[]'); ?>
                        </div>
                        <div class="form-group col-4">
                            <?= input('romaji[]'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="invisible" style="display: flex" id="duplicate">
                    <div class="form-group col-2">
                        <?= inputReadonly('id_jap[]'); ?>
                    </div>
                    <div class="form-group col-2">
                        <?= input('kanji[]'); ?>
                    </div>
                    <div class="form-group col-3">
                        <?= input('kana[]'); ?>
                    </div>
                    <div class="form-group col-4">
                        <?= input('romaji[]'); ?>
                    </div>
                </div>
                <a class="small btn btn-outline-dark" id="duplicatebtn">Ajouter une traduction</a>
            </div>

            <div class="col-6">
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
                    $mots = listAnglaisToFrancais($_GET['id']);
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
                                   href="index.php?p=anglais_delete_in_francais&id=<?= $_GET['id']; ?>&id_anglais=<?= $mot['id']; ?>">-</a>
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

                <a class="small btn btn-outline-dark" id="duplicatebtn2">Ajouter en anglais</a>
            </div>
        </div>
        <br/>

        <?= csrfInput(); ?>
        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form>

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