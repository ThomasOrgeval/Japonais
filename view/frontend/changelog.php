<?php $title = 'Changelog';
ob_start(); ?>

    <h2 class="text-uppercase font-weight-bold">Nouveautés :</h2><br/>

    <div id="v1.1" class="changelog-version">
        <div class="flexible">
            <h4 class="text-uppercase font-weight-bolder">Version 1.1
                <span class="font-weight-lighter changelog-date">- 28 Novembre 2020<span>
            </h4>
        </div>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold green-text">Nouvelles fonctionnalités</h5>
        <ul class="list-unstyled changelog-list" style="margin-left: 10px">
            <li><span class="font-weight-bold">Ajout d'un footer</span> (et oui enfin !) 📖</li>
            <li><span class="font-weight-bold">Ajout d'un changelog</span> afin de pouvoir se maintenir au courant des
                mises à jour du site, bienvenue sur la page en question ! 📝
            </li>
            <li><span class="font-weight-bold">Ajout d'une page de statistiques</span> (afin de voir qui a gagné le plus
                de points !💥) 📊
            </li>
        </ul>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold orange-text">Corrections de bugs</h5>
        <ul class="list-unstyled" style="margin-left: 10px">
            <li></li>
        </ul>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>