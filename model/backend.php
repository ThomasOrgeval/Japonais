<?php

function isAdmin($pseudo): bool
{
    $db = dbConnect();
    $pseudo = $db->quote($pseudo);
    return $db->query("select droits from USER where pseudo like $pseudo")->fetch()['droits'];
}

/**
 * Groupes
 */

function createGroupe($libelle, $id_parent, $quantifieur, $slug)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('insert into GROUPE(libelle, id_parent, quantifieur, slug) values(?, ?, ?, ?)');
    return $addGroupe->execute(array($libelle, $id_parent, $quantifieur, $slug));
}

function editGroupe($id, $libelle, $id_parent, $quantifieur, $slug)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('update GROUPE set libelle=?, id_parent=?, quantifieur=?, slug=? where id=?');
    return $addGroupe->execute(array($libelle, $id_parent, $quantifieur, $slug, $id));
}

function supprGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from GROUPE where id=?');
    $select = $select->execute(array($id));
    return $select;
}

function listGroupe()
{
    $db = dbConnect();
    $select = $db->query('select id, libelle from GROUPE order by libelle');
    return $select->fetchAll();
}

function testGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare("select id, libelle, id_parent, quantifieur from GROUPE where id=?");
    $select->execute(array($id));
    return $select->fetch();
}

function nbrGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select id, libelle, id_parent, quantifieur from GROUPE where id=$id");
    return $select->rowCount();
}

/**
 * Francais
 */

function researchFrBack($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select id from FRANCAIS where francais like $search");
    return $select->fetch();
}

function editWord($fr, $id, $slug)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $id = $db->quote($id);
    $slug = $db->quote($slug);
    return $db->query("update FRANCAIS set francais=$fr, slug=$slug where id=$id");
}

function createWord($francais, $slug)
{
    $db = dbConnect();
    $francais = $db->quote($francais);
    $slug = $db->quote($slug);
    $db->query("insert into FRANCAIS set francais=$francais, slug=$slug");
}

function supprWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from FRANCAIS where id=$id");
}

/**
 * Japonais
 */

function listJaponais()
{
    $db = dbConnect();
    $select = $db->query("select j.id, kanji, kana, romaji, francais from JAPONAIS j
        left join TRADUCTION t on j.id = t.id_japonais
        inner join FRANCAIS f on t.id_word = f.id
        group by kanji, romaji order by romaji");
    return $select->fetchAll();
}

function getJaponais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, kanji, kana, romaji, description, id_type, jlpt from JAPONAIS where id = $id")->fetch();
}

function testJaponaisID($id): bool
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id from JAPONAIS where id = $id")->rowCount() === 1;
}

function editJaponais($kana, $kanji, $romaji, $description, $id_type, $id, $jlpt)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $description = $db->quote($description);
    $id_type = $db->quote($id_type);
    $id = $db->quote($id);
    $jlpt = $db->quote($jlpt);
    return $db->query("update JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji, description=$description, id_type=$id_type, jlpt=$jlpt where id=$id");
}

function createJaponais($kana, $kanji, $romaji, $description, $id_type, $jlpt)
{
    $db = dbConnect();
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $description = $db->quote($description);
    $id_type = $db->quote($id_type);
    $jlpt = $db->quote($jlpt);
    return $db->query("insert into JAPONAIS set kanji=$kanji, kana=$kana, romaji=$romaji, description=$description, id_type=$id_type, jlpt=$jlpt");
}

function researchJaponais($romaji, $kanji)
{
    $db = dbConnect();
    $romaji = $db->quote($romaji);
    $kanji = $db->quote($kanji);
    $select = $db->query("select id, kanji from JAPONAIS where romaji like $romaji and kanji like $kanji");
    return $select->fetch();
}

function supprJaponais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from TRADUCTION where id_japonais=$id");
    return $db->query("delete from JAPONAIS where id=$id");
}

/**
 * Anglais
 */

function editAnglais($anglais, $id)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    $id = $db->quote($id);
    return $db->query("update ANGLAIS set anglais=$anglais where id=$id");
}

function createAnglais($anglais)
{
    $db = dbConnect();
    $anglais = $db->quote($anglais);
    return $db->query("insert into ANGLAIS set anglais=$anglais");
}

function supprAnglais($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from ANGLAIS where id=$id");
}

function researchAnglais($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select id from ANGLAIS where anglais like $search");
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
    $select = $db->query("select * from TRADUCTION where id_word=$id_francais and id_japonais=$id_japonais");
    return $select->fetchAll();
}

function createJaponaisAndFrancais($id_francais, $id_japonais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    $id_japonais = $db->quote($id_japonais);
    return $db->query("insert into TRADUCTION set id_word=$id_francais, id_japonais=$id_japonais");
}

function selectAnglaisAndJaponais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    $select = $db->query("select * from TRADUCTION where id_japonais=$id_japonais and id_anglais=$id_anglais");
    return $select->fetchAll();
}

function createJaponaisAndAnglais($id_japonais, $id_anglais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_anglais = $db->quote($id_anglais);
    return $db->query("insert into TRADUCTION set id_japonais=$id_japonais, id_anglais=$id_anglais");
}

function listFrancaisToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais from FRANCAIS
    inner join TRADUCTION as wj
        on wj.id_word = FRANCAIS.id
    where id_japonais=$id_japonais");
    return $select->fetchAll();
}

function listAnglaisToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select ANGLAIS.id, ANGLAIS.anglais from ANGLAIS
    inner join TRADUCTION as wj
        on wj.id_anglais = ANGLAIS.id
    where id_japonais=$id_japonais");
    return $select->fetchAll();
}

function listFrancaisAndJaponaisWhereGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select f.id, f.francais, f.slug, t.type as id_type, j.kanji, j.kana, j.romaji, j.description  from GROUPE
    inner join JAPONAIS_GROUPE jg
        on jg.id_groupe = GROUPE.id
    inner join JAPONAIS j
        on jg.id_japonais = j.id
    inner join TRADUCTION wj
    	on wj.id_japonais = j.id
    inner join FRANCAIS f
    	on wj.id_word = f.id
    inner join TYPE t 
        on j.id_type = t.id
    where GROUPE.id=$id");
    return $select->fetchAll();
}

function deleteFrancais($id_francais)
{
    $db = dbConnect();
    $id = $db->quote($id_francais);
    $db->exec("delete from TRADUCTION where id_word=$id");
    $db->exec("delete from FRANCAIS where id=$id");
}

function uniqueFrancais($id_francais)
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    return $db->query("select t.id from TRADUCTION t
    inner join FRANCAIS on t.id_word = FRANCAIS.id 
    where FRANCAIS.id = $id_francais")->rowCount();
}

function deleteAnglais($id_anglais)
{
    $db = dbConnect();
    $id = $db->quote($id_anglais);
    $db->exec("delete from TRADUCTION where id_anglais=$id");
    $db->exec("delete from ANGLAIS where id=$id");
}

function uniqueAnglais($id_anglais)
{
    $db = dbConnect();
    $id = $db->quote($id_anglais);
    return $db->query("select t.id from TRADUCTION t
    inner join ANGLAIS on t.id_anglais = ANGLAIS.id 
    where ANGLAIS.id = $id")->rowCount();
}

/**
 * Japonais - Groupe
 */

function selectGroupeFromJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select GROUPE.* from JAPONAIS j
    inner join JAPONAIS_GROUPE jg
        on jg.id_japonais = j.id
    inner join GROUPE
        on jg.id_groupe = GROUPE.id
    where j.id=$id_japonais order by libelle");
    return $select->fetchAll();
}

function listGroupeToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select GROUPE.id, GROUPE.libelle from JAPONAIS j
    inner join JAPONAIS_GROUPE jg
        on jg.id_japonais = j.id
    inner join GROUPE
        on jg.id_groupe = GROUPE.id
    where j.id=$id_japonais order by libelle");
    return $select->fetchAll();
}

function listWordToGroupe($id_groupe)
{
    $db = dbConnect();
    $id_groupe = $db->quote($id_groupe);
    $select = $db->query("select francais from FRANCAIS f
    inner join TRADUCTION t on f.id = t.id_word
    inner join JAPONAIS j on t.id_japonais = j.id
    inner join JAPONAIS_GROUPE jg on jg.id_japonais = j.id
    inner join GROUPE on jg.id_groupe = GROUPE.id
    where GROUPE.id=$id_groupe");
    return $select->fetchAll();
}

function listFromGroupe($libelle)
{
    $db = dbConnect();
    $libelle = $db->quote($libelle);
    $select = $db->query("select francais, kanji, kana, romaji from FRANCAIS f
    inner join TRADUCTION t on f.id = t.id_word
    inner join JAPONAIS j on t.id_japonais = j.id
    inner join JAPONAIS_GROUPE jg on jg.id_japonais = j.id
    inner join GROUPE on jg.id_groupe = GROUPE.id
    where GROUPE.libelle like $libelle");
    return $select->fetchAll();
}

function listFromGroupeWithoutKanji($libelle)
{
    $db = dbConnect();
    $libelle = $db->quote($libelle);
    $select = $db->query("select francais, kana, romaji from FRANCAIS f
    inner join TRADUCTION t on f.id = t.id_word
    inner join JAPONAIS j on t.id_japonais = j.id
    inner join JAPONAIS_GROUPE jg on jg.id_japonais = j.id
    inner join GROUPE on jg.id_groupe = GROUPE.id
    where GROUPE.libelle like $libelle");
    return $select->fetchAll();
}

function addGroupeToJaponais($id_group, $id_japonais)
{
    $db = dbConnect();
    $id_group = $db->quote($id_group);
    $id_japonais = $db->quote($id_japonais);
    return $db->query("insert into JAPONAIS_GROUPE set id_japonais=$id_japonais, id_groupe=$id_group");
}

function deleteGroupeToJaponais($id_group, $id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_group = $db->quote($id_group);
    return $db->query("delete from JAPONAIS_GROUPE where id_japonais=$id_japonais and id_groupe=$id_group");
}

function selectGroupAndJaponais($id_group, $id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $id_group = $db->quote($id_group);
    return $db->query("select id from JAPONAIS_GROUPE where id_japonais=$id_japonais and id_groupe=$id_group")->rowCount();
}

function deleteAllGroupeForJaponais($id_japonais)
{
    $db = dbConnect();
    $id = $db->quote($id_japonais);
    $db->query("delete from JAPONAIS_GROUPE where id_japonais=$id");
}

function deleteAllGroupe($id_groupe)
{
    $db = dbConnect();
    $id = $db->quote($id_groupe);
    $db->query("delete from JAPONAIS_GROUPE where id_groupe=$id");
}

/**
 * Type
 */

function listType()
{
    $db = dbConnect();
    $select = $db->query('select id, type, type_jp from TYPE order by type');
    return $select->fetchAll();
}

function testType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, type, type_jp from TYPE where id=$id");
}

function createType($type, $type_jp)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $type_jp = $db->quote($type_jp);
    return $db->query("insert into TYPE set type=$type, type_jp=$type_jp");
}

function editType($id, $type, $type_jp)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $type_jp = $db->quote($type_jp);
    $id = $db->quote($id);
    return $db->query("update TYPE set type=$type, type_jp=$type_jp where id=$id");
}

function supprType($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->exec("update JAPONAIS set id_type=null where id_type=$id");
    return $db->query("delete from TYPE where id=$id");
}

/**
 * Japonais - Kanji
 */

function deleteAllKanjiForJaponais($id_japonais)
{
    $db = dbConnect();
    $id = $db->quote($id_japonais);
    $db->exec("delete from JAPONAIS_KANJI where id_japonais=$id");
}

function addKanjiJaponais($id_japonais, $id_kanji)
{
    $db = dbConnect();
    $db->exec("insert into JAPONAIS_KANJI set id_japonais=$id_japonais, id_kanji=$id_kanji");
}

function testKanjiJaponais($id_japonais, $id_kanji)
{
    $db = dbConnect();
    $select = $db->query("select * from JAPONAIS_KANJI where id_japonais=$id_japonais and id_kanji=$id_kanji");
    return $select->fetch();
}

function listKanjiToJaponais($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select KANJI.* from KANJI
        inner join JAPONAIS_KANJI jk on KANJI.id = jk.id_kanji
        where id_japonais=$id_japonais");
    return $select->fetchAll();
}

function listJaponaisToKanji($id_kanji)
{
    $db = dbConnect();
    $id_kanji = $db->quote($id_kanji);
    $select = $db->query("select JAPONAIS.* from JAPONAIS
        inner join JAPONAIS_KANJI jk on JAPONAIS.id = jk.id_japonais
        where id_kanji=$id_kanji");
    return $select->fetchAll();
}

/**
 * Kanji
 */

function getKanjis(): array
{
    $db = dbConnect();
    return $db->query("select id, kanji, grade from KANJI")->fetchAll();
}

function getKanji($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, kanji, lignes, grade, on_yomi, kun_yomi, sens, sens_en from KANJI where id = $id")->fetch();
}

function existKanji($id): bool
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id from KANJI where id = $id")->rowCount() === 1;
}

function editKanji($id, $on, $kun, $sens, $sens_en)
{
    $db = dbConnect();
    $sens = $db->quote($sens);
    $kun = $db->quote($kun);
    $sens_en = $db->quote($sens_en);
    $on = $db->quote($on);
    $id = $db->quote($id);
    return $db->query("update KANJI set on_yomi=$on, sens=$sens, kun_yomi=$kun, sens_en=$sens_en where id=$id");
}

function testKanjiContains($kanji)
{
    $db = dbConnect();
    $kanji = $db->quote($kanji);
    return $db->query("select id from KANJI where kanji like $kanji");
}

/**
 * Recompense
 */

function getRecompense($id): bool
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, libelle, slug, cout, date_parution, id_type from RECOMPENSE where id=$id")->fetch();
}

function existRecompense($id): bool
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id from RECOMPENSE where id=$id")->rowCount() === 1;
}

function listRecompense()
{
    $db = dbConnect();
    $select = $db->query("select RECOMPENSE.id, libelle, cout, date_parution, type from RECOMPENSE 
    inner join RECOMPENSE_TYPE rt on RECOMPENSE.id_type = rt.id
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
    return $db->query("insert into RECOMPENSE set libelle=$libelle, cout=$cout, date_parution=curdate(), slug=$slug, id_type=$id_type");
}

function editRecompense($id, $libelle, $cout, $slug, $id_type)
{
    $db = dbConnect();
    $libelle = $db->quote($libelle);
    $cout = $db->quote($cout);
    $id = $db->quote($id);
    $slug = $db->quote($slug);
    $id_type = $db->quote($id_type);
    return $db->query("update RECOMPENSE set libelle=$libelle, cout=$cout, slug=$slug, id_type=$id_type where id=$id");
}

function supprRecompense($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from ACHAT where id_recompense=$id");
    return $db->query("delete from RECOMPENSE where id=$id");
}

function listTypeRecompense()
{
    $db = dbConnect();
    $select = $db->query('select id, type from RECOMPENSE_TYPE order by type');
    return $select->fetchAll();
}

/**
 * Achat
 */

function listAchateurFromRecompense($id_recompense)
{
    $db = dbConnect();
    $id_recompense = $db->quote($id_recompense);
    $select = $db->query("select USER.pseudo from ACHAT
        inner join USER on ACHAT.id_user = USER.id
        where id_recompense=$id_recompense");
    return $select->fetchAll();
}

/**
 * Musique
 */

function getMusics(): array
{
    $db = dbConnect();
    return $db->query("select id, anime, chanteur, titre from MUSIQUE")->fetchAll();
}

function getMusic($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, japonais, romaji, francais, anime, chanteur, titre, slug, audio from MUSIQUE where id=$id")->fetch();
}

function existMusic($id): bool
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id from MUSIQUE where id=$id")->rowCount() === 1;
}

function dropMusic($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from MUSIQUE where id=$id");
}

function addMusic($japonais, $romaji, $francais, $anime, $chanteur, $titre, $slug)
{
    $db = dbConnect();
    $japonais = $db->quote($japonais);
    $romaji = $db->quote($romaji);
    $francais = $db->quote($francais);
    $anime = $db->quote($anime);
    $chanteur = $db->quote($chanteur);
    $titre = $db->quote($titre);
    $slug = $db->quote($slug);
    $db->query("insert into MUSIQUE set japonais=$japonais, romaji=$romaji, francais=$francais, anime=$anime, chanteur=$chanteur, titre=$titre, slug=$slug");
}

function editMusic($id, $japonais, $romaji, $francais, $anime, $chanteur, $titre, $slug)
{
    $db = dbConnect();
    $japonais = $db->quote($japonais);
    $romaji = $db->quote($romaji);
    $francais = $db->quote($francais);
    $anime = $db->quote($anime);
    $chanteur = $db->quote($chanteur);
    $titre = $db->quote($titre);
    $slug = $db->quote($slug);
    $id = $db->quote($id);
    $db->query("update MUSIQUE set japonais=$japonais, romaji=$romaji, francais=$francais, anime=$anime, chanteur=$chanteur, titre=$titre, slug=$slug where id=$id");
}

function insertMusic($slug, $audio)
{
    $db = dbConnect();
    $audio = $db->quote($audio);
    $slug = $db->quote($slug);
    $db->query("update MUSIQUE set audio=$audio where slug like $slug");
}