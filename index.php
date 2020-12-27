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
        } elseif ($p === 'logout') {
            logout();
        } elseif ($p === 'submitLogin') {
            submitLogin($_POST['mail'], $_POST['password']);
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
        } elseif ($p === 'admin_portail') {
            admin_portail();
        } elseif ($p === 'type') {
            type();
        } elseif ($p === 'type_edit') {
            type_edit();
        } elseif ($p === 'type_add') {
            addType();
        } elseif ($p === 'type_delete') {
            deleteType($_GET['id']);
        } elseif ($p === 'japonais') {
            japonais();
        } elseif ($p === 'japonais_edit') {
            japonais_edit();
        } elseif ($p === 'japonais_add') {
            japonais_add();
        } elseif ($p === 'kanjis') {
            kanjis();
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
        } elseif ($p === 'forget_password') {
            forget_password();
        } elseif ($p === 'send_code') {
            recup_code();
        } elseif ($p === 'change_pass') {
            change_pass();
        } elseif ($p === 'theme') {
            theme();
        } elseif ($p === 'select_theme') {
            select_theme();
        } elseif ($p === 'change_icon') {
            change_icon();
        } elseif ($p === 'save_account') {
            save_account();
        } elseif ($p === 'search') {
            search();
        } elseif ($p === 'groupe_search') {
            groupe_page();
        } elseif ($p === 'liste') {
            liste();
        } elseif ($p === 'changelog') {
            changelog();
        } elseif ($p === 'statistiques') {
            statistiques();
        } elseif ($p === 'kanji') {
            kanji();
        } elseif ($p === 'contact') {
            contact();
        } elseif ($p === 'kana') {
            kana();
        } elseif ($p === 'history') {
            history();
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/error.php';
}