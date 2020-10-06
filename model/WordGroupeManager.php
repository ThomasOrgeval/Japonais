<?php
require_once './model/Manager.php';

class WordGroupeManager extends Manager
{
    public function listGroupeToWord()
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

    public function addGroupeToWord($id_groupe, $id) {
        $db = dbConnect();
        $word = $db->quote($id);
        $groupe = $db->quote($id_groupe);
        return $db->query("insert into words_groupe set id_word=$word, id_groupe=$groupe");
    }

    public function deleteGroupeToWord($id_groupe, $id)
    {
        $db = dbConnect();
        $idWord = $db->quote($id);
        $idGroupe = $db->quote($id_groupe);
        return $db->query("delete from words_groupe where id_word=$idWord and id_groupe=$idGroupe");
    }

    public function deleteAllGroupeForWord($id_word) {
        $db = dbConnect();
        $id = $db->quote($id_word);
        $db->query("delete from words_groupe where id_word=$id");
    }

    public function deleteAllGroupeForGroupe($id_groupe) {
        $db = dbConnect();
        $id = $db->quote($id_groupe);
        $db->query("delete from words_groupe where id_groupe=$id");
    }
}