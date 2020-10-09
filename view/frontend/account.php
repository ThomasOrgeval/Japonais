<?php $title = 'Mon compte';
ob_start(); ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>