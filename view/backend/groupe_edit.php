<?php $title = isset($_POST['id']) ? $_POST['libelle'] . ' - Edition' : 'Mon nouveau groupe';
ob_start(); ?>

    <h1 class="h1-admin">Editer un groupe</h1>

    <form action="index.php?p=groupe_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <?php if (isset($_GET['id'])): ?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <?= inputReadonly('id'); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="libelle">Nom du groupe</label>
                    <?= input('libelle'); ?>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Liste des mots :</h5>
                <?php foreach ($_POST['mots'] as $mot) : ?>
                    <span>- <?= $mot['francais'] ?></span><br/>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-dark" name="save">Enregistrer</button>
    </form>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>