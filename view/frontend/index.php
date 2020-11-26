<?php $title = 'Accueil';
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" style="width: 100%" id="autocomplete" class="autocomplete-bar" name="mot" placeholder="Recherche" autocomplete="off">
        <div id="search" class="search" style="width: 100%"></div>
    </form>
    <br/><br/>
<?php if (!empty($_POST['words'])): ?>
    <h3>Sélection aléatoire de mots :</h3>
    <br/>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
            <th class="hidden">Type du mot</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['words'] as $word): ?>
            <tr>
                <td><a href="index.php?p=search&mot=<?= $word['francais'] ?>"><?= $word['francais'] ?></a></td>
                <td><?= $word['kanji'] ?></td>
                <td class="hidden"><?= $word['kana'] ?></td>
                <td><?= $word['romaji'] ?></td>
                <td class="hidden"><?= $word['type'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    <br/><br/>
    <div class="card text-center">
        <div class="card-body" id="card">
            <h6 class="card-title" id="riddle">Trouve la bonne traduction !</h6>
            <?php if (isset($_SESSION['riddle']) && $_SESSION['life'] > 0) : ?>
                <form id="riddle-form">
                    <div id="riddle-div" class="flexible">
                        <p id="riddle-value" class="card-text"><?= $_SESSION['riddle'] ?></p>
                        <p class="life">
                            <img id="heart" class="svg" src="./resources/svgs/heart.svg" alt="heart"> :
                            <span id="life"><?= $_SESSION['life'] ?></span>
                        </p>
                    </div>
                    <div id="result"></div>
                    <input type="text" id="value" class="form-text riddle" autocomplete="off" required><br/>
                    <input type="submit" id="riddle-btn" class="btn btn-primary" value="Valider">
                </form>
            <?php elseif ($_SESSION['life'] === 0) : ?>
                <p class="card-text">Vous n'avez plus de vie, revenez demain !</p>
            <?php else : ?>
                <p class="card-text">Veuillez vous reconnecter s'il vous plait, l'affichage sera ensuite fonctionnel</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="snackbar">+ 20</div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>