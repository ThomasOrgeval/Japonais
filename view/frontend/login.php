<?php $title = 'Connexion';
ob_start(); ?>
<form class="text-center" action="index.php?p=submitLogin" method="post">
    <img src="./resources/svgs/sakura_login.svg" style="width: 140px">
    <div class="form-group">
        <i class="fa fa-user"></i>
        <label for="pseudo">Nom d'utilisateur</label>
        <input type='text' class='form-control' id='pseudo' name='pseudo' required>
    </div>
    <div class="form-group">
        <i class="fa fa-lock"></i>
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <a href="#"">Mot de passe oublié ?</a>
    </div>

    <button type="submit" class="btn btn-outline-dark">Se connecter</button>
    <p>Toujours pas membre ?
        <a href="index.php?p=register">Créer un compte</a>
    </p>
</form>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
