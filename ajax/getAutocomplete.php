<?php

require_once '../model/frontend.php';

if (!empty($_POST['keyword'])) :
    $key = htmlspecialchars($_POST['keyword']);
    $key = trim($key);
    $key = strip_tags($key);
    $mots = autocompleteMots($key);

    if (!empty($mots)) : ?>
        <ul class="list-group list-group-flush" id="research">
            <?php foreach ($mots as $mot) : ?>
            <a href="index.php?p=search&mot=<?= $mot['francais'] ?>" class="black-text">
                <li class="list-group-item border li-theme" style="cursor: pointer;"><?= $mot['francais'] ?></li>
            </a>
            <?php endforeach; ?>
        </ul>
    <?php endif;
endif;