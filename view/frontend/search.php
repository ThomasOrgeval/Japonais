<?php $title = $_POST['word']['francais'];
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" style="width: 100%" id="autocomplete" name="mot" placeholder="Recherche" autocomplete="off">
        <div id="search" class="search" style="width: 100%"></div>
    </form>
    <br/><br/>
    <h1><?= $_POST['word']['francais'] ?></h1>
    <br/><br/>
    <h3>Traductions possibles :</h3>
<?php foreach ($_POST['japonais'] as $japonais): ?>
    <h4><?= $_POST['word']['francais'] ?> en kanji : <?= $japonais['kanji'] ?></h4>
    <h4><?= $_POST['word']['francais'] ?> en kana : <?= $japonais['kana'] ?></h4>
    <h4><?= $_POST['word']['francais'] ?> en romaji : <?= $japonais['romaji'] ?></h4>
<?php endforeach;

if (!empty($_POST['groupes'])) :
    foreach ($_POST['groupes'] as $groupe) : ?>
        <a class="btn" href="index.php?p=groupe_search&id=<?= $groupe['id']; ?>"><?= $groupe['libelle']; ?></a>
    <?php endforeach;
else: ?>
    <p><?= $_POST['word']['francais']; ?> ne fait parti d'aucun groupe</p>
<?php endif;
$content = ob_get_clean();
require('./view/template/template.php'); ?>