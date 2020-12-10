<?php

require_once '../model/frontend.php';
require_once '../model/backend.php';

$value = selectGroupeAndJaponais($_POST['id_group'], $_POST['id_japonais']);

if ($value->rowCount() == 0) {
    addGroupeToJaponais($_POST['id_group'], $_POST['id_japonais']);
    echo 'ADD';
} else {
    deleteGroupeToJaponais($_POST['id_group'], $_POST['id_japonais']);
    echo 'REMOVE';
}