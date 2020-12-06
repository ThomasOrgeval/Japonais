<?php

session_start();
require_once '../model/frontend.php';
require_once '../model/backend.php';

$bool = false;
$french = true;
$traducts = listJaponaisToFrancaisWord($_SESSION['riddle']);
if ($traducts == null) {
    $traducts = listFrancaisToJaponaisWord($_SESSION['riddle']);
    $french = false;
}
$value = strtolower($_POST['value']);

foreach ($traducts as $traduct) {
    if ($french) {
        if ($value === strtolower($traduct['romaji']) || $value === strtolower($traduct['kanji']) || $value === strtolower($traduct['kana'])) {
            $bool = true;
        }
    } else {
        if ($value === strtolower($traduct['francais'])) {
            $bool = true;
        }
    }
}

if (rand(0, 1) === 1) { // Sélection mot japonais
    $japonais = rand(0, 2);
    if ($japonais === 0) {
        $_SESSION['riddle'] = selectOneRandomWord()['kanji'];
    } elseif ($japonais === 1) {
        $_SESSION['riddle'] = selectOneRandomWord()['kana'];
    } else {
        $_SESSION['riddle'] = selectOneRandomWord()['romaji'];
    }
} else { // Sélection mot francais
    $_SESSION['riddle'] = selectOneRandomWord()['francais'];
}
setRiddle($_SESSION['id'], $_SESSION['riddle']);

if ($bool) {
    $_SESSION['points'] += 20;
    setSakura($_SESSION['id'], 20);
    echo "Success";
} else {
    --$_SESSION['life'];
    setLife($_SESSION['id'], $_SESSION['life']);
    if ($french) {
        echo "Failed - " . $traducts[0]['romaji'];
    } else {
        echo "Failed - " . $traducts[0]['francais'];
    }
}