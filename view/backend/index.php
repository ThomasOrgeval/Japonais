<?php $title = 'Administration';
ob_start(); ?>
<h1 class="h1-admin">Mon administration :</h1>
<p>&nbsp;</p>
<div class="row-cols-1 display">
    <h3>Les éditions :</h3>
    <a class="btn btn-outline-dark" href="mots">En japonais</a><br/>
    <a class="btn btn-outline-dark" href="groupe_admin">Les groupes</a>
    <a class="btn btn-outline-dark" href="type">Les types</a>
    <a class="btn btn-outline-dark" href="kanjis">Les kanjis</a>
    <a class="btn btn-outline-dark" href="reward">Les récompenses</a>
</div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
