<?php $title = $_POST['word']['francais'];
ob_start(); ?>

    <form action="index.php?p=search" method="post">
        <input type="text" style="width: 100%" id="autocomplete" class="autocomplete-bar" name="mot"
               placeholder="Recherche" autocomplete="off">
        <div id="search" class="search" style="width: 100%"></div>
    </form><br/><br/>

    <div class="flexible">
        <h1 id="value" style="margin-right: auto"><?= $_POST['word']['francais'] ?></h1>
        <a href="" style="text-align: center" data-toggle="modal" data-target="#modalListe">
            <img id="plus-circle" class="svg" src="./resources/svgs/plus-circle.svg" alt="plus">
        </a>
    </div><br/><br/>

    <h3>Traductions possibles :</h3>
<?php foreach ($_POST['japonais'] as $japonais) : ?>
    <h4><?= $_POST['word']['francais'] ?> en kanji : <?= $japonais['kanji'] ?></h4>
    <h4><?= $_POST['word']['francais'] ?> en kana : <?= $japonais['kana'] ?></h4>
    <h4><?= $_POST['word']['francais'] ?> en romaji : <?= $japonais['romaji'] ?></h4>
<?php endforeach;

if (!empty($_POST['groupes'])) :
    foreach ($_POST['groupes'] as $groupe) : ?>
        <a class="btn" href="index.php?p=groupe_search&id=<?= $groupe['id'] ?>"><?= $groupe['libelle'] ?></a>
    <?php endforeach;
else : ?>
    <p><?= $_POST['word']['francais']; ?> n'appartient à aucun groupe</p>
<?php endif; ?>

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
                                <li id="li-liste" class="list-group-item border li-theme">
                                    <div class="flexible">
                                        <?= $liste['nom'] ?>
                                        <img id="uncheck" class="svg" src="./resources/svgs/uncheck.svg"
                                             alt="<?= $liste['nom'] ?>">
                                    </div>
                                </li>
                            </a>
                        <?php endforeach; ?>
                        <?php foreach ($_POST['other_listes'] as $liste) : ?>
                            <a onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['word']['id'] ?>')">
                                <li id="li-liste" class="list-group-item border li-theme"
                                    onclick="addToList('<?= $liste['id'] ?>', '<?= $_POST['word']['id'] ?>')">
                                    <div class="flexible">
                                        <?= $liste['nom'] ?>
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
require('./view/template/template.php'); ?>