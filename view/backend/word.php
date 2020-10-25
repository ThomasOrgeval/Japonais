<?php $title = 'Les mots en français';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots français</h1>

    <p class="add"><a href="index.php?p=word_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th class="hidden">Anglais</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['words'] as $word): ?>
            <tr>
                <td><?= $word['francais']; ?></td>
                <td><?php $japonais = listJaponaisToFrancais($word['id']);
                    if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kanji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kanji'];
                    }
                    ?></td>
                <td class="hidden"><?php $anglais = listAnglaisToFrancais($word['id']);
                    if (sizeof($anglais) > 1) {
                        foreach ($anglais as $value) {
                            echo $value['anglais'] . ", ";
                        }
                    } elseif (sizeof($anglais) == 1) {
                        echo $anglais['0']['anglais'];
                    }
                    ?></td>
                <td>
                    <a href="index.php?p=word_edit&id=<?= $word['id']; ?>" class="btn btn-outline-dark btn-small">Edit</a>
                    <a href="index.php?p=word_delete&id=<?= $word['id']; ?>"
                       class="btn btn-outline-danger btn-small">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>