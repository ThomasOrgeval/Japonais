<?php $title = 'Résultat de la recherche';
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" name="search" style="width: 100%" onkeyup="showResult(this.value)">
        <div id="search" class="search" style="width: 100%" ></div>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>