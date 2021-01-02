<?php

require './model/backend.php';

function admin_portail()
{
    if (connect_admin()) {
        require './view/backend/index.php';
    } else header('Location:index.php?p=accueil');
}

function groupe()
{
    if (connect_admin()) {
        $_POST['groupes'] = listGroupe();
        require './view/backend/groupe.php';
    } else header('Location:index.php?p=accueil');
}

function groupe_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $groupe = testGroupe($_GET['id']);
            if ($groupe->rowCount() === 0) {
                setFlash('Il n\'y a pas de groupe avec cet ID', 'danger');
                header('Location: index.php?p=groupe');
            }
            $_POST = $groupe->fetch();
            $_POST['mots'] = listWordToGroupe($_GET['id']);
        }
        require 'view/backend/groupe_edit.php';
    } else header('Location:index.php?p=accueil');
}

function type()
{
    if (connect_admin()) {
        $_POST['type'] = listType();
        require './view/backend/type.php';
    } else header('Location:index.php?p=accueil');
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
    } else header('Location:index.php?p=accueil');
}

function japonais()
{
    if (connect_admin()) {
        $_POST['japonais'] = listJaponais();
        require './view/backend/japonais.php';
    } else header('Location:index.php?p=accueil');
}

function japonais_edit()
{
    if (connect_admin()) {
        $types = listType();
        $type_list = array();
        $_POST['groupes'] = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $japonais = testJaponaisID($_GET['id']);
            if ($japonais->rowCount() === 0) {
                setFlash("Il n'y a pas de mot japonais avec cet ID", "danger");
                header("Location:index.php?p=japonais");
            }
            $_POST = $japonais->fetch();
            $_POST['groupes'] = listGroupeToJaponais($_GET['id']);
            $_POST['kanjis'] = listKanjiToJaponais($_GET['id']);
        }
        $_POST['otherGroupes'] = otherGroupe($_POST['groupes']);
        $_POST['type'] = $type_list;
        require './view/backend/japonais_edit.php';
    } else header('Location:index.php?p=accueil');
}

function japonais_add()
{
    if (connect_admin()) {
        $kanji = securize($_POST['kanji']);
        $kana = securize($_POST['kana']);
        $romaji = securize($_POST['romaji']);
        $desc = securize($_POST['description']);

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $addWord = editJaponais($kana, $kanji, $romaji, $desc, $_POST['id_type'], $_GET['id']);
            $id = $_GET['id'];
        } else {
            $addWord = createJaponais($kana, $kanji, $romaji, $desc, $_POST['id_type']);
            $id = researchJaponais($romaji)['id'];
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

        if ($addWord === false) {
            setFlash('Le mot n\'a pas été ajouté', 'danger');
            throw new Exception();
        }

        setFlash('Le mot a bien été crée');
        header('Location:index.php?p=japonais');
    } else header('Location:index.php?p=accueil');
}

function kanjis()
{
    if (connect_admin()) {
        $_POST['kanji'] = listKanji();
        require './view/backend/kanjis.php';
    } else header('Location:index.php?p=accueil');
}

function kanji_edit()
{
    if (connect_admin()) {

        if (isset($_GET['id'])) {
            $kanji = testKanji($_GET['id']);
            if ($kanji->rowCount() === 0) {
                setFlash("Il n'y a pas de kanji avec cet ID", "danger");
                header("Location:index.php?p=kanji");
            }
            $_POST = $kanji->fetch();
            $_POST['japonais'] = listJaponaisToKanji($_GET['id']);
        }
        require './view/backend/kanji_edit.php';
    } else header('Location:index.php?p=accueil');
}

function recompense()
{
    if (connect_admin()) {
        $_POST['recompense'] = listRecompense();
        require './view/backend/recompense.php';
    } else header('Location:index.php?p=accueil');
}

function recompense_edit()
{
    if (connect_admin()) {
        $types = listTypeRecompense();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $recompense = testRecompense($_GET['id']);
            if ($recompense->rowCount() === 0) {
                setFlash("Il n'y a pas de récompense avec cet ID", "danger");
                header("Location:index.php?p=recompense");
            }
            $_POST = $recompense->fetch();
            $_POST['acheteurs'] = listAchateurFromRecompense($_GET['id']);
        }
        require './view/backend/recompense_edit.php';
    } else header('Location:index.php?p=accueil');
}

function connect_admin()
{
    if ($_SESSION['connect'] !== 'OK' || $_SESSION['admin'] === 0) {
        header('Location:index.php?p=accueil');
        return false;
    }
    return true;
}

function securize($var)
{
    $var = htmlspecialchars($var);
    $var = trim($var);
    $var = strip_tags($var);
    return $var;
}

/**
 * Groupe
 */

function addGroupe($libelle, $id)
{
    if (connect_admin()) {
        $libelle = securize($libelle);

        if ($id > 0) {
            $addGroupe = editGroupe($id, $libelle);
        } else {
            $addGroupe = createGroupe($libelle);
        }

        if ($addGroupe === false) {
            setFlash("Le groupe n'a pas été ajouté", 'danger');
            throw new Exception();
        }

        setFlash('Le groupe a bien été ajouté');
        header('Location:index.php?p=groupe');
    } else header('Location:index.php?p=accueil');
}

function deleteGroupe($id)
{
    if (connect_admin()) {
        deleteAllGroupe($id);
        $deleteGroupe = supprGroupe($id);
        if ($deleteGroupe === false) {
            setFlash('Le groupe n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le groupe a bien été supprimé');
        header('Location:index.php?p=groupe');
    } else header('Location:index.php?p=accueil');
}

/**
 * Francais
 */

function addFrancais($id, $francais)
{
    if (connect_admin()) {
        $francais = securize($francais);

        if ($id > 0) {
            editWord($francais, $id);
        } else {
            if (empty(researchFrBack($francais))) createWord($francais);
        }
    } else header('Location:index.php?p=accueil');
}

/**
 * Type
 */

function addType()
{
    if (connect_admin()) {
        $type = securize($_POST['type']);
        $type_jp = securize($_POST['type_jp']);

        if ($_GET['id'] > 0) {
            $addType = editType($_GET['id'], $type, $type_jp);
        } else {
            $addType = createType($type, $type_jp);
        }

        if ($addType === false) {
            setFlash('Le type n\'a pas été ajouté', 'danger');
            throw new Exception();
        }

        setFlash('Le type a bien été crée');
        header('Location:index.php?p=type');
    } else header('Location:index.php?p=accueil');
}

function deleteType($id)
{
    if (connect_admin()) {
        $deleteType = supprType($id);
        if ($deleteType === false) {
            setFlash('Le type n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le type a bien été supprimé');
        header('Location:index.php?p=type');
    } else header('Location:index.php?p=accueil');
}

/**
 * Anglais
 */


function addAnglais($id, $anglais)
{
    if (connect_admin()) {
        $anglais = securize($anglais);

        if ($id > 0) {
            editAnglais($anglais, $id);
        } else {
            if (empty(researchAnglais($anglais))) createAnglais($anglais);
        }
    } else header('Location:index.php?p=accueil');
}

/**
 * Kanji
 */

function saveKanji()
{
    if (connect_admin()) {
        $addKanji = editKanji($_POST['id'], $_POST['on_yomi'], $_POST['kun_yomi'], $_POST['sens'], $_POST['sens_en']);
        if ($addKanji === false) {
            setFlash('Le kanji n\'a pas été sauvegardé', 'danger');
            throw new Exception();
        }
        setFlash('Le kanji a bien été sauvegardé');
        header('Location:index.php?p=kanjis');
    } else header('Location:index.php?p=accueil');
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

function addRecompense()
{
    if (connect_admin()) {
        if (preg_match('/^[a-z\-0-9]+$/', $_POST['slug'])) {
            if ($_GET['id'] > 0) {
                $addRecompense = editRecompense($_GET['id'], $_POST['libelle'], $_POST['cout'], $_POST['slug'], $_POST['id_type']);
            } else {
                $addRecompense = createRecompense($_POST['libelle'], $_POST['cout'], $_POST['slug'], $_POST['id_type']);
            }

            if ($addRecompense === false) {
                setFlash('La récompense n\'a pas été ajouté', 'danger');
                throw new Exception();
            }

            setFlash('La récompense a bien été crée');
            header('Location:index.php?p=recompense');
        } else {
            setFlash("Le slug n'est pas valide", 'danger');
        }
    } else header('Location:index.php?p=accueil');
}

function deleteRecompense($id)
{
    if (connect_admin()) {
        $delete = supprRecompense($id);
        if ($delete === false) {
            setFlash('La récompense n\'a pas été supprimée', 'danger');
            throw new Exception();
        }

        setFlash('La récompense a bien été supprimée');
        header('Location:index.php?p=recompense');
    } else header('Location:index.php?p=accueil');
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