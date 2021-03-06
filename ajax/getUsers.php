<?php

session_start();
require_once __DIR__ . '/../model/frontend.php';

if (!empty($_POST['keyword'])) :
    $key = htmlspecialchars($_POST['keyword']);
    $key = trim($key);
    $key = strip_tags($key);
    $users = autocompleteUser($key, $_SESSION['Account']['id']);

    if (!empty($users)) : ?>
        <ul class="list-group list-group-flush" id="research">
            <?php foreach ($users as $user) : ?>
            <a href="compte/<?= $user['slug'] ?>" class="black-text">
                <li class="list-group-item border li-theme" style="cursor: pointer;">
                    <div class="flexible">
                        <img class="icon-research" src="./resources/icons/<?= $user['icone'] ?>.png" alt="icone">
                        <span style="margin-left: 7px"><?= $user['pseudo'] ?></span>
                    </div>
                </li>
            </a>
            <?php endforeach; ?>
        </ul>
    <?php endif;
endif; ?>