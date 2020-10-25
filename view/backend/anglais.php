<?php $title = 'Les mots en anglais';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots anglais</h1>

    <p class="add"><a href="index.php?p=anglais_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th>Anglais</th>
            <th>Kanji</th>
            <th>Français</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['anglais'] as $mot): ?>
            <tr>
                <td><?= $mot['anglais']; ?></td>
                <td><?php $japonais = listJaponaisToAnglais($mot['id']);
                    if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kanji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kanji'];
                    }
                    ?></td>
                <td><?php $francais = listFrancaisToAnglais($mot['id']);
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