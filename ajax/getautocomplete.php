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
                <li class="list-group-item border li-theme" style="cursor: pointer;" onClick="researchMot('<?= $mot['francais'] ?>')"><?= $mot['francais'] ?></li>
            <?php endforeach; ?>
        </ul>
        <script>
            function researchMot(val) {
                $("#autocomplete").select().val(val);
                $("#search").hide();
            }
        </script>
    <?php endif;
endif; ?>