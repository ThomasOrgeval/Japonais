<?php

require './controller/frontend.php';

try {
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
        if ($p === 'accueil') {
            accueil();
        } elseif ($p === 'groupe') {
            groupe();
        } elseif ($p === 'groupe_edit') {
            groupe_edit();
        } elseif ($p === 'groupe_add') {
            if (isset($_POST['save'])) {
                addGroupe($_POST['libelle'], $_GET['id']);
            }
        } elseif ($p === 'groupe_delete') {
            deleteGroupe($_GET['id']);
        } elseif ($p === 'word') {
            word();
        } elseif ($p === 'word_edit') {
            word_edit();
        } elseif ($p === 'word_add') {
            if (isset($_POST['save'])) {
                addWord($_POST['fr'], $_POST['kana'], $_POST['kanji'], $_POST['romaji'], $_GET['id']);
            }
        } elseif ($p === 'word_delete') {
            deleteWord($_GET['id']);
        } elseif ($p === 'word_groupe') {
            wordGroupe($_GET['id_groupe'], $_GET['id'], $_GET['bool']);
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    $php_errormsg = $e->getMessage();
    require './view/errorView.php';
}