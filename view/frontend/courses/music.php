<?php $title = 'Les musiques';
ob_start(); ?>

<div class="form-group row">
    <div class="col-md-8">
        <h2 class="text-uppercase font-weight-bold"><?= $_POST['music']['chanteur'] ?> - <?= $_POST['music']['titre'] ?>
            :</h2>
    </div>
    <div class="col-md-4 text-center">
        <audio controls>
            <source src="./resources/audio/<?= $_POST['music']['audio'] ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>

<?php if (!empty($_POST['music']['anime'])) : ?>
    <p style="margin-bottom: 30px">Cette musique est utilisée dans : <span
                class="font-weight-bold"><?= $_POST['music']['anime'] ?></span></p>
<?php endif; ?>

<div id="music-id">
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item li-music" onclick="showKanji()">Kanji</li>
                <li class="list-group-item li-music" onclick="showRomaji()">Romaji</li>
            </ul>
        </div>
    </div>
    <?php foreach ($_POST['music']['japonais'] as $k => $music) : ?>
        <div class="div-music row">
            <div id="jp" class="col-md-6">
                <?= $_POST['music']['japonais'][$k] ?>
            </div>
            <div id="rj" class="col-md-6 hide">
                <?= $_POST['music']['romaji'][$k] ?>
            </div>
            <div class="col-md-6 md-underline">
                <?= $_POST['music']['francais'][$k] ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function showKanji() {
        $('#music-id > div > #jp').removeClass('hide');
        $('#music-id > div > #rj').addClass('hide');
    }

    function showRomaji() {
        $('#music-id > div > #jp').addClass('hide');
        $('#music-id > div > #rj').removeClass('hide');
    }
</script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
