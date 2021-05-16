<?php $title = 'Les mots en japonais';
ob_start(); ?>

<div class="d-flex justify-content-between">
    <h1 class="h1-admin-left">Les mots japonais</h1>
    <a href="index.php?p=japonais_edit" class="btn btn-lg btn-success">
        <span style="vertical-align: sub">Ajout</span>
    </a>
</div>

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
        <tbody id="row"></tbody>
    </table>

    <script>
        // Datatables
        $(document).ready(function () {
            $.post(
                'ajax/lazyJaponais.php',
                function (data) {
                    $('#row').append(data);
                },
                'html'
            )
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
                    } else if (data === 'fail') {
                        console.log('Accès non autorisé');
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