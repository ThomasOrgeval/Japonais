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
    </div><br/><hr class="black"><br/>

    <div class="row">
        <div class="col-sm-6">
            <canvas id="leaderboard"></canvas>
        </div>
        <div class="col-sm-6">

        </div>
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
                    backgroundColor: ["rgba(255,99,132,0.2)", "rgba(255,159,64,0.2)",
                        "rgba(255,205,86,0.2)", "rgba(75,192,192,0.2)", "rgba(54,162,235,0.2)"
                    ],
                    borderColor: ["rgb(255,99,132)", "rgb(255,159,64)", "rgb(255,205,86)",
                        "rgb(75,192,192)", "rgb(54,162,235)"
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
                },
                title: {
                    display: true,
                    text: "Classement des 5 meilleurs joueurs"
                }
            }
        });
    </script>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>