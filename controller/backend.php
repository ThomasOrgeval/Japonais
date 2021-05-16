<?php

require './model/backend.php';

function admin_portail()
{
    if (connect_admin()) require './view/backend/index.php';
    else header('Location:accueil');
}

function groupe()
{
    if (connect_admin()) {
        $_POST['groupes'] = listGroupe();
        require './view/backend/groupe.php';
    } else header('Location:accueil');
}

function groupe_edit()
{
    if (connect_admin()) {
        $groupes = listGroupe();
        $groupe_list = [0 => ''];
        foreach ($groupes as $groupe) {
            $groupe_list[$groupe['id']] = $groupe['libelle'];
        }

        if (isset($_GET['id'])) {
            if (nbrGroupe($_GET['id']) === 0) {
                setFlash('Il n\'y a pas de groupe avec cet ID', 'danger');
                header('Location: index.php?p=groupe');
            }
            $_POST = testGroupe($_GET['id']);
            unset($groupe_list[array_search($_POST['libelle'], $groupe_list, true)]);
            $_POST['mots'] = listWordToGroupe($_GET['id']);
        }
        require 'view/backend/groupe_edit.php';
    } else header('Location:accueil');
}

function type()
{
    if (connect_admin()) {
        $_POST['type'] = listType();
        require 'view/backend/type.php';
    } else header('Location:accueil');
}

function type_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $type = testType($_GET['id']);
            if ($type->rowCount() === 0) {
                setFlash("Il n'y a pas de type avec cet ID", "danger");
                header("Location:index.php?p=type");
            }
            $_POST = $type->fetch();
        }
        require './view/backend/type_edit.php';
    } else header('Location:accueil');
}

function japonais()
{
    if (connect_admin()) require './view/backend/japonais.php';
    else header('Location:accueil');
}

function japonais_edit()
{
    if (connect_admin()) {
        $_POST['groupes'] = array();

        $types = listType();
        $type_list = array();
        foreach ($types as $type) $type_list[$type['id']] = $type['type'];

        if (isset($_GET['id'])) {
            if (!testJaponaisID($_GET['id'])) {
                setFlash("Il n'y a pas de mot japonais avec cet ID", "danger");
                header("Location:index.php?p=japonais");
                exit();
            }
            $_POST = getJaponais($_GET['id']);
            $_POST['groupes'] = listGroupeToJaponais($_GET['id']);
            $_POST['kanjis'] = listKanjiToJaponais($_GET['id']);
        }

        $_POST['otherGroupes'] = otherGroupe($_POST['groupes']);
        $_POST['type'] = $type_list;
        $_POST['jlptValues'] = [0 => null, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
        require './view/backend/japonais_edit.php';
    } else header('Location:accueil');
}

function japonais_add()
{
    if (connect_admin()) {
        $kanji = secure($_POST['kanji']);
        $kana = secure($_POST['kana']);
        $romaji = secure($_POST['romaji']);
        $desc = secure($_POST['description']);
        $jlpt = secure($_POST['jlpt']);

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $addWord = editJaponais($kana, $kanji, $romaji, $desc, $_POST['id_type'], $_GET['id'], $jlpt);
            $id = $_GET['id'];
        } else {
            $addWord = createJaponais($kana, $kanji, $romaji, $desc, $_POST['id_type'], $jlpt);
            $id = researchJaponais($romaji, $kanji)['id'];
        }
        addJaponaisKanji($kanji, $id);

        foreach ($_POST['groupe'] as $key => $group) {
            if ($group == 0 && selectGroupAndJaponais($key, $id) >= 1) deleteGroupeToJaponais($key, $id);
            else if ($group == 1 && selectGroupAndJaponais($key, $id) == 0) addGroupeToJaponais($key, $id);
        }

        for ($i = 0; $i <= sizeof($_POST['id_francais']); $i++) {
            if (!empty($_POST['francais'][$i])) {
                addFrancais($_POST['id_francais'][$i], $_POST['francais'][$i]);
                $id_francais = researchFrBack($_POST['francais'][$i])['id'];
                if (empty(selectJaponaisAndFrancais($id_francais, $id))) createJaponaisAndFrancais($id_francais, $id);
            }
        }
        for ($i = 0; $i <= sizeof($_POST['id_anglais']); $i++) {
            if (!empty($_POST['anglais'][$i])) {
                addAnglais($_POST['id_anglais'][$i], $_POST['anglais'][$i]);
                $id_anglais = researchAnglais($_POST['anglais'][$i])['id'];
                if (empty(selectAnglaisAndJaponais($id, $id_anglais))) createJaponaisAndAnglais($id, $id_anglais);
            }
        }

        if ($addWord === false) setFlash('Le mot n\'a pas été ajouté', 'danger');
        else setFlash('Le mot a bien été crée');
        header('Location:index.php?p=japonais');
    } else header('Location:accueil');
}

function kanjis()
{
    if (connect_admin()) {
        $_POST['kanji'] = getKanjis();
        require './view/backend/kanjis.php';
    } else header('Location:accueil');
}

function kanji_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            if (!existKanji($_GET['id'])) {
                setFlash("Il n'y a pas de kanji avec cet ID", "danger");
                header("Location:index.php?p=kanji");
            }
            $_POST = getKanji($_GET['id']);
            $_POST['japonais'] = listJaponaisToKanji($_GET['id']);
        }
        require './view/backend/kanji_edit.php';
    } else header('Location:accueil');
}

function recompense()
{
    if (connect_admin()) {
        $_POST['recompense'] = listRecompense();
        require './view/backend/recompense.php';
    } else header('Location:accueil');
}

function recompense_edit()
{
    if (connect_admin()) {
        $types = listTypeRecompense();
        $type_list = array();
        foreach ($types as $type) $type_list[$type['id']] = $type['type'];

        if (isset($_GET['id'])) {
            if (!existRecompense($_GET['id'])) {
                setFlash("Il n'y a pas de récompense avec cet ID", "danger");
                header("Location:index.php?p=recompense");
            }
            $_POST = getRecompense($_GET['id']);
            $_POST['acheteurs'] = listAchateurFromRecompense($_GET['id']);
        }
        require './view/backend/recompense_edit.php';
    } else header('Location:accueil');
}

function connect_admin()
{
    if ($_SESSION['Account']['admin'] != 1 || !isAdmin($_SESSION['Account']['pseudo'])) {
        header('Location:accueil');
        return false;
    }
    return true;
}

function secure($var): string
{
    $var = htmlspecialchars($var);
    $var = trim($var);
    return strip_tags($var);
}

/**
 * Groupe
 */

function groupe_add()
{
    if (connect_admin()) {
        $libelle = secure($_POST['libelle']);
        if (strlen($_POST['id_parent']) != 0 && (int)$_POST['id_parent'] != 0) $id_parent = (int)secure($_POST['id_parent']);
        else $id_parent = null;
        $quantifieur = secure($_POST['quantifieur']);
        $slug = slug($libelle);

        if ($_GET['id'] > 0) {
            $addGroupe = editGroupe($_GET['id'], $libelle, $id_parent, $quantifieur, $slug);
        } else {
            $addGroupe = createGroupe($libelle, $id_parent, $quantifieur, $slug);
        }

        if ($addGroupe === false) {
            setFlash("Le groupe n'a pas été ajouté", 'danger');
            throw new Exception();
        }

        setFlash('Le groupe a bien été ajouté');
        header('Location:index.php?p=groupe');
    } else header('Location:accueil');
}

function groupe_delete()
{
    if (connect_admin()) {
        deleteAllGroupe($_GET['id']);
        if (!supprGroupe($_GET['id'])) setFlash('Le groupe n\'a pas été supprimé', 'danger');
        else setFlash('Le groupe a bien été supprimé');
        header('Location:index.php?p=groupe');
    } else header('Location:accueil');
}

/**
 * Francais
 */

function addFrancais($id, $francais)
{
    if (connect_admin()) {
        $francais = secure($francais);
        $slug = secure(slug($francais));

        if ($id > 0) {
            editWord($francais, $id, $slug);
        } else {
            if (empty(researchFrBack($francais))) createWord($francais, $slug);
        }
    } else header('Location:accueil');
}

function slug($str, $delimiter = '-'): string
{
    $unwanted_array = ['é' => 'e', 'è' => 'e', 'É' => 'e', 'ç' => 'c', 'È' => 'e', 'Ù' => 'u', 'ù' => 'u', 'À' => 'a', 'à' => 'a', 'Ç' => 'c', 'ô' => 'o', 'Ô' => 'o'];
    $str = strtr($str, $unwanted_array);
    return strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
}

/**
 * Type
 */

function type_add()
{
    if (connect_admin()) {
        $type = secure($_POST['type']);
        $type_jp = secure($_POST['type_jp']);

        if ($_GET['id'] > 0) $addType = editType($_GET['id'], $type, $type_jp);
        else $addType = createType($type, $type_jp);

        if ($addType === false) setFlash('Le type n\'a pas été ajouté', 'danger');
        else setFlash('Le type a bien été crée');
        header('Location:index.php?p=type');
    } else header('Location:accueil');
}

function type_delete()
{
    if (connect_admin()) {
        if (!supprType($_GET['id'])) setFlash('Le type n\'a pas été supprimé', 'danger');
        else setFlash('Le type a bien été supprimé');
        header('Location:index.php?p=type');
    } else header('Location:accueil');
}

/**
 * Anglais
 */


function addAnglais($id, $anglais)
{
    if (connect_admin()) {
        $anglais = secure($anglais);

        if ($id > 0) {
            editAnglais($anglais, $id);
        } else {
            if (empty(researchAnglais($anglais))) createAnglais($anglais);
        }
    } else header('Location:accueil');
}

/**
 * Kanji
 */

function kanji_save()
{
    if (connect_admin()) {
        $addKanji = editKanji($_POST['id'], $_POST['on_yomi'], $_POST['kun_yomi'], $_POST['sens'], $_POST['sens_en']);
        if ($addKanji === false) {
            setFlash('Le kanji n\'a pas été sauvegardé', 'danger');
            throw new Exception();
        }
        setFlash('Le kanji a bien été sauvegardé');
        header('Location:index.php?p=kanjis');
    } else header('Location:accueil');
}

function addJaponaisKanji($values, $id)
{
    $values = find_kanji($values);

    foreach ($values as $value) {
        $kanji = testKanjiContains($value);
        if ($kanji->rowCount() !== 0) {
            $kanji = $kanji->fetch();
            if (!testKanjiJaponais($id, $kanji['id'])) {
                addKanjiJaponais($id, $kanji['id']);
            }
        }
    }
}

function find_kanji($var)
{
    $values = preg_replace("/\P{Han}/u", '', $var); // Garde uniquement les kanjis
    return preg_split('/(?<!^)(?!$)/u', $values); // Crée un tableau de chaque caractère
}

/**
 * Récompense
 */

function recompense_add()
{
    if (connect_admin()) {
        $libelle = secure($_POST['libelle']);
        $cost = secure($_POST['cout']);
        $slug = secure($_POST['slug']);
        if (preg_match('/^[a-z\-0-9]+$/', $slug)) {
            if ($_GET['id'] > 0) $addRecompense = editRecompense($_GET['id'], $libelle, $cost, $slug, $_POST['id_type']);
            else $addRecompense = createRecompense($libelle, $cost, $slug, $_POST['id_type']);

            if (!$addRecompense) setFlash('La récompense n\'a pas été ajouté', 'danger');
            else setFlash('La récompense a bien été crée');
            header('Location:index.php?p=recompense');
        } else setFlash("Le slug n'est pas valide", 'danger');
    } else header('Location:accueil');
}

function recompense_delete()
{
    if (connect_admin()) {
        if (supprRecompense($_GET['id'])) setFlash('La récompense a bien été supprimée');
        else setFlash('La récompense n\'a pas été supprimée', 'danger');

        header('Location:index.php?p=recompense');
    } else header('Location:accueil');
}

function otherGroupe($listPresent)
{
    if (connect_admin()) {
        $listAll = listGroupe();
        if (empty($listPresent)) return $listAll;
        $listOther = $listAll;
        foreach ($listPresent as $present) {
            foreach ($listAll as $item) {
                if ($present['libelle'] === $item['libelle']) {
                    unset($listOther[array_search($present, $listOther, true)]);
                }
            }
        }
        return $listOther;
    } else return null;
}

/**
 * Musique
 */

function music()
{
    if (connect_admin()) {
        $_POST['music'] = getMusics();
        require './view/backend/music.php';
    } else header('Location:accueil');
}

function music_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            if (!existMusic($_GET['id'])) {
                setFlash('Il n\'y a pas de musique avec cet ID', 'danger');
                header('Location: index.php?p=groupe');
            }
            $_POST = getMusic($_GET['id']);
        }
        require 'view/backend/music_edit.php';
    } else header('Location:accueil');
}

function music_delete()
{
    if (connect_admin()) {
        dropMusic($_GET['id']);
        header('Location:index.php?p=music');
    } else header('Location:accueil');
}

function music_add()
{
    if (connect_admin()) {
        $anime = secure($_POST['anime']);
        $chanteur = secure($_POST['chanteur']);
        $titre = secure($_POST['titre']);
        $slug = slug($chanteur . ' - ' . $titre);

        if ($_GET['id'] > 0) editMusic($_GET['id'], $_POST['japonais'], $_POST['romaji'], $_POST['francais'], $anime, $chanteur, $titre, $slug);
        else addMusic($_POST['japonais'], $_POST['romaji'], $_POST['francais'], $anime, $chanteur, $titre, $slug);

        if (!empty($_FILES['audio']['name'])) {
            $audio = slug($_FILES['audio']['name']);
            if (!file_exists("./resources/audio/" . $audio)) move_uploaded_file($_FILES['audio']['tmp_name'], "./resources/audio/" . $audio);
            insertMusic($slug, $audio);
        }

        setFlash('La musique a bien été crée');
        header('Location:index.php?p=music');
    } else header('Location:accueil');
}