<?php

session_start();
require_once './controller/form.php';
require './controller/session.php';
require './controller/csrf.php';

require './model/frontend.php';
/*require_once './model/GroupeManager.php';
require_once './model/WordManager.php';
require_once './model/WordGroupeManager.php';*/

/**
 * Chargement de pages
 */

function accueil()
{
    $groupes = listGroupe();
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

function groupe()
{
    if (connect_admin()) {
        $groupes = listGroupe();
        require './view/frontend/groupe.php';
    }
}

function groupe_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $groupe = testGroupe($_GET['id']);
            if ($groupe->rowCount() == 0) {
                setFlash('Il n\'y a pas de groupe avec cet ID', 'danger');
                header('Location: index.php?p=groupe');
            }
            $_POST = $groupe->fetch();
        }
        require 'view/frontend/groupe_edit.php';
    }
}

function word()
{
    if (connect_admin()) {
        $words = listWords();
        require './view/frontend/word.php';
    }
}

function word_edit()
{
    if (connect_admin()) {
        // Ajout de tous les types de mots
        $types = listType();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $word = testWord($_GET['id']);
            $groupes = listGroupeToWord();
            $otherGroupes = otherGroupeToWord();
            if ($word->rowCount() == 0) {
                setFlash("Il n'y a pas de mot avec cet ID", "danger");
                header("Location:index.php?p=word");
            }
            $_POST = $word->fetch();
        }
        require './view/frontend/word_edit.php';
    }
}

function connect_admin()
{
    if ($_SESSION['connect'] != 'OK' || $_SESSION['admin'] == 0) {
        header('Location:index.php?p=accueil');
        return false;
    }
    return true;
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
 * Groupe
 * @throws Exception
 */

function addGroupe($libelle, $id)
{
    if ($id > 0) {
        $addGroupe = editGroupe($id, $libelle);
    } else {
        $addGroupe = createGroupe($libelle);
    }

    if ($addGroupe === false) {
        setFlash("Le groupe n'a pas été ajouté", 'danger');
        throw new Exception();
    } else {
        setFlash('Le groupe a bien été ajouté');
        header('Location:index.php?p=groupe');
    }
}

function deleteGroupe($id)
{
    deleteAllGroupeForGroupe($id);
    $deleteGroupe = supprGroupe($id);
    if ($deleteGroupe === false) {
        setFlash('Le groupe n\'a pas été supprimé', 'danger');
        throw new Exception();
    } else {
        setFlash('Le groupe a bien été supprimé');
        header('Location:index.php?p=groupe');
    }
}

/**
 * Word
 */

function addWord($fr, $kana, $kanji, $romaji, $id, $id_type)
{
    if ($id > 0) {
        $addWord = editWord($fr, $kana, $kanji, $romaji, $id, $id_type);
    } else {
        $addWord = createWord($fr, $kana, $kanji, $romaji, $id_type);
    }

    if ($addWord === false) {
        setFlash('Le mot n\'a pas été ajouté', 'danger');
        throw new Exception();
    } else {
        setFlash('Le mot a bien été crée');
        header('Location:index.php?p=word');
    }
}

function deleteWord($id)
{
    deleteAllGroupeForWord($id);
    $deleteWord = supprWord($id);
    if ($deleteWord === false) {
        setFlash('Le mot n\'a pas été supprimé', 'danger');
        throw new Exception();
    } else {
        setFlash('Le mot a bien été supprimé');
        header('Location:index.php?p=word');
    }
}

function otherGroupeToWord()
{
    $listePresent = listGroupeToWord();
    $listAll = listGroupe();
    $listOther = $listAll;
    foreach ($listePresent as $present) {
        foreach ($listAll as $item) {
            if ($present == $item) {
                unset($listOther[array_search($present, $listOther)]);
            }
        }
    }
    return $listOther;
}

function wordGroupe($id_groupe, $id, $bool)
{
    if ($bool == 1) {
        $wordGroupe = addGroupeToWord($id_groupe, $id);
    } else {
        $wordGroupe = deleteGroupeToWord($id_groupe, $id);
    }

    if ($wordGroupe === false) {
        throw new Exception();
    } else {
        header('Location:index.php?p=word_edit&id=' . $id);
    }
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
            $password = password_hash($password, PASSWORD_DEFAULT);
            createUser($pseudo, $password, $mail);
            submitLogin($pseudo, $password);
        }
    }
}