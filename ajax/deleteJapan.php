<?php

require_once '../model/frontend.php';
require_once '../model/backend.php';

deleteAllKanjiForJaponais($_POST['id']);
$anglais = listAnglaisToJaponais($_POST['id']);
foreach ($anglais as $word) {
    deleteAllForAnglais($word['id']);
    supprAnglais($word['id']);
}
$francais = listFrancaisToJaponais($_POST['id']);
foreach ($francais as $word) {
    deleteAllForFrancais($word['id']);
    supprWord($word['id']);
}
$deleteJaponais = supprJaponais($_POST['id']);

if ($deleteJaponais == true) {
    echo 'SUCCESS';
}