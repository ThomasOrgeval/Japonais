<?php

require './model/backend.php';

function admin_portail()
{
    if (connect_admin()) {
        require './view/backend/index.php';
    }
}

function groupe()
{
    if (connect_admin()) {
        $groupes = listGroupe();
        require './view/backend/groupe.php';
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
        require 'view/backend/groupe_edit.php';
    }
}

function word()
{
    if (connect_admin()) {
        $_POST['words'] = listWords();
        require './view/backend/word.php';
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
            $groupes = listGroupeToWord($_GET['id']);
            $otherGroupes = otherGroupeToWord();
            if ($word->rowCount() == 0) {
                setFlash("Il n'y a pas de mot avec cet ID", "danger");
                header("Location:index.php?p=word");
            }
            $_POST = $word->fetch();
        }
        require './view/backend/word_edit.php';
    }
}

function francais_add()
{
    $japonais = array();

    for ($i = 1; $i <= $_POST['nombre']; $i++) {
        addJaponaisFromFrancais($_POST['id_jap' . $i], $_POST['kanji' . $i], $_POST['kana' . $i], $_POST['romaji' . $i]);
        array_push($japonais, $_POST['romaji' . $i]);
    }
    addFrancais($_GET['id'], $_POST['francais'], $_POST['id_type'], $japonais);
}

function type()
{
    if (connect_admin()) {
        $types = listType();
        require './view/backend/type.php';
    }
}

function type_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $type = testType($_GET['id']);
            if ($type->rowCount() == 0) {
                setFlash("Il n'y a pas de type avec cet ID", "danger");
                header("Location:index.php?p=type");
            }
            $_POST = $type->fetch();
        }
        require './view/backend/type_edit.php';
    }
}

function japonais()
{
    if (connect_admin()) {
        $_POST['japonais'] = listJaponais();
        require './view/backend/japonais.php';
    }
}

function japonais_edit()
{
    if (connect_admin()) {
        $types = listType();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $japonais = testJaponaisID($_GET['id']);
            if ($japonais->rowCount() == 0) {
                setFlash("Il n'y a pas de mot japonais avec cet ID", "danger");
                header("Location:index.php?p=type");
            }
            $_POST = $japonais->fetch();
        }
        require './view/backend/japonais_edit.php';
    }
}

function japonais_add()
{
    $francais = array();

    for ($i = 1; $i <= $_POST['nombre']; $i++) {
        addFrancaisFromJaponais($_POST['id_francais' . $i], $_POST['francais' . $i], $_POST['id_type' . $i]);
        array_push($francais, $_POST['francais' . $i]);
    }
    addJaponais($_GET['id'], $_POST['kanji'], $_POST['kana'], $_POST['romaji'], $francais);
}

function connect_admin()
{
    if ($_SESSION['connect'] != 'OK' || $_SESSION['admin'] == 0) {
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

function exportxml()
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<pages>
';

    $words = listWords();
    foreach ($words as $word) {
        $xml .= '    <link>
';
        $xml .= '        <title>' . $word['francais'] . '</title>
';
        $xml .= '        <url>index.php?p=search&amp;t=word&amp;q=' . $word['francais'] . '</url>
';
        $xml .= '    </link>
';
    }
    $groupes = listGroupe();
    foreach ($groupes as $groupe) {
        $xml .= '    <link>
';
        $xml .= '        <title>' . $groupe['libelle'] . '</title>
';
        $xml .= '        <url>index.php?p=search&amp;t=groupe&amp;q=' . $groupe['libelle'] . '</url>
';
        $xml .= '    </link>
';
    }

    $xml .= '</pages>';
    $fp = fopen("links.xml", 'w+');
    fputs($fp, $xml);
    fclose($fp);
    setFlash('Export xml réussi');
    header('Location:index.php?p=accueil');
}

/**
 * Groupe
 */

function addGroupe($libelle, $id)
{
    $libelle = securize($libelle);

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
 * Francais
 */

function addFrancaisFromJaponais($id, $francais, $id_type)
{
    $francais = securize($francais);

    if ($id > 0) {
        editWord($francais, $id, $id_type);
    } else {
        createWord($francais, $id_type);
    }
}

function addFrancais($id, $francais, $id_type, $listJaponais)
{
    $francais = securize($francais);

    if ($id > 0) {
        $addWord = editWord($francais, $id, $id_type);
    } else {
        $addWord = createWord($francais, $id_type);
        $id = researchWord($francais);
        $id = $id['id'];
    }

    foreach ($listJaponais as $japonais) {
        $id_japonais = researchJaponais($japonais);
        if (empty(selectJaponaisAndFrancais($id, $id_japonais['id']))) {
            createJaponaisAndFrancais($id, $id_japonais['id']);
        }
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
    deleteAllJaponaisForWord($id);
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
    $listePresent = listGroupeToWord($_GET['id']);
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
 * Type
 */

function addType($id, $type)
{
    $type = securize($type);

    if ($id > 0) {
        $addType = editType($id, $type);
    } else {
        $addType = createType($type);
    }

    if ($addType === false) {
        setFlash('Le type n\'a pas été ajouté', 'danger');
        throw new Exception();
    } else {
        setFlash('Le type a bien été crée');
        header('Location:index.php?p=type');
    }
}

function deleteType($id)
{
    $deleteType = supprType($id);
    if ($deleteType === false) {
        setFlash('Le type n\'a pas été supprimé', 'danger');
        throw new Exception();
    } else {
        setFlash('Le type a bien été supprimé');
        header('Location:index.php?p=type');
    }
}

/**
 * Japonais
 */

function addJaponaisFromFrancais($id, $kanji, $kana, $romaji)
{
    $kanji = securize($kanji);
    $kana = securize($kana);
    $romaji = securize($romaji);

    if ($id > 0) {
        editJaponais($kana, $kanji, $romaji, $id);
    } else {
        createJaponais($kana, $kanji, $romaji);
    }
}

function addJaponais($id, $kanji, $kana, $romaji, $listFrancais)
{
    $kanji = securize($kanji);
    $kana = securize($kana);
    $romaji = securize($romaji);

    if ($id > 0) {
        $addWord = editJaponais($kana, $kanji, $romaji, $id);
    } else {
        $addWord = createJaponais($kana, $kanji, $romaji);
        $id = researchJaponais($romaji);
        $id = $id['id'];
    }

    foreach ($listFrancais as $francais) {
        $id_francais = researchWord($francais);
        if (empty(selectJaponaisAndFrancais($id_francais['id'], $id))) {
            createJaponaisAndFrancais($id_francais['id'], $id);
        }
    }

    if ($addWord === false) {
        setFlash('Le mot n\'a pas été ajouté', 'danger');
        throw new Exception();
    } else {
        setFlash('Le mot a bien été crée');
        header('Location:index.php?p=japonais');
    }
}

function deleteJaponais($id)
{
    deleteAllWordForJaponais($id);
    $deleteJaponais = supprJaponais($id);
    if ($deleteJaponais === false) {
        setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
        throw new Exception();
    } else {
        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=japonais');
    }
}