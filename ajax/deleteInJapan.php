<?php

session_start();
require_once __DIR__ . '/../model/frontend.php';
require_once __DIR__ . '/../model/backend.php';
if ($_SESSION['Account']['admin'] == 1 && isAdmin($_SESSION['Account']['pseudo'])) {

    if ($_POST['lang'] == 'fr') deleteFrancais($_POST['id']);
    elseif ($_POST['lang'] == 'en') deleteAnglais($_POST['id']);
    echo 'success';
} else echo 'fail';