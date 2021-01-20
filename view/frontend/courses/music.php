<?php $title = 'Les musiques';
ob_start(); ?>

<div class="form-group row">
    <div class="col-md-8">
        <h2 class="text-uppercase font-weight-bold"><?= $_POST['music']['chanteur'] ?> - <?= $_POST['music']['titre'] ?> :</h2>
    </div>
    <div class="col-md-4 text-center">
        <audio controls>
            <source src="./resources/audio/<?= $_POST['music']['audio'] ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>

<?php if (!empty($_POST['music']['anime'])) : ?>
    <p>Cette musique est utilisée dans : <span class="font-weight-bold"><?= $_POST['music']['anime'] ?></span></p>
<?php endif; ?>

<table id="table-music" class="table">
    <tbody>
    <tr>
        <td><?= $_POST['music']['japonais'] ?></td>
        <td><?= $_POST['music']['francais'] ?></td>
    </tr>
    </tbody>
</table>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
