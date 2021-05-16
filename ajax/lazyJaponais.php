<?php

session_start();
require_once __DIR__ . '/../model/frontend.php';
require_once __DIR__ . '/../model/backend.php';
if ($_SESSION['Account']['admin'] == 1 && isAdmin($_SESSION['Account']['pseudo'])) {
    $japonais = listJaponais();
    foreach ($japonais as $mot): ?>
        <tr id="row<?= $mot['id'] ?>">
            <td><?= $mot['kanji']; ?></td>
            <td class="hidden"><?= $mot['kana']; ?></td>
            <td><?= $mot['romaji']; ?></td>
            <td class="hidden"><?= $mot['francais']; ?></td>
            <td>
                <a href="index.php?p=japonais_edit&id=<?= $mot['id']; ?>"
                   class="btn btn-outline-primary btn-sm">Edit</a>
                <a onclick="deleteJaponais('<?= $mot['id'] ?>')" class="btn btn-outline-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php endforeach;
}
