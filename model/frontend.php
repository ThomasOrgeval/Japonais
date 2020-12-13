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

function createUser($pseudo, $pass, $mail)
{
    $db = dbConnect();
    $pseudo = $db->quote($pseudo);
    $pass = $db->quote($pass);
    $mail = $db->quote($mail);
    $db->query("insert into lexiqumjaponais.USER(pseudo, pass, mail, date, droits, nombre, icone, life, last_login, theme, kanji) 
                        values ($pseudo, $pass, $mail, curdate(), 0, 10, 0, 5, curdate(), 0, 1) ");
}

function loginUser($mail, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, pseudo, pass, mail, droits, nombre, icone, life, last_login, theme, kanji from lexiqumjaponais.USER where mail=?');
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
    $selectUser = $db->prepare('select id, last_login, icone, pseudo from lexiqumjaponais.USER where pseudo=?');
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

function saveAccount($id, $words, $kanji)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $words = $db->quote($words);
    $kanji = $db->quote($kanji);
    $db->exec("update lexiqumjaponais.USER set nombre=$words, kanji=$kanji where id=$id");
}

function changeIcon($id_icon)
{
    $db = dbConnect();
    $id_icon = $db->quote($id_icon);
    $select = $db->query("select * from lexiqumjaponais.RECOMPENSE where id=$id_icon");
    return $select->fetch();
}

function setIcon($id_user, $slug)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $slug = $db->quote($slug);
    $db->exec("update lexiqumjaponais.USER set icone=$slug where id=$id_user");
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
 * Sakura
 */

function getSakura($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select sakura, sakura_total from lexiqumjaponais.SAKURA where id_user=$id_user");
    return $select->fetch();
}

function setSakura($id_user, $sakura)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $db->exec("update lexiqumjaponais.SAKURA set sakura = sakura + $sakura, sakura_total = sakura_total + $sakura where id_user=$id_user");
}

function buySakura($id_user, $sakura)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $sakura = $db->quote($sakura);
    $db->exec("update lexiqumjaponais.SAKURA set sakura=$sakura where id_user=$id_user");
}

function getSakuraLastMonth($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    return $db->query("select sakura, date from lexiqumjaponais.HISTORIQUE_SAKURA
        where date <= curdate() and date > date_sub(curdate(), interval 1 month)
    and id_user = $id_user")->fetchAll();
}

/**
 * Riddle
 */

function getRiddle($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select riddle from lexiqumjaponais.RIDDLE where id_user=$id_user");
    return $select->fetch()['riddle'];
}

function setRiddle($id_user, $riddle, $old_response)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $riddle = $db->quote($riddle);
    $old_response = $db->quote($old_response);
    $db->exec("update lexiqumjaponais.RIDDLE set riddle=$riddle, last_response = $old_response where id_user=$id_user");
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
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, JAPONAIS.id_type, JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, TYPE.id, TYPE.type from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.TYPE
        on JAPONAIS.id_type = TYPE.id
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
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, JAPONAIS.description from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.francais like $francais");
    return $select->fetchAll();
}

function listFrancaisToJaponaisWord($japonais)
{
    $db = dbConnect();
    $japonais = $db->quote($japonais);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais from lexiqumjaponais.JAPONAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join lexiqumjaponais.FRANCAIS
        on wj.id_word = FRANCAIS.id
    where JAPONAIS.kanji like $japonais or JAPONAIS.kana like $japonais or JAPONAIS.romaji like $japonais");
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
    $select = $db->query("select id, nom, description, id_confidentiality, id_user from lexiqumjaponais.LISTES where id=$id");
    return $select->fetch();
}

function selectUserFromListe($id_liste)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $select = $db->query("select USER.icone, USER.pseudo from lexiqumjaponais.USER 
    inner join lexiqumjaponais.LISTES 
        on USER.id = LISTES.id_user
    where LISTES.id=$id_liste");
    return $select->fetch();
}

function haveListes($id_user, $id_francais)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_francais = $db->quote($id_francais);
    $select = $db->query("select LISTES.id, nom, description, id_confidentiality, id_user from lexiqumjaponais.LISTES 
    inner join lexiqumjaponais.WORDS_LISTES wl 
        on LISTES.id = wl.id_liste
    inner join lexiqumjaponais.FRANCAIS fr
        on wl.id_word = fr.id
    where id_user=$id_user and fr.id=$id_francais");
    return $select->fetchAll();
}

function selectFrancaisFromListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select FRANCAIS.* from lexiqumjaponais.FRANCAIS 
    inner join lexiqumjaponais.WORDS_LISTES wl 
        on FRANCAIS.id = wl.id_word
    inner join lexiqumjaponais.LISTES l
        on wl.id_liste = l.id
    where l.id=$id");
    return $select->fetchAll();
}

function supprListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from lexiqumjaponais.WORDS_LISTES where id_liste=$id");
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
    $select = $db->prepare('select id, nom, description from lexiqumjaponais.LISTES where id_user=? and id_confidentiality=1');
    $select->execute(array($pseudo));
    return $select->fetchAll();
}

/**
 * Confidentiality
 */

function listConfidentiality()
{
    $db = dbConnect();
    $select = $db->query('select id, confidentiality from lexiqumjaponais.CONFIDENTIALITY order by confidentiality');
    return $select->fetchAll();
}

/**
 * Recherche
 */

function researchWord($search, $type)
{
    $db = dbConnect();
    $type = $db->quote($type);
    $select = $db->query("select f.francais, f.id, j.id_type, ty.type, ty.type_jp from lexiqumjaponais.FRANCAIS f
        inner join lexiqumjaponais.TRADUCTION t on f.id = t.id_word
        inner join lexiqumjaponais.JAPONAIS j on t.id_japonais = j.id
        inner join lexiqumjaponais.TYPE ty on j.id_type = ty.id
        where francais like '$search' and j.id_type=$type");
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
    $select = $db->query("select RECOMPENSE.* from lexiqumjaponais.RECOMPENSE
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
    $select = $db->query("select francais, j.id_type, type from lexiqumjaponais.FRANCAIS 
        inner join lexiqumjaponais.TRADUCTION t on FRANCAIS.id = t.id_word
        inner join lexiqumjaponais.JAPONAIS j on t.id_japonais = j.id
        inner join lexiqumjaponais.TYPE ty on j.id_type = ty.id
        where francais like '$key%' order by francais limit 0,10");
    return $select->fetchAll();
}

function autocompleteUser($key, $id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select pseudo, icone from lexiqumjaponais.USER where pseudo like '$key%' and id!=$id_user order by pseudo limit 0,5");
    return $select->fetchAll();
}

/**
 * words_liste
 */

function selectWordInListe($id_liste, $id_word)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $id_word = $db->quote($id_word);
    return $db->query("select * from lexiqumjaponais.WORDS_LISTES where id_liste=$id_liste and id_word=$id_word");
}

function addWordInListe($id_liste, $id_word)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $id_word = $db->quote($id_word);
    $db->query("insert into lexiqumjaponais.WORDS_LISTES set id_liste=$id_liste, id_word=$id_word");
}

function removeWordInListe($id_liste, $id_word)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $id_word = $db->quote($id_word);
    $db->query("delete from lexiqumjaponais.WORDS_LISTES where id_liste=$id_liste and id_word=$id_word");
}

/**
 * Statistiques
 */

function countUser()
{
    $db = dbConnect();
    $select = $db->query("select count(*) as users from lexiqumjaponais.USER");
    return $select->fetch();
}

function countJaponais()
{
    $db = dbConnect();
    $select = $db->query("select count(*) as japonais from lexiqumjaponais.JAPONAIS");
    return $select->fetch();
}

function sumSakura()
{
    $db = dbConnect();
    $select = $db->query("select sum(sakura) as sakura, sum(sakura_total) as sakura_total from lexiqumjaponais.SAKURA");
    return $select->fetch();
}

function bestUser()
{
    $db = dbConnect();
    $select = $db->query("select sakura, pseudo from lexiqumjaponais.SAKURA 
        inner join lexiqumjaponais.USER on SAKURA.id_user = USER.id
        order by sakura desc limit 5");
    return $select->fetchAll();
}

function bestUser2()
{
    $db = dbConnect();
    $select = $db->query("select sakura_total, pseudo from lexiqumjaponais.SAKURA 
        inner join lexiqumjaponais.USER on SAKURA.id_user = USER.id
        order by sakura_total desc limit 5");
    return $select->fetchAll();
}

function bestKanjis()
{
    $db = dbConnect();
    $select = $db->query("select KANJI.id, kanji, count(id_kanji) count, kun_yomi from lexiqumjaponais.KANJI
        inner join lexiqumjaponais.JAPONAIS_KANJI jk on KANJI.id = jk.id_kanji
        group by jk.id_kanji order by count(id_kanji) desc limit 10");
    return $select->fetchAll();
}

function lastDayHistory()
{
    $db = dbConnect();
    return $db->query("select * from lexiqumjaponais.select_day")->fetchAll();
}

function lastWeekHistory()
{
    $db = dbConnect();
    return $db->query("select * from lexiqumjaponais.select_week")->fetchAll();
}

function lastMonthHistory()
{
    $db = dbConnect();
    return $db->query("select * from lexiqumjaponais.select_month")->fetchAll();
}

/**
 * Kanji
 */

function listFrancaisToJaponaisLimit1($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select FRANCAIS.francais, JAPONAIS.id_type from lexiqumjaponais.FRANCAIS
    inner join lexiqumjaponais.TRADUCTION as wj
        on wj.id_word = FRANCAIS.id
    inner join lexiqumjaponais.JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id_japonais limit 1");
    return $select->fetch();
}