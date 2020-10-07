<?php

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=japonais', 'root', '');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
    return $db;
}

/**
 * User
 */

function createUser($pseudo, $pass, $mail)
{
    $db = dbConnect();
    $addUser = $db->prepare('insert into japonais.user(pseudo, pass, mail, date, droits) values(?, ?, ?, CURRENT_DATE, ?)');
    $addUser = $addUser->execute(array($pseudo, $pass, $mail, 0));
    return $addUser;
}

function loginUser($pseudo, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select pseudo, mail from japonais.user where pseudo=? and pass=?');
    $selectUser = $selectUser->execute(array($pseudo, $pass));
    return $selectUser;
}

/**
 * Groupes
 */

function createGroupe($libelle)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('insert into japonais.groupe(libelle) values(?)');
    $addGroupe = $addGroupe->execute(array($libelle));
    return $addGroupe;
}

function editGroupe($id, $libelle)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $libelle = $db->quote($libelle);
    $editGroupe = $db->query("update japonais.groupe set libelle=$libelle where id=$id");
    return $editGroupe;
}

function supprGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from japonais.groupe where id=?');
    $select = $select->execute(array($id));
    return $select;
}

function listGroupe()
{
    $db = dbConnect();
    $select = $db->query('select id, libelle from japonais.groupe');
    return $select->fetchAll();
}

function testGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, libelle from japonais.groupe where id=$id");
}

/**
 * Mots
 */

function testWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from japonais.words where id=$id");
}

function listWords()
{
    $db = dbConnect();
    $select = $db->query("select id, fr, kana, kanji, romaji from japonais.words order by fr asc");
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
    return $db->query("update japonais.words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type where id=$id");
}

function createWord($fr, $kana, $kanji, $romaji, $id_type)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id_type = $db->quote($id_type);
    return $db->query("insert into japonais.words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji, id_type=$id_type");
}

function supprWord($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from japonais.words where id=?');
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
        $select = $db->query("select words.id, groupe.* from japonais.words
    inner join japonais.words_groupe as wg
        on wg.id_word = words.id
    inner join japonais.groupe
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
    return $db->query("insert into japonais.words_groupe set id_word=$word, id_groupe=$groupe");
}

function deleteGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $idWord = $db->quote($id);
    $idGroupe = $db->quote($id_groupe);
    return $db->query("delete from japonais.words_groupe where id_word=$idWord and id_groupe=$idGroupe");
}

function deleteAllGroupeForWord($id_word)
{
    $db = dbConnect();
    $id = $db->quote($id_word);
    $db->query("delete from japonais.words_groupe where id_word=$id");
}

function deleteAllGroupeForGroupe($id_groupe)
{
    $db = dbConnect();
    $id = $db->quote($id_groupe);
    $db->query("delete from japonais.words_groupe where id_groupe=$id");
}

/**
 * Type
 */

function listType()
{
    $db = dbConnect();
    $select = $db->query('select id, type from japonais.type order by type asc');
    return $select->fetchAll();
}