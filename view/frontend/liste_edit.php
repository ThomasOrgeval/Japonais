<?php if (isset($_POST['id'])) {
    $title = $_POST['nom'] . ' - Edition';
} else {
    $title = 'Ma nouvelle liste';
}
ob_start(); ?>
    <h1 class="h1-admin">Editer une liste</h1>

    <form action="index.php?p=liste_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post" style="display: flex;">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="nom">Nom de la liste</label>
                <?= inputRequired('nom'); ?>
            </div>
            <div class="form-group">
                <label for="description">Description de la liste</label>
                <?= textarea('description'); ?>
            </div>
            <div class="form-group">
                <label for="id_confidentiality">Confidentialité de la liste</label>
                <?= select('id_confidentiality', $confidential_list); ?>
            </div>

            <?= csrfInput(); ?>
            <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
        </div>
    </form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>