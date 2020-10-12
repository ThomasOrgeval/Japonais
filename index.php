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
            francais_add();
            /*var_dump($_POST, $_GET);
            if (!isset($_POST['id_jap']) || !empty($_POST['id_jap'])) {
                addWord($_GET['id'], $_POST['francais'], $_POST['id_type'], $_POST['id_jap'], $_POST['kanji'], $_POST['kana'], $_POST['romaji']);
            } else {
                addWord($_GET['id'], $_POST['francais'], $_POST['id_type'], 0, $_POST['kanji'], $_POST['kana'], $_POST['romaji']);
            }*/
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
        } elseif ($p === 'search') {
            if (isset($_POST['search'])) {
                searchByTape($_POST['search']);
            } elseif (isset($_GET['t']) && isset($_GET['q'])) {
                searchByItem($_GET['t'], $_GET['q']);
            } else {
                search($_GET['search']);
            }
        } elseif ($p === 'exportxml') {
            exportxml();
        } elseif ($p === 'admin_portail') {
            admin_portail();
        } elseif ($p === 'type') {
            type();
        } elseif ($p === 'type_edit') {
            type_edit();
        } elseif ($p === 'type_add') {
            addType($_GET['id'], $_POST['type']);
        } elseif ($p === 'type_delete') {
            deleteType($_GET['id']);
        } elseif ($p === 'japonais') {
            japonais();
        } elseif ($p === 'japonais_edit') {
            japonais_edit();
        } elseif ($p === 'japonais_add') {
            japonais_add();
        } elseif ($p === 'japonais_delete') {
            deleteJaponais($_GET['id']);
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/error.php';
}