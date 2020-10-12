<?php

/**
 * Groupes
 */

function createGroupe($libelle)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('insert into lexiqumjaponais.GROUPE(libelle) values(?)');
    $addGroupe = $addGroupe->execute(array($libelle));
    return $addGroupe;
}

function editGroupe($id, $libelle)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $libelle = $db->quote($libelle);
    $editGroupe = $db->query("update lexiqumjaponais.GROUPE set libelle=$libelle where id=$id");
    return $editGroupe;
}

function supprGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from lexiqumjaponais.GROUPE where id=?');
    $select = $select->execute(array($id));
    return $select;
}

function listGroupe()
{
    $db = dbConnect();
    $select = $db->query('select id, libelle from lexiqumjaponais.GROUPE');
    return $select->fetchAll();
}

function testGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, libelle from lexiqumjaponais.GROUPE where id=$id");
}

/**
 * Mots
 */

function testWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.WORDS where id=$id");
}

function listWords()
{
    $db = dbConnect();
    $select = $db->query("select id, fr, kana, kanji, romaji from lexiqumjaponais.WORDS order by fr asc");
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
    return $db->query("update lexiqumjaponais.WORDS set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type where id=$id");
}

function createWord($fr, $kana, $kanji, $romaji, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.WORDS set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type");
}

function supprWord($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from lexiqumjaponais.WORDS where id=?');
    $select = $select->execute(array($id));
    return $select;
}

/**
 * Groupe - Mots
 */

function listGroupeToWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select WORDS.id, GROUPE.* from lexiqumjaponais.WORDS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = WORDS.id
    inner join lexiqumjaponais.GROUPE
        on wg.id_groupe = GROUPE.id
    where WORDS.id=$id");
    return $select->fetchAll();
}

function listWordToGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select WORDS.*, GROUPE.id from lexiqumjaponais.WORDS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = WORDS.id
    inner join lexiqumjaponais.GROUPE
        on wg.id_groupe = GROUPE.id
    where GROUPE.id=$id");
    return $select->fetchAll();
}

function addGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $word = $db->quote($id);
    $groupe = $db->quote($id_groupe);
    return $db->query("insert into lexiqumjaponais.WORDS_GROUPE set id_word=$word, id_groupe=$groupe");
}

function deleteGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $idWord = $db->quote($id);
    $idGroupe = $db->quote($id_groupe);
    return $db->query("delete from lexiqumjaponais.WORDS_GROUPE where id_word=$idWord and id_groupe=$idGroupe");
}

function deleteAllGroupeForWord($id_word)
{
    $db = dbConnect();
    $id = $db->quote($id_word);
    $db->query("delete from lexiqumjaponais.WORDS_GROUPE where id_word=$id");
}

function deleteAllGroupeForGroupe($id_groupe)
{
    $db = dbConnect();
    $id = $db->quote($id_groupe);
    $db->query("delete from lexiqumjaponais.WORDS_GROUPE where id_groupe=$id");
}

/**
 * Type
 */

function listType()
{
    $db = dbConnect();
    $select = $db->query('select id, type from lexiqumjaponais.TYPE order by type asc');
    return $select->fetchAll();
}

function testType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.TYPE where id=$id");
}

function createType($type)
{
    $db = dbConnect();
    $type = $db->quote($type);
    return $db->query("insert into lexiqumjaponais.TYPE set type=$type");
}

function editType($id, $type)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.TYPE set type=$type where id=$id");
}

function supprType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("update lexiqumjaponais.WORDS set id_type=null where id_type=$id");
    return $db->query("delete from lexiqumjaponais.TYPE where id=$id");
}