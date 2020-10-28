<?php

require './model/backend.php';

function admin_portail()
{
    if (connect_admin()) {
        require './view/backend/index.php';
    }
}

function groupe()
{
    if (connect_admin()) {
        $groupes = listGroupe();
        require './view/backend/groupe.php';
    }
}

function groupe_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $groupe = testGroupe($_GET['id']);
            if ($groupe->rowCount() === 0) {
                setFlash('Il n\'y a pas de groupe avec cet ID', 'danger');
                header('Location: index.php?p=groupe');
            }
            $_POST = $groupe->fetch();
        }
        require 'view/backend/groupe_edit.php';
    }
}

function word()
{
    if (connect_admin()) {
        $_POST['words'] = listWords();
        require './view/backend/word.php';
    }
}

function word_edit()
{
    if (connect_admin()) {
        // Ajout de tous les types de mots
        $types = listType();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $word = testWord($_GET['id']);
            $groupes = listGroupeToWord($_GET['id']);
            $otherGroupes = otherGroupeToWord();
            if ($word->rowCount() === 0) {
                setFlash("Il n'y a pas de mot avec cet ID", "danger");
                header("Location:index.php?p=word");
            }
            $_POST = $word->fetch();
        }
        require './view/backend/word_edit.php';
    }
}

function francais_add()
{
    if (connect_admin()) {
        $japonais = array();
        $anglais = array();

        for ($i = 0; $i <= sizeof($_POST['id_jap']); $i++) {
            if (!empty($_POST['kanji'][$i]) || !empty($_POST['kana'][$i] || !empty($_POST['romaji'][$i]))) {
                addJaponaisFromOther($_POST['id_jap'][$i], $_POST['kanji'][$i], $_POST['kana'][$i], $_POST['romaji'][$i]);
                $japonais[] = $_POST['romaji'][$i];
            }
        }
        for ($i = 0; $i <= sizeof($_POST['id_anglais']); $i++) {
            if (!empty($_POST['anglais'][$i])) {
                addAnglaisFromOther($_POST['id_anglais'][$i], $_POST['anglais'][$i], $_POST['id_type_anglais'][$i]);
                $anglais[] = $_POST['anglais'][$i];
            }
        }
        addFrancais($_GET['id'], $_POST['francais'], $_POST['id_type'], $japonais, $anglais);
    }
}

function type()
{
    if (connect_admin()) {
        $types = listType();
        require './view/backend/type.php';
    }
}

function type_edit()
{
    if (connect_admin()) {
        if (isset($_GET['id'])) {
            $type = testType($_GET['id']);
            if ($type->rowCount() === 0) {
                setFlash("Il n'y a pas de type avec cet ID", "danger");
                header("Location:index.php?p=type");
            }
            $_POST = $type->fetch();
        }
        require './view/backend/type_edit.php';
    }
}

function japonais()
{
    if (connect_admin()) {
        $_POST['japonais'] = listJaponais();
        require './view/backend/japonais.php';
    }
}

function japonais_edit()
{
    if (connect_admin()) {
        $types = listType();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $japonais = testJaponaisID($_GET['id']);
            if ($japonais->rowCount() === 0) {
                setFlash("Il n'y a pas de mot japonais avec cet ID", "danger");
                header("Location:index.php?p=japonais");
            }
            $_POST = $japonais->fetch();
            $_POST['kanjis'] = listKanjiToJaponais($_GET['id']);
        }
        require './view/backend/japonais_edit.php';
    }
}

function japonais_add()
{
    if (connect_admin()) {
        $francais = array();
        $anglais = array();

        for ($i = 0; $i <= sizeof($_POST['id_francais']); $i++) {
            if (!empty($_POST['francais'][$i])) {
                addFrancaisFromOther($_POST['id_francais'][$i], $_POST['francais'][$i], $_POST['id_type'][$i]);
                $francais[] = $_POST['francais'][$i];
            }
        }
        for ($i = 0; $i <= sizeof($_POST['id_anglais']); $i++) {
            if (!empty($_POST['anglais'][$i])) {
                addAnglaisFromOther($_POST['id_anglais'][$i], $_POST['anglais'][$i], $_POST['id_type_anglais'][$i]);
                $anglais[] = $_POST['anglais'][$i];
            }
        }

        addJaponais($_GET['id'], $_POST['kanji'], $_POST['kana'], $_POST['romaji'], $francais, $anglais);
    }
}

function anglais()
{
    if (connect_admin()) {
        $_POST['anglais'] = listAnglais();
        require './view/backend/anglais.php';
    }
}

function anglais_edit()
{
    if (connect_admin()) {
        $types = listType();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $anglais = testAnglais($_GET['id']);
            if ($anglais->rowCount() === 0) {
                setFlash("Il n'y a pas de mot anglais avec cet ID", "danger");
                header("Location:index.php?p=anglais");
            }
            $_POST = $anglais->fetch();
        }
        require './view/backend/anglais_edit.php';
    }
}

function anglais_add()
{
    if (connect_admin()) {
        $japonais = array();
        $francais = array();

        for ($i = 0; $i <= sizeof($_POST['id_jap']); $i++) {
            if (!empty($_POST['kanji'][$i]) || !empty($_POST['kana'][$i] || !empty($_POST['romaji'][$i]))) {
                addJaponaisFromOther($_POST['id_jap'][$i], $_POST['kanji'][$i], $_POST['kana'][$i], $_POST['romaji'][$i]);
                $japonais[] = $_POST['romaji'][$i];
            }
        }
        for ($i = 0; $i <= sizeof($_POST['id_francais']); $i++) {
            if (!empty($_POST['francais'][$i])) {
                addFrancaisFromOther($_POST['id_francais'][$i], $_POST['francais'][$i], $_POST['id_type_francais'][$i]);
                $francais[] = $_POST['francais'][$i];
            }
        }
        addAnglais($_GET['id'], $_POST['anglais'], $_POST['id_type'], $francais, $japonais);
    }
}

function kanji()
{
    if (connect_admin()) {
        $_POST['kanji'] = listKanji();
        require './view/backend/kanji.php';
    }
}

function kanji_edit()
{
    if (connect_admin()) {

        if (isset($_GET['id'])) {
            $kanji = testKanji($_GET['id']);
            if ($kanji->rowCount() === 0) {
                setFlash("Il n'y a pas de kanji avec cet ID", "danger");
                header("Location:index.php?p=kanji");
            }
            $_POST = $kanji->fetch();
            $_POST['japonais'] = listJaponaisToKanji($_GET['id']);
        }
        require './view/backend/kanji_edit.php';
    }
}

function recompense()
{
    if (connect_admin()) {
        $_POST['recompense'] = listRecompense();
        require './view/backend/recompense.php';
    }
}

function recompense_edit()
{
    if (connect_admin()) {
        $types = listTypeRecompense();
        $type_list = array();
        foreach ($types as $type) {
            $type_list[$type['id']] = $type['type'];
        }

        if (isset($_GET['id'])) {
            $recompense = testRecompense($_GET['id']);
            if ($recompense->rowCount() === 0) {
                setFlash("Il n'y a pas de récompense avec cet ID", "danger");
                header("Location:index.php?p=recompense");
            }
            $_POST = $recompense->fetch();
            $_POST['acheteurs'] = listAchateurFromRecompense($_GET['id']);
        }
        require './view/backend/recompense_edit.php';
    }
}

function connect_admin()
{
    if ($_SESSION['connect'] !== 'OK' || $_SESSION['admin'] === 0) {
        header('Location:index.php?p=accueil');
        return false;
    }
    return true;
}

function securize($var)
{
    $var = htmlspecialchars($var);
    $var = trim($var);
    $var = strip_tags($var);
    return $var;
}

function exportxml()
{
    if (connect_admin()) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<pages>
';

        $words = listWords();
        foreach ($words as $word) {
            $xml .= '    <link>
';
            $xml .= '        <title>' . $word['francais'] . '</title>
';
            $xml .= '        <url>index.php?p=search&amp;t=word&amp;q=' . $word['francais'] . '</url>
';
            $xml .= '    </link>
';
        }
        $groupes = listGroupe();
        foreach ($groupes as $groupe) {
            $xml .= '    <link>
';
            $xml .= '        <title>' . $groupe['libelle'] . '</title>
';
            $xml .= '        <url>index.php?p=search&amp;t=groupe&amp;q=' . $groupe['libelle'] . '</url>
';
            $xml .= '    </link>
';
        }

        $xml .= '</pages>';
        $fp = fopen("links.xml", 'w+');
        fputs($fp, $xml);
        fclose($fp);
        setFlash('Export xml réussi');
        header('Location:index.php?p=accueil');
    }
}

/**
 * Groupe
 */

function addGroupe($libelle, $id)
{
    if (connect_admin()) {
        $libelle = securize($libelle);

        if ($id > 0) {
            $addGroupe = editGroupe($id, $libelle);
        } else {
            $addGroupe = createGroupe($libelle);
        }

        if ($addGroupe === false) {
            setFlash("Le groupe n'a pas été ajouté", 'danger');
            throw new Exception();
        }

        setFlash('Le groupe a bien été ajouté');
        header('Location:index.php?p=groupe');
    }
}

function deleteGroupe($id)
{
    if (connect_admin()) {
        deleteAllGroupeForGroupe($id);
        $deleteGroupe = supprGroupe($id);
        if ($deleteGroupe === false) {
            setFlash('Le groupe n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le groupe a bien été supprimé');
        header('Location:index.php?p=groupe');
    }
}

/**
 * Francais
 */

function addFrancaisFromOther($id, $francais, $id_type)
{
    if (connect_admin()) {
        $francais = securize($francais);

        if ($id > 0) {
            editWord($francais, $id, $id_type);
        } else {
            createWord($francais, $id_type);
        }
    }
}

function addFrancais($id, $francais, $id_type, $listJaponais, $listAnglais)
{
    if (connect_admin()) {
        $francais = securize($francais);

        if ($id > 0) {
            $addWord = editWord($francais, $id, $id_type);
        } else {
            $addWord = createWord($francais, $id_type);
            $id = researchWord($francais);
            $id = $id['id'];
        }

        foreach ($listJaponais as $japonais) {
            $id_japonais = researchJaponais($japonais);
            addJaponaisKanji($id_japonais['kanji'], $id_japonais['id']);
            if (empty(selectJaponaisAndFrancais($id, $id_japonais['id']))) {
                createJaponaisAndFrancais($id, $id_japonais['id']);
            }
        }

        foreach ($listAnglais as $anglais) {
            $id_anglais = researchAnglais($anglais);
            if (empty(selectAnglaisAndFrancais($id, $id_anglais['id']))) {
                createAnglaisAndFrancais($id, $id_anglais['id']);
            }
        }

        $japonais = listJaponaisToFrancais($id);
        foreach ($japonais as $mot) {
            foreach ($listAnglais as $anglais) {
                $id_anglais = researchAnglais($anglais);
                if (empty(selectAnglaisAndJaponais($mot['id'], $id_anglais['id']))) {
                    createAnglaisAndJaponais($mot['id'], $id_anglais['id']);
                }
            }
        }

        if ($addWord === false) {
            setFlash('Le mot n\'a pas été ajouté', 'danger');
        } else {
            setFlash('Le mot a bien été crée');
            header('Location:index.php?p=word');
        }
    }
}

function deleteFrancais($id)
{
    if (connect_admin()) {
        deleteAllGroupeForWord($id);
        deleteAllForFrancais($id);
        $deleteWord = supprWord($id);
        if ($deleteWord === false) {
            setFlash('Le mot n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot a bien été supprimé');
        header('Location:index.php?p=word');
    }
}

function otherGroupeToWord()
{
    if (connect_admin()) {
        $listPresent = listGroupeToWord($_GET['id']);
        $listAll = listGroupe();
        $listOther = $listAll;
        foreach ($listPresent as $present) {
            foreach ($listAll as $item) {
                if ($present['libelle'] === $item['libelle']) {
                    unset($listOther[array_search($present, $listOther, true)]);
                }
            }
        }
        return $listOther;
    }
}

function wordGroupe($id_groupe, $id, $bool)
{
    if (connect_admin()) {
        if ($bool === 1) {
            $wordGroupe = addGroupeToWord($id_groupe, $id);
        } else {
            $wordGroupe = deleteGroupeToWord($id_groupe, $id);
        }

        if ($wordGroupe === false) {
            throw new Exception();
        }

        header('Location:index.php?p=word_edit&id=' . $id);
    }
}

function deleteFrancaisInJaponais($id_francais, $id_japonais)
{
    if (connect_admin()) {
        deleteAllGroupeForWord($id_francais);
        deleteAllForFrancais($id_francais);
        $delete = supprWord($id_francais);
        if ($delete === false) {
            setFlash('Le mot francais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot francais a bien été supprimé');
        header('Location:index.php?p=japonais_edit&id=' . $id_japonais);
    }
}

function deleteFrancaisInAnglais($id_francais, $id_anglais)
{
    if (connect_admin()) {
        deleteAllGroupeForWord($id_francais);
        deleteAllForFrancais($id_francais);
        $delete = supprWord($id_francais);
        if ($delete === false) {
            setFlash('Le mot francais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot francais a bien été supprimé');
        header('Location:index.php?p=anglais_edit&id=' . $id_anglais);
    }
}

/**
 * Type
 */

function addType($id, $type)
{
    if (connect_admin()) {
        $type = securize($type);

        if ($id > 0) {
            $addType = editType($id, $type);
        } else {
            $addType = createType($type);
        }

        if ($addType === false) {
            setFlash('Le type n\'a pas été ajouté', 'danger');
            throw new Exception();
        }

        setFlash('Le type a bien été crée');
        header('Location:index.php?p=type');
    }
}

function deleteType($id)
{
    if (connect_admin()) {
        $deleteType = supprType($id);
        if ($deleteType === false) {
            setFlash('Le type n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le type a bien été supprimé');
        header('Location:index.php?p=type');
    }
}

/**
 * Japonais
 */

function addJaponaisFromOther($id, $kanji, $kana, $romaji)
{
    if (connect_admin()) {
        $kanji = securize($kanji);
        $kana = securize($kana);
        $romaji = securize($romaji);

        if ($id > 0) {
            editJaponais($kana, $kanji, $romaji, $id);
        } else {
            createJaponais($kana, $kanji, $romaji);
        }
    }
}

function addJaponais($id, $kanji, $kana, $romaji, $listFrancais, $listAnglais)
{
    if (connect_admin()) {
        $kanji = securize($kanji);
        $kana = securize($kana);
        $romaji = securize($romaji);

        if ($id > 0) {
            $addWord = editJaponais($kana, $kanji, $romaji, $id);
        } else {
            $addWord = createJaponais($kana, $kanji, $romaji);
            $id = researchJaponais($romaji);
            $id = $id['id'];
        }
        addJaponaisKanji($kanji, $id);

        foreach ($listFrancais as $francais) {
            $id_francais = researchWord($francais);
            if (empty(selectJaponaisAndFrancais($id_francais['id'], $id))) {
                createJaponaisAndFrancais($id_francais['id'], $id);
            }
        }

        foreach ($listAnglais as $anglais) {
            $id_anglais = researchAnglais($anglais);
            if (empty(selectAnglaisAndJaponais($id, $id_anglais['id']))) {
                createAnglaisAndJaponais($id, $id_anglais['id']);
            }
        }

        $francais = listFrancaisToJaponais($id);
        foreach ($francais as $mot) {
            foreach ($listAnglais as $anglais) {
                $id_anglais = researchAnglais($anglais);
                if (empty(selectAnglaisAndFrancais($mot['id'], $id_anglais['id']))) {
                    createAnglaisAndFrancais($mot['id'], $id_anglais['id']);
                }
            }
        }

        if ($addWord === false) {
            setFlash('Le mot n\'a pas été ajouté', 'danger');
            throw new Exception();
        }

        setFlash('Le mot a bien été crée');
        header('Location:index.php?p=japonais');
    }
}

function deleteJaponais($id)
{
    if (connect_admin()) {
        deleteAllKanjiForJaponais($id);
        deleteAllForJaponais($id);
        $deleteJaponais = supprJaponais($id);
        if ($deleteJaponais === false) {
            setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=japonais');
    }
}

function deleteJaponaisInFrancais($id_japonais, $id_francais)
{
    if (connect_admin()) {
        deleteAllKanjiForJaponais($id_japonais);
        deleteAllForJaponais($id_japonais);
        $delete = supprJaponais($id_japonais);
        if ($delete === false) {
            setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=word_edit&id=' . $id_francais);
    }
}

function deleteJaponaisInAnglais($id_japonais, $id_anglais)
{
    if (connect_admin()) {
        deleteAllKanjiForJaponais($id_japonais);
        deleteAllForJaponais($id_japonais);
        $delete = supprJaponais($id_japonais);
        if ($delete === false) {
            setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=anglais_edit&id=' . $id_anglais);
    }
}

/**
 * Anglais
 */

function deleteAnglais($id)
{
    if (connect_admin()) {
        deleteAllForAnglais($id);
        $delete = supprAnglais($id);
        if ($delete === false) {
            setFlash('Le mot anglais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot anglais a bien été supprimé');
        header('Location:index.php?p=anglais');
    }
}

function deleteAnglaisInJaponais($id_anglais, $id_japonais)
{
    if (connect_admin()) {
        deleteAllForAnglais($id_anglais);
        $delete = supprAnglais($id_anglais);
        if ($delete === false) {
            setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=japonais_edit&id=' . $id_japonais);
    }
}

function deleteAnglaisInFrancais($id_anglais, $id_francais)
{
    if (connect_admin()) {
        deleteAllForAnglais($id_anglais);
        $delete = supprAnglais($id_anglais);
        if ($delete === false) {
            setFlash('Le mot japonais n\'a pas été supprimé', 'danger');
            throw new Exception();
        }

        setFlash('Le mot japonais a bien été supprimé');
        header('Location:index.php?p=word_edit&id=' . $id_francais);
    }
}

function addAnglaisFromOther($id, $anglais, $id_type)
{
    if (connect_admin()) {
        $anglais = securize($anglais);

        if ($id > 0) {
            editAnglais($anglais, $id, $id_type);
        } else {
            createAnglais($anglais, $id_type);
        }
    }
}

function addAnglais($id, $anglais, $id_type, $listFrancais, $listJaponais)
{
    if (connect_admin()) {
        $anglais = securize($anglais);

        if ($id > 0) {
            $addWord = editAnglais($anglais, $id, $id_type);
        } else {
            $addWord = createAnglais($anglais, $id_type);
            $id = researchAnglais($anglais);
            $id = $id['id'];
        }

        foreach ($listFrancais as $francais) {
            $id_francais = researchWord($francais);
            if (empty(selectAnglaisAndFrancais($id_francais['id'], $id))) {
                createAnglaisAndFrancais($id_francais['id'], $id);
            }
        }

        foreach ($listJaponais as $japonais) {
            $id_japonais = researchJaponais($japonais);
            addJaponaisKanji($id_japonais['kanji'], $id_japonais['id']);
            if (empty(selectAnglaisAndJaponais($id_japonais['id'], $id))) {
                createAnglaisAndJaponais($id_japonais['id'], $id);
            }
        }

        $francais = listFrancaisToAnglais($id);
        foreach ($francais as $mot) {
            foreach ($listJaponais as $japonais) {
                $id_japonais = researchJaponais($japonais);
                if (empty(selectJaponaisAndFrancais($mot['id'], $id_japonais['id']))) {
                    createJaponaisAndFrancais($mot['id'], $id_japonais['id']);
                }
            }
        }

        if ($addWord === false) {
            setFlash('Le mot n\'a pas été ajouté', 'danger');
            throw new Exception();
        }

        setFlash('Le mot a bien été crée');
        header('Location:index.php?p=anglais');
    }
}

/**
 * Kanji
 */

function saveKanji()
{
    if (connect_admin()) {
        $addKanji = editKanji($_POST['id'], $_POST['on_yomi'], $_POST['kun_yomi'], $_POST['sens'], $_POST['sens_en']);
        if ($addKanji === false) {
            setFlash('Le kanji n\'a pas été sauvegardé', 'danger');
            throw new Exception();
        }
        setFlash('Le kanji a bien été sauvegardé');
        header('Location:index.php?p=kanji');
    }
}

function addJaponaisKanji($values, $id)
{
    $pattern = "/\P{Han}/u"; // Garde uniquement les kanjis
    $values = preg_replace($pattern, '', $values);
    $pattern = '/(?<!^)(?!$)/u'; // Crée un tableau de chaque caractère
    $values = preg_split($pattern, $values);

    foreach ($values as $value) {
        $kanji = testKanjiContains($value);
        if ($kanji->rowCount() !== 0) {
            $kanji = $kanji->fetch();
            if (!testKanjiJaponais($id, $kanji['id'])) {
                addKanjiJaponais($id, $kanji['id']);
            }
        }
    }
}

/**
 * Récompense
 */

function addRecompense()
{
    if (connect_admin()) {
        if (preg_match('/^[a-z\-0-9]+$/', $_POST['slug'])) {
            if ($_GET['id'] > 0) {
                $addRecompense = editRecompense($_GET['id'], $_POST['libelle'], $_POST['cout'], $_POST['slug'], $_POST['id_type']);
            } else {
                $addRecompense = createRecompense($_POST['libelle'], $_POST['cout'], $_POST['slug'], $_POST['id_type']);
            }

            if ($addRecompense === false) {
                setFlash('La récompense n\'a pas été ajouté', 'danger');
                throw new Exception();
            }

            setFlash('La récompense a bien été crée');
            header('Location:index.php?p=recompense');
        } else {
            setFlash("Le slug n'est pas valide", 'danger');
        }
    }
}

function deleteRecompense($id)
{
    if (connect_admin()) {
        $delete = supprRecompense($id);
        if ($delete === false) {
            setFlash('La récompense n\'a pas été supprimée', 'danger');
            throw new Exception();
        }

        setFlash('La récompense a bien été supprimée');
        header('Location:index.php?p=recompense');
    }
}