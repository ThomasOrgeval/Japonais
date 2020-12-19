<?php $title = 'Kana';
ob_start(); ?>

    <h2 class="text-uppercase font-weight-bold">Kana :</h2><br/>

    <table id="tableKana" class="table table-hover table-bordered table-sm"
           style="text-align: center; table-layout: fixed;">
        <thead>
        <tr>
            <th></th>
            <th>a</th>
            <th>o</th>
            <th>u</th>
            <th>i</th>
            <th>e</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['kana'] as $key => $kana) : ?>
            <tr>
                <td><?= $key ?></td>
                <?php foreach ($kana as $value) : ?>
                    <td onclick="kana('<?= $value['romaji'] ?>')">
                        <?= $value['hiragana'] ?>
                        <?php if (!empty($value['hiragana'])) : ?> - <?php endif; ?>
                        <?= $value['katakana'] ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>a</th>
            <th>o</th>
            <th>u</th>
            <th>i</th>
            <th>e</th>
        </tr>
        </tfoot>
    </table>

    <div class="modal fade" id="modalKana" role="dialog">
    </div>

    <script>
        function kana(romaji) {
            if (romaji.length !== 0) {
                $.post(
                    'ajax/showKana.php',
                    {
                        romaji: romaji
                    },
                    function (data) {
                        $('#modalKana').html(data).modal('show');
                        $('body').addClass('modal-open');
                    },
                    'html'
                );
            }
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>