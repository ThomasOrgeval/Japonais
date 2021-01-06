<?php

require_once '../controller/libs/base_url.php';
require_once '../model/frontend.php';

if (!empty($_POST['keyword'])) :
    $key = htmlspecialchars($_POST['keyword']);
    $key = trim($key);
    $key = strip_tags($key);
    $mots = autocompleteMots($key);

    if (!empty($mots)) : ?>
        <ul class="list-group list-group-flush" id="research">
            <?php foreach ($mots as $mot) :

                $end3 = substr($mot['romaji'], strlen($mot['romaji']) - 3);
                $end2 = substr($mot['romaji'], strlen($mot['romaji']) - 2);
                $exceptFirstGroupe = listExceptions();
                $types = getTypes(addslashes($mot['francais']));

                foreach ($types as $type) {
                    switch ($type['type']) {
                        case 'Verbe':
                            if ($mot['romaji'] == 'Suru' || $mot['romaji'] == 'Kuru') $var = 'Verbe - Groupe 3 (Irrégulier)';
                            elseif (($end3 == 'eru' || $end3 == 'iru') && !in_array($mot['romaji'], $exceptFirstGroupe))
                                $var = 'Verbe - Groupe 2 (Ichidan)';
                            else $var = 'Verbe - Groupe 1 (Godan)';
                            break;
                        case 'Adjectif':
                            if ($end2 == 'na') $var = 'Adjectif (Rentaishi)';
                            else $var = 'Adjectif (Keiyoushi)';
                            break;
                        case
                        'Nom':
                            if (isset($var)) $var .= ' + Nom (Futsuumeishi)';
                            else $var = 'Nom (Futsuumeishi)';
                            break;
                        default:
                            $var = $mot['type'];
                    }
                } ?>
                <a href="recherche/<?= $mot['slug'] ?>" class="black-text">
                    <li class="list-group-item border li-theme" style="cursor: pointer">
                        <?= $mot['francais'] ?> - <?= $var ?>
                    </li>
                </a>
                <?php unset($var);
            endforeach; ?>
        </ul>
    <?php endif;
endif;