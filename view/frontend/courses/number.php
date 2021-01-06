<?php $title = 'Nombres';
ob_start(); ?>

    <h2 class="text-uppercase font-weight-bold">Les nombres</h2><br/>

    <table id="tableNumber" class="table table-size"
           style="text-align: center;">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Kanji</th>
            <th class="hidden">Kana</th>
            <th>Romaji</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_POST['data'] as $number) :
            $array = (array) $number ?>
            <tr onclick="textToAudio('<?= $array['romaji'] ?>')">
                <td><?= $array['id'] ?></td>
                <td><?= $array['kanji'] ?></td>
                <td class="hidden"><?= $array['kana'] ?></td>
                <td><?= $array['romaji'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#tableNumber').dataTable({
                "paging": false,
                "fnInitComplete": function () {
                    const myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
                    const ps = new PerfectScrollbar(myCustomScrollbar);
                },
                "scrollY": 600,

                "aaSorting": [],
                columnDefs: [{
                    orderable: false,
                    targets: [0, 1, 3]
                }]
            });
            $('.dataTables_length').addClass('bs-select');
        });

    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php');