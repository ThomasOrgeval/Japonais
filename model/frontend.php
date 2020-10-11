<?php

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=japonais;charset=utf8', 'root', '');
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
    $addUser = $db->prepare('insert into lexiqumjaponais.user(pseudo, pass, mail, date, droits) values(?, ?, ?, CURRENT_DATE, ?)');
    $addUser = $addUser->execute(array($pseudo, $pass, $mail, 0));
    return $addUser;
}

function loginUser($pseudo, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, pseudo, pass, mail, droits from lexiqumjaponais.user where pseudo=?');
    $selectUser->execute(array($pseudo));
    $selectUser = $selectUser->fetch();
    if (password_verify($pass, $selectUser['pass'])) {
        return $selectUser;
    } else {
        return false;
    }
}

function searchPseudo($pseudo)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select pseudo from lexiqumjaponais.user where pseudo=?');
    $selectUser->execute(array($pseudo));
    return $selectUser->fetch();
}

function searchMail($mail)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select pseudo from lexiqumjaponais.user where mail=?');
    $selectUser->execute(array($mail));
    return $selectUser->fetch();
}

/**
 * Listes
 */

function listListes($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select id, nom, description, id_confidentiality, id_user from lexiqumjaponais.listes where id_user=$id_user");
    return $select->fetchAll();
}

function selectListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, nom, description, id_confidentiality, id_user from lexiqumjaponais.listes where id=$id");;
}

function supprListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from lexiqumjaponais.listes where id=$id");
}

function editListe($nom, $desc, $id_confidentiality, $id, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id = $db->quote($id);
    $id_user = $db->quote($id_user);
    return $db->query("update lexiqumjaponais.listes set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user where id=$id");
}

function createListe($nom, $desc, $id_confidentiality, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id_user = $db->quote($id_user);
    return $db->query("insert into lexiqumjaponais.listes set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user");
}

/**
 * Confidentiality
 */

function listConfidentiality()
{
    $db = dbConnect();
    $select = $db->query('select id, confidentiality from lexiqumjaponais.confidentiality order by confidentiality asc');
    return $select->fetchAll();
}

/**
 * Formulaire de recherche
 */

function listSearchWord($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.words where fr like '%$search%'");
    return $select->fetchAll();
}

function listSearchGroupe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.groupe where libelle like '%$search%'");
    return $select->fetchAll();
}

function listSearchListe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.listes where nom like '%$search%' and id_confidentiality=1");
    return $select->fetchAll();
}