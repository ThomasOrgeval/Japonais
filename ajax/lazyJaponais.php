<?php

define('BASE_URL', 'https://lexiquejaponais.fr/');
session_start();
if ($_SESSION['connect'] === 'OK' && $_SESSION['admin'] == 1) {
    require_once '../model/frontend.php';
    require_once '../model/backend.php';
    $japonais = listJaponais();
    foreach ($japonais as $mot): ?>
        <tr id="row<?= $mot['id'] ?>">
            <td><?= $mot['kanji']; ?></td>
            <td class="hidden"><?= $mot['kana']; ?></td>
            <td><?= $mot['romaji']; ?></td>
            <td class="hidden"><?php $francais = listFrancaisToJaponais($mot['id']);
                if (sizeof($francais) > 1) {
                    foreach ($francais as $value) {
                        echo $value['francais'] . ", ";
                    }
                } elseif (sizeof($francais) == 1) {
                    echo $francais['0']['francais'];
                }
                ?></td>
            <td>
                <a href="index.php?p=japonais_edit&id=<?= $mot['id']; ?>"
                   class="btn btn-outline-dark btn-sm">Edit</a>
                <a onclick="deleteJaponais('<?= $mot['id'] ?>')" class="btn btn-outline-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php endforeach;
}
