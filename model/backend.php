<?php

/**
 * Groupes
 */

function createGroupe($libelle)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('insert into lexiqumjaponais.groupe(libelle) values(?)');
    $addGroupe = $addGroupe->execute(array($libelle));
    return $addGroupe;
}

function editGroupe($id, $libelle)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $libelle = $db->quote($libelle);
    $editGroupe = $db->query("update lexiqumjaponais.groupe set libelle=$libelle where id=$id");
    return $editGroupe;
}

function supprGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from lexiqumjaponais.groupe where id=?');
    $select = $select->execute(array($id));
    return $select;
}

function listGroupe()
{
    $db = dbConnect();
    $select = $db->query('select id, libelle from lexiqumjaponais.groupe');
    return $select->fetchAll();
}

function testGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, libelle from lexiqumjaponais.groupe where id=$id");
}

/**
 * Mots
 */

function testWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.words where id=$id");
}

function listWords()
{
    $db = dbConnect();
    $select = $db->query("select id, fr, kana, kanji, romaji from lexiqumjaponais.words order by fr asc");
    return $select->fetchAll();
}

function editWord($fr, $kana, $kanji, $romaji, $id, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id_type = $db->quote($id_type);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type where id=$id");
}

function createWord($fr, $kana, $kanji, $romaji, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type");
}

function supprWord($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from lexiqumjaponais.words where id=?');
    $select = $select->execute(array($id));
    return $select;
}

/**
 * Groupe - Mots
 */

function listGroupeToWord()
{
    $db = dbConnect();
    if (isset($_GET['id'])) {
        $id = $db->quote($_GET['id']);
        $select = $db->query("select words.id, groupe.* from lexiqumjaponais.words
    inner join lexiqumjaponais.words_groupe as wg
        on wg.id_word = words.id
    inner join lexiqumjaponais.groupe
        on wg.id_groupe = groupe.id
    where words.id=$id");
    } else {
        return null;
    }
    return $select->fetchAll();
}

function addGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $word = $db->quote($id);
    $groupe = $db->quote($id_groupe);
    return $db->query("insert into lexiqumjaponais.words_groupe set id_word=$word, id_groupe=$groupe");
}

function deleteGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $idWord = $db->quote($id);
    $idGroupe = $db->quote($id_groupe);
    return $db->query("delete from lexiqumjaponais.words_groupe where id_word=$idWord and id_groupe=$idGroupe");
}

function deleteAllGroupeForWord($id_word)
{
    $db = dbConnect();
    $id = $db->quote($id_word);
    $db->query("delete from lexiqumjaponais.words_groupe where id_word=$id");
}

function deleteAllGroupeForGroupe($id_groupe)
{
    $db = dbConnect();
    $id = $db->quote($id_groupe);
    $db->query("delete from lexiqumjaponais.words_groupe where id_groupe=$id");
}

/**
 * Type
 */

function listType()
{
    $db = dbConnect();
    $select = $db->query('select id, type from lexiqumjaponais.type order by type asc');
    return $select->fetchAll();
}