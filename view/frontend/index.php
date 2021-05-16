<?php ob_start(); ?>

    <div class="row mx-2 pt-4 my-4">
        <label for="autocomplete"></label>
        <input type="text" id="autocomplete" class="autocomplete-bar" name="mot" placeholder="Recherche"
               autocomplete="off">
        <div id="search" class="search p-0"></div>
    </div>

<?php if (!empty($_POST['words'])): ?>
    <h3 class="mb-2">Sélection aléatoire de mots :</h3>
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
                <td><a href="recherche/<?= $word['slug'] ?>"><?= $word['francais'] ?></a></td>
                <td><?= $word['kanji'] ?></td>
                <td class="hidden"><?= $word['kana'] ?></td>
                <td><?= $word['romaji'] ?></td>
                <td class="hidden"><?= $word['type'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br/>
<?php endif; ?>

<?php if (!empty($_POST['groups'])) : ?>
    <h3>Sélection aléatoire de groupes :</h3>
    <br/>
    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Groupe</th>
            <th class="hidden">Groupe parent</th>
            <th>Quantifieur</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['groups'] as $group): ?>
            <tr>
                <td><a href="groupe/<?= $group['slug'] ?>"><?= $group['libelle'] ?></a></td>
                <td class="hidden"><a href="groupe/<?= $group['parent_slug'] ?>"><?= $group['parent'] ?></a></td>
                <td><?= $group['quantifieur'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br/><br/>
<?php endif; ?>

<?php if (isset($_SESSION['Account'])) : ?>
    <div class="card text-center">
        <div class="card-body" id="card">
            <h6 class="card-title" id="riddle">Trouve la bonne traduction !</h6>
            <?php if (isset($_SESSION['Account']['riddle']) && $_SESSION['Account']['life'] > 0) : ?>
                <form id="riddle-form">
                    <div id="riddle-div" class="d-flex h5">
                        <p id="riddle-value" class="card-text"><?= $_SESSION['Account']['riddle'] ?></p>
                        <p class="life">
                            <img id="heart" class="svg" src="resources/svgs/heart.svg" alt="heart"> :
                            <span id="life"><?= $_SESSION['Account']['life'] ?></span>
                        </p>
                    </div>
                    <div id="result"></div>
                    <div class="form-outline mb-4">
                        <input type="text" id="value" class="form-control" autocomplete="off" required>
                        <label for="value" class="form-label">Devinette</label>
                    </div>
                    <input type="submit" id="riddle-btn" class="btn btn-primary btn-lg btn-block" value="Valider">
                </form>
            <?php else : ?>
                <p class="card-text">Vous n'avez plus de vie, revenez demain !</p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

    <div id="snackbar"></div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>