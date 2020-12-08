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

function researchWordBack($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.FRANCAIS where francais like '$search'");
    return $select->fetch();
}

function editWord($fr, $id)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.FRANCAIS set francais=$fr where id=$id");
}

function createWord($francais)
{
    $db = dbConnect();
    $francais = $db->quote($francais);
    $db->query("insert into lexiqumjaponais.FRANCAIS set francais=$francais");
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
    $select = $db->query("select * from lexiqumjaponais.JAPONAIS order by romaji");
    return $select->fetchAll();
}

function testJaponaisID($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.JAPONAIS where id=$id");
}

function editJaponais($kana, $kanji, $romaji, $description, $id_type, $id)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $description = $db->quote($description);
    $id_type = $db->quote($id_type);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji, description=$description, id_type=$id_type where id=$id");
}

function createJaponais($kana, $kanji, $romaji, $description, $id_type)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $description = $db->quote($description);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji, description=$description, id_type=$id_type");
}

function researchJaponais($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select id, kanji from lexiqumjaponais.JAPONAIS where romaji like $search");
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

function editAnglais($anglais, $id)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.ANGLAIS set anglais=$anglais where id=$id");
}

function createAnglais($anglais)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    return $db->query("insert into lexiqumjaponais.ANGLAIS set anglais=$anglais");
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

function selectJaponaisAndFrancais($id_francais, $id_japonais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select * from lexiqumjaponais.TRADUCTION where id_word=$id_francais and id_japonais=$id_japonais");
    return $select->fetchAll();
}

function createJaponaisAndFrancais($id_francais, $id_japonais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    return $db->query("insert into lexiqumjaponais.TRADUCTION set id_word=$id_francais, id_japonais=$id_japonais");
}

function selectAnglaisAndJaponais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select * from lexiqumjaponais.TRADUCTION where id_japonais=$id_japonais and id_anglais=$id_anglais");
    return $select->fetchAll();
}

function createAnglaisAndJaponais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    return $db->query("insert into lexiqumjaponais.TRADUCTION set id_japonais=$id_japonais, id_anglais=$id_anglais");
}

function listJaponaisToFrancais($id_francais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, JAPONAIS.description from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION t
        on t.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on t.id_word = FRANCAIS.id
    where FRANCAIS.id=$id_francais");
    return $select->fetchAll();
}

function listAnglaisToFrancais($id_francais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $select = $db->query("select ANGLAIS.id, ANGLAIS.anglais from lexiqumjaponais.ANGLAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_anglais = ANGLAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.id=$id_francais");
    return $select->fetchAll();
}

function listFrancaisToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id_japonais");
    return $select->fetchAll();
}

function listAnglaisToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select ANGLAIS.id, ANGLAIS.anglais from lexiqumjaponais.ANGLAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_anglais = ANGLAIS.id
    inner join lexiqumjaponais.JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id_japonais");
    return $select->fetchAll();
}

function listFrancaisToAnglais($id_anglais)
{
    $db = dbConnect();
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.ANGLAIS
        on wj.id_anglais = ANGLAIS.id
    where ANGLAIS.id=$id_anglais");
    return $select->fetchAll();
}

function listJaponaisToAnglais($id_anglais)
{
    $db = dbConnect();
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, JAPONAIS.description from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.ANGLAIS
        on wj.id_anglais = ANGLAIS.id
    where ANGLAIS.id=$id_anglais");
    return $select->fetchAll();
}

function listFrancaisAndJaponaisWhereGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, JAPONAIS.id_type, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, JAPONAIS.description  from lexiqumjaponais.GROUPE
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_groupe = GROUPE.id
    inner join lexiqumjaponais.FRANCAIS
        on wg.id_word = FRANCAIS.id
    inner join lexiqumjaponais.TRADUCTION as wj
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
    $db->exec("delete from lexiqumjaponais.TRADUCTION where id_word=$id");
}

function deleteAllForAnglais($id_anglais)
{
    $db = dbConnect();
    $id = $db->quote($id_anglais);
    $db->exec("delete from lexiqumjaponais.TRADUCTION where id_anglais=$id");
}

/**
 * Francais - Groupe
 */

function listGroupeToWord($id_francais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $select = $db->query("select FRANCAIS.id, GROUPE.id, GROUPE.libelle from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = FRANCAIS.id
    inner join lexiqumjaponais.GROUPE
        on wg.id_groupe = GROUPE.id
    where FRANCAIS.id=$id_francais");
    return $select->fetchAll();
}

function listWordToGroupe($id_groupe)
{
    $db = dbConnect();
    $id_groupe = $db->quote($id_groupe);
    $select = $db->query("select francais from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.WORDS_GROUPE as wg
        on wg.id_word = FRANCAIS.id
    inner join lexiqumjaponais.GROUPE
        on wg.id_groupe = GROUPE.id
    where GROUPE.id=$id_groupe");
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
    $select = $db->query('select id, type, type_jp from lexiqumjaponais.TYPE order by type');
    return $select->fetchAll();
}

function testType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, type, type_jp from lexiqumjaponais.TYPE where id=$id");
}

function createType($type, $type_jp)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $type_jp = $db->quote($type_jp);
    return $db->query("insert into lexiqumjaponais.TYPE set type=$type, type_jp=$type_jp");
}

function editType($id, $type, $type_jp)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $type_jp = $db->quote($type_jp);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.TYPE set type=$type, type_jp=$type_jp where id=$id");
}

function supprType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->exec("update lexiqumjaponais.JAPONAIS set id_type=null where id_type=$id");
    return $db->query("delete from lexiqumjaponais.TYPE where id=$id");
}

/**
 * Japonais - Kanji
 */

function deleteAllKanjiForJaponais($id_japonais)
{
    $db = dbConnect();
    $id = $db->quote($id_japonais);
    $db->exec("delete from lexiqumjaponais.JAPONAIS_KANJI where id_japonais=$id");
}

function addKanjiJaponais($id_japonais, $id_kanji)
{
    $db = dbConnect();
    $db->exec("insert into lexiqumjaponais.JAPONAIS_KANJI set id_japonais=$id_japonais, id_kanji=$id_kanji");
}

function testKanjiJaponais($id_japonais, $id_kanji)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.JAPONAIS_KANJI where id_japonais=$id_japonais and id_kanji=$id_kanji");
    return $select->fetch();
}

function listKanjiToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select KANJI.* from lexiqumjaponais.KANJI
        inner join lexiqumjaponais.JAPONAIS_KANJI jk on KANJI.id = jk.id_kanji
        where id_japonais=$id_japonais");
    return $select->fetchAll();
}

function listJaponaisToKanji($id_kanji)
{
    $db = dbConnect();
    $id_kanji = $db->quote($id_kanji);
    $select = $db->query("select JAPONAIS.* from lexiqumjaponais.JAPONAIS
        inner join lexiqumjaponais.JAPONAIS_KANJI jk on JAPONAIS.id = jk.id_japonais
        where id_kanji=$id_kanji");
    return $select->fetchAll();
}

/**
 * Kanji
 */

function listKanji()
{
    $db = dbConnect();
    $select = $db->query("select id, kanji, grade from lexiqumjaponais.KANJI");
    return $select->fetchAll();
}

function testKanji($id_kanji)
{
    $db = dbConnect();
    $id = $db->quote($id_kanji);
    return $db->query("select * from lexiqumjaponais.KANJI where id=$id");
}

function editKanji($id, $on, $kun, $sens, $sens_en)
{
    $db = dbConnect();
    $sens = $db->quote($sens);
    $kun = $db->quote($kun);
    $sens_en = $db->quote($sens_en);
    $on = $db->quote($on);
    $id = $db->quote($id);
    return $db->query("update lexiqumjaponais.KANJI set on_yomi=$on, sens=$sens, kun_yomi=$kun, sens_en=$sens_en where id=$id");
}

function testKanjiContains($kanji)
{
    $db = dbConnect();
    $kanji = $db->quote($kanji);
    return $db->query("select id from lexiqumjaponais.KANJI where kanji like $kanji");
}

/**
 * Recompense
 */

function testRecompense($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from lexiqumjaponais.RECOMPENSE where id=$id");
}

function listRecompense()
{
    $db = dbConnect();
    $select = $db->query("select RECOMPENSE.id, libelle, cout, date_parution, type from lexiqumjaponais.RECOMPENSE 
    inner join lexiqumjaponais.RECOMPENSE_TYPE rt on RECOMPENSE.id_type = rt.id
    order by libelle");
    return $select->fetchAll();
}

function createRecompense($libelle, $cout, $slug, $id_type)
{
    $db = dbConnect();
    $libelle = $db->quote($libelle);
    $cout = $db->quote($cout);
    $slug = $db->quote($slug);
    $id_type = $db->quote($id_type);
    return $db->query("insert into lexiqumjaponais.RECOMPENSE set libelle=$libelle, cout=$cout, date_parution=curdate(), slug=$slug, id_type=$id_type");
}

function editRecompense($id, $libelle, $cout, $slug, $id_type)
{
    $db = dbConnect();
    $libelle = $db->quote($libelle);
    $cout = $db->quote($cout);
    $id = $db->quote($id);
    $slug = $db->quote($slug);
    $id_type = $db->quote($id_type);
    return $db->query("update lexiqumjaponais.RECOMPENSE set libelle=$libelle, cout=$cout, slug=$slug, id_type=$id_type where id=$id");
}

function supprRecompense($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from lexiqumjaponais.ACHAT where id_recompense=$id");
    return $db->query("delete from lexiqumjaponais.RECOMPENSE where id=$id");
}

function listTypeRecompense()
{
    $db = dbConnect();
    $select = $db->query('select id, type from lexiqumjaponais.RECOMPENSE_TYPE order by type asc');
    return $select->fetchAll();
}

/**
 * Achat
 */

function listAchateurFromRecompense($id_recompense)
{
    $db = dbConnect();
    $id_recompense = $db->quote($id_recompense);
    $select = $db->query("select USER.pseudo from lexiqumjaponais.ACHAT
        inner join lexiqumjaponais.USER on achat.id_user = user.id
        where id_recompense=$id_recompense");
    return $select->fetchAll();
}