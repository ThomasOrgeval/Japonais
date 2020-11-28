<?php $title = 'Statistiques';
ob_start(); ?>

<?php var_dump($_POST) ?>

    <div class="row">
        <div class="col-sm">
            <h4 class="font-weight-bold">Utilisateurs :
                <span class="font-weight-normal"><?= $_POST['stats']['users'] ?></span>
            </h4>
        </div>
        <div class="col-sm">
            <h4 class="font-weight-bold">Mots :
                <span class="font-weight-normal"><?= $_POST['stats']['japonais'] ?></span>
            </h4>
        </div>
        <div class="col-sm">
            <h4 class="font-weight-bold">Sakuras :
                <span class="font-weight-normal"><?= $_POST['stats']['sakuras'] ?></span>
                <img id="sakura-stats" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
            </h4>
        </div>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>