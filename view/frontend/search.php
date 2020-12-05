<?php $title = $_POST['word']['francais'];
ob_start(); ?>

    <input type="text" style="width: 100%" id="autocomplete" class="autocomplete-bar" name="mot"
           placeholder="Recherche" autocomplete="off">
    <div id="search" class="search" style="width: 100%"></div<br/><br/>

    <div class="card" style="margin: 0 auto;">
        <div class="card-header">
            <div class="flexible">
                <h4 class="card-title text-center" style="margin-top: 20px"><?= $_POST['word']['francais'] ?></h4>
                <a data-toggle="modal" data-target="#modalListe" style="margin-left: auto; margin-top: 20px">
                    <img id="plus-circle" class="svg" src="./resources/svgs/plus-circle.svg" alt="plus">
                </a>
            </div>
        </div>
        <?php foreach ($_POST['japonais'] as $japonais) : ?>
            <ul class="list-group list-group-flush" onclick="textToAudio('<?= $japonais['romaji'] ?>')">
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
        endforeach; ?>
        <div class="card-body">
            <?php if (!empty($_POST['groupes'])) :
                foreach ($_POST['groupes'] as $groupe) : ?>
                    <a class="card-link" href="index.php?p=groupe_search&id=<?= $groupe['id'] ?>">
                        <?= $groupe['libelle'] ?>
                    </a>
                <?php endforeach;
            else : ?>
                <span>
                    <span class="font-weight-bold"><?= $_POST['word']['francais']; ?></span>
                     n'appartient à aucun groupe
                </span>
            <?php endif; ?>
        </div>
    </div>

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
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>