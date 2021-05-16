<?php $title = isset($_POST['id']) ? $title = $_POST['kanji'] . ' - Edition' : 'Mon nouveau mot';
ob_start(); ?>

    <h1 class="h1-admin mb-5">Editer un mot japonais</h1>

    <form action="index.php?p=japonais_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post" autocomplete="off" class="mb-4">
        <?php if (isset($_GET['id'])): ?>
            <div class="form-outline mb-4">
                <?= inputReadonly('id'); ?>
                <label class="form-label" for="id">ID</label>
            </div>
        <?php endif; ?>
        <div class="form-outline mb-4">
            <?= input('kanji'); ?>
            <label class="form-label" for="kanji">Mot en kanji</label>
        </div>
        <div class="form-outline mb-4">
            <?= input('kana'); ?>
            <label class="form-label" for="kana">Mot en kana</label>
        </div>
        <div class="form-outline mb-4">
            <?= input('romaji'); ?>
            <label class="form-label" for="romaji">Mot en romaji</label>
        </div>
        <div class="form-outline mb-4">
            <?= textarea('description'); ?>
            <label class="form-label" for="description">Description</label>
        </div>
        <hr class="my-5">
        <div class="mb-4">
            <?= select('id_type', $_POST['type'], 'Type de mot'); ?>
        </div>
        <div class="mb-4">
            <?= select('jlpt', $_POST['jlptValues'], 'Niveau JLPT'); ?>
        </div>
        <hr class="my-5">
        <div class="dropdown">
            <button class="btn btn-primary btn-block btn-lg dropdown-toggle" id="groupe" type="button"
                    data-mdb-toggle="dropdown" aria-expanded="false" data-mdb-dropdown-animation="off">
                Les groupes
            </button>
            <div class="dropdown-menu" aria-labelledby="groupe">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                    <?php if (!empty($_POST['groupes'])) :
                        foreach ($_POST['groupes'] as $group) : ?>
                            <div id="grp-<?= $group['id'] ?>"
                                 onclick="addGroup('<?= $group['id'] ?>')">
                                <div class="d-flex justify-content-between dropdown-item">
                                    <?= $group['libelle'] ?>
                                    <img id="check" class="svg" src="./resources/svgs/check.svg"
                                         alt="<?= $group['libelle'] ?>">
                                    <input type="hidden" value="1" name="groupe[<?= $group['id'] ?>]">
                                </div>
                            </div>
                        <?php endforeach;
                    endif;
                    foreach ($_POST['otherGroupes'] as $group) : ?>
                        <div id="grp-<?= $group['id'] ?>"
                             onclick="addGroup('<?= $group['id'] ?>')">
                            <div class="d-flex justify-content-between dropdown-item">
                                <?= $group['libelle'] ?>
                                <img id="uncheck" class="svg" src="./resources/svgs/uncheck.svg"
                                     alt="<?= $group['libelle'] ?>">
                                <input type="hidden" value="0" name="groupe[<?= $group['id'] ?>]">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <br/>
        <hr class="my-4">

        <h3 class="font-weight-bold mb-4">Traduction :</h3>

        <h6 class="heading-small text-muted mb-4">Français</h6>
        <hr class="my-4">
        <div class="mx-4">
            <?php if (isset($_GET['id'])) $mots = listFrancaisToJaponais($_GET['id']);
            if (!empty($mots)):
                foreach ($mots as $mot): ?>
                    <div id="fr_<?= $mot['id'] ?>" class="row">
                        <div class="col-md-2">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control bg-danger clickable"
                                       id="id_francais<?= $mot['id'] ?>" name="id_francais[]" readonly
                                       value="<?= $mot['id']; ?>" onclick="remove('fr', '<?= $mot['id'] ?>')">
                                <label class="form-label" for="id_francais<?= $mot['id'] ?>">ID</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" name="francais[]"
                                       id="francais<?= $mot['id'] ?>" value="<?= $mot['francais'] ?>">
                                <label class="form-label" for="francais<?= $mot['id'] ?>">Français</label>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-outline mb-4">
                            <?= inputReadonly('id_francais[]'); ?>
                            <label class="form-label">ID</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-outline mb-4">
                            <?= input('francais[]'); ?>
                            <label class="form-label">Français</label>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-none row" id="duplicate1">
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <?= inputReadonly('id_francais[]'); ?>
                        <label class="form-label">ID</label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-outline mb-4">
                        <?= input('francais[]'); ?>
                        <label class="form-label">Français</label>
                    </div>
                </div>
            </div>

            <a class="btn btn-block btn-sm btn-outline-secondary mb-4" id="duplicatebtn1">Ajouter une traduction</a>
        </div>

        <h6 class="heading-small text-muted mb-4">Anglais</h6>
        <hr class="my-4">
        <div class="mx-4">
            <?php if (isset($_GET['id'])) $mots = listAnglaisToJaponais($_GET['id']);
            if (!empty($mots)):
                foreach ($mots as $mot): ?>
                    <div id="en_<?= $mot['id'] ?>" class="row">
                        <div class="col-md-2">
                            <div class="form-outline mb-4" onclick="remove('en', '<?= $mot['id'] ?>')">
                                <input type='text' class='form-control bg-danger clickable'
                                       id='id_anglais<?= $mot['id'] ?>' name='id_anglais[]'
                                       value="<?= $mot['id']; ?>" readonly>
                                <label class="form-label" for="id_anglais<?= $mot['id'] ?>">ID</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-outline mb-4">
                                <input type='text' class='form-control' id='anglais<?= $mot['id'] ?>'
                                       name='anglais[]' value="<?= $mot['anglais']; ?>">
                                <label class="form-label" for="anglais<?= $mot['id'] ?>">Anglais</label>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-outline mb-4">
                            <?= inputReadonly('id_anglais[]'); ?>
                            <label class="form-label">ID</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-outline mb-4">
                            <?= input('anglais[]'); ?>
                            <label class="form-label">Anglais</label>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-none row" id="duplicate2">
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <?= inputReadonly('id_anglais[]'); ?>
                        <label class="form-label">ID</label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-outline mb-4">
                        <?= input('anglais[]'); ?>
                        <label class="form-label">Anglais</label>
                    </div>
                </div>
            </div>

            <a class="btn btn-block btn-sm btn-outline-secondary mb-4" id="duplicatebtn2">Ajouter une traduction</a>
        </div>

        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form>

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
        $('#duplicatebtn1').click(function (e) {
            e.preventDefault();
            $('#duplicate1').before($('#duplicate1').clone().attr('id', '').removeClass('d-none'));
        });

        $('#duplicatebtn2').click(function (e) {
            e.preventDefault();
            $('#duplicate2').before($('#duplicate2').clone().attr('id', '').removeClass('d-none'));
        });

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
                    if (data === 'success') $('#' + lang + '_' + id).remove();
                    else if (data === 'fail') console.log('Accès non autorisé');
                    else console.log(data);
                },
                'html'
            );
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>