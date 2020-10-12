<?php $title = 'Accueil';
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" name="search" style="width: 100%" onkeyup="showResult(this.value)">
        <div id="search" class="search" style="width: 100%"></div>
    </form>
    <br/><br/>
<?php if (!empty($_POST['words'])): ?>
    <h1>Sélection de mots aléatoires :</h1>
    <br/>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th>Kana</th>
            <th>Romaji</th>
            <th>Type du mot</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['words'] as $word): ?>
            <tr>
                <td style="font-size: 30px"><?= $word['francais']; ?></td>
                <td style="font-size: 30px"><?= $word['kanji']; ?></td>
                <td style="font-size: 30px"><?= $word['kana']; ?></td>
                <td style="font-size: 30px"><?= $word['romaji']; ?></td>
                <td style="font-size: 30px"><?= $word['id_type']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>