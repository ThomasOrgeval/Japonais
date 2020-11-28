<?php $title = 'Statistiques';
ob_start(); ?>

    <div class="row">
        <div class="col-sm">
            <h4 class="font-weight-bold">Utilisateurs :
                <span class="font-weight-normal"><?= $_POST['stats']['users'] ?></span>
            </h4>
        </div>
        <div class="col-sm">
            <h4 class="font-weight-bold">Mots :
                <span class="font-weight-normal"><?= $_POST['stats']['japonais'] ?> en japonais</span>
            </h4>
        </div>
        <div class="col-sm">
            <h4 class="font-weight-bold">Sakuras :
                <span class="font-weight-normal"><?= $_POST['stats']['sakuras'] ?></span>
                <img id="sakura-stats" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
            </h4>
        </div>
    </div><br/>
    <hr class="black"><br/>

    <div class="row">
        <div class="col-sm-6">
            <h6 class="text-center">Classement des 5 meilleurs joueurs</h6>
            <canvas id="leaderboard"></canvas>
        </div>
        <div class="col-sm-6">
            <h6 class="text-center">Kanjis les plus utilisés</h6>
            <canvas id="kanjisboard"></canvas>
        </div>
    </div><br/>
    <hr class="black"><br/>

    <div class="row">

    </div>

    <script>
        new Chart(document.getElementById("leaderboard"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['leaders'] as $leader): ?>
                    "<?= $leader['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['leaders'] as $leader): ?>
                        <?= $leader['points'] ?>,
                        <?php endforeach; ?>],
                    fill: false,
                    backgroundColor: ["rgba(255,34,79,0.2)", "rgba(255,143,32,0.2)",
                        "rgba(255,191,40,0.2)", "rgba(30,190,190,0.2)", "rgba(21,149,236,0.2)"
                    ],
                    borderColor: ["rgb(255,0,54)", "rgb(255,127,0)", "rgb(255,180,0)",
                        "rgb(33,191,191)", "rgb(21,150,238)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true,
                legend: {
                    display: false
                }
            }
        });

        const kanjiCanvas = document.getElementById('kanjisboard');
        var kanjiBar = new Chart(kanjiCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: [<?php foreach ($_POST['stats']['kanjis'] as $kanji): ?>
                        '<?= $kanji['kanji'] ?> <?= $kanji['kun_yomi'] ?>',
                        <?php endforeach; ?>],
                    datasets: [{
                        data: [<?php foreach ($_POST['stats']['kanjis'] as $kanji): ?>
                            <?= $kanji['count'] ?>,
                            <?php endforeach; ?>],
                        backgroundColor: ["#003f5c", "#2f4b7c", "#665191", "#a05195", "#d45087",
                            "#f95d6a", "#ff7c43", "#ffa600", "#ffd200", "#fff500"]
                    }]
                },
                options: {
                    responsive: true
                }
        });

        kanjiCanvas.onclick = function(e) {
            const slice = kanjiBar.getElementAtEvent(e);
            if (!slice.length) return; // return if not clicked on slice
            const label = slice[0]._model.label;
            switch (label) {
                <?php foreach ($_POST['stats']['kanjis'] as $kanji): ?>
                    case '<?= $kanji['kanji'] ?> <?= $kanji['kun_yomi'] ?>':
                        window.open('https://lexiquejaponais.fr/index.php?p=kanji&id=<?= $kanji['id'] ?>');
                        break;
                <?php endforeach; ?>
            }
        }
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>