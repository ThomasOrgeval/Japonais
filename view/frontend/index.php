<?php $title = 'Mon blog';
ob_start(); ?>
    <div id="groupe">
        <?php foreach ($groupes as $groupe): ?>
            <p><?= $groupe['libelle']; ?></p>
        <?php endforeach; ?>
        <?= $_SESSION['admin']?>
        <a class="nav-item nav-link" href="index.php?p=word">Mots</a>
        <a class="nav-item nav-link" href="index.php?p=groupe">Groupes</a>
    </div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>