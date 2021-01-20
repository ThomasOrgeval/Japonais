<?php $title = isset($_POST['id']) ? $_POST['titre'] . ' - Edition' : 'Ma nouvelle musique';
ob_start(); ?>

    <h1 class="h1-admin">Editer une musique</h1>

    <form action="index.php?p=music_add<?php if (isset($_GET['id'])) {
        echo '&id=' . $_GET['id'];
    } ?>" method="post" autocomplete="off" enctype="multipart/form-data">
        <?php if (isset($_GET['id'])): ?>
            <div class="form-group">
                <label for="id">ID</label>
                <?= inputReadonly('id'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="titre">Titre de la musique</label>
            <?= input('titre') ?>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="japonais">Japonais</label>
                <?= textarea('japonais') ?>
            </div>
            <div class="form-group col-md-6">
                <label for="romaji">Romaji</label>
                <?= textarea('romaji') ?>
            </div>
        </div>
        <div class="form-group">
            <label for="francais">Francais</label>
            <?= textarea('francais') ?>
        </div>
        <div class="form-group">
            <label for="anime">Nom de l'animé</label>
            <?= input('anime') ?>
        </div>
        <div class="form-group">
            <label for="chanteur">Nom du chanteur</label>
            <?= input('chanteur') ?>
        </div>

        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" name="audio" class="custom-file-input" id="audio">
                <label class="custom-file-label" for="audio">Choisir fichier</label>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-dark">Enregistrer</button>
    </form>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/cq9fpx7h3gak9curb21o4hzf8745n6g3yyrzor7w98mm93hn/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: '',
            toolbar: '',
            toolbar_mode: 'floating',
        });
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>