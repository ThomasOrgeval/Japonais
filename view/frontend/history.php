<?php $title = 'Historique';
ob_start(); ?>

    <h2 class="font-weight-bold">Historique</h2>

    <table class="table table-bordered table-size">
        <thead>
        <tr>
            <th>Mot d'origine</th>
            <th>Français</th>
            <th class="hidden">Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['history'] as $value) : ?>
            <tr class="<?php if ($value['response'] == '1') : ?> green-table
            <?php else : ?> red-table <?php endif; ?>">
                <th><?= $value['riddle'] ?></th>
                <?php if (isset($value[0][0]['kanji'])) : ?>
                    <th></th>
                    <th class="hidden"><?= $value[0][0]['kanji'] ?></th>
                    <th class="hidden"><?= $value[0][0]['kana'] ?></th>
                    <th><?= $value[0][0]['romaji'] ?></th>
                <?php else : ?>
                    <th><?= $value[0][0]['francais'] ?></th>
                    <th class="hidden"></th>
                    <th class="hidden"></th>
                    <th></th>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php $content = ob_get_clean();
require('./view/template/template.php');