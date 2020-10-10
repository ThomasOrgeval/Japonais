<?php

require './model/backend.php';

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
        $words = listWords();
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
            $groupes = listGroupeToWord();
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
        $xml .= '        <title>' . $word['fr'] . '</title>
';
        $xml .= '        <url>index.php?p=search&amp;t=word&amp;q=' . $word['fr'] . '</url>
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
 * Word
 */

function addWord($fr, $kana, $kanji, $romaji, $id, $id_type)
{
    $fr = securize($fr);
    $kana = securize($kana);
    $kanji = securize($kanji);
    $romaji = securize($romaji);

    if ($id > 0) {
        $addWord = editWord($fr, $kana, $kanji, $romaji, $id, $id_type);
    } else {
        $addWord = createWord($fr, $kana, $kanji, $romaji, $id_type);
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
    $listePresent = listGroupeToWord();
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