<?php $title = 'Thèmes';
ob_start(); ?>

    <h2 class="font-weight-bold text-uppercase">Voici vos thèmes :</h2>

    <table>
        <tbody>
        <td><a class="btn btn-purple" href="index.php?p=select_theme&id=0">Défaut</a></td>
        <?php if (isset($_POST['themes_own'])) :
            foreach ($_POST['themes_own'] as $theme) : ?>
                <td><a class="btn btn-purple"
                       href="index.php?p=select_theme&id=<?= $theme['slug'] ?>"><?= $theme['libelle'] ?></a></td>
            <?php endforeach;
        endif; ?>
        </tbody>
    </table><br/>

<?php if (isset($_POST['themes']) && !empty($_POST['themes'])) : ?>
    <div style="margin-left: 20px">
        <h4>Et les autres :</h4>

        <table>
            <tbody>
            <?php foreach ($_POST['themes'] as $theme) : ?>
                <td><a class="btn btn-outline-purple"
                       onclick="return confirm('Voulez-vous vraiment acheter ce thème ?')"
                       href="index.php?p=achat&id_recompense=<?= $theme['id'] ?>&page=theme"><?= $theme['libelle'] ?></a>
                </td>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

    <br/><br/>
    <h2 class="font-weight-bold text-uppercase">Voici vos arrières plans :</h2>

    <table>
        <tbody>
        <td><a class="btn btn-purple" href="index.php?p=select_back&id=0">Défaut</a></td>
        <?php if (isset($_POST['background_own'])) :
            foreach ($_POST['background_own'] as $background) : ?>
                <td><a class="btn btn-purple"
                       href="index.php?p=select_back&id=<?= $background['slug'] ?>"><?= $background['libelle'] ?></a>
                </td>
            <?php endforeach;
        endif; ?>
        </tbody>
    </table><br/>

<?php if (isset($_POST['background']) && !empty($_POST['background'])) : ?>
    <div style="margin-left: 20px">
        <h4>Et les autres :</h4>

        <table>
            <tbody>
            <?php foreach ($_POST['background'] as $background) : ?>
                <td><a class="btn btn-outline-purple"
                       onclick="return confirm('Voulez-vous vraiment acheter cet arrière plan ?')"
                       href="index.php?p=achat&id_recompense=<?= $background['id'] ?>&page=theme"><?= $background['libelle'] ?></a>
                </td>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>