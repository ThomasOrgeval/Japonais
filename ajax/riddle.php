<?php

session_start();
require_once '../model/frontend.php';
require_once '../model/backend.php';

$bool = false;
$french = true;
$sakura = 0;

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
            if ($value === strtolower($traduct['romaji'])) $sakura = 15;
            elseif ($value === strtolower($traduct['kana'])) $sakura = 30;
            elseif ($value === strtolower($traduct['kanji'])) $sakura = 45;
        }
    } else {
        if ($value === strtolower($traduct['francais'])) {
            $bool = true;
            $sakura = 20;
        }
    }
}

if (rand(0, 1) === 1) { // Sélection mot japonais
    $japonais = rand(0, 2);
    if ($japonais === 0) $_SESSION['riddle'] = selectOneRandomWord()['kanji'];
    elseif ($japonais === 1) $_SESSION['riddle'] = selectOneRandomWord()['kana'];
    else $_SESSION['riddle'] = selectOneRandomWord()['romaji'];
} else { // Sélection mot francais
    $_SESSION['riddle'] = selectOneRandomWord()['francais'];
}

if ($bool) {
    $_SESSION['points'] += $sakura;
    setSakura($_SESSION['id'], $sakura);
    setRiddle($_SESSION['id'], $_SESSION['riddle'], 1);
    echo "Success - " . $sakura;
} else {
    --$_SESSION['life'];
    setLife($_SESSION['id'], $_SESSION['life']);
    setRiddle($_SESSION['id'], $_SESSION['riddle'], 0);
    if ($french) {
        echo "Failed - " . $traducts[0]['romaji'];
    } else {
        echo "Failed - " . $traducts[0]['francais'];
    }
}