<?php $title = 'Edition - groupe';
ob_start(); ?>
<h1 class="h1-admin">Editer un groupe</h1>

<form action="index.php?p=groupe_add<?php if (isset($_GET['id'])) {echo '&id=' . $_GET['id'];} ?>" method="post">
    <div class="form-group">
        <label for="libelle">Nom du groupe</label>
        <?= input('libelle'); ?>
    </div>

    <?= csrfInput(); ?>
    <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
</form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
