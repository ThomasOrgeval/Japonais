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
 * Francais
 */

function testWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.FRANCAIS where id=$id");
}

function listWords()
{
    $db = dbConnect();
    $select = $db->query("select id, francais from lexiqumjaponais.FRANCAIS order by francais asc");
    return $select->fetchAll();
}

function editWord($fr, $id, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $id_type = $db->quote($id_type);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.FRANCAIS set francais=$fr, id_type=$id_type  where id=$id");
}

function createWord($fr, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.FRANCAIS set francais=$fr, id_type=$id_type");
}

function supprWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from lexiqumjaponais.FRANCAIS where id=$id");
}

/**
 * Japonais
 */

function listJaponais()
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.JAPONAIS");
    return $select->fetchAll();
}

function testJaponais($kanji, $kana, $romaji)
{
    $db = dbConnect();
    $kanji = $db->quote($kanji);
    $kana = $db->quote($kana);
    $romaji = $db->quote($romaji);
    $select = $db->query("select * from lexiqumjaponais.JAPONAIS where kanji like $kanji and kana like $kana and romaji like $romaji");
    return $select->fetch();
}

function testJaponaisID($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.JAPONAIS where id=$id");
}

function editJaponais($kana, $kanji, $romaji, $id)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji where id=$id");
}

function createJaponais($kana, $kanji, $romaji)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    return $db->query("insert into lexiqumjaponais.JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji");
}

function researchJaponais($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select id from lexiqumjaponais.JAPONAIS where romaji like $search");
    return $select->fetch();
}

function supprJaponais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from lexiqumjaponais.JAPONAIS where id=$id");
}

/**
 * Anglais
 */

function testAnglais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.ANGLAIS where id=$id");
}

function listAnglais()
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.ANGLAIS order by anglais asc");
    return $select->fetchAll();
}

function editAnglais($anglais, $id, $id_type)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    $id = $db->quote($id);
    $id_type = $db->quote($id_type);
    return $db->query("update lexiqumjaponais.ANGLAIS set anglais=$anglais, id_type=$id_type where id=$id");
}

function createAnglais($anglais, $id_type)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.ANGLAIS set anglais=$anglais, id_type=$id_type");
}

function supprAnglais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from lexiqumjaponais.ANGLAIS where id=$id");
}

function researchAnglais($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select id from lexiqumjaponais.ANGLAIS where anglais like $search");
    return $select->fetch();
}

/**
 * Francais - Japonais - Anglais
 */

function listAllJaponaisAndFrancais()
{
    $db = dbConnect();
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.ANGLAIS
        on wj.id_anglais = ANGLAIS.id");
    return $select->fetchAll();
}

function selectJaponaisAndFrancais($id_francais, $id_japonais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select * from lexiqumjaponais.WORDS_JAPONAIS where id_word=$id_francais and id_japonais=$id_japonais");
    return $select->fetchAll();
}

function createJaponaisAndFrancais($id_francais, $id_japonais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    return $db->query("insert into lexiqumjaponais.WORDS_JAPONAIS set id_word=$id_francais, id_japonais=$id_japonais");
}

function selectAnglaisAndFrancais($id_francais, $id_anglais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select * from lexiqumjaponais.WORDS_JAPONAIS where id_word=$id_francais and id_anglais=$id_anglais");
    return $select->fetchAll();
}

function createAnglaisAndFrancais($id_francais, $id_anglais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_anglais = $db->quote($id_anglais);
    return $db->query("insert into lexiqumjaponais.WORDS_JAPONAIS set id_word=$id_francais, id_anglais=$id_anglais");
}

function selectAnglaisAndJaponais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select * from lexiqumjaponais.WORDS_JAPONAIS where id_japonais=$id_japonais and id_anglais=$id_anglais");
    return $select->fetchAll();
}

function createAnglaisAndJaponais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    return $db->query("insert into lexiqumjaponais.WORDS_JAPONAIS set id_japonais=$id_japonais, id_anglais=$id_anglais");
}

function selectTraductionAll($id_francais, $id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select * from lexiqumjaponais.WORDS_JAPONAIS where id_word=$id_francais and id_japonais=$id_japonais and id_anglais=$id_anglais");
    return $select->fetchAll();
}

function createTraductionAll($id_francais, $id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    return $db->query("insert into lexiqumjaponais.WORDS_JAPONAIS set id_word=$id_francais, id_japonais=$id_japonais, id_anglais=$id_anglais");
}

function listJaponaisToFrancais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.id=$id");
    return $select->fetchAll();
}

function listAnglaisToFrancais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select ANGLAIS.id, ANGLAIS.anglais, ANGLAIS.id_type from lexiqumjaponais.ANGLAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_anglais = ANGLAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.id=$id");
    return $select->fetchAll();
}

function listFrancaisToJaponais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, FRANCAIS.id_type from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id");
    return $select->fetchAll();
}

function listAnglaisToJaponais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select ANGLAIS.id, ANGLAIS.anglais, ANGLAIS.id_type from lexiqumjaponais.ANGLAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_anglais = ANGLAIS.id
    inner join lexiqumjaponais.JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id");
    return $select->fetchAll();
}

function listFrancaisToAnglais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, FRANCAIS.id_type from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.ANGLAIS
        on wj.id_anglais = ANGLAIS.id
    where ANGLAIS.id=$id");
    return $select->fetchAll();
}

function listJaponaisToAnglais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.ANGLAIS
        on wj.id_anglais = ANGLAIS.id
    where ANGLAIS.id=$id");
    return $select->fetchAll();
}

function listFrancaisAndJaponaisWhereGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, FRANCAIS.id_type, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.GROUPE
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_groupe = GROUPE.id
    inner join lexiqumjaponais.FRANCAIS
        on wg.id_word = FRANCAIS.id
    inner join lexiqumjaponais.WORDS_JAPONAIS as wj
    	on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.JAPONAIS
    	on wj.id_japonais = JAPONAIS.id
    where GROUPE.id=$id");
    return $select->fetchAll();
}

function deleteAllForFrancais($id_francais)
{
    $db = dbConnect();
    $id = $db->quote($id_francais);
    $db->query("delete from lexiqumjaponais.WORDS_JAPONAIS where id_word=$id");
}

function deleteAllForJaponais($id_japonais)
{
    $db = dbConnect();
    $id = $db->quote($id_japonais);
    $db->query("delete from lexiqumjaponais.WORDS_JAPONAIS where id_japonais=$id");
}

function deleteAllForAnglais($id_anglais)
{
    $db = dbConnect();
    $id = $db->quote($id_anglais);
    $db->query("delete from lexiqumjaponais.WORDS_JAPONAIS where id_anglais=$id");
}

/**
 * Francais - Groupe
 */

function listGroupeToWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.id, GROUPE.id, GROUPE.libelle from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = FRANCAIS.id
    inner join lexiqumjaponais.GROUPE
        on wg.id_groupe = GROUPE.id
    where FRANCAIS.id=$id");
    return $select->fetchAll();
}

function listWordToGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.*, GROUPE.id from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = FRANCAIS.id
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
    $db->query("update lexiqumjaponais.FRANCAIS set id_type=null where id_type=$id");
    return $db->query("delete from lexiqumjaponais.TYPE where id=$id");
}

/**
 * Japonais - Kanji
 */

function deleteAllKanjiForJaponais($id_japonais)
{
    $db = dbConnect();
    $id = $db->quote($id_japonais);
    $db->query("delete from lexiqumjaponais.JAPONAIS_KANJI where id_japonais=$id");
}

function deleteAllJaponaisForKanji($id_kanji)
{
    $db = dbConnect();
    $id = $db->quote($id_kanji);
    $db->query("delete from lexiqumjaponais.JAPONAIS_KANJI where id_kanji=$id");
}

/**
 * Kanji
 */

function listKanji()
{
    $db = dbConnect();
    $select = $db->query("select id, kanji, grade from lexiqumjaponais.KANJI order by grade asc");
    return $select->fetchAll();
}

/**
 * Recompense
 */

function listRecompense()
{
    $db = dbConnect();
    $select = $db->query("select id, libelle, cout from lexiqumjaponais.RECOMPENSE order by libelle");
    return $select->fetchAll();
}