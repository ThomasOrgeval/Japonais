<?php $title = 'Les mots en anglais';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots anglais</h1>

    <p class="add"><a href="index.php?p=anglais_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped">
        <thead>
        <tr>
            <th style="font-size: 24px">Anglais</th>
            <th style="font-size: 24px">Kanji</th>
            <th style="font-size: 24px">Français</th>
            <th style="font-size: 24px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['anglais'] as $mot): ?>
            <tr>
                <td style="font-size: 24px"><?= $mot['anglais']; ?></td>
                <td style="font-size: 24px"><?php $japonais = listJaponaisToAnglais($mot['id']);
                    if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kanji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kanji'];
                    }
                    ?></td>
                <td style="font-size: 24px"><?php $francais = listFrancaisToAnglais($mot['id']);
                    if (sizeof($francais) > 1) {
                        foreach ($francais as $value) {
                            echo $value['francais'] . ", ";
                        }
                    } elseif (sizeof($francais) == 1) {
                        echo $francais['0']['francais'];
                    }
                    ?></td>
                <td>
                    <a href="index.php?p=anglais_edit&id=<?= $mot['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=anglais_delete&id=<?= $mot['id']; ?>"
                       class="btn btn-outline-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>