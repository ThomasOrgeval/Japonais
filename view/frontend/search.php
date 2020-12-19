<?php $title = $_POST['francais']['francais'];
ob_start(); ?>

    <label for="autocomplete"></label>
    <input type="text" style="width: 100%" id="autocomplete" class="autocomplete-bar" name="mot" placeholder="Recherche"
           autocomplete="off">
    <div id="search" class="search" style="width: 100%"></div><br/><br/>

    <div class="form-group card mx-auto">
        <div class="card-header">
            <div class="flexible">
                <h4 class="card-title text-center" style="margin-top: 20px"><?= $_POST['francais']['francais'] ?></h4>
                <a data-toggle="modal" data-target="#modalListe" style="margin-left: auto; margin-top: 20px">
                    <img id="plus-circle" class="svg" src="./resources/svgs/plus-circle.svg" alt="plus">
                </a>
            </div>
        </div>
        <?php if (isset($_POST['type']) && $_POST['type'][0] != null) : ?>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center">
                    <?= key($_POST['type'][0]) ?>
                </li>
            </ul>
        <?php endif; ?>
        <?php foreach ($_POST['japonais'] as $japonais) : ?>
            <ul class="list-group list-group-flush" onclick="textToAudio('<?= $japonais['romaji'] ?>')"
                style="cursor: pointer">
                <li class="list-group-item flexible">
                    <span>Kanji : <?= $japonais['kanji'] ?></span>
                    <img src="./resources/svgs/speaker.svg" alt="speaker" class="svg speaker">
                </li>
                <li class="list-group-item">
                    <span>Kana : <?= $japonais['kana'] ?></span>
                </li>
                <li class="list-group-item">
                    <span>Romaji : <?= $japonais['romaji'] ?></span>
                </li>
            </ul>
            <?php if (!empty($japonais['description'])) : ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item flexible">
                        <span><?= nl2br($japonais['description']) ?></span>
                    </li>
                </ul>
            <?php endif;
            $kanji = listKanjiToJaponais($japonais['id']);
            if (!empty($kanji)) :
                foreach ($kanji as $aKanji) : ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item flexible">
                            <a class="black-text" href="kanji/<?= $aKanji['id'] ?>">
                                <?= $aKanji['kanji'] ?> - <?= $aKanji['sens'] ?>
                            </a>
                        </li>
                    </ul>
                <?php endforeach;
            endif;
            if ($japonais != array_slice($_POST['japonais'], -1)[0]) : ?>
                <br/><br/>
            <?php endif;
        endforeach;
        if (!empty($_POST['groupes'])) : ?>
            <div class="card-body">
                <?php foreach ($_POST['groupes'] as $groupe) : ?>
                    <a class="card-link" href="groupe/<?= $groupe['id'] ?>">
                        <?= $groupe['libelle'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php if (isset($_POST['type']) && $_POST['type'][0] != null) :
    foreach ($_POST['type'] as $list) :
        foreach ($list as $value) :
            $i = 1; ?>
            <div class="card-group">
                <?php foreach ($value as $key => $item) :
                    $j = 0; ?>
                    <div class="col-md-4">
                        <div class="form-group card mx-auto" style="width: 100%">
                            <div class="card-header">
                                <span class="font-weight-bold"><?= $key ?></span>
                            </div>
                            <div class="accordion md-accordion" id="card<?= $i ?>" role="tablist"
                                 aria-multiselectable="true">
                                <?php foreach ($item as $lecture => $verbe) :
                                    $j = $j + 1; ?>
                                    <div class="card" style="width: 100%">
                                        <div class="card-header" role="tab" id="heading<?= $lecture . $i ?>">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#card<?= $i ?>"
                                               href="#collapse<?= $lecture . $i ?>" aria-expanded="false"
                                               aria-controls="collapse<?= $lecture . $i ?>">
                                                <div class="flexible">
                                                    <span><?= $lecture ?></span>
                                                    <i class="fas fa-angle-down rotate-icon"
                                                       style="margin-left: auto"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="collapse<?= $lecture . $i ?>" class="collapse" role="tabpanel"
                                             aria-labelledby="heading<?= $lecture . $i ?>"
                                             data-parent="#card<?= $i ?>">
                                            <div class="card-body">
                                                <?php foreach ($verbe as $sens => $ecriture) : ?>
                                                    <p class="flexible" style="cursor: pointer"
                                                       onclick="textToAudio('<?= $item['Romaji'][$sens] ?>')">
                                                        <span><?= $sens ?> :</span>
                                                        <span style="margin-left: auto"><?= $ecriture ?></span>
                                                    </p>
                                                <?php endforeach; ?>
                                            </div>
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
    endforeach;
endif; ?>

    <div class="modal fade" id="modalListe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
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
                            <a onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['word']['id'] ?>')">
                                <li id="li-<?= $liste['id'] ?>" class="list-group-item border li-theme">
                                    <div class="flexible">
                                        <span><?= $liste['nom'] ?></span>
                                        <img id="uncheck" class="svg" src="./resources/svgs/uncheck.svg"
                                             alt="<?= $liste['nom'] ?>">
                                    </div>
                                </li>
                            </a>
                        <?php endforeach;
                        foreach ($_POST['other_listes'] as $liste) : ?>
                            <a onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['word']['id'] ?>')">
                                <li id="li-<?= $liste['id'] ?>" class="list-group-item border li-theme">
                                    <div class="flexible">
                                        <span><?= $liste['nom'] ?></span>
                                        <img id="check" class="svg" src="./resources/svgs/check.svg"
                                             alt="<?= $liste['nom'] ?>">
                                    </div>
                                </li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php');