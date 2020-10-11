<?php

session_start();
require_once './controller/libs/form.php';
require './controller/libs/session.php';
require './controller/libs/csrf.php';

require './controller/backend.php';
require './model/frontend.php';
/*require_once './model/class/GroupeManager.php';
require_once './model/class/WordManager.php';
require_once './model/class/WordGroupeManager.php';*/

/**
 * Chargement de pages
 */

function accueil()
{
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
        foreach ($confidential as $value ) {
            $confidential_list[$value['id']] = $value['confidentiality'];
        }

        if (isset($_GET['id'])) {
            $liste = selectListe($_GET['id']);
            if ($liste->rowCount() == 0) {
                setFlash('Vous n\'avez pas accès à cette liste', 'danger');
                header('Location:index.php?p=listes');
            }
            $_POST = $liste->fetch();
            if ($_POST['id_user'] != $_SESSION['id']) {
                setFlash('Vous n\'avez pas accès à cette liste', 'danger');
                header('Location:index.php?p=listes');
            }
        }
        require './view/frontend/liste_edit.php';
    }
}

function connect()
{
    if ($_SESSION['connect'] != 'OK') {
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
            $_SESSION['connect'] = 'OK';
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
    } else {
        setFlash('La liste a bien été supprimée');
        header('Location:index.php?p=listes');
    }
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
    } else {
        setFlash('La liste a bien été crée');
        header('Location:index.php?p=listes');
    }
}

/**
 * Formulaire de recherche
 */

function search($search)
{
    $search = securize($search);
    $xmlDoc=new DOMDocument();
    $xmlDoc->load("links.xml");
    $x=$xmlDoc->getElementsByTagName('link');

    if (strlen($search)>0) {
        $hint="";
        for($i=0; $i<($x->length); $i++) {
            $y=$x->item($i)->getElementsByTagName('title');
            $z=$x->item($i)->getElementsByTagName('url');
            if ($y->item(0)->nodeType==1) {
                //find a link matching the search text
                if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$search)) {
                    if ($hint=="") {
                        $hint="<a class='search-a' href='" .
                            $z->item(0)->childNodes->item(0)->nodeValue .
                            "'>" .
                            $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                    } else {
                        $hint=$hint . "<br /><a class='search-a' href='" .
                            $z->item(0)->childNodes->item(0)->nodeValue .
                            "'>" .
                            $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                    }
                }
            }
        }
    }

    if ($hint=="") {
        $response="no suggestion";
    } else {
        $response=$hint;
    }

    echo $response;
}

function search2($type, $search)
{
    $type = securize($type);
    $search = securize($search);


}

function search3($search)
{
    $search = securize($search);
    $_POST['words'] = listSearchWord($search);
    $_POST['groupes'] = listSearchGroupe($search);
    $_POST['listes'] = listSearchListe($search);

    require './view/frontend/search/3.php';
}