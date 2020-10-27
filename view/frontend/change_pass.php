<?php $title = 'Récupération de compte';
ob_start(); ?>
    <div>
        <p>Nouveau mot de passe pour <?= $_SESSION['recup_mail'] ?></p>
        <form action="index.php?p=change_pass" method="post">
            <i class="fas fa-lock prefix grey-text"></i>
            <input id="password" type="password" data-parsley-minlength="8" class="form-control eq-ui-input" name="password"
                   required>
            <label for="password" data-error="Le mot de passe doit faire 8 caractères au minimum">Mot de
                passe</label><br/>

            <i class="fas fa-lock prefix grey-text"></i>
            <input id="password-confirm" type="password" data-parsley-minlength="8" data-parsley-equalto="#password"
                   class="form-control eq-ui-input" required>
            <label for="password-confirm" data-error="Ce ne sont pas les mêmes mot de passe">Confirmation mot de
                passe</label>
            <button type="submit" class="btn btn-purple">Valider</button>
        </form>
    </div>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>