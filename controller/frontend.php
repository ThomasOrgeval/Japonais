<?php

session_start();
mb_internal_encoding("UTF-8");
require_once './controller/libs/form.php';
require './controller/libs/session.php';
require './controller/libs/mail.php';
require './controller/libs/type.php';

require './controller/backend.php';
require './model/frontend.php';

/**
 * Chargement de pages
 */

function accueil()
{
    if (isset($_COOKIE['mail'], $_COOKIE['pass']) && !isset($_SESSION['pseudo'])) submitLogin($_COOKIE['mail'], $_COOKIE['pass']);

    if (isset($_SESSION['new_life']) && $_SESSION['new_life'] === true) $_SESSION['new_life'] = false;

    if (isset($_SESSION['nombreWords']) && !empty($_SESSION['nombreWords'])) $_POST['words'] = listRandomWords($_SESSION['nombreWords']);
    else $_POST['words'] = listRandomWords(10);

    foreach ($_POST['words'] as $key => $word) {
        $kana = preg_split('/(?<!^)(?!$)/u', $word['kana']);
        $replace = preg_split('/(?<!^)(?!$)/u', $word['kanji']);
        $kanjis = find_kanji($word['kanji']);
    }

    require './view/frontend/index.php';
}

function logout()
{
    session_destroy();
    setcookie('mail');
    setcookie('pass');
    setcookie('theme');
    header('Location:index.php?p=accueil');
}

function account()
{
    if (connect()) {
        if (isset($_GET['user'])) {
            $_POST['user'] = searchUser($_GET['user']);
            if (empty($_POST['user'])) {
                setFlash('Cet utilisateur n\'existe pas', 'danger');
                accueil();
            } else {
                $_POST['sakura'] = getSakura($_POST['user']['id']);
                $_POST['listes'] = searchListeUser($_POST['user']['id']);
                $_POST['chart'] = getSakuraLastMonth($_POST['user']['id']);
            }
        } else {
            $_POST['icones_own'] = listAchatIconByAccount($_SESSION['id']);
            $_POST['icones'] = listIcons();
            $_POST['listes'] = searchListe($_SESSION['id']);
            $_POST['sakura'] = getSakura($_SESSION['id']);
            $_POST['chart'] = getSakuraLastMonth($_SESSION['id']);
            foreach ($_POST['icones'] as $icone) {
                foreach ($_POST['icones_own'] as $icone_own) {
                    if ($icone['libelle'] === $icone_own['libelle']) {
                        unset($_POST['icones'][array_search($icone, $_POST['icones'], true)]);
                    }
                }
            }
        }
        require './view/frontend/account.php';
    }
}

function change_icon()
{
    if (connect()) {
        if (isset($_GET['id']) && (!empty($_GET['id']) || $_GET['id'] == 0)) {
            if (haveIcon($_SESSION['id'], $_GET['id']) || $_GET['id'] == 0) {
                $icone = changeIcon($_GET['id']);
                setIcon($_SESSION['id'], $icone['slug']);
                $_SESSION['icone'] = $icone['slug'];
                setFlash('L\'îcone a été modifiée');
            }
        }
        header('Location:index.php?p=account');
    }
}

function save_account()
{
    if (connect()) {
        $words = securize($_POST['nombrewords']);
        $kanji = isset($_POST['kanji']) ? 1 : 0;
        if (is_numeric($words)) {
            if ($words > 100) {
                $words = 100;
            }
            saveAccount($_SESSION['id'], $words, $kanji);
            $_SESSION['nombreWords'] = $words;
            $_SESSION['kanji'] = $kanji;
            setFlash('Modifications enregistrées !');
        } else {
            setFlash('Vous n\'avez pas rentré un nombre', 'danger');
        }
        header('Location:index.php?p=accueil');
    }
}

function liste()
{
    $_POST['liste'] = selectListe($_GET['id']);
    if (!empty($_POST['liste']) && ($_POST['liste']['id_user'] == $_SESSION['id'] || $_POST['liste']['id_confidentiality'] == 1)) {
        $_POST['user'] = selectUserFromListe($_GET['id']);
        $_POST['mots'] = selectFrancaisFromListe($_GET['id']);
        require './view/frontend/liste.php';
    } else {
        setFlash('Cette liste n\'est pas accessible');
        header('Location:index.php?p=accueil');
    }
}

function listes()
{
    if (connect()) {
        $_POST['listes'] = listListes($_SESSION['id']);
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
            if (empty($_POST) || $_POST['id_user'] != $_SESSION['id']) {
                unset($_POST);
                setFlash('Vous n\'avez pas accès à cette liste');
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
        if (achatByUser($_SESSION['id'], $_GET['id_recompense']) == false) {
            $points = getSakura($_SESSION['id']);
            $cout = selectRecompense($_GET['id_recompense'])['cout'];
            if ($points['sakura'] >= $cout) {
                achatdb($_SESSION['id'], $_GET['id_recompense']);
                buySakura($_SESSION['id'], $points['sakura'] - $cout);
                $_SESSION['points'] = getSakura($_SESSION['id'])['sakura'];
                setFlash('Vous avez bien ajouté ce lot !');
            } else {
                setFlash('Vous n\'avez pas assez de points :(', 'danger');
            }
        }

        if ($_GET['page'] === 'account') {
            header('Location:index.php?p=account');
        } elseif ($_GET['page'] === 'theme') {
            header('Location:index.php?p=theme');
        } else {
            header('Location:index.php?p=points');
        }
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

function submitLogin($mail, $password)
{
    if (!empty($mail) && !empty($password)) {
        $statements = loginUser($mail, $password);
        if ($statements == true) {
            $_SESSION['pseudo'] = $statements['pseudo'];
            $_SESSION['admin'] = $statements['droits'];
            $_SESSION['id'] = $statements['id'];
            $_SESSION['nombreWords'] = $statements['nombre'];
            $_SESSION['points'] = getSakura($_SESSION['id'])['sakura'];
            $_SESSION['connect'] = 'OK';
            $_SESSION['icone'] = $statements['icone'];
            $_SESSION['theme'] = $statements['theme'];
            $_SESSION['kanji'] = $statements['kanji'];
            $_SESSION['riddle'] = getRiddle($_SESSION['id']);

            if ($statements['last_login'] < date("Y-m-d") || $statements['last_login'] == null) {
                setLastLogin($_SESSION['id']);
                if ((int)$statements['life'] < 5) {
                    setLife($_SESSION['id'], (int)$statements['life'] + 1);
                    $_SESSION['life'] = (int)$statements['life'] + 1;
                    $_SESSION['new_life'] = true;
                } else {
                    $_SESSION['life'] = (int)$statements['life'];
                }
            } else {
                $_SESSION['life'] = (int)$statements['life'];
            }
            setcookie('mail', $mail, time() + 365 * 24 * 3600);
            setcookie('pass', $password, time() + 365 * 24 * 3600);
            setFlash('Connexion réussie');
        } else {
            setFlash('Mot de passe ou identifiant incorrect', 'danger');
        }
    } else {
        setFlash('Un champ est vide', 'danger');
    }
    header('Location:index.php?p=accueil');
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
            header('Location:index.php?p=accueil');
        } elseif ($correctPseudo) {
            setFlash('Le pseudo est déjà utilisé', 'danger');
            header('Location:index.php?p=accueil');
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            createUser($pseudo, $password_hash, $mail);
            submitLogin($mail, $password);
        }
    }
}

function forget_password()
{
    $mail = securize($_POST['mail']);
    if (!empty($mail) && searchMail($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        createCode($mail, searchMail($mail)['pseudo']);
    } elseif (isset($_SESSION['recup_mail'])) {
        createCode($_SESSION['recup_mail'], searchMail($_SESSION['recup_mail'])['pseudo']);
    } else {
        setFlash('Le code est invalide', 'danger');
        header('Location:index.php?p=accueil');
    }
}

function recup_code()
{
    $code = securize($_POST['code']);
    if (!empty($code)) {
        $recup = searchRecup($_SESSION['recup_mail'], $code);
        if ($recup->rowCount() === 1) {
            $recup = $recup->fetch();
            $_SESSION['recup_code'] = $code;
            $_SESSION['recup_id'] = $recup['id'];
            require './view/frontend/change_pass.php';
        }
    } elseif (isset($_SESSION['recup_code']) && !empty($_SESSION['recup_code'])) {
        require './view/frontend/change_pass.php';
    }

    header('Location:index.php?p=forget_password');
}

function change_pass()
{
    $pass = securize($_POST['password']);
    $passVerif = securize($_POST['password2']);
    if (!empty($pass)) {
        if ($pass === $passVerif) {
            changePass($_SESSION['recup_mail'], password_hash($pass, PASSWORD_DEFAULT));
            deleteRecup($_SESSION['recup_id']);
            unset($_SESSION['recup_mail'], $_SESSION['recup_code'], $_SESSION['recup_id']);
            setFlash('Vous avez bien changé votre mot de passe !');
            submitLogin($_SESSION['recup_mail'], $pass);
        } else {
            recup_code();
        }
    }

    header('Location:index.php?p=send_code');
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
 * Récupération
 */

function createCode($mail, $pseudo)
{
    $code = "";
    for ($i = 0; $i < 8; $i++) {
        $code .= mt_rand(0, 9);
    }
    $_SESSION['recup_mail'] = $mail;
    if (searchRecupMail($mail) === 1) {
        updateRecup($mail, $code);
    } else {
        createRecup($mail, $code);
    }

    $header = 'From: Lexiquejaponais <support@lexiquejaponais.fr>' . "\r\n" .
        'Reply-To: support@lexiquejaponais.fr' . "\r\n" .
        'X-Mailer: PHP/' . PHP_VERSION . "\r\n" .
        "Content-type: text/html; charset=utf-8";
    $message = sendResetPassword($pseudo, $code);
    mail($mail, "Récupération de mot de passe - lexiquejaponais.fr", $message, $header);
    setFlash("Un code vous a été envoyé à " . $mail);
    require './view/frontend/forget_pass.php';
}

/**
 * Thèmes
 */

function theme()
{
    if (connect()) {
        $_POST['themes'] = listThemes();
        $_POST['themes_own'] = listAchatThemeByAccount($_SESSION['id']);
        foreach ($_POST['themes'] as $theme) {
            foreach ($_POST['themes_own'] as $theme1) {
                if ($theme['libelle'] === $theme1['libelle']) {
                    unset($_POST['themes'][array_search($theme, $_POST['themes'], true)]);
                }
            }
        }
        require './view/frontend/theme.php';
    }
}

function select_theme()
{
    if (connect()) {
        setTheme($_SESSION['id'], $_GET['id']);
        $_SESSION['theme'] = $_GET['id'];
        header('Location:index.php?p=accueil');
    }
}

function search()
{
    if (isset($_GET['mot'])) {
        $_POST['francais'] = researchWord($_GET['mot']);
        $_POST['japonais'] = listJaponaisToFrancais($_POST['francais']['id']);
        $_POST['groupes'] = listGroupeToJaponais($_POST['francais']['id']);
        $_POST['listes'] = listListes($_SESSION['id']);
        $_POST['other_listes'] = haveListes($_SESSION['id'], $_POST['francais']['id']);

        $_POST['type'] = array();
        foreach ($_POST['japonais'] as $japonais) {
            array_push($_POST['type'], add_selection_type($japonais['id_type'], $japonais));
        }
        foreach ($_POST['other_listes'] as $other_liste) {
            foreach ($_POST['listes'] as $liste) {
                if ($liste['nom'] === $other_liste['nom']) {
                    unset($_POST['listes'][array_search($liste, $_POST['listes'], true)]);
                }
            }
        }
        require './view/frontend/search.php';
    } else {
        setFlash('Ce mot n\'existe pas', 'danger');
        header('Location:index.php?p=accueil');
    }
}

function groupe_page()
{
    $id = securize($_GET['id']);
    $_POST['groupe'] = researchGroupeId($id);
    if (!empty($_POST['groupe'])) {
        $_POST['words'] = listFrancaisAndJaponaisWhereGroupe($_POST['groupe']['id']);
        require './view/frontend/groupe.php';
    } else {
        setFlash('Ce groupe n\'existe pas', 'danger');
        header('Location:index.php?p=accueil');
    }
}

/**
 * Kanjis
 */

function kanji()
{
    if (isset($_GET['id'])) {
        $kanji = testKanji($_GET['id']);
        if ($kanji->rowCount() === 0) {
            setFlash("Aucun kanji avec cet id", "danger");
            header("Location:index.php?p=accueil");
        }
        $_POST = $kanji->fetch();
        $_POST['japonais'] = listJaponaisToKanji($_GET['id']);
        foreach ($_POST['japonais'] as $key => $japonais) {
            $_POST['japonais'][$key] += listFrancaisToJaponaisLimit1($japonais['id']);
        }
        require './view/frontend/kanji.php';
    } else {
        setFlash('Aucun kanji avec cet id', 'danger');
        header('Location:index.php?p=accueil');
    }
}

/**
 * Changelog
 */

function changelog()
{
    require './view/frontend/changelog.php';
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
    require './view/frontend/statistiques.php';
}

/**
 * Développeur
 */

function contact()
{
    require './view/frontend/contact.php';
}

/**
 * Kana
 */

function kana()
{
    $kana = listKana();
    $_POST['kana'][''] = array();
    $_POST['kana']['k'] = array();
    $_POST['kana']['g'] = array();
    $_POST['kana']['s'] = array();
    $_POST['kana']['z'] = array();
    $_POST['kana']['t'] = array();
    $_POST['kana']['d'] = array();
    $_POST['kana']['n'] = array();
    $_POST['kana']['h'] = array();
    $_POST['kana']['b'] = array();
    $_POST['kana']['p'] = array();
    $_POST['kana']['m'] = array();
    $_POST['kana']['y'] = array();
    $_POST['kana']['r'] = array();
    $_POST['kana']['w'] = array();

    $_POST['kana']['ky'] = array();
    $_POST['kana']['gy'] = array();
    $_POST['kana']['sh'] = array();
    $_POST['kana']['j'] = array();
    $_POST['kana']['ch'] = array();
    $_POST['kana']['ny'] = array();
    $_POST['kana']['hy'] = array();
    $_POST['kana']['by'] = array();
    $_POST['kana']['py'] = array();
    $_POST['kana']['my'] = array();
    $_POST['kana']['ry'] = array();

    $excepts = ['cha', 'cho', 'chu', 'sha', 'sho', 'shu', 'ja', 'jo', 'ju', 'n'];
    foreach ($kana as $item) {
        if (substr($item['romaji'], 1, 1) != 'y' && !in_array($item['romaji'], $excepts)) {
            switch (substr($item['romaji'], 0, 1)) {
                case 'k':
                    array_push($_POST['kana']['k'], $item);
                    break;
                case 'g':
                    array_push($_POST['kana']['g'], $item);
                    break;
                case 's':
                    array_push($_POST['kana']['s'], $item);
                    break;
                case 'z':
                case 'j':
                    if ($item['hiragana'] === 'づ') {
                        array_push($_POST['kana']['d'], $item);
                        array_push($_POST['kana']['d'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    } else {
                        array_push($_POST['kana']['z'], $item);
                    }
                    break;
                case 't':
                case 'c':
                    array_push($_POST['kana']['t'], $item);
                    break;
                case 'd':
                    array_push($_POST['kana']['d'], $item);
                    break;
                case 'n':
                    array_push($_POST['kana']['n'], $item);
                    break;
                case 'h':
                case 'f':
                    array_push($_POST['kana']['h'], $item);
                    break;
                case 'p':
                    array_push($_POST['kana']['p'], $item);
                    break;
                case 'b':
                    array_push($_POST['kana']['b'], $item);
                    break;
                case 'm':
                    array_push($_POST['kana']['m'], $item);
                    break;
                case 'y':
                    array_push($_POST['kana']['y'], $item);
                    break;
                case 'r':
                    array_push($_POST['kana']['r'], $item);
                    break;
                case 'w':
                    array_push($_POST['kana']['w'], $item);
                    break;
                default:
                    array_push($_POST['kana'][''], $item);
            }
        } else {
            switch (substr($item['romaji'], 0, 2)) {
                case 'ky':
                    array_push($_POST['kana']['ky'], $item);
                    if ($item['romaji'] == 'kyu') {
                        array_push($_POST['kana']['ky'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ky'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'gy':
                    array_push($_POST['kana']['gy'], $item);
                    if ($item['romaji'] == 'gyu') {
                        array_push($_POST['kana']['gy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['gy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'sh':
                    array_push($_POST['kana']['sh'], $item);
                    if ($item['romaji'] == 'shu') {
                        array_push($_POST['kana']['sh'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['sh'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ch':
                    array_push($_POST['kana']['ch'], $item);
                    if ($item['romaji'] == 'chu') {
                        array_push($_POST['kana']['ch'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ch'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ny':
                    array_push($_POST['kana']['ny'], $item);
                    if ($item['romaji'] == 'nyu') {
                        array_push($_POST['kana']['ny'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ny'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'hy':
                    array_push($_POST['kana']['hy'], $item);
                    if ($item['romaji'] == 'hyu') {
                        array_push($_POST['kana']['hy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['hy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'by':
                    array_push($_POST['kana']['by'], $item);
                    if ($item['romaji'] == 'byu') {
                        array_push($_POST['kana']['by'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['by'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'py':
                    array_push($_POST['kana']['py'], $item);
                    if ($item['romaji'] == 'pyu') {
                        array_push($_POST['kana']['py'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['py'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'my':
                    array_push($_POST['kana']['my'], $item);
                    if ($item['romaji'] == 'myu') {
                        array_push($_POST['kana']['my'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['my'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ry':
                    array_push($_POST['kana']['ry'], $item);
                    if ($item['romaji'] == 'ryu') {
                        array_push($_POST['kana']['ry'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ry'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                default:
                    if ($item['hiragana'] == 'ん') {
                        array_push($_POST['kana']['w'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['w'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['w'], $item);
                    } else {
                        array_push($_POST['kana']['j'], $item);
                        if ($item['romaji'] == 'ju') {
                            array_push($_POST['kana']['j'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                            array_push($_POST['kana']['j'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        }
                    }
                    break;
            }
        }
    }
    array_push($_POST['kana']['y'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
    array_push($_POST['kana']['y'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
    require './view/frontend/kana.php';
}

function history()
{
    if (connect()) {
        $_POST['value'] = selectHistory($_SESSION['id']);
        $_POST['history'] = array();

        foreach ($_POST['value'] as $value) {
            $traducts = listJaponaisToFrancaisWord($value['riddle']);
            if ($traducts == null) $traducts = listFrancaisToJaponaisWord($value['riddle']);
            array_push($value, $traducts);
            array_push($_POST['history'], $value);
        }
        unset($_POST['value']);

        require './view/frontend/history.php';
    } else {
        setFlash('Accès interdit', 'danger');
        header('Location:index.php?p=accueil');
    }
}