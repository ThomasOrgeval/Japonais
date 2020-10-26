<?php $title = 'Accueil';
ob_start(); ?>
    <form action="index.php?p=search" method="post">
        <input type="text" name="search" style="width: 100%" onkeyup="showResult(this.value)">
        <div id="search" class="search" style="width: 100%"></div>
    </form>
    <br/><br/>
<?php if (!empty($_POST['words'])): ?>
    <h1>Sélection aléatoire de mots :</h1>
    <br/>
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
                <td><?= $word['francais'] ?></td>
                <td><?= $word['kanji'] ?></td>
                <td class="hidden"><?= $word['kana'] ?></td>
                <td><?= $word['romaji'] ?></td>
                <td class="hidden"><?= $word['type'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <br/><br/>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>