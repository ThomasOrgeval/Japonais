<?php $title = 'Résultat de la recherche';
ob_start(); ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>