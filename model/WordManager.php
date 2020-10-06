<?php
require_once './model/Manager.php';

class WordManager extends Manager
{
    public function testWord($id)
    {
        $db = dbConnect();
        $id = $db->quote($id);
        return $db->query("select * from words where id=$id");
    }

    public function listWords()
    {
        $db = dbConnect();
        $select = $db->query("select id, fr, kana, kanji, romaji from words order by fr asc");
        return $select->fetchAll();
    }

    public function editWord($fr, $kana, $kanji, $romaji, $id)
    {
        $db = dbConnect();
        $fr = $db->quote($fr);
        $kana = $db->quote($kana);
        $kanji = $db->quote($kanji);
        $romaji = $db->quote($romaji);
        $id = $db->quote($id);
        return $db->query("update words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji where id=$id");
    }

    public function createWord($fr, $kana, $kanji, $romaji)
    {
        $db = dbConnect();
        $fr = $db->quote($fr);
        $kana = $db->quote($kana);
        $kanji = $db->quote($kanji);
        $romaji = $db->quote($romaji);
        return $db->query("insert into words set fr=$fr, kana=$kana, kanji=$kanji, romaji=$romaji");
    }

    public function supprWord($id)
    {
        $db = dbConnect();
        $select = $db->prepare('delete from words where id=?');
        $select = $select->execute(array($id));
        return $select;
    }
}