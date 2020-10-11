<?php $title = 'Connexion';
ob_start(); ?>
<form action="index.php?p=submitLogin" method="post">
    <div class="form-group">
        <label for="pseudo">Nom d'utilisateur</label>
        <input type='text' class='form-control' id='pseudo' name='pseudo' required>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-outline-dark">Se connecter</button>
    <a href="index.php?p=register" class="btn btn-green">Créer un compte</a>
</form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
