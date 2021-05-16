<?php

function dbConnect()
{
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $db = new PDO('mysql:host=localhost;dbname=japonais;charset=utf8', 'root', '');
    } else {
        $var = (array) json_decode(file_get_contents('https://lexiquejaponais.fr/model/env.json'));
        $db = new PDO('mysql:host=' . $var['HTTP_HOST'] . '; dbname=' . $var['HTTP_DBNAME'] . '; charset=utf8', $var['HTTP_USER'], $var['HTTP_MDP']);
    }
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
    return $db;
}

/**
 * User
 */

function createUser($pseudo, $pass, $mail, $slug)
{
    $db = dbConnect();
    $pseudo = $db->quote($pseudo);
    $pass = $db->quote($pass);
    $mail = $db->quote($mail);
    $slug = $db->quote($slug);
    $db->query("insert into USER(pseudo, pass, mail, date, droits, nombre, icone, life, last_login, theme, kanji, slug, background) 
                        values ($pseudo, $pass, $mail, curdate(), 0, 10, 0, 5, curdate(), 0, 1, $slug, 0) ");
}

function loginUser($mail, $pass)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, pseudo, pass, mail, droits, nombre, icone, life, last_login, theme, 
       kanji, background from USER where mail = ?');
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
    $selectUser = $db->prepare('select pseudo from USER where pseudo=?');
    $selectUser->execute(array($pseudo));
    return $selectUser->fetch();
}

function searchSlug($pseudo)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select slug from USER where slug=?');
    $selectUser->execute(array($pseudo));
    return $selectUser->fetch();
}

function searchUser($pseudo)
{
    $db = dbConnect();
    $selectUser = $db->prepare('select id, last_login, icone, pseudo from USER where pseudo=?');
    $selectUser->execute(array($pseudo));
    return $selectUser->fetch();
}

function searchMail($mail)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    return $db->query("select pseudo from USER where mail = $mail")->rowCount() === 1;
}

function changePass($mail, $pass)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $pass = $db->quote($pass);
    $db->query("update USER set pass=$pass where mail like $mail");
}

function saveAccount($id, $words, $kanji)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $words = $db->quote($words);
    $kanji = $db->quote($kanji);
    $db->query("update USER set nombre = $words, kanji = $kanji where id=$id");
}

function setIcon($id_user, $slug)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $slug = $db->quote($slug);
    $db->query("update USER set icone = $slug where id = $id_user");
}

function setLife($id_user, $life)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $life = $db->quote($life);
    $db->exec("update USER set life=$life where id=$id_user");
}

function setLastLogin($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $db->exec("update USER set last_login=curdate() where id=$id_user");
}

function setTheme($id_user, $slug)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $slug = $db->quote($slug);
    $db->exec("update USER set theme=$slug where id=$id_user");
}

function setBackground($id_user, $slug)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $slug = $db->quote($slug);
    $db->exec("update USER set background=$slug where id=$id_user");
}

function getBackground($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select background from USER where id=$id_user");
    return $select->fetch();
}

/**
 * Sakura
 */

function getSakura($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select sakura, sakura_total from SAKURA where id_user=$id_user");
    return $select->fetch();
}

function setSakura($id_user, $sakura)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $db->exec("update SAKURA set sakura = sakura + $sakura, sakura_total = sakura_total + $sakura where id_user=$id_user");
}

function buySakura($id_user, $sakura)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $sakura = $db->quote($sakura);
    $db->exec("update SAKURA set sakura=$sakura where id_user=$id_user");
}

function getSakuraLastMonth($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    return $db->query("select sakura, date from HISTORIQUE_SAKURA
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
    $select = $db->query("select riddle from RIDDLE where id_user=$id_user");
    return $select->fetch()['riddle'];
}

function setRiddle($id_user, $riddle, $old_response)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $riddle = $db->quote($riddle);
    $old_response = $db->quote($old_response);
    $db->exec("update RIDDLE set riddle=$riddle, last_response = $old_response where id_user=$id_user");
}

/**
 * Recuperation
 */

function createRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    $db->exec("insert into RECUPERATION set mail=$mail, code=$code");
}

function updateRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    $db->exec("update RECUPERATION set code=$code where mail=$mail");
}

function searchRecupMail($mail): bool
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    return $db->query("select id from RECUPERATION where mail like $mail")->rowCount() === 1;
}

function searchRecup($mail, $code)
{
    $db = dbConnect();
    $mail = $db->quote($mail);
    $code = $db->quote($code);
    return $db->query("select * from RECUPERATION where code = $code and mail = $mail")->fetch();
}

function deleteRecup($id)
{
    $db = dbConnect();
    $db->exec("delete from RECUPERATION where id=$id");
}

/**
 * Word
 */

function listRandomWords($nombre)
{
    $db = dbConnect();
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, FRANCAIS.slug, JAPONAIS.id_type, JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, TYPE.id, TYPE.type from JAPONAIS
    inner join TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join FRANCAIS
        on wj.id_word = FRANCAIS.id
    inner join TYPE
        on JAPONAIS.id_type = TYPE.id
    ORDER BY RAND()
    LIMIT $nombre");
    return $select->fetchAll();
}

function listRandomGroups($nombre)
{
    $db = dbConnect();
    $select = $db->query("select g.libelle, g2.libelle as parent, g2.slug as parent_slug, g.quantifieur, g.slug from GROUPE g
    left join GROUPE g2 on g.id_parent = g2.id
    order by RAND() limit $nombre");
    return $select->fetchAll();
}

function selectOneRandomWord()
{
    $db = dbConnect();
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji from FRANCAIS
    inner join TRADUCTION trad on FRANCAIS.id = trad.id_word
    inner join JAPONAIS on trad.id_japonais = JAPONAIS.id
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
    $select = $db->query("select JAPONAIS.id, JAPONAIS.kanji, JAPONAIS.kana, JAPONAIS.romaji, JAPONAIS.description from JAPONAIS
    inner join TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join FRANCAIS
        on wj.id_word = FRANCAIS.id
    where FRANCAIS.francais like $francais");
    return $select->fetchAll();
}

function listFrancaisToJaponaisWord($japonais)
{
    $db = dbConnect();
    $japonais = $db->quote($japonais);
    $select = $db->query("select FRANCAIS.id, FRANCAIS.francais from JAPONAIS
    inner join TRADUCTION as wj
        on wj.id_japonais = JAPONAIS.id
    inner join FRANCAIS
        on wj.id_word = FRANCAIS.id
    where JAPONAIS.kanji like $japonais or JAPONAIS.kana like $japonais or JAPONAIS.romaji like $japonais");
    return $select->fetchAll();
}

/**
 * Listes
 */

function getListes($id_user): array
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    return $db->query("select id, nom, description, id_confidentiality, id_user from LISTES where id_user=$id_user")->fetchAll();
}

function selectListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select id, nom, description, id_confidentiality, id_user from LISTES where id=$id")->fetch();
}

function selectUserFromListe($id_liste)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    return $db->query("select USER.icone, USER.pseudo from USER 
        inner join LISTES on USER.id = LISTES.id_user
        where LISTES.id = $id_liste")->fetch();
}

function haveListes($id_user, $id_francais): array
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_francais = $db->quote($id_francais);
    return $db->query("select LISTES.id, nom, description, id_confidentiality, id_user from LISTES 
        inner join WORDS_LISTES wl on LISTES.id = wl.id_liste
        inner join FRANCAIS fr on wl.id_word = fr.id
        where id_user = $id_user and fr.id = $id_francais")->fetchAll();
}

function selectFrancaisFromListe($id): array
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select FRANCAIS.* from FRANCAIS 
        inner join WORDS_LISTES wl on FRANCAIS.id = wl.id_word
        inner join LISTES l on wl.id_liste = l.id
        where l.id=$id")->fetchAll();
}

function supprListe($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $db->query("delete from WORDS_LISTES where id_liste=$id");
    return $db->query("delete from LISTES where id=$id");
}

function editListe($nom, $desc, $id_confidentiality, $id, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id = $db->quote($id);
    $id_user = $db->quote($id_user);
    return $db->query("update LISTES set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user where id=$id");
}

function createListe($nom, $desc, $id_confidentiality, $id_user)
{
    $db = dbConnect();
    $nom = $db->quote($nom);
    $desc = $db->quote($desc);
    $id_confidentiality = $db->quote($id_confidentiality);
    $id_user = $db->quote($id_user);
    return $db->query("insert into LISTES set nom=$nom, description=$desc, id_confidentiality=$id_confidentiality, id_user=$id_user");
}

function searchListe($pseudo)
{
    $db = dbConnect();
    $select = $db->prepare('select id, nom, description from LISTES where id_user=?');
    $select->execute(array($pseudo));
    return $select->fetchAll();
}

function searchListeUser($pseudo)
{
    $db = dbConnect();
    $select = $db->prepare('select id, nom, description from LISTES where id_user=? and id_confidentiality=1');
    $select->execute(array($pseudo));
    return $select->fetchAll();
}

/**
 * Confidentiality
 */

function listConfidentiality()
{
    $db = dbConnect();
    $select = $db->query('select id, confidentiality from CONFIDENTIALITY order by confidentiality');
    return $select->fetchAll();
}

/**
 * Recherche
 */

function researchWord($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    return $db->query("select id, francais, slug from FRANCAIS where slug like $search")->fetch();
}

function researchGroupeSlug($search)
{
    $db = dbConnect();
    $search = $db->quote($search);
    $select = $db->query("select * from GROUPE where slug like $search");
    return $select->fetch();
}

function groupeParent($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from GROUPE where id=$id")->fetch();
}

function groupeEnfant($id): array
{
    $db = dbConnect();
    $id = $db->quote($id);
    return $db->query("select * from GROUPE where id_parent=$id")->fetchAll();
}

function listJaponaisToFrancais($id_francais): array
{
    $db = dbConnect();
    $id_francais = $db->quote($id_francais);
    return $db->query("select JAPONAIS.*, j.color as color from JAPONAIS
        left join JLPT j on j.id = JAPONAIS.jlpt
        inner join TRADUCTION t on t.id_japonais = JAPONAIS.id
        where id_word = $id_francais order by id_type")->fetchAll();
}

/**
 * Achat
 */

function listAchatByAccount($id_user): array
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    return $db->query("select RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat, type from RECOMPENSE
        inner join ACHAT on RECOMPENSE.id = ACHAT.id_recompense
        inner join RECOMPENSE_TYPE on RECOMPENSE.id_type = RECOMPENSE_TYPE.id
        where ACHAT.id_user=$id_user")->fetchAll();
}

function listAchatThemeByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat from ACHAT
        inner join RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Theme'");
    return $select->fetchAll();
}

function listThemes()
{
    $db = dbConnect();
    $select = $db->query("select RECOMPENSE.* from RECOMPENSE
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where type like 'Theme'");
    return $select->fetchAll();
}

function listAchatBackgroundByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat from ACHAT
        inner join RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Background'");
    return $select->fetchAll();
}

function listBackgrounds()
{
    $db = dbConnect();
    $select = $db->query("select RECOMPENSE.* from RECOMPENSE
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where type like 'Background'");
    return $select->fetchAll();
}

function listAchatIconByAccount($id_user)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select RECOMPENSE.id, RECOMPENSE.libelle, RECOMPENSE.date_parution, RECOMPENSE.slug, RECOMPENSE.cout, ACHAT.date_achat from ACHAT
        inner join RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where ACHAT.id_user=$id_user and RT.type like 'Icone'");
    return $select->fetchAll();
}

function getIcons(): array
{
    $db = dbConnect();
    return $db->query("select RECOMPENSE.* from RECOMPENSE
        inner join RECOMPENSE_TYPE RT on RECOMPENSE.id_type = RT.id
        where type like 'Icone'")->fetchAll();
}

function getIcon($id_user, $id_icon)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_icon = $db->quote($id_icon);
    return $db->query("select RECOMPENSE.id, RECOMPENSE.slug from ACHAT
        inner join RECOMPENSE on RECOMPENSE.id = ACHAT.id_recompense
        inner join RECOMPENSE_TYPE rt on RECOMPENSE.id_type = rt.id
        where ACHAT.id_user=$id_user and rt.type like 'Icone' and ACHAT.id_recompense=$id_icon")->fetch();
}

function achatByUser($id_user, $id_recompense): bool
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_recompense = $db->quote($id_recompense);
    return $db->query("select id from ACHAT where id_user=$id_user and id_recompense=$id_recompense")->rowCount() === 1;
}

function achatdb($id_user, $id_recompense)
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $id_recompense = $db->quote($id_recompense);
    $db->exec("insert into ACHAT set id_user=$id_user, id_recompense=$id_recompense, date_achat=curdate()");
}

function selectRecompense($id)
{
    $db = dbConnect();
    $id = $db->quote($id);
    $select = $db->query("select * from RECOMPENSE where id=$id");
    return $select->fetch();
}

/**
 * Autocomplete
 */

function autocompleteMots($key): array
{
    $db = dbConnect();
    $key = $db->quote($key . '%');
    $select = $db->query("select francais, slug, j.id_type, type, j.romaji from FRANCAIS 
        inner join TRADUCTION t on FRANCAIS.id = t.id_word
        inner join JAPONAIS j on t.id_japonais = j.id
        inner join TYPE ty on j.id_type = ty.id
        where francais like $key group by francais order by francais limit 0,10");
    return $select->fetchAll();
}

function getTypes($key): array
{
    $db = dbConnect();
    $select = $db->query("select type from FRANCAIS 
        inner join TRADUCTION t on FRANCAIS.id = t.id_word
        inner join JAPONAIS j on t.id_japonais = j.id
        inner join TYPE ty on j.id_type = ty.id
        where francais like '$key%' order by type");
    return $select->fetchAll();
}

function autocompleteUser($key, $id_user): array
{
    $db = dbConnect();
    $id_user = $db->quote($id_user);
    $select = $db->query("select pseudo, icone, slug from USER where pseudo like '$key%' and id!=$id_user order by pseudo limit 0,5");
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
    return $db->query("select * from WORDS_LISTES where id_liste=$id_liste and id_word=$id_word");
}

function addWordInListe($id_liste, $id_word)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $id_word = $db->quote($id_word);
    $db->query("insert into WORDS_LISTES set id_liste=$id_liste, id_word=$id_word");
}

function removeWordInListe($id_liste, $id_word)
{
    $db = dbConnect();
    $id_liste = $db->quote($id_liste);
    $id_word = $db->quote($id_word);
    $db->query("delete from WORDS_LISTES where id_liste=$id_liste and id_word=$id_word");
}

/**
 * Statistiques
 */

function countUser()
{
    $db = dbConnect();
    $select = $db->query("select count(*) as users from USER");
    return $select->fetch();
}

function countJaponais()
{
    $db = dbConnect();
    $select = $db->query("select count(*) as japonais from JAPONAIS");
    return $select->fetch();
}

function sumSakura()
{
    $db = dbConnect();
    $select = $db->query("select sum(sakura) as sakura, sum(sakura_total) as sakura_total from SAKURA");
    return $select->fetch();
}

function bestUser()
{
    $db = dbConnect();
    $select = $db->query("select sakura, pseudo from SAKURA 
        inner join USER on SAKURA.id_user = USER.id
        order by sakura desc limit 5");
    return $select->fetchAll();
}

function bestUser2()
{
    $db = dbConnect();
    $select = $db->query("select sakura_total, pseudo from SAKURA 
        inner join USER on SAKURA.id_user = USER.id
        order by sakura_total desc limit 5");
    return $select->fetchAll();
}

function bestKanjis()
{
    $db = dbConnect();
    $select = $db->query("select KANJI.id, kanji, count(id_kanji) count, kun_yomi from KANJI
        inner join JAPONAIS_KANJI jk on KANJI.id = jk.id_kanji
        group by jk.id_kanji order by count(id_kanji) desc limit 10");
    return $select->fetchAll();
}

function lastDayHistory(): array
{
    $db = dbConnect();
    return $db->query("select * from select_day")->fetchAll();
}

function lastWeekHistory()
{
    $db = dbConnect();
    return $db->query("select * from select_week")->fetchAll();
}

function lastMonthHistory()
{
    $db = dbConnect();
    return $db->query("select * from select_month")->fetchAll();
}

/**
 * Kanji
 */

function listFrancaisToJaponaisLimit1($id_japonais)
{
    $db = dbConnect();
    $id_japonais = $db->quote($id_japonais);
    $select = $db->query("select FRANCAIS.francais, FRANCAIS.slug, JAPONAIS.id_type from FRANCAIS
    inner join TRADUCTION as wj
        on wj.id_word = FRANCAIS.id
    inner join JAPONAIS
        on wj.id_japonais = JAPONAIS.id
    where JAPONAIS.id=$id_japonais limit 1");
    return $select->fetch();
}

/**
 * Kana
 */

function listKana()
{
    $db = dbConnect();
    return $db->query("select hiragana, katakana, romaji from KANA where hiragana is not null")->fetchAll();
}

function getKana($romaji)
{
    $db = dbConnect();
    $romaji = $db->quote($romaji);
    return $db->query("select hiragana, katakana, romaji from KANA where romaji like $romaji")->fetch();
}

function selectHistory($id)
{
    $db = dbConnect();
    return $db->query("select id, riddle, response, life from HISTORIQUE_RIDDLE where id_user = $id order by id desc limit 15")->fetchAll();
}

/**
 * Exception
 */

function listExceptions()
{
    $db = dbConnect();
    return $db->query("select libelle from EXCEPTION")->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Music
 */

function selectMusics()
{
    $db = dbConnect();
    return $db->query("select anime, chanteur, titre, slug from MUSIQUE")->fetchAll();
}

function selectMusic($slug)
{
    $db = dbConnect();
    $slug = $db->quote($slug);
    return $db->query("select japonais, romaji, francais, anime, chanteur, titre, audio from MUSIQUE where slug like $slug")->fetch();
}