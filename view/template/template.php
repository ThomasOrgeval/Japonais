<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"/>
    <title><?= $title ?></title>

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
    <link rel="stylesheet" href="./resources/css/bootstrap.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="./resources/css/mdb.css">
    <!-- MDB Datatable -->
    <link href="./resources/css/addons/datatables2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./resources/css/style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script defer src="../../resources/js/all.js"></script>
    <script src="./resources/js/addons/datatables2.min.js"></script>
    <script src="./resources/js/main.js"></script>
</head>

<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark " id="navbar-top">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto">
            <li><a class="nav-item nav-link" href="index.php?p=accueil">Accueil</a></li>
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] === 'OK'): ?>
                <li><a class="nav-item nav-link" href="index.php?p=listes">Mes listes</a></li>
                <?php if ($_SESSION['admin'] == 1): ?>
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
                    <?php if ($_SESSION['admin'] == 1): ?>
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
                        <input type="email" id="defaultForm-email" class="form-control validate" name="mail">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Votre adresse mail</label>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="password" id="defaultForm-pass" class="form-control validate" name="password">
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Votre mot de passe</label>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-purple">S'identifier</button>
                    <a class="btn btn-outline-purple" href="index.php?p=register">Créer un compte</a>
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
            var_dump($_POST);
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