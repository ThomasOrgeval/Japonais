<?php $title = 'Points';
ob_start(); ?>

    <h1>Vous avez : <?= $_SESSION['points'] ?><img id="sakura-svg-points" src="./resources/svgs/sakura.svg"
                                                   alt="sakura"></h1>

    <h2>Voici ce que vous pouvez acheter :</h2><br/><br/>

    <h2>Ce que vous avez déjà acheté :</h2><br/><br/>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>