<?php $title = 'Cours';
ob_start(); ?>

    <h1 class="font-weight-bold">Les cours</h1><br/>

    <div class="row-cols-md-4">
        <a class="btn btn-outline-dark" href="index.php?p=number">Nombres</a>
        <a class="btn btn-outline-dark" href="index.php?p=kana">Kana</a>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php');