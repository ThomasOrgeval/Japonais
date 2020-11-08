<?php

function dbConnect()
{
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $db = new PDO('mysql:host=localhost;dbname=lexiqumjaponais;charset=utf8', 'root', '');
    } else {
        $host = 'lexiqumjaponais.mysql.db';
        $dbname = 'lexiqumjaponais';
        $user = 'lexiqumjaponais';
        $pass = 'Cvd38Q8am5X8D';
        $db = new PDO('mysql:host=' . $host . '; dbname=' . $dbname . '; charset=utf8', $user, $pass);
    }
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
    return $db;
}

/**
 * User
 */

function createUser($pseudo, $pass, $mail, $riddle)
{
    $db = dbConnect();
    $addUser = $db->prepare('insert into lexiqumjaponais.USER(pseudo, pass, mail, date, droits, nombre, points, icone, riddle, life, last_login, theme) values(?, ?, ?, CURRENT_DATE, 0, 10, 0, 0, ?, 3, curdate(), 0)');
    $addUser = $addUser->execute(array($pseudo, $pass, $mail, $riddle));
    return $addUser;
}

function loginUser($mail, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, pseudo, pass, mail, droits, nombre, points, icone, riddle, life, last_login, theme from lexiqumjaponais.USER where mail=?');
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

function searchUser($pseudo)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, last_login, icone, points, pseudo from lexiqumjaponais.USER where pseudo=?');
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

function changePass($mail, $pass)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $pass = $db->quote($pass);
    $db->exec("update lexiqumjaponais.USER set pass=$pass where mail like $mail");
}

function saveAccount($id, $words)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $words = $db->quote($words);
    $db->exec("update lexiqumjaponais.USER set nombre=$words where id=$id");
}

function changeIcon($id_user, $id_icon)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_icon = $db->quote($id_icon);
    $db->exec("update lexiqumjaponais.USER set icone=$id_icon where id=$id_user");
}

function getPoints($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select points from lexiqumjaponais.USER where id=$id_user");
    return $select->fetch();
}

function setPoints($id_user, $points)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $points = $db->quote($points);
    $db->exec("update lexiqumjaponais.USER set points=$points where id=$id_user");
}

function setRiddle($id_user, $francais)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $francais = $db->quote($francais);
    $db->exec("update lexiqumjaponais.USER set riddle=$francais where id=$id_user");
}

function setLife($id_user, $life)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $life = $db->quote($life);
    $db->exec("update lexiqumjaponais.USER set life=$life where id=$id_user");
}

function setLastLogin($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $db->exec("update lexiqumjaponais.USER set last_login=curdate() where id=$id_user");
}

function setTheme($id_user, $slug)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $slug = $db->quote($slug);
    $db->exec("update lexiqumjaponais.USER set theme=$slug where id=$id_user");
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

function searchRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    return $db->query("select * from lexiqumjaponais.RECUPERATION where code=$code and mail=$mail");
}

function deleteRecup($id)
{
    $db = dbConnect();
    $db->exec("delete from lexiqumjaponais.RECUPERATION where id=$id");
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

function selectOneRandomWord()
{
    $db = dbConnect();
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.TRADUCTION trad on FRANCAIS.id = trad.id_word
    inner join lexiqumjaponais.JAPONAIS on trad.id_japonais = JAPONAIS.id
    order by rand()
    limit 1");
    return $select->fetch();
}

/**
 * Traduction
 */

function listJaponaisToFrancaisWord($francais)
{
    $db = dbConnect();
    $francais = $db->quote($francais);
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.francais like $francais");
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

function searchListe($pseudo)
{
    $db = dbConnect();
    $select = $db->prepare('select id, nom, description from lexiqumjaponais.LISTES where id_user=?');
    $select->execute(array($pseudo));
    return $select->fetchAll();
}

function searchListeUser($pseudo)
{
    $db = dbConnect();
    $select = $db->prepare('select id, nom, description from lexiqumjaponais.LISTES 
                                    where id_user=? and id_confidentiality=1');
    $select->execute(array($pseudo));
    return $select->fetchAll();
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
 * Recherche
 */

function researchWord($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.FRANCAIS where francais like '$search'");
    return $select->fetch();
}

function researchGroupeId($search)
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.GROUPE where id=$search");
    return $select->fetch();
}

/**
 * Achat
 */

function listAchatByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat, type from lexiqumjaponais.RECOMPENSE
        inner join lexiqumjaponais.ACHAT on RECOMPENSE.id = ACHAT.id_recompense
        inner join lexiqumjaponais.RECOMPENSE_TYPE on RECOMPENSE.id_type = RECOMPENSE_TYPE.id
        where ACHAT.id_user=$id_user");
    return $select->fetchAll();
}

function listAchatThemeByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat from lexiqumjaponais.ACHAT
        inner join lexiqumjaponais.RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Theme'");
    return $select->fetchAll();
}

function achatThemeById($id_recompense)
{
    $db = dbConnect();
    $id_recompense = $db->quote($id_recompense);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout from lexiqumjaponais.RECOMPENSE
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where RECOMPENSE.id=$id_recompense and RT.type like 'Theme'");
    return $select->fetch();
}

function listThemes()
{
    $db = dbConnect();
    $select = $db->query("select RECOMPENSE.* from lexiqumjaponais.RECOMPENSE
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where type like 'Theme'");
    return $select->fetchAll();
}

function listAchatIconByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat from lexiqumjaponais.ACHAT
        inner join lexiqumjaponais.RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Icone'");
    return $select->fetchAll();
}

function listIcons()
{
    $db = dbConnect();
    $select = $db->query("select * from lexiqumjaponais.RECOMPENSE
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where type like 'Icone'");
    return $select->fetchAll();
}

function haveIcon($id_user, $id_icon)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_icon = $db->quote($id_icon);
    $select = $db->query("select RECOMPENSE.id from lexiqumjaponais.ACHAT
        inner join lexiqumjaponais.RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join lexiqumjaponais.RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Icone' and ACHAT.id_recompense=$id_icon");
    return $select->fetch();
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

function selectRecompense($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select * from lexiqumjaponais.RECOMPENSE where id=$id");
    return $select->fetch();
}

/**
 * Autocomplete
 */

function autocompleteMots($key)
{
    $db = dbConnect();
    $select = $db->query("select francais from lexiqumjaponais.FRANCAIS where francais like '$key%' order by francais limit 0,10");
    return $select->fetchAll();
}

function autocompleteUser($key, $id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select pseudo, icone from lexiqumjaponais.USER where pseudo like '$key%' and id!=$id_user order by pseudo limit 0,5");
    return $select->fetchAll();
}