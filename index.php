<?php

mb_internal_encoding("UTF-8");
require './controller/frontend.php';

try {
    if (isset($_GET['p'])) {
        switch ($_GET['p']) {
            case 'accueil':
                accueil();
                break;
            case 'signIn':
                submitLogin($_POST['mail'], $_POST['pass']);
                break;
            case 'signUp':
                submitRegister($_POST['pseudo'], $_POST['pass'], $_POST['mail']);
                break;
            case 'logout':
                logout();
                break;
            case 'groupe':
                groupe();
                break;
            case 'groupe_edit':
                groupe_edit();
                break;
            case 'groupe_add':
                groupe_add();
                break;
            case 'groupe_delete':
                groupe_delete();
                break;
            case 'listes':
                listes();
                break;
            case 'liste_edit':
                liste_edit();
                break;
            case 'liste_delete':
                liste_delete();
                break;
            case 'liste_add':
                liste_add();
                break;
            case 'account':
                account();
                break;
            case 'admin_portail':
                admin_portail();
                break;
            case 'type':
                type();
                break;
            case 'type_edit':
                type_edit();
                break;
            case 'type_add':
                type_add();
                break;
            case 'type_delete':
                type_delete();
                break;
            case 'japonais':
                japonais();
                break;
            case 'japonais_edit':
                japonais_edit();
                break;
            case 'japonais_add':
                japonais_add();
                break;
            case 'kanjis':
                kanjis();
                break;
            case 'kanji_edit':
                kanji_edit();
                break;
            case 'kanji_save':
                kanji_save();
                break;
            case 'points':
                points();
                break;
            case 'recompense':
                recompense();
                break;
            case 'recompense_edit':
                recompense_edit();
                break;
            case 'recompense_add':
                recompense_add();
                break;
            case 'recompense_delete':
                recompense_delete();
                break;
            case 'achat':
                achat();
                break;
            case 'forget_pass':
                forget_password();
                break;
            case 'send_code':
                send_code();
                break;
            case 'change_pass':
                change_pass();
                break;
            case 'theme':
                theme();
                break;
            case 'select_theme':
                select_theme();
                break;
            case 'select_back':
                select_back();
                break;
            case 'change_icon':
                change_icon();
                break;
            case 'save_account':
                save_account();
                break;
            case 'search':
                search();
                break;
            case 'groupe_search':
                groupe_page();
                break;
            case 'liste':
                liste();
                break;
            case 'changelog':
                changelog();
                break;
            case 'statistiques':
                statistiques();
                break;
            case 'kanji':
                kanji();
                break;
            case 'contact':
                contact();
                break;
            case 'kana':
                kana();
                break;
            case 'history':
                history();
                break;
            case 'courses':
                courses();
                break;
            case 'number':
                number();
                break;
            case 'music':
                music();
                break;
            case 'music_edit':
                music_edit();
                break;
            case 'music_add':
                music_add();
                break;
            case 'musique_delete':
                music_delete();
                break;
            case 'musics':
                musics();
                break;
            case 'music_show':
                music_show();
                break;
        }
    } else header('Location:accueil');
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/error.php';
}