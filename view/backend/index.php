<?php $title = 'Administration';
ob_start(); ?>
<h1 class="h1-admin">Mon administration</h1>
<p>&nbsp;</p>
<div class="row-cols-1 display">
    <p>Les éditions</p>
    <a class="btn btn-outline-dark" href="index.php?p=word">En français</a>
    <a class="btn btn-outline-dark" href="index.php?p=japonais">En japonais</a>
    <a class="btn btn-outline-dark" href="index.php?p=groupe">Les groupes</a>
    <a class="btn btn-outline-dark" href="index.php?p=type">Les types</a>
</div><br/><br/>
<div>
    <p>Les commandes</p>
    <a class="btn btn-grey" href="index.php?p=exportxml">Export XML</a>
</div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
