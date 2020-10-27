<?php $title = 'Récupération de compte';
ob_start(); ?>
    <div>
        <p>Code de récupération pour <?= $_SESSION['recup_mail'] ?></p>
        <form action="index.php?p=send_code" method="post">
            <i class="fas fa-code prefix grey-text"></i>
            <input type="text" id="code" class="form-control validate" name="code" required>
            <label data-error="wrong" data-success="right" for="code">Code de récupération</label>
            <button type="submit" class="btn btn-purple">Valider</button>
        </form>
    </div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>