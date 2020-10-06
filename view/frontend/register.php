<?php $title = 'Mon blog';
ob_start(); ?>
<form action="index.php?p=submitRegister" method="post">
    <div class="form-group">
        <label for="pseudo">Nom d'utilisateur</label>
        <?= input('pseudo') ?>
    </div>
    <div class="form-group">
        <label for="mail">Adresse email</label>
        <?= input('mail') ?>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-outline-dark">Créer son compte</button>
</form>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
