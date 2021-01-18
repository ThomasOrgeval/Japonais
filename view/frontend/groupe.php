<?php $title = $_POST['groupe']['libelle'];
ob_start(); ?>

    <label for="autocomplete"></label>
    <input type="text" style="width: 100%" id="autocomplete" name="mot" placeholder="Recherche" autocomplete="off">
    <div id="search" class="search" style="width: 100%"></div><br/><br/>

    <h1><?= $_POST['groupe']['libelle'] ?>
        <?php if (isset($_POST['groupe']['quantifieur']) && strlen($_POST['groupe']['quantifieur']) != 0) : ?>
            <span class="h5">- <?= $_POST['groupe']['quantifieur'] ?></span>
        <?php endif; ?>
        :</h1>
    <br/>
<?php if (isset($_POST['parent']) && $_POST['parent']) : ?>
    <p>
        <span>Voici le groupe parent de <?= $_POST['groupe']['libelle'] ?> :</span>
        <a href="groupe/<?= $_POST['parent']['slug'] ?>"><?= $_POST['parent']['libelle'] ?></a>
    </p>
<?php endif;
if (!empty($_POST['words'])) : ?>
    <p>Liste des mots composant le groupe :</p>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
            <th class="hidden">Type du mot</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['words'] as $word): ?>
            <tr>
                <td>
                    <a href="recherche/<?= $word['slug'] ?>"><?= $word['francais'] ?></a>
                </td>
                <td><?= $word['kanji'] ?></td>
                <td class="hidden"><?= $word['kana'] ?></td>
                <td><?= $word['romaji'] ?></td>
                <td class="hidden"><?= $word['id_type'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_POST['enfant'])) :
    foreach ($_POST['enfant'] as $enfant) :?>
        <p>
            <span>Voici un groupe enfant de <?= $_POST['groupe']['libelle'] ?> :</span>
            <a href="groupe/<?= $enfant['slug'] ?>"><?= $enfant['libelle'] ?></a>
            <span> dont voici le contenu</span>
        </p>
        <table class="table table-striped table-size">
            <thead>
            <tr>
                <th>Français</th>
                <th>Kanji</th>
                <th class="hidden">Kana</th>
                <th>Romaji</th>
                <th class="hidden">Type du mot</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($enfant['words'] as $word) : ?>
                <tr>
                    <td>
                        <a href="recherche/<?= $word['slug'] ?>"><?= $word['francais'] ?></a>
                    </td>
                    <td><?= $word['kanji'] ?></td>
                    <td class="hidden"><?= $word['kana'] ?></td>
                    <td><?= $word['romaji'] ?></td>
                    <td class="hidden"><?= $word['id_type'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach;
endif;
if (count($_POST['words']) >= 5) : ?>
    <br/><br/>
    <div class="card text-center">
        <div class="card-body" id="card">
            <a class="btn btn-primary" onclick="riddleGroup('<?= $_POST['groupe']['libelle'] ?>')">
                Lancer une session d'énigmes
            </a>
        </div>
    </div>

    <div id="snackbar"></div>
<?php endif;
$content = ob_get_clean();
require('./view/template/template.php'); ?>