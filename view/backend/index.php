<?php $title = 'Administration';
ob_start(); ?>
<h1 class="h1-admin">Mon administration :</h1>
<p>&nbsp;</p>
<div class="row-cols-1 display">
    <h3>Les éditions :</h3>
    <a class="btn btn-outline-dark" href="index.php?p=word">En français</a>
    <a class="btn btn-outline-dark" href="index.php?p=japonais">En japonais</a>
    <a class="btn btn-outline-dark" href="index.php?p=anglais">En anglais</a><br/>
    <a class="btn btn-outline-dark" href="index.php?p=groupe">Les groupes</a>
    <a class="btn btn-outline-dark" href="index.php?p=type">Les types</a>
    <a class="btn btn-outline-dark" href="index.php?p=kanjis">Les kanjis</a>
    <a class="btn btn-outline-dark" href="index.php?p=recompense">Les récompenses</a>
</div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
