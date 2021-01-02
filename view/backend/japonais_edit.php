<?php $title = isset($_POST['id']) ? $title = $_POST['kanji'] . ' - Edition' : 'Mon nouveau mot';
ob_start(); ?>

    <h1 class="h1-admin">Editer un mot japonais</h1>

    <form action="index.php?p=japonais_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post" autocomplete="off">
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
        <div class="form-group">
            <label for="description">Description</label>
            <?= textarea('description'); ?>
        </div>
        <div class="form-group">
            <label for="id_type">Type de mot</label>
            <?= select('id_type', $_POST['type']); ?>
        </div>

        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" id="groupe" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">Les groupes</a>
            <div class="dropdown-menu" aria-labelledby="groupe">
                <?php if (!empty($_POST['groupes'])) :
                    foreach ($_POST['groupes'] as $group) : ?>
                        <div id="grp-<?= $group['id'] ?>" class="dropdown-item"
                             onclick="addGroup('<?= $group['id'] ?>')">
                            <div class="flexible">
                                <?= $group['libelle'] ?>
                                <img id="check" class="svg" src="./resources/svgs/check.svg"
                                     alt="<?= $group['libelle'] ?>">
                                <input type="hidden" value="1" name="groupe[<?= $group['id'] ?>]">
                            </div>
                        </div>
                    <?php endforeach;
                endif;
                foreach ($_POST['otherGroupes'] as $group) : ?>
                    <div id="grp-<?= $group['id'] ?>" class="dropdown-item"
                         onclick="addGroup('<?= $group['id'] ?>')">
                        <div class="flexible">
                            <?= $group['libelle'] ?>
                            <img id="uncheck" class="svg" src="./resources/svgs/uncheck.svg"
                                 alt="<?= $group['libelle'] ?>">
                            <input type="hidden" value="0" name="groupe[<?= $group['id'] ?>]">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <br/>
        <hr class="black">

        <h3 class="font-weight-bold">Traduction :</h3><br/>
        <h5 class="font-weight-bold">Français :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-md-2">ID</div>
            <div class="form-group col-md-10">Traduction française</div>
        </div>

        <?php if (isset($_GET['id'])) $mots = listFrancaisToJaponais($_GET['id']);
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div id="fr_<?= $mot['id'] ?>" class="row">
                    <div class="form-group col-md-2">
                        <label class="small-screen" for="id_francais<?= $mot['id'] ?>">ID</label>
                        <input type="text" class="form-control bg-danger" id="id_francais<?= $mot['id'] ?>"
                               name="id_francais[]" style="cursor: pointer; color: white"
                               value="<?= $mot['id']; ?>" readonly onclick="remove('fr', '<?= $mot['id'] ?>')">
                    </div>
                    <div class="form-group col-md-10">
                        <label class="small-screen" for="francais<?= $mot['id'] ?>">Traduction française</label>
                        <input type="text" class="form-control" id="francais<?= $mot['id'] ?>" name="francais[]"
                               value="<?= $mot['francais']; ?>">
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="small-screen">ID</label>
                    <?= inputReadonly('id_francais[]'); ?>
                </div>
                <div class="form-group col-md-10">
                    <label class="small-screen">Français</label>
                    <?= input('francais[]'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible hidden row" id="duplicate1">
            <div class="form-group col-md-2">
                <label class="small-screen">ID</label>
                <?= inputReadonly('id_francais[]'); ?>
            </div>
            <div class="form-group col-md-10">
                <label class="small-screen">Français</label>
                <?= input('francais[]'); ?>
            </div>
        </div>

        <a class="small btn btn-outline-dark" id="duplicatebtn1">Ajouter une traduction</a><br/><br/>

        <h5 class="font-weight-bold">Anglais :</h5>
        <hr>
        <div class="flexible wide-screen">
            <div class="form-group col-md-2">ID</div>
            <div class="form-group col-md-10">Traduction anglaise</div>
        </div>

        <?php if (isset($_GET['id'])) $mots = listAnglaisToJaponais($_GET['id']);
        if (!empty($mots)):
            foreach ($mots as $mot): ?>
                <div id="en_<?= $mot['id'] ?>" class="row">
                    <div class="form-group col-md-2" onclick="remove('en', '<?= $mot['id'] ?>')">
                        <label class="small-screen" for="id_anglais<?= $mot['id'] ?>">ID</label>
                        <input type='text' class='form-control bg-danger' id='id_anglais<?= $mot['id'] ?>'
                               name='id_anglais[]' style="cursor: pointer; color: white"
                               value="<?= $mot['id']; ?>" readonly>
                    </div>
                    <div class="form-group col-md-10">
                        <label class="small-screen" for="anglais<?= $mot['id'] ?>">Anglais</label>
                        <input type='text' class='form-control' id='anglais<?= $mot['id'] ?>' name='anglais[]'
                               value="<?= $mot['anglais']; ?>">
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="small-screen">ID</label>
                    <?= inputReadonly('id_anglais[]'); ?>
                </div>
                <div class="form-group col-md-10">
                    <label class="small-screen">Anglais</label>
                    <?= input('anglais[]'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="invisible hidden row" id="duplicate2">
            <div class="form-group col-md-2">
                <label class="small-screen">ID</label>
                <?= inputReadonly('id_anglais[]'); ?>
            </div>
            <div class="form-group col-md-10">
                <label class="small-screen">Anglais</label>
                <?= input('anglais[]'); ?>
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

        function addGroup(id_group) {
            if ($('#grp-' + id_group + ' > div > input').val() == 0) {
                $('#grp-' + id_group + ' > div > svg').attr('id', 'check');
                $('#grp-' + id_group + ' > div > svg > path').attr('d', 'M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z');
                $('#grp-' + id_group + ' > div > input').val(1);
            } else {
                $('#grp-' + id_group + ' > div > svg').attr('id', 'uncheck');
                $('#grp-' + id_group + ' > div > svg > path').attr('d', 'M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z');
                $('#grp-' + id_group + ' > div > input').val(0);
            }
        }

        function remove(lang, id) {
            $.post(
                'ajax/deleteInJapan.php',
                {
                    lang: lang,
                    id: id
                },
                function (data) {
                    if (data === 'success') {
                        $('#' + lang + '_' + id).remove();
                    } else if(data === 'fail') {
                        console.log('Accès non autorisé');
                    } else {
                        console.log(data);
                    }
                },
                'html'
            );
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>