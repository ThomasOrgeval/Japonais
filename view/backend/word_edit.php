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

        <div>
            <h3>Traduction :</h3>
            <?php if (isset($_GET['id'])) :
                $mots = listJaponaisToFrancais($_GET['id']);
            endif;
            if (!empty($mots)):
                $k = 1;
                foreach ($mots as $mot):?>
                    <div style="display: flex">
                        <div class="form-group col-1">
                            <label for="id_jap">ID</label>
                            <input type='text' class='form-control' id='id_jap<?= $k; ?>' name='id_jap<?= $k; ?>'
                                   value='<?= $mot['id']; ?>' readonly>
                        </div>
                        <div class="form-group col-3">
                            <label for="kanji">Mot en kanji</label>
                            <input type='text' class='form-control' id='kanji<?= $k; ?>' name='kanji<?= $k; ?>'
                                   value='<?= $mot['kanji']; ?>'>
                        </div>
                        <div class="form-group col-3">
                            <label for="kana">Mot en kana</label>
                            <input type='text' class='form-control' id='kana<?= $k; ?>' name='kana<?= $k; ?>'
                                   value='<?= $mot['kana']; ?>'>
                        </div>
                        <div class="form-group col-4">
                            <label for="romaji">Mot en romaji</label>
                            <input type='text' class='form-control' id='romaji<?= $k; ?>' name='romaji<?= $k; ?>'
                                   value='<?= $mot['romaji']; ?>'>
                        </div>
                    </div>
                    <?php $k = $k + 1;
                endforeach; ?>
                <input class="invisible" name="nombre" value="<?= $k - 1; ?>">
            <?php else: ?>
                <div style="display: flex">
                    <div class="form-group col-1">
                        <label for="id_jap1">ID</label>
                        <?= inputReadonly('id_jap1'); ?>
                    </div>
                    <div class="form-group col-3">
                        <label for="kanji1">Mot en kanji</label>
                        <?= input('kanji1'); ?>
                    </div>
                    <div class="form-group col-3">
                        <label for="kana1">Mot en kana</label>
                        <?= input('kana1'); ?>
                    </div>
                    <div class="form-group col-4">
                        <label for="romaji1">Mot en romaji</label>
                        <?= input('romaji1'); ?>
                    </div>
                </div>
                <input class="invisible" name="nombre" value="1">
            <?php endif; ?>
            <br/>

            <?= csrfInput(); ?>
            <a type="submit" class="small btn btn-green">Ajouter une traduction</a>
            <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
        </div>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>