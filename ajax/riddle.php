<?php

session_start();
require_once '../model/frontend.php';
require_once '../model/backend.php';

$bool = false;
$traducts = listJaponaisToFrancaisWord($_SESSION['riddle']);
foreach ($traducts as $traduct) {
    if (in_array($_POST['value'], $traduct, true)) {
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