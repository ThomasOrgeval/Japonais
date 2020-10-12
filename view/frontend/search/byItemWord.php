<?php $title = $_POST['word']['fr'];
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" name="search" style="width: 100%" onkeyup="showResult(this.value)">
        <div id="search" class="search" style="width: 100%"></div>
    </form>
    <br/><br/>
    <h1><?= $_POST['word']['fr'] ?></h1>
<?php if (isset($_POST['word']['kanji'])): ?>
    <h3><?= $_POST['word']['fr'] ?> en kanji : <?= $_POST['word']['kanji'] ?></h3>
<?php endif;
if (isset($_POST['word']['kana'])): ?>
    <h3><?= $_POST['word']['fr'] ?> en kana : <?= $_POST['word']['kana'] ?></h3>
<?php endif;
if (isset($_POST['word']['romaji'])): ?>
    <h3><?= $_POST['word']['fr'] ?> en romaji : <?= $_POST['word']['romaji'] ?></h3>
<?php endif;

if (!empty($_POST['groupes'])):
    foreach ($_POST['groupes'] as $groupe): ?>
        <a class="btn" href="index.php?p=search&t=groupe&q=<?= $groupe['libelle']; ?>"><?= $groupe['libelle']; ?></a>
    <?php endforeach;
else: ?>
    <p><?= $_POST['word']['fr']; ?> ne fait parti d'aucun groupe</p>
<?php endif;
$content = ob_get_clean();
require('./view/template/template.php'); ?>