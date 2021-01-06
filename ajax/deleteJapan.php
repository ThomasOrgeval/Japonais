<?php

require '../controller/libs/base_url.php';
session_start();
if ($_SESSION['connect'] === 'OK' && $_SESSION['admin'] == 1) {
    require_once '../model/frontend.php';
    require_once '../model/backend.php';

    deleteAllKanjiForJaponais($_POST['id']);
    deleteAllGroupeForJaponais($_POST['id']);
    $anglais = listAnglaisToJaponais($_POST['id']);
    foreach ($anglais as $word) {
        if (uniqueAnglais($word['id']) == 1) {
            deleteAnglais($word['id']);
            supprAnglais($word['id']);
        }
    }
    $francais = listFrancaisToJaponais($_POST['id']);
    foreach ($francais as $word) {
        if (uniqueFrancais($word['id']) == 1) {
            deleteFrancais($word['id']);
            supprWord($word['id']);
        }
    }
    $deleteJaponais = supprJaponais($_POST['id']);

    if ($deleteJaponais == true) echo 'success';
} else echo 'fail';