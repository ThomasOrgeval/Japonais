<?php $title = 'Les mots en japonais';
ob_start(); ?>

    <h1 class="h1-admin-left">Les mots japonais</h1>

    <p class="add"><a href="index.php?p=japonais_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-striped table-size">
        <thead>
        <tr>
            <th>Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
            <th class="hidden">Français</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['japonais'] as $mot): ?>
            <tr id="row<?= $mot['id'] ?>">
                <td><?= $mot['kanji']; ?></td>
                <td class="hidden"><?= $mot['kana']; ?></td>
                <td><?= $mot['romaji']; ?></td>
                <td class="hidden"><?php $francais = listFrancaisToJaponais($mot['id']);
                    if (sizeof($francais) > 1) {
                        foreach ($francais as $value) {
                            echo $value['francais'] . ", ";
                        }
                    } elseif (sizeof($francais) == 1) {
                        echo $francais['0']['francais'];
                    }
                    ?></td>
                <td>
                    <a href="index.php?p=japonais_edit&id=<?= $mot['id']; ?>" class="btn btn-outline-dark btn-sm">Edit</a>
                    <a onclick="deleteJaponais('<?= $mot['id'] ?>')" class="btn btn-outline-danger btn-sm">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <script>
        function deleteJaponais(id) {
            $.post(
                'ajax/deleteJapan.php',
                {
                    id: id
                },
                function (data) {
                    if (data === 'SUCCESS') {
                        $('#row' + id).remove();
                    } else {
                        console.log(data);
                    }
                },
                'html'
            );
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>