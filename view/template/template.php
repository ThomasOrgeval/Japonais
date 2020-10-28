<!DOCTYPE html>
<html lang="fr">
<head>
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
    <script src="../../resources/js/all.js"></script>
    <script src="./resources/js/addons/datatables2.min.js"></script>
    <script src="./resources/js/main.js"></script>

    <?php if (isset($_COOKIE['theme']) && $_COOKIE['theme'] !== 0) : ?>
        <link rel="stylesheet" href="./resources/css/theme/<?= $_COOKIE['theme'] ?>.css">
    <?php endif; ?>
</head>

<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark " id="navbar-top">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto">
            <li><a class="nav-item nav-link" href="index.php?p=accueil">Accueil</a></li>
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                <li><a class="nav-item nav-link" href="index.php?p=listes">Mes listes</a></li>
                <?php if (isset($_SESSION['Themes']) && !empty($_SESSION['Themes'])) : ?>
                    <li><a class="nav-item nav-link" href="index.php?p=theme">Mes thèmes</a></li>
                <?php endif;
                if ($_SESSION['admin'] == 1): ?>
                    <li><a class="nav-item nav-link" href="index.php?p=admin_portail">Administration</a></li>
                <?php endif;
            endif; ?>
        </ul>
        <div class="navbar-nav">
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                <a class="nav-item nav-link" href="index.php?p=points"><?= $_SESSION['points'] ?>
                    <img id="sakura-svg" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
                </a>
                <a class="nav-item nav-link" href="index.php?p=account" style="color: white;">Bienvenue,
                    &thinsp; <?= $_SESSION['pseudo'] ?></a>
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
                <li><a class="nav-item nav-link" href="index.php?p=accueil">Accueil</a></li>
                <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                    <li><a class="nav-item nav-link" href="index.php?p=listes">Mes listes</a></li>
                    <?php if (isset($_SESSION['Themes']) && !empty($_SESSION['Themes'])) : ?>
                        <li><a class="nav-item nav-link" href="index.php?p=theme">Mes thèmes</a></li>
                    <?php endif;
                    if ($_SESSION['admin'] == 1): ?>
                        <li><a class="nav-item nav-link" href="index.php?p=admin_portail">Administration</a></li>
                    <?php endif;
                endif; ?>
            </ul>
            <div class="navbar-nav">
                <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                    <a class="nav-item nav-link" href="index.php?p=points"><?= $_SESSION['points'] ?>
                        <img id="sakura-svg" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
                    </a>
                    <a class="nav-item nav-link" href="index.php?p=account" style="color: white;">Bienvenue,
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
            var_dump($_COOKIE);
            var_dump($_SESSION);
            //var_dump($_POST);
        } ?>
    </p><br/>
    <div class="content">
        <?= $content ?>
    </div>
</div>
<script>
    // Datatables
    $(document).ready(function () {
        $('#db').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

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
</body>
<footer>

</footer>
</html>