<?php $title = 'Mon blog';
ob_start(); ?>
<form action="index.php?p=submitLogin" method="post">
    <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <?= input('username') ?>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-outline-dark">Se connecter</button>
    <a href="index.php?p=register" class="btn btn-green">Créer un compte</a>
</form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
