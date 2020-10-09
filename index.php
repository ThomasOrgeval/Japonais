<?php

require './controller/frontend.php';

try {
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
        if ($p === 'accueil') {
            accueil();
        } elseif ($p === 'groupe') {
            groupe();
        } elseif ($p === 'groupe_edit') {
            groupe_edit();
        } elseif ($p === 'groupe_add') {
            if (isset($_POST['save'])) {
                addGroupe($_POST['libelle'], $_GET['id']);
            }
        } elseif ($p === 'groupe_delete') {
            deleteGroupe($_GET['id']);
        } elseif ($p === 'word') {
            word();
        } elseif ($p === 'word_edit') {
            word_edit();
        } elseif ($p === 'word_add') {
            if (isset($_POST['save'])) {
                addWord($_POST['fr'], $_POST['kana'], $_POST['kanji'], $_POST['romaji'], $_GET['id'], $_POST['id_type']);
            }
        } elseif ($p === 'word_delete') {
            deleteWord($_GET['id']);
        } elseif ($p === 'word_groupe') {
            wordGroupe($_GET['id_groupe'], $_GET['id'], $_GET['bool']);
        } elseif ($p === 'login') {
            login();
        } elseif ($p === 'register') {
            register();
        } elseif ($p === 'logout') {
            logout();
        } elseif ($p === 'submitLogin') {
            submitLogin($_POST['pseudo'], $_POST['password']);
        } elseif ($p === 'submitRegister') {
            submitRegister($_POST['pseudo'], $_POST['password'], $_POST['mail']);
        } elseif ($p === 'listes') {
            listes();
        } elseif ($p === 'liste_edit') {
            liste_edit();
        } elseif ($p === 'liste_delete') {
            deleteListe($_GET['id']);
        } elseif ($p === 'liste_add') {
            if (isset($_POST['save'])) {
                addListe($_POST['nom'], $_POST['description'], $_POST['id_confidentiality'], $_GET['id']);
            }
        } elseif ($p === 'account') {
            account();
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/error.php';
}