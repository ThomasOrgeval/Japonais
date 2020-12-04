<?php $title = $_POST['groupe']['libelle'];
ob_start(); ?>

    <input type="text" style="width: 100%" id="autocomplete" name="mot" placeholder="Recherche" autocomplete="off">
    <div id="search" class="search" style="width: 100%"></div><br/><br/>

    <h1><?= $_POST['groupe']['libelle'] ?> :</h1>
    <br/>
<?php if (!empty($_POST['words'])): ?>
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
                <td><a href="index.php?p=search&mot=<?= $word['francais'] ?>&type=<?= $word['id_type'] ?>"><?= $word['francais'] ?></a></td>
                <td><?= $word['kanji'] ?></td>
                <td class="hidden"><?= $word['kana'] ?></td>
                <td><?= $word['romaji'] ?></td>
                <td class="hidden"><?= $word['id_type'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>