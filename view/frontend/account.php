<?php
$title = isset($_POST['user']) ? $_POST['user']['pseudo'] : 'Mon compte';
$icone = isset($_POST['user']) ? $_POST['user']['icone'] : $_SESSION['icone'];
ob_start(); ?>

    <input type="text" style="width: 100%" id="autocompleteusers" class="autocomplete-bar" name="user"
           placeholder="Utilisateur" autocomplete="off">
    <div id="search" class="search" style="width: 100%"></div>
    <br/><br/>

    <div class="flexible wide-screen">
        <div class="col-sm-4">
            <?php if (isset($_POST['user'])) : ?>
                <img class="icon-account" src="./resources/icons/<?= $icone ?>.png" alt="icone">
            <?php else: ?>
                <a data-toggle="modal" data-target="#modalIcon">
                    <img class="icon-account" src="./resources/icons/<?= $icone ?>.png" alt="icone">
                </a>
            <?php endif; ?>
        </div>
        <div class="col-sm-8">
            <?php if (!isset($_POST['user'])) : ?>
            <form action="index.php?p=save_account" method="post">
                <?php endif; ?>
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <?php if (isset($_POST['user']) && !empty($_POST['user'])) : ?>
                        <input type="text" class="form-control" id="pseudo" name="pseudo"
                               value="<?= $_POST['user']['pseudo'] ?>"
                               readonly>
                    <?php else : ?>
                        <input type="text" class="form-control" id="pseudo" name="pseudo"
                               value="<?= $_SESSION['pseudo'] ?>"
                               readonly>
                    <?php endif; ?>
                </div>
                <?php if (isset($_POST['user'])) : ?>
                    <div class="form-group">
                        <label for="last_login">Dernière connexion</label>
                        <input type="text" class="form-control" id="last_login" name="last_login"
                               value="<?= $_POST['user']['last_login'] ?>" readonly><br/>
                        <label for="points">Nombre de points</label>
                        <input type="text" class="form-control" id="points" name="points"
                               value="<?= $_POST['user']['points'] ?>" readonly>
                    </div>
                <?php else : ?>
                <div class="form-group">
                    <label for="nombrewords">Nombre de mots affichés sur l'accueil</label>
                    <input type="number" class="form-control" id="nombrewords" name="nombrewords"
                           value="<?= $_SESSION['nombreWords'] ?>">
                </div>

                <button type="submit" class="btn btn-purple" name="save">Enregistrer</button>
            </form>
        <?php endif; ?>
        </div>
    </div><br/><br/>

    <div class="small-screen">
        <div class="col-sm-4">
            <?php if (isset($_POST['user'])) : ?>
                <img class="icon-account" src="./resources/icons/<?= $icone ?>.png" alt="icone">
            <?php else: ?>
                <a data-toggle="modal" data-target="#modalIcon">
                    <img class="icon-account" src="./resources/icons/<?= $icone ?>.png" alt="icone">
                </a>
            <?php endif; ?>
        </div>
        <div class="col-sm-8">
            <?php if (!isset($_POST['user'])) : ?>
            <form action="index.php?p=save_account" method="post">
                <?php endif; ?>
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <?php if (isset($_POST['user']) && !empty($_POST['user'])) : ?>
                        <input type="text" class="form-control" id="pseudo" name="pseudo"
                               value="<?= $_POST['user']['pseudo'] ?>"
                               readonly>
                    <?php else : ?>
                        <input type="text" class="form-control" id="pseudo" name="pseudo"
                               value="<?= $_SESSION['pseudo'] ?>"
                               readonly>
                    <?php endif; ?>
                </div>
                <?php if (isset($_POST['user'])) : ?>
                    <div class="form-group">
                        <label for="last_login">Dernière connexion</label>
                        <input type="text" class="form-control" id="last_login" name="last_login"
                               value="<?= $_POST['user']['last_login'] ?>" readonly><br/>
                        <label for="points">Nombre de points</label>
                        <input type="text" class="form-control" id="points" name="points"
                               value="<?= $_POST['user']['points'] ?>" readonly>
                    </div>
                <?php else : ?>
                <div class="form-group">
                    <label for="nombrewords">Nombre de mots affichés sur l'accueil</label>
                    <input type="number" class="form-control" id="nombrewords" name="nombrewords"
                           value="<?= $_SESSION['nombreWords'] ?>">
                </div>

                <button type="submit" class="btn btn-purple" name="save">Enregistrer</button>
            </form>
        <?php endif; ?>
        </div>
    </div><br/><br/>

<?php if (isset($_POST['listes']) && !empty($_POST['listes'])) : ?>
    <h4>Toutes les listes de l'utilisateur : </h4>
    <div class="card-deck">
        <?php foreach ($_POST['listes'] as $liste) : ?>
            <div class="card">
                <div class="card-body" id="card">
                    <h5 class="card-title">
                        <a href="index.php?p=liste&id=<?= $liste['id'] ?>">
                            <span class="color"><?= $liste['nom'] ?></span>
                        </a>
                    </h5>
                    <hr>
                    <p class="card-text"><?= nl2br($liste['description']) ?></p>
                    <!--hr>
                    <h6>Contenu de la liste :</h6-->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!isset($_POST['user'])) : ?>
    <div class="modal fade" id="modalIcon" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
                    <h4 class="modal-title w-100 font-weight-bold">Liste des îcones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table>
                        <tbody>
                        <td>
                            <a href="index.php?p=change_icon&id=0">
                                <img class="icon-table" src="./resources/icons/0.png" alt="icon0">
                            </a>
                        </td>
                        <?php foreach ($_POST['icones_own'] as $icone) : ?>
                            <td>
                                <a href="index.php?p=change_icon&id=<?= $icone['id'] ?>">
                                    <img class="icon-table" src="./resources/icons/<?= $icone['id'] ?>.png"
                                         alt="icon<?= $icone['id'] ?>">
                                </a>
                            </td>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <table>
                        <tbody>
                        <?php foreach ($_POST['icones'] as $icone) : ?>
                            <td>
                                <a href="index.php?p=achat&id_recompense=<?= $icone['id'] ?>&page=account"
                                   onclick="return confirm('Voulez-vous vraiment acheter cette îcone ?')">
                                    <div class="position-relative" style="width: 80px; height: 80px;">
                                        <img class="icon-table icon-table-other"
                                             src="./resources/icons/<?= $icone['id'] ?>.png"
                                             alt="icon<?= $icone['id'] ?>">
                                        <img class="icon-secure" src="./resources/svgs/lock.svg" alt="lock">
                                    </div>
                                </a>
                            </td>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>