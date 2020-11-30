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
        <ul class="list-unstyled changelog-list">
            <li><span class="font-weight-bold">Ajout d'un footer</span> (et oui enfin !) 📖</li>
            <li><span class="font-weight-bold">Ajout d'un changelog</span> afin de pouvoir se maintenir au courant des
                mises à jour du site, bienvenue sur la page en question ! 📝
            </li>
            <li><span class="font-weight-bold">Ajout d'une page de statistiques</span> (afin de voir qui a gagné le plus
                de sakuras !💥) 📊
                <ul class="list-unstyled changelog-list">
                    <li>- Affichage du nombre de compte sur le site</li>
                    <li>- Affichage du nombre de mots sur le site</li>
                    <li>- Affichage du nombre de sakuras cumulé de chaque utilisateur</li>
                    <li>- Affichage d'un scoreboard des meilleurs utilisateurs</li>
                    <li>- Affichage d'un scoreboard des meilleurs utilisateurs en comptant les dépenses</li>
                    <li>- Affichage d'un scoreboard des kanjis les plus utilisés</li>
                    <li>- Affichage d'un scoreboard des meilleurs utilisateurs sur une durée déterminée</li>
                </ul>
            </li>
            <li>
                <span class="font-weight-bold">Ajout d'une statistique sur le profil</span> pour voir la progression de
                chacun 😋
            </li>
            <li><span class="font-weight-bold">Nombre de vies à 5</span> désormais en tant que limite maximale et pour
                tous les nouveaux comptes !❤️
            </li>
            <li>
                <span class="font-weight-bold">Possibilité d'afficher des kanjis</span>, avec leur fiche personnelle. 🈸
            </li>
            <li>
                Il est désormais possible d'avoir des <span
                        class="font-weight-bold">mots japonais dans les énigmes</span>, sur l'écran d'accueil pour
                pouvoir vous tester davantage !🧠
            </li>
            <li>
                <span class="font-weight-bold">Ajout d'une page de contact</span> afin d'obtenir plus d'informations ou
                donner votre avis 😉 ça sera avec plaisir !
            </li>
        </ul>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold orange-text">Correction de bugs & Mises à jour</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Changement de lien relatif aux kanjis dans la partie administrative</span>
                afin que ça soit plus simple d'utilisation pour tout le monde !
            </li>
            <li>
                <span class="font-weight-bold">Changement important pour les url de recherche de mots</span>
                ainsi il sera plus facile de développer autour de ça ! Et les recherches autour de l'url seront
                également facilité
            </li>
            <li>
                <span class="font-weight-bold">Résolution de nombreux bugs</span> côté administration dans l'édition et
                la traduction des mots
            </li>
            <li>
                <span class="font-weight-bold">Changements importants pour la base de données</span> et notamment la
                gestion des sakuras qui désormais permettront d'avoir un historique
            </li>
            <li>
                <span class="font-weight-bold">Refonte des profils</span> pour une meilleure interface
            </li>
        </ul>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>