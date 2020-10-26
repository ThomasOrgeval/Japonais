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
        } elseif ($p === 'word_delete') {
            deleteFrancais($_GET['id']);
        } elseif ($p === 'word_groupe') {
            wordGroupe($_GET['id_groupe'], $_GET['id'], $_GET['bool']);
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
        } elseif ($p === 'francais_delete_in_japonais') {
            deleteFrancaisInJaponais($_GET['id_francais'], $_GET['id']);
        } elseif ($p === 'anglais_delete_in_japonais') {
            deleteAnglaisInJaponais($_GET['id_anglais'], $_GET['id']);
        } elseif ($p === 'japonais_delete_in_francais') {
            deleteJaponaisInFrancais($_GET['id_japonais'], $_GET['id']);
        } elseif ($p === 'anglais_delete_in_francais') {
            deleteAnglaisInFrancais($_GET['id_anglais'], $_GET['id']);
        } elseif ($p === 'anglais') {
            anglais();
        } elseif ($p === 'anglais_edit') {
            anglais_edit();
        } elseif ($p === 'anglais_add') {
            anglais_add();
        } elseif ($p === 'anglais_delete') {
            deleteAnglais($_GET['id']);
        } elseif ($p === 'francais_delete_in_anglais') {
            deleteFrancaisInAnglais($_GET['id_francais'], $_GET['id']);
        } elseif ($p === 'japonais_delete_in_anglais') {
            deleteJaponaisInAnglais($_GET['id_japonais'], $_GET['id']);
        } elseif ($p === 'kanji') {
            kanji();
        } elseif ($p === 'kanji_edit') {
            kanji_edit();
        } elseif ($p === 'kanji_save') {
            saveKanji();
        } elseif ($p === 'points') {
            points();
        } elseif ($p === 'recompense') {
            recompense();
        } elseif ($p === 'recompense_edit') {
            recompense_edit();
        } elseif ($p === 'recompense_add') {
            addRecompense();
        } elseif ($p === 'recompense_delete') {
            deleteRecompense($_GET['id']);
        } elseif ($p === 'achat') {
            achat();
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/error.php';
}