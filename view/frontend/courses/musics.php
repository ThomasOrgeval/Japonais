<?php $title = 'Les musiques';
ob_start(); ?>

<h2 class="text-uppercase font-weight-bold">Musiques :</h2><br/>

<table class="table table-striped table-size">
    <thead>
    <tr>
        <th>Titre</th>
        <th>Chanteur</th>
        <th class="hidden">Animé</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($_POST['musics'] as $music): ?>
        <tr class='clickable-row' style="cursor: pointer" data-href="musique/<?= $music['slug'] ?>">
            <td><?= $music['titre'] ?></td>
            <td><?= $music['chanteur'] ?></td>
            <td><?= $music['anime'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br/>

<script>
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>
