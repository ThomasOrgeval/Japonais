<?php $title = 'Accueil';
ob_start(); ?>
    <div id="groupe">
        <?php foreach ($groupes as $groupe): ?>
            <p><?= $groupe['libelle']; ?></p>
        <?php endforeach; ?>
        <a class="nav-item nav-link" href="index.php?p=word">Mots</a>
        <a class="nav-item nav-link" href="index.php?p=groupe">Groupes</a>
    </div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>