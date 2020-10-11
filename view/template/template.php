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

    <link rel="stylesheet" href="./resources/css/style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script defer src="../../resources/js/all.js"></script>
</head>

<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark " id="navbar-top">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto">
            <li><a class="nav-item nav-link" href="index.php?p=accueil">Accueil</a></li>
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] == 'OK'): ?>
                <li><a class="nav-item nav-link" href="index.php?p=listes">Mes listes</a></li>
                <?php if ($_SESSION['admin'] == 1): ?>
                    <li><a class="nav-item nav-link" href="index.php?p=admin_portail">Administration</a></li>
                <?php endif;
            endif; ?>
        </ul>
        <div class="navbar-nav">
            <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] == 'OK'): ?>
                <label class="navbar" style="color: rgba(255,255,255,.5);">Bienvenue, &thinsp;
                    <a class="nav-item nav-ling" href="index.php?p=account"
                       style="color: rgba(255,255,255);"><?= $_SESSION['pseudo']; ?></a>
                </label>
                <a class="nav-item nav-link" href="index.php?p=logout">Déconnexion</a>
            <?php else: ?>
                <a class="nav-item nav-link" href="index.php?p=login">Connexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<script>
    function showResult(str) {
        if (str.length === 0) {
            document.getElementById("search").innerHTML = "";
            document.getElementById("search").style.border = "0px";
            return;
        }
        var xmlhttp;
        if (window.XMLHttpRequest || window.ActiveXObject) {
            if (window.ActiveXObject) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
            } else {
                xmlhttp = new XMLHttpRequest();
            }
        } else {
            xmlhttp = new XMLHttpRequest();
        }

        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("search").innerHTML = this.responseText;
                document.getElementById("search").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "index.php?p=search&search=" + str, true);
        xmlhttp.send();
    }
</script>
<div class="container">
    <?= flash() ?>
    <p>
        <?php if ($_SERVER['HTTP_HOST'] == 'localhost') {
            echo '<h2>Session</h2>';
            var_dump($_SESSION);
            var_dump($_POST);
        } ?>
    </p>
    <?= $content ?>
</div>
</body>
</html>