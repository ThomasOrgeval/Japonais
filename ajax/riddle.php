<?php

session_start();
require_once '../model/frontend.php';
require_once '../model/backend.php';

$bool = false;
$traducts = listJaponaisToFrancaisWord($_SESSION['riddle']);
$value = strtolower($_POST['value']);
foreach ($traducts as $traduct) {
    if ($value === strtolower($traduct['romaji']) || $value === strtolower($traduct['kanji']) || $value === strtolower($traduct['kana'])) {
        $bool = true;
    }
}

$_SESSION['riddle'] = selectOneRandomWord()['francais'];
setRiddle($_SESSION['id'], $_SESSION['riddle']);

if ($bool) {
    $_SESSION['points'] += 20;
    setPoints($_SESSION['id'], $_SESSION['points']);
    echo "Success";
} else {
    --$_SESSION['life'];
    setLife($_SESSION['id'], $_SESSION['life']);
    echo "Failed";
}