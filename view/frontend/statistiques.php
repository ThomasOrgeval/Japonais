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
                <span class="font-weight-normal"><?= $_POST['stats']['sakura'] ?></span>
                <img id="sakura-stats" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
            </h4>
        </div>
        <div class="col-sm">
            <h4 class="font-weight-bold">Sakuras total :
                <span class="font-weight-normal"><?= $_POST['stats']['sakura_total'] ?></span>
                <img id="sakura-stats" class="svg" src="./resources/svgs/sakura.svg" alt="sakura">
            </h4>
        </div>
    </div><br/>
    <hr class="black"><br/>

    <div class="row">
        <div class="col-sm-6">
            <h6 class="text-center">Classement des 5 meilleurs joueurs actuels</h6>
            <canvas id="leaderboard"></canvas>
        </div>
        <div class="col-sm-6">
            <h6 class="text-center">Classement des 5 meilleurs joueurs depuis le début</h6>
            <canvas id="leaderboard2"></canvas>
        </div>
    </div><br/>
    <hr class="black"><br/>

    <div class="row">
        <div class="col-sm-4">
            <h6 class="text-center">Classement sur le denier jour</h6>
            <canvas id="leaderboardDay"></canvas>
        </div>
        <div class="col-sm-4">
            <h6 class="text-center">Classement sur la dernière semaine</h6>
            <canvas id="leaderboardWeek"></canvas>
        </div>
        <div class="col-sm-4">
            <h6 class="text-center">Classement sur le dernier mois</h6>
            <canvas id="leaderboardMonth"></canvas>
        </div>
    </div><br/>
    <hr class="black"><br/>

    <div class="row">
        <div class="col-sm-12">
            <h6 class="text-center">Kanjis les plus utilisés</h6>
            <canvas id="kanjisboard"></canvas>
        </div>
    </div>

    <script>
        new Chart(document.getElementById("leaderboard"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['leaders'] as $user): ?>
                    "<?= $user['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['leaders'] as $user): ?>
                        <?= $user['sakura'] ?>,
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

        new Chart(document.getElementById("leaderboard2"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['leaders2'] as $user): ?>
                    "<?= $user['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['leaders2'] as $user): ?>
                        <?= $user['sakura_total'] ?>,
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

        new Chart(document.getElementById("leaderboardDay"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['day'] as $user): ?>
                    "<?= $user['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['day'] as $user): ?>
                        <?= $user['sakura'] ?>,
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

        new Chart(document.getElementById("leaderboardWeek"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['week'] as $user): ?>
                    "<?= $user['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['week'] as $user): ?>
                        <?= $user['sakura'] ?>,
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

        new Chart(document.getElementById("leaderboardMonth"), {
            type: 'horizontalBar',
            data: {
                labels: [<?php foreach ($_POST['stats']['month'] as $user): ?>
                    "<?= $user['pseudo'] ?>",
                    <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($_POST['stats']['month'] as $user): ?>
                        <?= $user['sakura'] ?>,
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
            if (!slice.length) return;
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