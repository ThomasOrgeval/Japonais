<?php

session_start();
require __DIR__ . '/libs/form.php';
require __DIR__ . '/libs/session.php';
require __DIR__ . '/libs/mail.php';
require __DIR__ . '/libs/type.php';

require __DIR__ . '/backend.php';
require __DIR__ . '/courses.php';
require __DIR__ . '/../model/frontend.php';
require __DIR__ . '/../model/template/Database.php';

function accueil()
{
    if (isset($_COOKIE['mail'], $_COOKIE['token']) && !isset($_SESSION['Account']['pseudo'])) {
        $token = new Token();
        if ($token->rowCountToken(secure($_COOKIE['token']), secure($_COOKIE['mail'])) === 1) {
            submitToken();
        } else logout();
    }

    if (isset($_SESSION['Account']['nombreWords']) && !empty($_SESSION['Account']['nombreWords']))
        $_POST['words'] = listRandomWords($_SESSION['Account']['nombreWords']);
    else $_POST['words'] = listRandomWords(10);

    $_POST['groups'] = listRandomGroups(5);

    foreach ($_POST['words'] as $key => $word) {
        // Preparation for furigana
        $kana = preg_split('/(?<!^)(?!$)/u', $word['kana']);
        $replace = preg_split('/(?<!^)(?!$)/u', $word['kanji']);
        $kanjis = find_kanji($word['kanji']);
    }
    require 'view/frontend/index.php';
}

function logout()
{
    $token = new Token();
    $token->unsetToken($_COOKIE['token']);
    session_destroy();
    setcookie('mail');
    setcookie('token');
    setcookie('theme');
    header('Location:accueil');
}

function account()
{
    if (connect()) {
        // Création des 30 derniers jours pour le système de dates
        $today = new DateTime();
        $dates = array();
        for ($i = 0; $i < 30; $i++) {
            $dates[$i]['date'] = $today->format('Y-m-d');
            $today->modify('-1 day');
        }

        if (isset($_GET['user'])) {
            $_POST['user'] = searchUser($_GET['user']);
            if (empty($_POST['user'])) {
                setFlash('Cet utilisateur n\'existe pas', 'danger');
                accueil();
            } else {
                $_POST['sakura'] = getSakura($_POST['user']['id']);
                $_POST['listes'] = searchListeUser($_POST['user']['id']);
                $_POST['chart'] = getSakuraLastMonth($_POST['user']['id']);
                $_POST['background'] = getBackground($_POST['user']['id'])['background'] ?: 0;
            }
        } else {
            $_POST['icones_own'] = listAchatIconByAccount($_SESSION['Account']['id']);
            $_POST['icones'] = getIcons();
            $_POST['listes'] = searchListe($_SESSION['Account']['id']);
            $_POST['sakura'] = getSakura($_SESSION['Account']['id']);
            $_POST['chart'] = getSakuraLastMonth($_SESSION['Account']['id']);
            foreach ($_POST['icones'] as $icone) {
                foreach ($_POST['icones_own'] as $icone_own) {
                    if ($icone['libelle'] === $icone_own['libelle']) {
                        unset($_POST['icones'][array_search($icone, $_POST['icones'], true)]);
                    }
                }
            }
        }

        // Ajout des valeurs des sakuras obtenus chaque jour dans les 30 derniers jours
        foreach ($_POST['chart'] as $chart) {
            $dates[array_search($chart['date'], array_column($dates, 'date'))]['sakura'] = $chart['sakura'];
        }
        foreach ($dates as $key => $date) if (!isset($date['sakura'])) $dates[$key]['sakura'] = 0;
        $_POST['chart'] = array_reverse($dates);
        require './view/frontend/account.php';
    }
}

function change_icon()
{
    if (connect()) {
        if (isset($_GET['id']) && (!empty($_GET['id']) | $_GET['id'] == 0)) {
            if ($_GET['id'] == 0) {
                setIcon($_SESSION['Account']['id'], 0);
                $_SESSION['Account']['icone'] = 0;
            } elseif ($icone = getIcon($_SESSION['Account']['id'], $_GET['id'])) {
                setIcon($_SESSION['Account']['id'], $icone['slug']);
                $_SESSION['Account']['icone'] = $icone['slug'];
            }
            setFlash('L\'îcone a été modifiée');
        }
        header('Location:compte');
    }
}

function save_account()
{
    if (connect()) {
        $words = secure($_POST['nombrewords']);
        $kanji = isset($_POST['kanji']) ? 1 : 0;
        if (is_numeric($words)) {
            if ($words > 100) $words = 100;
            saveAccount($_SESSION['Account']['id'], $words, $kanji);
            $_SESSION['Account']['nombreWords'] = $words;
            $_SESSION['Account']['kanji'] = $kanji;
            setFlash('Modifications enregistrées !');
        } else setFlash('Vous n\'avez pas rentré un nombre', 'danger');
        header('Location:accueil');
    }
}

function liste()
{
    $_POST['liste'] = selectListe($_GET['id']);
    if (!empty($_POST['liste']) && ($_POST['liste']['id_user'] == $_SESSION['Account']['id'] || $_POST['liste']['id_confidentiality'] == 1)) {
        $_POST['user'] = selectUserFromListe($_GET['id']);
        $_POST['mots'] = selectFrancaisFromListe($_GET['id']);
        require 'view/frontend/liste.php';
    } else {
        setFlash('Cette liste n\'est pas accessible');
        header('Location:accueil');
    }
}

function listes()
{
    if (connect()) {
        $_POST['listes'] = getListes($_SESSION['Account']['id']);
        require './view/frontend/listes.php';
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
            $_POST = selectListe($_GET['id']);
            if (empty($_POST) || $_POST['id_user'] != $_SESSION['Account']['id']) {
                unset($_POST);
                setFlash('Vous n\'avez pas accès à cette liste');
                header('Location:listes');
            }
        }
        require './view/frontend/liste_edit.php';
    }
}

function points()
{
    if (connect()) {
        $_POST['recompenses'] = listRecompense();
        $_POST['achats'] = listAchatByAccount($_SESSION['Account']['id']);
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
        if (!achatByUser($_SESSION['Account']['id'], $_GET['id_recompense'])) {
            $points = getSakura($_SESSION['Account']['id']);
            $cout = selectRecompense($_GET['id_recompense'])['cout'];
            if ($points['sakura'] >= $cout) {
                achatdb($_SESSION['Account']['id'], $_GET['id_recompense']);
                buySakura($_SESSION['Account']['id'], $points['sakura'] - $cout);
                $_SESSION['points'] = getSakura($_SESSION['Account']['id'])['sakura'];
                setFlash('Vous avez bien ajouté ce lot !');
            } else setFlash('Vous n\'avez pas assez de points :(', 'danger');
        }

        if ($_GET['page'] === 'account') header('Location:index.php?p=account');
        elseif ($_GET['page'] === 'theme') header('Location:index.php?p=theme');
        else header('Location:index.php?p=points');
    }
}

function connect()
{
    if (!$_SESSION['Account']) {
        header('Location:accueil');
        return false;
    }
    return true;
}

function submitToken()
{
    $token = new Token();
    if ($token->rowCountToken(secure($_COOKIE['token']), secure($_COOKIE['mail'])) === 1) {
        $statements = $token->getUserWithToken(secure($_COOKIE['token']), secure($_COOKIE['mail']));
        $_SESSION['Account']['pseudo'] = $statements['pseudo'];
        $_SESSION['Account']['admin'] = $statements['droits'];
        $_SESSION['Account']['id'] = $statements['id'];
        $_SESSION['Account']['nombreWords'] = $statements['nombre'];
        $_SESSION['Account']['points'] = getSakura($_SESSION['Account']['id'])['sakura'];
        $_SESSION['Account']['icone'] = $statements['icone'];
        $_SESSION['Account']['theme'] = $statements['theme'];
        $_SESSION['Account']['background'] = $statements['background'];
        $_SESSION['Account']['kanji'] = $statements['kanji'];
        $_SESSION['Account']['riddle'] = getRiddle($_SESSION['Account']['id']);

        if ($statements['last_login'] < date("Y-m-d") || $statements['last_login'] == null) {
            setLastLogin($_SESSION['Account']['id']);
            if ((int)$statements['life'] < 5) {
                setLife($_SESSION['Account']['id'], (int)$statements['life'] + 1);
                $_SESSION['Account']['life'] = (int)$statements['life'] + 1;
            } else $_SESSION['Account']['life'] = (int)$statements['life'];
        } else $_SESSION['Account']['life'] = (int)$statements['life'];
    } else header('Location:accueil');
}

function submitLogin($mail, $password)
{
    if (!empty($mail) && !empty($password)) {
        $statements = loginUser(secure($mail), $password);
        if ($statements == true) {
            $_SESSION['Account']['pseudo'] = $statements['pseudo'];
            $_SESSION['Account']['admin'] = $statements['droits'];
            $_SESSION['Account']['id'] = $statements['id'];
            $_SESSION['Account']['nombreWords'] = $statements['nombre'];
            $_SESSION['Account']['points'] = getSakura($_SESSION['Account']['id'])['sakura'];
            $_SESSION['Account']['icone'] = $statements['icone'];
            $_SESSION['Account']['theme'] = $statements['theme'];
            $_SESSION['Account']['background'] = $statements['background'];
            $_SESSION['Account']['kanji'] = $statements['kanji'];
            $_SESSION['Account']['riddle'] = getRiddle($_SESSION['Account']['id']);

            if ($statements['last_login'] < date("Y-m-d") || $statements['last_login'] == null) {
                setLastLogin($_SESSION['Account']['id']);
                if ((int)$statements['life'] < 5) {
                    setLife($_SESSION['Account']['id'], (int)$statements['life'] + 1);
                    $_SESSION['Account']['life'] = (int)$statements['life'] + 1;
                } else {
                    $_SESSION['Account']['life'] = (int)$statements['life'];
                }
            } else $_SESSION['Account']['life'] = (int)$statements['life'];
            setcookie('mail', $mail, time() + 365 * 24 * 3600);

            $randomToken = bin2hex(random_bytes(24));
            setcookie('token', $randomToken, time() + 365 * 24 * 3600);
            $token = new Token();
            $token->setToken($randomToken, $_SESSION['Account']['id']);

            setFlash('Connexion réussie');
        } else setFlash('Mot de passe ou identifiant incorrect', 'danger');
    } else setFlash('Un champ est vide', 'danger');
    header('Location:accueil');
}

function submitRegister($pseudo, $pass, $mail)
{
    if (!empty($pseudo) && !empty($pass) && !empty($mail)) {
        $correctPseudo = searchPseudo(secure($pseudo));
        $correctSlug = searchSlug(slug(secure($pseudo)));
        if (searchMail(secure($mail))) {
            setFlash('L\'adresse mail est déjà utilisée', 'danger');
            header('Location:accueil');
        } elseif ($correctPseudo || $correctSlug) {
            setFlash('Le pseudo est déjà utilisé', 'danger');
            header('Location:accueil');
        } else {
            $password_hash = password_hash($pass, PASSWORD_DEFAULT);
            createUser(secure($pseudo), $password_hash, secure($mail), slug(secure($pseudo)));
            submitLogin($mail, $pass);
        }
    }
}

function forget_password()
{
    $mail = secure($_POST['mail']);
    if (!empty($mail) && searchMail($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL))
        createCode($mail, searchMail($mail)['pseudo']);
    elseif (isset($_SESSION['recup_mail']))
        createCode($_SESSION['recup_mail'], searchMail($_SESSION['recup_mail'])['pseudo']);
    else {
        setFlash('Le code est invalide', 'danger');
        header('Location:accueil');
    }
}

function send_code()
{
    $code = secure($_POST['code']);
    if (!empty($code)) {
        if ($recup = searchRecup($_SESSION['recup_mail'], $code)) {
            $_SESSION['recup_code'] = $code;
            $_SESSION['recup_id'] = $recup['id'];
            require 'view/frontend/change_pass.php';
        }
    } elseif (isset($_SESSION['recup_code']) && !empty($_SESSION['recup_code'])) require 'view/frontend/change_pass.php';

    header('Location:index.php?p=forget_password');
}

function change_pass()
{
    $pass = secure($_POST['password']);
    $passVerif = secure($_POST['password2']);
    if (!empty($pass)) {
        if ($pass === $passVerif) {
            changePass($_SESSION['recup_mail'], password_hash($pass, PASSWORD_DEFAULT));
            deleteRecup($_SESSION['recup_id']);
            unset($_SESSION['recup_code'], $_SESSION['recup_id']);
            setFlash('Vous avez bien changé votre mot de passe !');
            submitLogin($_SESSION['recup_mail'], $pass);
        } else send_code();
    }

    header('Location:index.php?p=send_code');
}

/**
 * Liste
 */

function liste_delete()
{
    if (!supprListe($_GET['id'])) setFlash('La liste n\'a pas été supprimée', 'danger');
    else setFlash('La liste a bien été supprimée');
    header('Location:index.php?p=listes');
}

function liste_add()
{
    if (isset($_POST['save'])) {
        $nom = secure($_POST['nom']);
        $desc = secure($_POST['description']);

        if ($_GET['id'] > 0) $addListe = editListe($nom, $desc, $_POST['id_confidentiality'], $_GET['id'], $_SESSION['Account']['id']);
        else $addListe = createListe($nom, $desc, $_POST['id_confidentiality'], $_SESSION['Account']['id']);

        if ($addListe === false) setFlash('La liste n\'a pas été ajoutée', 'danger');
        else setFlash('La liste a bien été crée');
    } else setFlash('Problème dans la création de la liste', 'danger');
    header('Location:index.php?p=listes');
}

/**
 * Récupération
 */

function createCode($mail, $pseudo)
{
    $code = "";
    for ($i = 0; $i < 8; $i++) $code .= mt_rand(0, 9);
    $_SESSION['recup_mail'] = $mail;
    if (searchRecupMail($mail)) updateRecup($mail, $code);
    else createRecup($mail, $code);

    $header = 'From: Lexiquejaponais <support@lexiquejaponais.fr>' . "\r\n" .
        'Reply-To: support@lexiquejaponais.fr' . "\r\n" .
        'X-Mailer: PHP/' . PHP_VERSION . "\r\n" .
        "Content-type: text/html; charset=utf-8";
    $message = sendResetPassword($pseudo, $code);
    mail($mail, "Récupération de mot de passe - lexiquejaponais.fr", $message, $header);
    setFlash("Un code vous a été envoyé à " . $mail);
    require 'view/frontend/forget_pass.php';
}

/**
 * Thèmes
 */

function theme()
{
    if (connect()) {
        $_POST['themes'] = listThemes();
        $_POST['themes_own'] = listAchatThemeByAccount($_SESSION['Account']['id']);
        $_POST['background_other'] = listBackgrounds();
        $_POST['background_own'] = listAchatBackgroundByAccount($_SESSION['Account']['id']);
        foreach ($_POST['themes'] as $theme) {
            foreach ($_POST['themes_own'] as $theme1) {
                if ($theme['libelle'] === $theme1['libelle']) {
                    unset($_POST['themes'][array_search($theme, $_POST['themes'], true)]);
                }
            }
        }
        foreach ($_POST['background_other'] as $background) {
            foreach ($_POST['background_own'] as $background1) {
                if ($background['libelle'] === $background1['libelle']) {
                    unset($_POST['background_other'][array_search($background, $_POST['background_other'], true)]);
                }
            }
        }
        require 'view/frontend/theme.php';
    }
}

function select_theme()
{
    if (connect()) {
        setTheme($_SESSION['Account']['id'], $_GET['id']);
        $_SESSION['Account']['theme'] = $_GET['id'];
        header('Location:accueil');
    }
}

function select_back()
{
    if (connect()) {
        setBackground($_SESSION['Account']['id'], $_GET['id']);
        $_SESSION['Account']['background'] = $_GET['id'];
        header('Location:accueil');
    }
}

function search()
{
    if (isset($_GET['mot'])) {
        $_POST['groupes'] = array();
        $_POST['type'] = array();

        $_POST['francais'] = researchWord(secure($_GET['mot']));
        $_POST['japonais'] = listJaponaisToFrancais($_POST['francais']['id']);

        foreach ($_POST['japonais'] as $japonais) {
            $_POST['groupes'][$japonais['id']] = selectGroupeFromJaponais($japonais['id']);
            array_push($_POST['type'], add_selection_type($japonais['id_type'], $japonais));
        }

        if (isset($_SESSION) && !empty($_SESSION)) {
            $_POST['listes'] = getListes($_SESSION['Account']['id']);
            $_POST['other_listes'] = haveListes($_SESSION['Account']['id'], $_POST['francais']['id']);

            foreach ($_POST['other_listes'] as $other_liste) {
                foreach ($_POST['listes'] as $liste) {
                    if ($liste['nom'] === $other_liste['nom']) {
                        unset($_POST['listes'][array_search($liste, $_POST['listes'], true)]);
                    }
                }
            }
        }

        require 'view/frontend/search.php';
    } else {
        setFlash('Ce mot n\'existe pas', 'danger');
        header('Location:accueil');
    }
}

function groupe_page()
{
    $id = secure($_GET['id']);
    $_POST['groupe'] = researchGroupeSlug($id);
    $_POST['parent'] = groupeParent($_POST['groupe']['id_parent']);
    $_POST['enfant'] = groupeEnfant($_POST['groupe']['id']);
    if (!empty($_POST['groupe'])) {
        $_POST['words'] = listFrancaisAndJaponaisWhereGroupe($_POST['groupe']['id']);
        if (isset($_POST['enfant'])) {
            foreach ($_POST['enfant'] as $key => $enfant) {
                $_POST['enfant'][$key]['words'] = listFrancaisAndJaponaisWhereGroupe($enfant['id']);
            }
        }
        require 'view/frontend/groupe.php';
    } else {
        setFlash('Ce groupe n\'existe pas', 'danger');
        header('Location:accueil');
    }
}

/**
 * Kanjis
 */

function kanji()
{
    if (isset($_GET['id'])) {
        if (!existKanji($_GET['id'])) {
            setFlash("Aucun kanji avec cet id", "danger");
            header("Location:accueil");
        }
        $_POST = getKanji($_GET['id']);
        $_POST['japonais'] = listJaponaisToKanji($_GET['id']);
        foreach ($_POST['japonais'] as $key => $japonais)
            $_POST['japonais'][$key] += listFrancaisToJaponaisLimit1($japonais['id']);
        require 'view/frontend/kanji.php';
    } else {
        setFlash('Aucun kanji avec cet id', 'danger');
        header('Location:accueil');
    }
}

/**
 * Changelog
 */

function changelog()
{
    require 'view/frontend/changelog.php';
}


/**
 * Statistiques
 */

function statistiques()
{
    $_POST['stats'] = countUser();
    $_POST['stats'] += countJaponais();
    $_POST['stats'] += sumSakura();
    $_POST['stats']['leaders'] = bestUser();
    $_POST['stats']['leaders2'] = bestUser2();
    $_POST['stats']['kanjis'] = bestKanjis();
    $_POST['stats']['day'] = lastDayHistory();
    $_POST['stats']['week'] = lastWeekHistory();
    $_POST['stats']['month'] = lastMonthHistory();
    require 'view/frontend/statistiques.php';
}

/**
 * Développeur
 */

function contact()
{
    require 'view/frontend/contact.php';
}

function history()
{
    if (connect()) {
        $_POST['value'] = selectHistory($_SESSION['Account']['id']);
        $_POST['history'] = array();

        foreach ($_POST['value'] as $value) {
            $traducts = listJaponaisToFrancaisWord($value['riddle']);
            if ($traducts == null) $traducts = listFrancaisToJaponaisWord($value['riddle']);
            array_push($value, $traducts);
            array_push($_POST['history'], $value);
        }
        unset($_POST['value']);

        require 'view/frontend/history.php';
    } else {
        setFlash('Accès interdit', 'danger');
        header('Location:accueil');
    }
}

function courses()
{
    require 'view/frontend/courses.php';
}