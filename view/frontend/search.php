<?php $title = $_POST['francais']['francais'];
ob_start(); ?>

    <div class="row mb-3">
        <label for="autocomplete"></label>
        <input type="text" id="autocomplete" class="autocomplete-bar" name="mot" placeholder="Recherche"
               autocomplete="off">
        <div id="search" class="search p-0"></div>
    </div>

    <div class="form-group card mx-auto mb-4 shadow-1-strong">
        <div class="card-header">
            <div class="flexible">
                <h4 class="card-title font-weight-bold text-center mt-4"><?= $_POST['francais']['francais'] ?></h4>
                <a data-toggle="modal" data-target="#modalListe" style="margin-left: auto; margin-top: 20px">
                    <img id="plus-circle" class="svg" src="./resources/svgs/plus-circle.svg" alt="plus">
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php $i = 0;
            foreach ($_POST['japonais'] as $japonais) :
                if (isset($_POST['type']) && $_POST['type'][$i] != null) : ?>
                    <ul class="list-group list-group-flush list-search">
                        <li class="list-group-item text-center">
                            <?= key($_POST['type'][$i]) ?>
                            <?php if (isset($japonais['jlpt']) && $japonais['jlpt'] != 0) {
                                echo '- <span class="' . $japonais['color'] . '">JLPT : N' . $japonais['jlpt'] . '</span>';
                            } ?>
                        </li>
                    </ul>
                <?php endif;
                $i = $i + 1; ?>
                <ul class="list-group list-group-flush list-search clickable"
                    onclick="textToAudio('<?= $japonais['romaji'] ?>')">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Kanji : <?= $japonais['kanji'] ?></span>
                        <img src="resources/svgs/speaker.svg" alt="speaker" class="svg speaker" style="height: inherit">
                    </li>
                    <li class="list-group-item">
                        <span>Kana : <?= $japonais['kana'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <span>Romaji : <?= $japonais['romaji'] ?></span>
                    </li>
                    <?php if (!empty($japonais['description'])) : ?>
                        <li class="list-group-item">
                            <span><?= nl2br($japonais['description']) ?></span>
                        </li>
                    <?php endif;
                    foreach (listKanjiToJaponais($japonais['id']) as $kanji) : ?>
                        <li class="list-group-item flexible">
                            <a class="button-a" href="kanji/<?= $kanji['id'] ?>">
                                <?= $kanji['kanji'] ?> - <?= $kanji['sens'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($japonais != array_slice($_POST['japonais'], -1)[0]) : ?>
                <hr class="black">
            <?php endif;
                if (!empty($_POST['groupes'][$japonais["id"]])) : ?>
                    <div class="row">
                        <?php foreach ($_POST['groupes'][$japonais["id"]] as $groupe) : ?>
                            <div class="col-6 col-md-4 col-lg-2">
                                <a class="button-a" href="groupe/<?= $groupe['slug'] ?>">
                                    - <?= $groupe['libelle'] ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

<?php foreach ($_POST['type'] as $list) :
    if ($list != null && substr(key($list), 0, 5) == 'Verbe') :
        foreach ($list as $value) :
            $i = 1; ?>
            <hr class="my-4">
            <div class="row">
                <?php foreach ($value as $key => $item) :
                    $j = 0; ?>
                    <div class="col-lg-6 col-xl-4 mb-3 mb-md-4">
                        <div class="form-group card mx-auto">
                            <div class="card-header font-weight-bold"><?= $key ?></div>
                            <div class="accordion" id="accordion<?= $i ?>">
                                <?php foreach ($item as $lecture => $verbe) :
                                    $j = $j + 1; ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?= $i ?>">
                                            <button class="accordion-button collapsed" data-mdb-toggle="collapse"
                                                    aria-expanded="false"
                                                    data-mdb-target="#collapse<?= $lecture . $i ?>"
                                                    aria-controls="collapse<?= $lecture . $i ?>" type="button">
                                                <?= $lecture ?>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse<?= $lecture . $i ?>" class="accordion-collapse collapse"
                                         aria-labelledby="heading<?= $i ?>"
                                         data-mdb-parent="#accordion<?= $i ?>">
                                        <div class="accordion-body">
                                            <?php foreach ($verbe as $sens => $ecriture) : ?>
                                                <div class="d-flex clickable"
                                                     onclick="textToAudio('<?= $item['Romaji'][$sens] ?>')">
                                                    <span><?= $sens ?> :</span>
                                                    <span class="ms-auto"><?= $ecriture ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i = $i + 1;
                endforeach; ?>
            </div>
        <?php endforeach;
    elseif ($list != null && substr(key($list), 0, 8) == 'Adjectif') :
        foreach ($list as $value) : ?>
            <hr class="my-4">
            <div class="row">
                <div class="col-lg-6 col-xl-4 mb-3 mb-md-4">
                    <div class="form-group card mx-auto">
                        <div class="card-header font-weight-bold">Possibilités</div>
                        <div class="accordion" id="accordionAdj1">
                            <?php foreach ($value as $lecture => $verbe) : ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAdj1">
                                        <button class="accordion-button collapsed" data-mdb-toggle="collapse"
                                                aria-expanded="false"
                                                data-mdb-target="#collapse<?= $lecture ?>1"
                                                aria-controls="collapse<?= $lecture ?>1" type="button">
                                            <?= $lecture ?>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse<?= $lecture ?>1" class="accordion-collapse collapse"
                                     aria-labelledby="headingAdj1"
                                     data-mdb-parent="#accordionAdj1">
                                    <div class="accordion-body">
                                        <?php foreach ($verbe as $sens => $ecriture) : ?>
                                            <div class="d-flex clickable"
                                                 onclick="textToAudio('<?= $value['Romaji'][$sens] ?>')">
                                                <span><?= $sens ?> :</span>
                                                <span class="ms-auto"><?= $ecriture ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;
    endif;
endforeach; ?>

    <div class="modal fade" id="modalListe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <img src="resources/svgs/sakura_login.svg" style="width: 40px" alt="logo">
                    <h4 class="modal-title w-100 font-weight-bold">Ajouter à une liste</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="autocompleteListe"></label>
                    <input type="text" style="width: 100%" id="autocompleteListe" class="autocomplete-bar" name="mot"
                           placeholder="Rechercher une liste" autocomplete="off">
                    <hr>
                    <ul id="searchListe" class="list-group list-group-flush" style="width: 100%">
                        <?php foreach ($_POST['listes'] as $liste) : ?>
                            <li id="li-<?= $liste['id'] ?>" class="list-group-item border li-theme clickable"
                                onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['francais']['id'] ?>')">
                                <div class="flexible">
                                    <span><?= $liste['nom'] ?></span>
                                    <img id="uncheck" class="svg" src="./resources/svgs/uncheck.svg"
                                         alt="<?= $liste['nom'] ?>">
                                </div>
                            </li>
                        <?php endforeach;
                        foreach ($_POST['other_listes'] as $liste) : ?>
                            <li id="li-<?= $liste['id'] ?>" class="list-group-item border li-theme clickable"
                                onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['word']['id'] ?>')">
                                <div class="flexible">
                                    <span><?= $liste['nom'] ?></span>
                                    <img id="check" class="svg" src="./resources/svgs/check.svg"
                                         alt="<?= $liste['nom'] ?>">
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php');