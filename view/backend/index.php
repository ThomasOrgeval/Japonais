<?php $title = 'Administration';
ob_start(); ?>

<h1 class="my-4">Mon administration :</h1>
<div class="row row-cols-1 row-cols-md-3 row-cols-xl-4">
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=japonais">En japonais</a>
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=groupe">Les groupes</a>
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=type">Les types</a>
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=kanjis">Les kanjis</a>
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=recompense">Les récompenses</a>
    <a class="btn btn-lg btn-outline-dark" href="index.php?p=music">Les musiques</a>
</div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
