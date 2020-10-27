<?php

function dbConnect()
{
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $db = new PDO('mysql:host=localhost;dbname=lexiqumjaponais;charset=utf8', 'root', '');
    } else {
        $db = new PDO('mysql:host=lexiqumjaponais.mysql.db; dbname=lexiqumjaponais; charset=utf8', 'lexiqumjaponais', 'Cvd38Q8am5X8D');
    }
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
    $addUser = $db->prepare('insert into lexiqumjaponais.USER(pseudo, pass, mail, date, droits, nombre, points) values(?, ?, ?, CURRENT_DATE, ?, 10, 0)');
    $addUser = $addUser->execute(array($pseudo, $pass, $mail, 0));
    return $addUser;
}

function loginUser($mail, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, pseudo, pass, mail, droits, nombre, points from lexiqumjaponais.USER where mail=?');
    $selectUser->execute(array($mail));
    $selectUser = $selectUser->fetch();
    if (password_verify($pass, $selectUser['pass'])) {
        return $selectUser;
    }
    return false;
}

function searchPseudo($pseudo)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select pseudo from lexiqumjaponais.USER where pseudo=?');
    $selectUser->execute(array($pseudo));
    return $selectUser->fetch();
}

function searchMail($mail)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select pseudo from lexiqumjaponais.USER where mail=?');
    $selectUser->execute(array($mail));
    return $selectUser->fetch();
}

/**
 * Recuperation
 */

function createRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    $db->exec("insert into lexiqumjaponais.RECUPERATION set mail=$mail, code=$code");
}

function updateRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    $db->exec("update lexiqumjaponais.RECUPERATION set code=$code where mail=$mail");
}

function searchRecupMail($mail)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id from lexiqumjaponais.RECUPERATION where mail=?');
    $selectUser->execute(array($mail));
    return $selectUser->rowCount();
}

/**
 * Word
 */

function listRandomWords($nombre)
{
    $db = dbConnect();
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, FRANCAIS.id_type, JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, TYPE.id, TYPE.type from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.TYPE
        on FRANCAIS.id_type = TYPE.id
    ORDER BY RAND()
    LIMIT $nombre");
    return $select->fetchAll();
}

/**
 * Listes
 */

function listListes($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select id, nom, description, id_confidentiality, id_user from lexiqumjaponais.LISTES where id_user=$id_user");
    return $select->fetchAll();
}

function selectListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, nom, description, id_confidentiality, id_user from lexiqumjaponais.LISTES where id=$id");;
}

function supprListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("delete from lexiqumjaponais.LISTES where id=$id");
}

function editListe($nom, $desc, $id_confidentiality, $id, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id = $db->quote($id);
    $id_user = $db->quote($id_user);
    return $db->query("update lexiqumjaponais.LISTES set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user where id=$id");
}

function createListe($nom, $desc, $id_confidentiality, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id_user = $db->quote($id_user);
    return $db->query("insert into lexiqumjaponais.LISTES set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user");
}

/**
 * Confidentiality
 */

function listConfidentiality()
{
    $db = dbConnect();
    $select = $db->query('select id, confidentiality from lexiqumjaponais.CONFIDENTIALITY order by confidentiality asc');
    return $select->fetchAll();
}

/**
 * Formulaire de recherche
 */

function listSearchWord($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.FRANCAIS where francais like '%$search%'");
    return $select->fetchAll();
}

function listSearchGroupe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.GROUPE where libelle like '%$search%'");
    return $select->fetchAll();
}

function listSearchListe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.LISTES where nom like '%$search%' and id_confidentiality=1");
    return $select->fetchAll();
}

function researchWord($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.FRANCAIS where francais like '$search'");
    return $select->fetch();
}

function researchGroupe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.GROUPE where libelle like '$search'");
    return $select->fetch();
}

function researchListe($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.LISTES where nom like '$search' and id_confidentiality = 0");
    return $select->fetch();
}

/**
 * Achat
 */

function listAchatByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.cout, ACHAT.date_achat from lexiqumjaponais.RECOMPENSE
        inner join lexiqumjaponais.ACHAT on RECOMPENSE.id = ACHAT.id_recompense
        where ACHAT.id_user=$id_user");
    return $select->fetchAll();
}

function achatByUser($id_user, $id_recompense)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_recompense = $db->quote($id_recompense);
    $select = $db->query("select * from lexiqumjaponais.ACHAT where id_user=$id_user and id_recompense=$id_recompense");
    return $select->fetch();
}

function achatdb($id_user, $id_recompense)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_recompense = $db->quote($id_recompense);
    $db->exec("insert into lexiqumjaponais.ACHAT set id_user=$id_user, id_recompense=$id_recompense, date_achat=curdate()");
}

function depense($id, $points)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $points = $db->quote($points);
    $db->exec("update lexiqumjaponais.USER set points=$points where id=$id");
}

function pointsUser($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select points from lexiqumjaponais.USER where id=$id");
    return $select->fetch();
}