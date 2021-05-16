<?php $title = $_POST['kanji'];
ob_start(); ?>

    <div class="row mb-3">
        <label for="autocomplete"></label>
        <input type="text" id="autocomplete" class="autocomplete-bar" name="mot" placeholder="Recherche"
               autocomplete="off">
        <div id="search" class="search p-0"></div>
    </div>

    <div class="card mx-auto">
        <div class="card-header clickable" onclick="modalKanji()">
            <h4 class="card-title text-center" style="margin-top: 20px"><?= $_POST['kanji'] ?></h4>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span>Nombre de lignes : <?= $_POST['lignes'] ?></span>
            </li>
            <li class="list-group-item">
                <span>Grade : <?= $_POST['grade'] ?></span>
            </li>
            <li class="list-group-item" data-mdb-toggle="tooltip" title="Lecture chinoise">
                <span>On_yomi : <?= $_POST['on_yomi'] ?></span>
            </li>
            <li class="list-group-item" data-mdb-toggle="tooltip" title="Lecture japonaise">
                <span>Kun_yomi : <?= $_POST['kun_yomi'] ?></span>
            </li>
            <li class="list-group-item">
                <span>Sens du kanji : <?= $_POST['sens'] ?></span>
            </li>
        </ul>
        <div class="card-body">
            <?php if (!empty($_POST['japonais'])) : ?>
                <span class="font-weight-bold">Liste des mots utilisant ce kanji :</span><br/><br>
                <?php $i = count($_POST['japonais']);
                foreach ($_POST['japonais'] as $japonais) : ?>
                    <a class="card-link button-a" href="recherche/<?= $japonais['slug'] ?>">
                        <?= $japonais['kanji'] ?> - <?= $japonais['romaji'] ?> : <?= $japonais['francais'] ?>
                    </a>
                    <?php if (--$i): ?>
                        <hr>
                    <?php endif;
                endforeach;
            else : ?>
                <span><?= $_POST['kanji']; ?> n'est utilisé dans aucun mot</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="modalKanji" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <span class="modal-kanji"><?= $_POST['kanji'] ?></span>
            </div>
        </div>
    </div>

    <script>
        function modalKanji() {
            $('#modalKanji').modal('show');
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>