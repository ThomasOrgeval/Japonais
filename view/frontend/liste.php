<?php $title = $_POST['liste']['nom'];
ob_start(); ?>

    <h1 class="h1-admin"><?= $_POST['liste']['nom'] ?> :</h1>
<?php var_dump($_POST) ?>
    <p><?= nl2br($_POST['liste']['description']) ?></p>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>