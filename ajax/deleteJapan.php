<?php

require_once '../model/frontend.php';
require_once '../model/backend.php';

deleteAllKanjiForJaponais($_POST['id']);
deleteAllForJaponais($_POST['id']);
$deleteJaponais = supprJaponais($_POST['id']);

if ($deleteJaponais == true) {
    echo 'SUCCESS';
}