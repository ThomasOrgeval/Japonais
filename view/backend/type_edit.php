<?php if (isset($_POST['id'])) {
    $title = $_POST['type'] . ' - Edition';
} else {
    $title = 'Mon nouveau type';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer un type</h1>

    <form action="index.php?p=type_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <div class="form-group">
            <label for="type">Type</label>
            <?= input('type'); ?>
        </div>

        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>