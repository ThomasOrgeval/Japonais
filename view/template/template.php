<!DOCTYPE html>
<html lang="fr">
<head>
    <?php if ($_SERVER['HTTP_HOST'] === 'localhost') : ?>
        <base href="/japonais/">
    <?php else :
        define('BASE_URL', 'https://lexiquejaponais.fr/'); ?>
        <base href="<?= BASE_URL ?>">
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"/>
    <title><?= $title ?></title>
    <link rel="shortcut icon" type="image" href="./resources/svgs/sakura_login.svg">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Google Icons Material -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="./resources/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="./resources/css/mdb.min.css">
    <!-- MDB Datatable -->
    <link href="./resources/css/addons/datatables2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./resources/css/style.css">

    <!-- jQuery -->
    <script type="text/javascript" src="./resources/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="./resources/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="./resources/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="./resources/js/mdb.min.js"></script>
    <script src="./resources/js/all.js"></script>
    <script src="./resources/js/addons/datatables2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>

    <script src="./resources/js/main.js"></script>

    <?php if (isset($_SESSION['theme']) && $_SESSION['theme'] != '0') : ?>
        <link rel="stylesheet" href="./resources/css/theme/<?= $_SESSION['theme'] ?>.css">
    <?php endif; ?>
</head>

<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark " id="navbar-top">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="accueil">Accueil</a>
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                <a class="nav-item nav-link" href="listes">Mes listes</a>
                <a class="nav-item nav-link" href="theme">Mes thèmes</a>
                <a class="nav-item nav-link" href="historique">Historique</a>
                <?php if ($_SESSION['admin'] == 1): ?>
                    <a class="nav-item nav-link" href="index.php?p=admin_portail">Administration</a>
                <?php endif;
            endif; ?>
            <a class="nav-item nav-link" href="cours">Cours</a>
        </ul>
        <div class="navbar-nav">
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                <a class="nav-item nav-link" href="points" style="padding-bottom: 0;">
                    <span id="points" style="vertical-align:middle;"><?= $_SESSION['points'] ?></span>
                    <img id="sakura-svg" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
                </a>
                <a class="nav-item nav-link" href="compte" style="color: white;">Bienvenue,
                    &thinsp; <?= $_SESSION['pseudo'] ?></a>
                <a href="index.php?p=account">
                    <img class="icon" src="./resources/icons/<?= $_SESSION['icone'] ?>.png" alt="icone">
                </a>
                <a class="nav-item nav-link" href="index.php?p=logout">Déconnexion</a>
            <?php else: ?>
                <a href="" class="nav-item nav-link" data-toggle="modal"
                   data-target="#modalLoginForm">Connexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar-top-small">
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <ul class="navbar-nav mr-auto">
                <a class="nav-item nav-link" href="accueil">Accueil</a>
                <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                    <a class="nav-item nav-link" href="listes">Mes listes</a>
                    <a class="nav-item nav-link" href="theme">Mes thèmes</a>
                    <a class="nav-item nav-link" href="historique">Historique</a>
                    <?php if ($_SESSION['admin'] == 1): ?>
                        <a class="nav-item nav-link" href="index.php?p=admin_portail">Administration</a>
                    <?php endif;
                endif; ?>
                <a class="nav-item nav-link" href="cours">Cours</a>
            </ul>
            <div class="navbar-nav">
                <hr style="margin-top: 5px; margin-bottom: 5px">
                <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                    <a class="nav-item nav-link" href="points">
                        <span style="vertical-align:middle;"><?= $_SESSION['points'] ?></span>
                        <img id="sakura-svg" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
                    </a>
                    <a class="nav-item nav-link" href="compte" style="color: white;">Bienvenue,
                        &thinsp; <?= $_SESSION['pseudo'] ?></a>
                    <a class="nav-item nav-link" href="index.php?p=logout">Déconnexion</a>
                <?php else: ?>
                    <a href="" class="nav-item nav-link" data-toggle="modal"
                       data-target="#modalLoginForm">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
</nav>

<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="index.php?p=submitLogin" method="post">
                <div class="modal-header text-center">
                    <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
                    <h4 class="modal-title w-100 font-weight-bold">Connexion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="email" id="login-mail" class="form-control validate" name="mail">
                        <label data-error="wrong" data-success="right" for="login-mail">Votre adresse mail</label>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="password" id="login-pass" class="form-control validate" name="password">
                        <label data-error="wrong" data-success="right" for="login-pass">Votre mot de passe</label>
                    </div>
                    <a href="" style="font-size: 13px" data-toggle="modal" data-target="#modalForgetPasswordForm"
                       data-dismiss="modal">Mot de passe oublié ?</a>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-purple">S'identifier</button>
                    <div class="text-center">
                        <a href="" class="btn btn-outline-purple" data-toggle="modal" data-target="#modalRegisterForm"
                           data-dismiss="modal">Créer un compte</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="index.php?p=submitRegister" method="post">
                <div class="modal-header text-center">
                    <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
                    <h4 class="modal-title w-100 font-weight-bold">Créer votre compte</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-user prefix grey-text"></i>
                        <input type="text" id="register-name" class="form-control validate" name="pseudo">
                        <label data-error="wrong" data-success="right" for="register-name">Votre pseudo</label>
                    </div>
                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="email" id="register-mail" class="form-control validate" name="mail">
                        <label data-error="wrong" data-success="right" for="register-mail">Votre adresse mail</label>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="password" id="register-pass" class="form-control validate" name="password"
                               data-parsley-minlength="8">
                        <label data-error="wrong" data-success="right" for="register-pass">Votre mot de passe</label>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-purple">Créer un compte</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalForgetPasswordForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="index.php?p=forget_password" method="post">
                <div class="modal-header text-center">
                    <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
                    <h4 class="modal-title w-100 font-weight-bold">Récupération de compte</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="email" id="reset-mail" class="form-control validate" name="mail">
                        <label data-error="wrong" data-success="right" for="reset-mail">Votre adresse mail</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-purple">Recevoir un mail</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <?= flash() ?>
    <p>
        <?php if ($_SERVER['HTTP_HOST'] === 'localhost') {
            //var_dump($_COOKIE);
            var_dump($_SESSION);
            //var_dump($_POST);
        } ?>
    </p><br/>
    <div class="content">
        <?= $content ?>
    </div>
</div>
<br/><br/>
</body>
<footer class="page-footer font-small bg-dark pt-4">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
            <div class="col-md-6 mt-md-0 mt-3" style="padding-right: 20px">
                <h5 class="text-uppercase">Description</h5>
                <p>Lexique japonais est un site qui permet de retrouver des mots traduits du français ou de l'anglais
                    vers le japonais. Ce site est également un projet universitaire de L3 MIAGE. Toujours en
                    développement !</p>
            </div>
            <hr class="clearfix w-100 d-md-none pb-3">
            <div class="col-md-3 mb-md-0 mb-3">
                <h5 class="text-uppercase">Statistiques :</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="stats">Statistiques</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 mb-md-0 mb-3">
                <h5 class="text-uppercase">Pages annexes :</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="changelog">Changelog</a>
                    </li>
                    <li>
                        <a href="contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
        <a href="accueil"> lexiquejaponais.fr.</a>
        All Rights Reserved.
        <a href="https://discord.gg/Mksrg3hDuv" target="_blank" style="margin-left: 8px">
            <i class="fab fa-discord"></i>
        </a>
        <a href="https://www.instagram.com/lexiquejaponais/" target="_blank" style="margin-left: 8px">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
</footer>

<script>
    // SVG changer de couleur
    jQuery('img.svg').each(function () {
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function (data) {
            var $svg = jQuery(data).find('svg');
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }
            $svg = $svg.removeAttr('xmlns:a');
            $img.replaceWith($svg);
        }, 'xml');
    });
</script>
</html>