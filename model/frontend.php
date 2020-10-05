<?php

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=japonais', 'root', '');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
    return $db;
}

/**
 * Groupes
 */

function createGroupe($libelle)
{
    $db = dbConnect();
    $addGroupe = $db->prepare('insert into groupe(libelle) values(?)');
    $addGroupe = $addGroupe->execute(array($libelle));
    return $addGroupe;
}

function editGroupe($id, $libelle)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $libelle = $db->quote($libelle);
    $editGroupe = $db->query("update groupe set libelle=$libelle where id=$id");
    return $editGroupe;
}

function supprGroupe($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from groupe where id=?');
    $select = $select->execute(array($id));
    return $select;
}

function listGroupe()
{
    $db = dbConnect();
    $select = $db->query('select id, libelle from groupe');
    return $select->fetchAll();
}

function testGroupe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, libelle from groupe where id=$id");
}

/**
 * Mots
 */

function testWord($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from words where id=$id");
}

function listWords()
{
    $db = dbConnect();
    $select = $db->query("select id, fr, kana, kanji, romaji from words order by fr asc");
    return $select->fetchAll();
}

function editWord($fr, $kana, $kanji, $romaji, $id)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    $id = $db->quote($id);
    return $db->query("update words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji where id=$id");
}

function createWord($fr, $kana, $kanji, $romaji)
{
    $db = dbConnect();
    $fr = $db->quote($fr);
    $kana = $db->quote($kana);
    $kanji = $db->quote($kanji);
    $romaji = $db->quote($romaji);
    return $db->query("insert into words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji");
}

function supprWord($id)
{
    $db = dbConnect();
    $select = $db->prepare('delete from words where id=?');
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
        $select = $db->query("select words.id, groupe.* from words
    inner join words_groupe as wg
        on wg.id_word = words.id
    inner join groupe
        on wg.id_groupe = groupe.id
    where words.id=$id");
    } else {
        return null;
    }
    return $select->fetchAll();
}

function addGroupeToWord($id_groupe, $id) {
    $db = dbConnect();
    $word = $db->quote($id);
    $groupe = $db->quote($id_groupe);
    return $db->query("insert into words_groupe set id_word=$word, id_groupe=$groupe");
}

function deleteGroupeToWord($id_groupe, $id)
{
    $db = dbConnect();
    $idWord = $db->quote($id);
    $idGroupe = $db->quote($id_groupe);
    return $db->query("delete from words_groupe where id_word=$idWord and id_groupe=$idGroupe");
}

function deleteAllGroupeForWord($id_word) {
    $db = dbConnect();
    $id = $db->quote($id_word);
    $db->query("delete from words_groupe where id_word=$id");
}