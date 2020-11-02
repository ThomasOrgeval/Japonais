<?php $title = 'Thèmes';
ob_start(); ?>

<h4>Voici vos thèmes :</h4>

<table>
    <tbody>
    <td><a class="btn btn-purple" href="index.php?p=select_theme&id=0">Défaut</a></td>
    <?php foreach ($_POST['themes_own'] as $theme) : ?>
        <td><a class="btn btn-purple"
               href="index.php?p=select_theme&id=<?= $theme['slug'] ?>"><?= $theme['libelle'] ?></a></td>
    <?php endforeach; ?>
    </tbody>
</table><br/>

<?php if (isset($_POST['themes']) && !empty($_POST['themes'])) : ?>
    <h4>Et les autres :</h4>

    <table>
        <tbody>
        <?php foreach ($_POST['themes'] as $theme) : ?>
            <td><a class="btn btn-outline-purple" onclick="return confirm('Voulez-vous vraiment acheter ce thème ?')"
                   href="index.php?p=achat&id_recompense=<?= $theme['id'] ?>&page=theme"><?= $theme['libelle'] ?></a></td>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
