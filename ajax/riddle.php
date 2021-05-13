<?php

session_start();
require_once __DIR__ . '/../model/frontend.php';
require_once __DIR__ . '/../model/backend.php';
require_once __DIR__ . '/../controller/libs/accent.php';

$value = accents(mb_strtolower($_POST['value']));

$bool = false;
$french = true;
$sakura = 0;

$traducts = listJaponaisToFrancaisWord($_SESSION['Account']['riddle']);
if ($traducts == null) {
    $traducts = listFrancaisToJaponaisWord($_SESSION['Account']['riddle']);
    $french = false;
}

foreach ($traducts as $traduct) {
    if ($french) {
        if ($value === strtolower($traduct['romaji']) || $value === strtolower($traduct['kanji']) || $value === strtolower($traduct['kana'])) {
            $bool = true;
            if ($value === strtolower($traduct['romaji'])) $sakura = 15;
            elseif ($value === strtolower($traduct['kana'])) $sakura = 30;
            elseif ($value === strtolower($traduct['kanji'])) $sakura = 45;
        }
    } else {
        if ($value === accents(mb_strtolower($traduct['francais']))) {
            $bool = true;
            $sakura = 20;
        }
    }
}

if (rand(0, 1) === 1) { // Sélection mot japonais
    if ($_SESSION['Account']['kanji'] == 1) $japonais = rand(0, 2);
    else $japonais = rand(0, 1);

    if ($japonais === 0) $_SESSION['Account']['riddle'] = selectOneRandomWord()['romaji'];
    elseif ($japonais === 1) $_SESSION['Account']['riddle'] = selectOneRandomWord()['kana'];
    else $_SESSION['Account']['riddle'] = selectOneRandomWord()['kanji'];
} else { // Sélection mot francais
    $_SESSION['Account']['riddle'] = selectOneRandomWord()['francais'];
}

if ($bool) {
    $_SESSION['Account']['points'] += $sakura;
    setSakura($_SESSION['Account']['id'], $sakura);
    setRiddle($_SESSION['Account']['id'], $_SESSION['Account']['riddle'], 1);
    echo "Success - " . $sakura;
} else {
    --$_SESSION['Account']['life'];
    setLife($_SESSION['Account']['id'], $_SESSION['Account']['life']);
    setRiddle($_SESSION['Account']['id'], $_SESSION['Account']['riddle'], 0);
    if ($french) {
        echo "Failed - " . $traducts[0]['romaji'];
    } else {
        echo "Failed - " . $traducts[0]['francais'];
    }
}