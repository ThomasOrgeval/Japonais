<?php $title = 'Les mots en japonais';
ob_start(); ?>

    <h1 class="h1-admin-left">Les mots japonais</h1>

    <p class="add"><a href="index.php?p=japonais_edit" class="btn btn-success">Ajout</a></p>

    <table id="db" class="table table-size">
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
        // Datatables
        $(document).ready(function () {
            $('#db').dataTable({
                "paging": false,
                "fnInitComplete": function () {
                    const myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
                    const ps = new PerfectScrollbar(myCustomScrollbar);
                },
                "scrollY": 600,

                "aaSorting": [],
                columnDefs: [{
                    orderable: false,
                    targets: [0, 1, 4]
                }]
            });
            $('.dataTables_length').addClass('bs-select');
        });

        function deleteJaponais(id) {
            $.post(
                'ajax/deleteJapan.php',
                {
                    id: id
                },
                function (data) {
                    if (data === 'success') {
                        $('#row' + id).remove();
                    } else if(data === 'fail') {
                        console.log('Accès non autorisé');
                    } else {
                        console.log(data);
                    }
                },
                'html'
            );
        }

        try {
            // Create the performance observer.
            const po = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    // Logs all server timing data for this response
                    console.log('Server Timing', entry.serverTiming);
                }
            });
            // Start listening for `navigation` entries to be dispatched.
            po.observe({type: 'navigation', buffered: true});
        } catch (e) {
            // Do nothing if the browser doesn't support this API.
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>