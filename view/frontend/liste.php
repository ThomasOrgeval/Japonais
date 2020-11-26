<?php $title = $_POST['liste']['nom'];
ob_start(); ?>

    <h1 class="h1-admin">
        <span><?= $_POST['liste']['nom'] ?> par </span>
        <a class="font-weight-bold" href="index.php?p=account&user=<?= $_POST['user']['pseudo'] ?>">
            <?= $_POST['user']['pseudo'] ?>
        </a>
        <span>:</span>
    </h1><br/>

    <h4>Description :</h4>
    <p><?= nl2br($_POST['liste']['description']) ?></p>

    <table class="table table-striped table-size">
        <thead>
        <tr>
            <th>Français</th>
            <th>Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['mots'] as $mot):
            $japonais = listJaponaisToFrancais($mot['id']) ?>
            <tr>
                <td><a href="index.php?p=search&mot=<?= $mot['francais'] ?>"><?= $mot['francais'] ?></a></td>
                <td><?php if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kanji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kanji'];
                    } ?>
                </td>
                <td class="hidden"><?php if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['kana'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['kana'];
                    } ?>
                </td>
                <td><?php if (sizeof($japonais) > 1) {
                        foreach ($japonais as $value) {
                            echo $value['romaji'] . ", ";
                        }
                    } elseif (sizeof($japonais) == 1) {
                        echo $japonais['0']['romaji'];
                    } ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>