<?php
require_once './model/Manager.php';

class GroupeManager extends Manager
{
    public function createGroupe($libelle)
    {
        $db = dbConnect();
        $addGroupe = $db->prepare('insert into groupe(libelle) values(?)');
        $addGroupe = $addGroupe->execute(array($libelle));
        return $addGroupe;
    }

    public function editGroupe($id, $libelle)
    {
        $db = dbConnect();
        $id = $db->quote($id);
        $libelle = $db->quote($libelle);
        $editGroupe = $db->query("update groupe set libelle=$libelle where id=$id");
        return $editGroupe;
    }

    public function supprGroupe($id)
    {
        $db = dbConnect();
        $select = $db->prepare('delete from groupe where id=?');
        $select = $select->execute(array($id));
        return $select;
    }

    public function listGroupe()
    {
        $db = dbConnect();
        $select = $db->query('select id, libelle from groupe');
        return $select->fetchAll();
    }

    public function testGroupe($id)
    {
        $db = dbConnect();
        $id = $db->quote($id);
        return $db->query("select id, libelle from groupe where id=$id");
    }
}