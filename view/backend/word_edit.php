<?php if (isset($_POST['id'])) {
    $title = $_POST['fr'] . ' - Edition';
} else {
    $title = 'Mon nouveau mot';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer un mot</h1>

    <form action="index.php?p=word_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post" style="display: flex;">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="fr">Mot en français</label>
                <?= input('fr'); ?>
            </div>
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
                <label for="id_type">Catégorie</label>
                <?= select('id_type', $type_list); ?>
            </div>

            <?= csrfInput(); ?>
            <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
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
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>