<?php

define('BASE_URL', 'https://lexiquejaponais.fr/');
session_start();
require_once '../model/frontend.php';
require_once '../model/backend.php';
require_once '../controller/libs/accent.php';

if (!isset($_POST['riddle'])) {
    if ($_SESSION['kanji'] == 1) $values = listFromGroupe($_POST['group']);
    else $values = listFromGroupeWithoutKanji($_POST['group']);

    $rand_keys = array();
    for ($i = 0; $i < 20; $i++) $rand_keys[] += array_rand($values);

    echo 'success -- ';
    foreach ($rand_keys as $rand) {
        $keys = array_keys($values[$rand]);
        $int = rand(0, count($values[$rand]) - 1);
        echo $values[$rand][$keys[$int]] . "/";
    }
} else {
    $b = false;
    $french = true;
    $value = accents(mb_strtolower($_POST['value']));

    $traducts = listJaponaisToFrancaisWord($_POST['riddle']);
    if ($traducts == null) {
        $traducts = listFrancaisToJaponaisWord($_POST['riddle']);
        $french = false;
    }

    foreach ($traducts as $traduct) {
        if ($french) {
            if ($value === strtolower($traduct['romaji']) || $value === strtolower($traduct['kanji']) || $value === strtolower($traduct['kana'])) {
                $b = true;
            }
        } else {
            if ($value === accents(mb_strtolower($traduct['francais']))) {
                $b = true;
            }
        }
    }


    $array = array();
    $vars = explode(',', $_POST['array']);
    if ($b) {
        $array = ['success' => [
            'riddle' => array_shift($vars),
            'array' => $vars
        ]];

        $_SESSION['points'] += 10;
        setSakura($_SESSION['id'], 10);
    } else {
        array_push($vars, $_POST['riddle']);
        $array = array();
        $array = ['failed' => [
            'riddle' => array_shift($vars),
            'array' => $vars
        ]];
    }
    header('Content-Type: application/json');
    echo json_encode($array);
}