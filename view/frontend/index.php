<?php $title = 'Mon blog';
ob_start(); ?>
    <div id="groupe">
        <?php foreach ($groupes as $groupe): ?>
            <p><?= $groupe['libelle']; ?></p>
        <?php endforeach; ?>
    </div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>