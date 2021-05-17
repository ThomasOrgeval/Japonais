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
    <meta name="description"
          content="Lexique japonais permet de s’exercer chaque jour, se lancer des défis, défier des amis, le tout dans la langue de ごく (Goku) ! Lexique japonais contient tout ce que vous recherchez sur la langue japonaise.">
    <title><?= $title ?? 'Lexique Japonais' ?></title>
    <link rel="shortcut icon" type="image" href="resources/images/sakura.webp">

    <meta property="og:title" content="Lexique Japonais">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://lexiquejaponais.fr">
    <meta property="og:image" content="https://lexiquejaponais.fr/resources/images/sakura.webp">
    <meta property="og:description"
          content="Lexique japonais permet de s’exercer chaque jour, se lancer des défis, défier des amis, le tout dans la langue de ごく (Goku) ! Lexique japonais contient tout ce que vous recherchez sur la langue japonaise.">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" href="resources/css/style.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php if (isset($_SESSION['Account']['theme']) && $_SESSION['Account']['theme'] != '0') : ?>
        <link rel="stylesheet" href="resources/css/theme/<?= $_SESSION['Account']['theme'] ?>.css">
    <?php endif; ?>
</head>

<body style="
<?php if (isset($_POST['background'])) :
    if ($_POST['background'] != '0' || empty($_POST['background'])) : ?>
            background-image: url('./resources/background/<?= $_POST['background'] ?>.png');
    <?php endif;
elseif (isset($_SESSION['Account']['background']) && ($_SESSION['Account']['background'] != '0' || !empty($_SESSION['Account']['background']))) : ?>
        background-image: url('./resources/background/<?= $_SESSION['Account']['background'] ?>.png');
<?php endif; ?>"
>
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand me-0" href="">
            <img src="resources/images/sakura.webp" height="22" alt="logo" style="margin-top: -3px">
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbar1"
                aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active"><a class="nav-link" aria-current="page" href="">Accueil</a></li>
                <?php if (isset($_SESSION['Account'])) : ?>
                    <li class="nav-item active"><a class="nav-link" href="listes">Mes listes</a></li>
                    <li class="nav-item active"><a class="nav-link" href="theme">Mes thèmes</a></li>
                    <li class="nav-item active"><a class="nav-link" href="historique">Historique</a></li>
                    <?php if ($_SESSION['Account']['admin'] == 1): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php?p=admin_portail">Administration</a>
                        </li>
                    <?php endif;
                endif; ?>
                <li class="nav-item active"><a class="nav-link" href="cours">Cours</a></li>
            </ul>

            <ul class="navbar-nav d-flex">
                <?php if (isset($_SESSION['Account'])) : ?>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link pb-0" href="points">
                            <span id="points" class="align-middle"><?= $_SESSION['Account']['points'] ?></span>
                            <img id="sakura-svg" class="svg" src="resources/svgs/sakura.svg" alt="sakura">
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link text-white" href="compte">
                            <span><?= $_SESSION['Account']['pseudo'] ?></span>
                            <img class="icon" src="resources/icons/<?= $_SESSION['Account']['icone'] ?>.png"
                                 alt="icone">
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="index.php?p=logout">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item me-3 me-lg-0 ">
                        <a class="nav-link" data-mdb-toggle="modal" data-mdb-target="#connect"
                           role="button">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="connect" tabindex="-1" aria-labelledby="connect" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-4">
                <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="mdb-tab-login" data-mdb-toggle="pill" href="#pills-login"
                           role="tab" aria-controls="pills-login" aria-selected="true">Connexion</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="mdb-tab-register" data-mdb-toggle="pill" href="#pills-register"
                           role="tab" aria-controls="pills-register" aria-selected="false">Créer mon compte</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="pills-login" role="tabpanel"
                         aria-labelledby="mdb-tab-login">
                        <form method="post" action="index.php?p=signIn">

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="loginMail" name="mail"
                                       class="form-control" required>
                                <label class="form-label" for="loginMail">Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="loginPassword" name="pass"
                                       class="form-control" required>
                                <label class="form-label" for="loginPassword">Password</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Connexion</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="mdb-tab-register">
                        <form method="post" action="index.php?p=signUp">

                            <!-- Pseudo input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="registerPseudo" name="pseudo"
                                       class="form-control" required>
                                <label class="form-label" for="registerPseudo">Pseudo</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="registerEmail" name="mail"
                                       class="form-control" required>
                                <label class="form-label" for="registerEmail">Adresse mail</label>
                            </div>
                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="registerPassword" name="pass" autocomplete="new-password"
                                       class="form-control" minlength="8" required>
                                <label class="form-label" for="registerPassword">Password (8 caractères au
                                    minimum)</label>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-1">Connexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--div class="modal fade" id="modalForgetPasswordForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
</div-->

<div id="content" class="container">
    <?= flash() ?>
    <?= $content ?>
</div>
<br/><br/>
</body>

<!-- Footer -->
<footer class="page-footer pt-4">
    <!-- Grid container -->
    <div class="container-fluid text-center text-md-start">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Description</h5>
                <p>Lexique japonais est un site qui permet de retrouver des mots traduits du français ou de l'anglais
                    vers le japonais. Ce site est également un projet universitaire de L3 MIAGE. Toujours en
                    développement !</p>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Statistiques :</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="stats">Statistiques</a>
                    </li>
                </ul>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-0">Pages annexes :</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="changelog">Changelog</a>
                    </li>
                    <li>
                        <a href="contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020-21 Copyright:
        <a href=""> lexiquejaponais.fr.</a>
        All Rights Reserved.
        <a href="https://discord.gg/Mksrg3hDuv" target="_blank" style="margin-left: 8px">
            <i class="fab fa-discord"></i>
        </a>
        <a href="https://www.instagram.com/lexiquejaponais/" target="_blank" style="margin-left: 8px">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous" defer></script>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"
        defer></script>
<!-- JQuerry validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" defer></script>
<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js" defer></script>

<script src="resources/js/main.js" defer></script>
</html>