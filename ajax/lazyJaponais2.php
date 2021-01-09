<?php

define('BASE_URL', 'https://lexiquejaponais.fr/');
session_start();
if ($_SESSION['connect'] === 'OK' && $_SESSION['admin'] == 1) {
    require_once '../model/frontend.php';
    require_once '../model/backend.php';
    $data = ['data' => listJaponais()];
    foreach ($data['data'] as $mot) {
        $francais = listFrancaisToJaponais($mot['id']);
        var_dump($francais);
        $mot['francais'] = $francais['0']['francais'];
        if (sizeof($francais) > 1) {
            foreach ($francais as $value) {
                $mot['francais'] .=  ", " . $value['francais'];
            }
        }
        array_push($mot, $mot['francais']);
    }
    var_dump($data);
    header('content-type: text/json');
    echo json_encode($data);
}
