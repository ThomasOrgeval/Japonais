<?php

session_start();
if ($_SESSION['connect'] === 'OK' && $_SESSION['admin'] == 1) {
    require_once '../model/frontend.php';
    require_once '../model/backend.php';

    if ($_POST['lang'] == 'fr') deleteFrancais($_POST['id']);
    else if ($_POST['lang'] == 'en') deleteAnglais($_POST['id']);
    echo 'success';
} else echo 'fail';