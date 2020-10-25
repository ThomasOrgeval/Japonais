<?php $title = 'Les mots en japonais';
ob_start(); ?>
    <h1 class="h1-admin-left">Les mots japonais</h1>

    <p class="add"><a href="index.php?p=japonais_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th>Kanji</th>
            <th>Kana</th>
            <th>Romaji</th>
            <th>Français</th>
            <th>Anglais</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['japonais'] as $mot): ?>
            <tr>
                <td><?= $mot['kanji']; ?></td>
                <td><?= $mot['kana']; ?></td>
                <td><?= $mot['romaji']; ?></td>
                <td><?php $francais = listFrancaisToJaponais($mot['id']);
                    if (sizeof($francais) > 1) {
                        foreach ($francais as $value) {
                            echo $value['francais'] . ", ";
                        }
                    } elseif (sizeof($francais) == 1) {
                        echo $francais['0']['francais'];
                    }
                    ?></td>
                <td><?php $anglais = listAnglaisToJaponais($mot['id']);
                    if (sizeof($anglais) > 1) {
                        foreach ($anglais as $value) {
                            echo $value['anglais'] . ", ";
                        }
                    } elseif (sizeof($anglais) == 1) {
                        echo $anglais['0']['anglais'];
                    }
                    ?></td>
                <td>
                    <a href="index.php?p=japonais_edit&id=<?= $mot['id']; ?>" class="btn btn-outline-dark">Edit</a>
                    <a href="index.php?p=japonais_delete&id=<?= $mot['id']; ?>"
                       class="btn btn-outline-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>