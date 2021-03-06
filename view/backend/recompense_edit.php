<?php $title = isset($_POST['id']) ? $_POST['libelle'] . ' - Edition' : 'Nouvelle récompense';
ob_start(); ?>

    <h1 class="h1-admin">Editer une récompense</h1>

    <form action="index.php?p=recompense_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <?php if (isset($_GET['id'])): ?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <?= inputReadonly('id') ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="libelle">Libellé</label>
                    <?= input('libelle') ?>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <?= input('slug') ?>
                </div>
                <div class="form-group">
                    <label for="cout">Cout</label>
                    <?= inputNumber('cout') ?>
                </div>
                <div class="form-group">
                    <label for="id_type">Type</label>
                    <?= select('id_type', $type_list) ?>
                </div>
            </div>

            <div class="col-md-4">
                <h5>Liste des acheteurs :</h5>
                <?php if (isset($_POST['acheteurs'])) :
                    foreach ($_POST['acheteurs'] as $acheteur) : ?>
                        <span><?= $acheteur['pseudo'] ?></span>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-green" name="save">Enregistrer</button>
    </form>

<?php $content = ob_get_clean();
require('./view/template/template.php');