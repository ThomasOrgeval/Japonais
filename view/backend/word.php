<?php $title = 'Les mots en français';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots français</h1>

    <p class="add"><a href="index.php?p=word_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped">
        <thead>
        <tr>
            <th style="font-size: 24px">Français</th>
            <th style="font-size: 24px">Kanji</th>
            <th style="font-size: 24px">Anglais</th>
            <th style="font-size: 24px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['words'] as $word): ?>
            <tr>
                <td style="font-size: 24px"><?= $word['francais']; ?></td>
                <td style="font-size: 24px"><?php $japonais = listJaponaisToFrancais($word['id']);
                    if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kanji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kanji'];
                    }
                    ?></td>
                <td style="font-size: 24px"><?php $anglais = listAnglaisToFrancais($word['id']);
                    if (sizeof($anglais) > 1) {
                        foreach ($anglais as $value) {
                            echo $value['anglais'] . ", ";
                        }
                    } elseif (sizeof($anglais) == 1) {
                        echo $anglais['0']['anglais'];
                    }
                    ?></td>
                <td>
                    <a href="index.php?p=word_edit&id=<?= $word['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=word_delete&id=<?= $word['id']; ?>"
                       class="btn btn-outline-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>