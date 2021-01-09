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
            <td class="hidden"><?= $mot['francais']; ?></td>
            <td>
                <a href="index.php?p=japonais_edit&id=<?= $mot['id']; ?>"
                   class="btn btn-outline-dark btn-sm">Edit</a>
                <a onclick="deleteJaponais('<?= $mot['id'] ?>')" class="btn btn-outline-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php endforeach;
}
