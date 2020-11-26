<?php

require_once '../model/frontend.php';

$id_liste = $_POST['id_liste'];
$id_mot = $_POST['id_mot'];
$value = selectWordInListe($id_liste, $id_mot);

if ($value->rowCount() == 0) {
    addWordInListe($id_liste, $id_mot);
    echo 'ADD';
} else {
    removeWordInListe($id_liste, $id_mot);
    echo 'REMOVE';
}