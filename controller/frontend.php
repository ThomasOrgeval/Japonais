<?php

session_start();
mb_internal_encoding("UTF-8");
require_once './controller/libs/form.php';
require './controller/libs/session.php';

require './controller/backend.php';
require './model/frontend.php';

/**
 * Chargement de pages
 */

function accueil()
{
    if (isset($_COOKIE['pseudo'], $_COOKIE['pass']) && !isset($_SESSION['pseudo'])) {
        submitLogin($_COOKIE['pseudo'], $_COOKIE['pass']);
    }
    if (isset($_SESSION['nombreWords']) && !empty($_SESSION['nombreWords'])) {
        $_POST['words'] = listRandomWords($_SESSION['nombreWords']);
    } else {
        $_POST['words'] = listRandomWords(10);
    }
    require './view/frontend/index.php';
}

function login()
{
    require './view/frontend/login.php';
}

function register()
{
    require './view/frontend/register.php';
}

function logout()
{
    session_destroy();
    setcookie('pseudo');
    setcookie('pass');
    header('Location:index.php?p=accueil');
}

function account()
{
    if (connect()) {
        require './view/frontend/account.php';
    }
}

function listes()
{
    if (connect()) {
        $listes = listListes($_SESSION['id']);
        require './view/frontend/liste.php';
    }
}

function liste_edit()
{
    if (connect()) {
        $confidential = listConfidentiality();
        $confidential_list = array();
        foreach ($confidential as $value) {
            $confidential_list[$value['id']] = $value['confidentiality'];
        }

        if (isset($_GET['id'])) {
            $liste = selectListe($_GET['id']);
            if ($liste->rowCount() === 0) {
                setFlash('Vous n\'avez pas accès à cette liste', 'danger');
                header('Location:index.php?p=listes');
            }
            $_POST = $liste->fetch();
            if ($_POST['id_user'] !== $_SESSION['id']) {
                setFlash('Vous n\'avez pas accès à cette liste', 'danger');
                header('Location:index.php?p=listes');
            }
        }
        require './view/frontend/liste_edit.php';
    }
}

function points()
{
    if (connect()) {
        $_POST['recompenses'] = listRecompense();
        $_POST['achats'] = listAchatByAccount($_SESSION['id']);
        foreach ($_POST['recompenses'] as $recompense) {
            foreach ($_POST['achats'] as $achat) {
                if ($recompense['libelle'] === $achat['libelle']) {
                    unset($_POST['recompenses'][array_search($recompense, $_POST['recompenses'], true)]);
                }
            }
        }
        require './view/frontend/points.php';
    }
}

function achat()
{
    if (connect()) {
        if (achatByUser($_SESSION['id'], $_GET['id_recompense']) === false) {
            $points = pointsUser($_SESSION['id']);
            if ($points['points'] >= $_GET['cout']) {
                achatdb($_SESSION['id'], $_GET['id_recompense']);
                depense($_SESSION['id'], $points['points'] - $_GET['cout']);
                $_SESSION['points'] = pointsUser($_SESSION['id'])['points'];
                setFlash('Vous avez bien ajouté ce lot !');
            } else {
                setFlash('Vous n\'avez pas assez de points :(', 'danger');
            }
        }
        header('Location:index.php?p=points');
    }
}

function connect()
{
    if ($_SESSION['connect'] !== 'OK') {
        header('Location:index.php?p=accueil');
        return false;
    }
    return true;
}

/**
 * Login
 */

function submitLogin($pseudo, $password)
{
    if (!empty($pseudo) && !empty($password)) {
        $statements = loginUser($pseudo, $password);
        if ($statements == true) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['admin'] = $statements['droits'];
            $_SESSION['id'] = $statements['id'];
            $_SESSION['nombreWords'] = $statements['nombre'];
            $_SESSION['points'] = $statements['points'];
            $_SESSION['connect'] = 'OK';
            setcookie('pseudo', $pseudo, time() + 365 * 24 * 3600);
            setcookie('pass', $password, time() + 365 * 24 * 3600);
            setFlash('Connexion réussie');
            header('Location:index.php?p=accueil');
        } else {
            setFlash('Mot de passe ou identifiant incorrect', 'danger');
            header('Location:index.php?p=login');
        }
    } else {
        setFlash('Un champ est vide', 'danger');
        header('Location:index.php?p=login');
    }
}

function submitRegister($pseudo, $password, $mail)
{
    $pseudo = securize($pseudo);
    $password = securize($password);
    $mail = securize($mail);

    if (!empty($pseudo) && !empty($password) && !empty($mail)) {
        $correctMail = searchMail($mail);
        $correctPseudo = searchPseudo($pseudo);
        if ($correctMail) {
            setFlash('L\'adresse mail est déjà utilisée', 'danger');
            header('Location:index.php?p=register');
        } elseif ($correctPseudo) {
            setFlash('Le pseudo est déjà utilisé', 'danger');
            header('Location:index.php?p=register');
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            createUser($pseudo, $password_hash, $mail);
            submitLogin($pseudo, $password);
        }
    }
}

/**
 * Liste
 */

function deleteListe($id)
{
    $deleteListe = supprListe($id);
    if ($deleteListe === false) {
        setFlash('La liste n\'a pas été supprimée', 'danger');
        throw new Exception();
    }

    setFlash('La liste a bien été supprimée');
    header('Location:index.php?p=listes');
}

function addListe($nom, $desc, $id_confidentiality, $id)
{
    $nom = securize($nom);
    $desc = securize($desc);

    if ($id > 0) {
        $addListe = editListe($nom, $desc, $id_confidentiality, $id, $_SESSION['id']);
    } else {
        $addListe = createListe($nom, $desc, $id_confidentiality, $_SESSION['id']);
    }

    if ($addListe === false) {
        setFlash('La liste n\'a pas été ajoutée', 'danger');
        throw new Exception();
    }

    setFlash('La liste a bien été crée');
    header('Location:index.php?p=listes');
}

/**
 * Formulaire de recherche
 */

function search($search)
{
    $search = securize($search);
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("links.xml");
    $x = $xmlDoc->getElementsByTagName('link');

    if ($search !== '') {
        $hint = "";
        for ($i = 0; $i < ($x->length); $i++) {
            $y = $x->item($i)->getElementsByTagName('title');
            $z = $x->item($i)->getElementsByTagName('url');
            if ($y->item(0)->nodeType === 1) {
                //find a link matching the search text
                if (stripos($y->item(0)->childNodes->item(0)->nodeValue, $search) !== false) {
                    if ($hint == "") {
                        $hint = "<a class='search-a' style='display: block;' href='" .
                            $z->item(0)->childNodes->item(0)->nodeValue .
                            "'>" .
                            $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                    } else {
                        $hint .= "<br /><a class='search-a' style='display: block;' href='" . $z->item(0)->childNodes->item(0)->nodeValue . "'>" . $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                    }
                }
            }
        }
    }

    if ($hint === "") {
        $response = "no suggestion";
    } else {
        $response = $hint;
    }

    echo $response;
}

function searchByItem($type, $search)
{
    $type = securize($type);
    $search = securize($search);

    if ($type === 'word') {
        $_POST['word'] = researchWord($search);
        $_POST['groupes'] = listGroupeToWord($_POST['word']['id']);
        $_POST['japonais'] = listJaponaisToFrancais($_POST['word']['id']);
        require './view/frontend/search/byItemWord.php';
    } elseif ($type === 'groupe') {
        $_POST['groupe'] = researchGroupe($search);
        $_POST['words'] = listFrancaisAndJaponaisWhereGroupe($_POST['groupe']['id']);
        require './view/frontend/search/byItemGroupe.php';
    }
}

function searchByTape($search)
{
    $search = securize($search);
    $_POST['words'] = listSearchWord($search);
    $_POST['groupes'] = listSearchGroupe($search);
    $_POST['listes'] = listSearchListe($search);

    require './view/frontend/search/byTape.php';
}