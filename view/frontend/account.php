<?php $title = 'Mon compte';
ob_start(); ?>

    <div class="flexible wide-screen">
        <div class="col-sm-4">
            <a data-toggle="modal" data-target="#modalIcon">
                <img class="icon-account" src="./resources/icons/<?= $_SESSION['icone'] ?>.png" alt="icone">
            </a>
        </div>
        <div class="col-sm-8">
            <form action="index.php?p=save_account" method="post">
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $_SESSION['pseudo'] ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="nombrewords">Nombre de mots affichés sur l'accueil</label>
                    <input type="number" class="form-control" id="nombrewords" name="nombrewords"
                           value="<?= $_SESSION['nombreWords'] ?>">
                </div>

                <button type="submit" class="btn btn-purple" name="save">Enregistrer</button>
            </form>
        </div>
    </div>
    <div class="small-screen">
        <div class="col-sm-4">
            <a data-toggle="modal" data-target="#modalIcon">
                <img class="icon-account" src="./resources/icons/<?= $_SESSION['icone'] ?>.png" alt="icone">
            </a>
        </div>
        <div class="col-sm-8">
            <form action="index.php?p=save_account" method="post">
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $_SESSION['pseudo'] ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="nombrewords">Nombre de mots affichés sur l'accueil</label>
                    <input type="number" class="form-control" id="nombrewords" name="nombrewords"
                           value="<?= $_SESSION['nombreWords'] ?>">
                </div>

                <button type="submit" class="btn btn-purple" name="save">Enregistrer</button>
            </form>
        </div>
    </div>

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

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>