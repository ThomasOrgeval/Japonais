<?php $title = 'Changelog';
ob_start(); ?>

    <h2 class="text-uppercase font-weight-bold">Nouveautés :</h2><br/>

    <div id="v1.4" class="changelog-version">
        <div class="flexible">
            <h4 class="text-uppercase font-weight-bolder">Version 1.4
                <span class="font-weight-lighter changelog-date">- 18 Janvier 2021<span>
            </h4>
        </div>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold green-text">Nouvelles fonctionnalités</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Ajout des musiques !</span> Vous pouvez les retrouver dans la section
                cours -> musique
            </li>
        </ul>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold orange-text">Correction de bugs & Mises à jour</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Correction de l'affichage du thème basique sur les mots japonais</span>
            </li>
        </ul>
    </div><br/>

    <div id="v1.3" class="changelog-version">
        <div class="flexible">
            <h4 class="text-uppercase font-weight-bolder">Version 1.3
                <span class="font-weight-lighter changelog-date">- 18 Janvier 2021<span>
            </h4>
        </div>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold green-text">Nouvelles fonctionnalités</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Ajout d'un bouton de retour</span> afin que vous puissiez donner votre
                avis
                voire m'aider ! Ça sera avec plaisir 🤗 <a href="index.php?p=contact">En bas de page</a>
            </li>
            <li>
                <span class="font-weight-bold">Ajout d'un nouveau thème</span> basé sur le bleu !
            </li>
            <li>
                <span class="font-weight-bold">Ajout des nombres de 0 à 10000 !</span> <a
                        href="index.php?p=number">Lien</a>
            </li>
            <li>
                <span class="font-weight-bold">Modification du lien pour trouver le tableau des kanas</span>, il faut
                désormais aller dans "cours" en haut de votre écran ;)
            </li>
            <li>
                <span class="font-weight-bold">Ajout des belles urls !</span>
            </li>
            <li>
                <span class="font-weight-bold">On peut désormais voir les groupes enfants et parent de chacun des groupes
                    ainsi que les quantifieurs de chacun des groupes s'ils existent</span>
            </li>
            <li>
                <span class="font-weight-bold">Ajout des backgrounds !</span> Vous pouvez les voir dans la section <a
                        href="index.php?p=theme">"Mes thèmes"</a>
            </li>
            <li>
                <span class="font-weight-bold">Ajout des niveaux JLPT !</span> (Japanese Language Proficiency Test)
                allant de N5 (débutant) jusqu'à N1 (avancé)
            </li>
            <li>
                <span class="font-weight-bold">Ajout de devinettes pour les groupes</span> lorsque ceux-ci ont au moins
                5 mots.
            </li>
            <li>
                <span class="font-weight-bold">Ajout de 5 groupes aléatoires sur l'accueil !</span>
            </li>
        </ul>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold orange-text">Correction de bugs & Mises à jour</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Résolution de nombreux bugs :</span>
                <ul class="list-unstyled">
                    <li>Affichage des groupes pour les fiches des mots</li>
                    <li>Temps verbaux qui ne prennaient par toute la largeur sur mobile</li>
                    <li>Modifications côté administration</li>
                </ul>
            </li>
            <li>
                <span class="font-weight-bold">Modification du htaccess</span> pour vous renvoyez les adresses http vers
                https 😊
            </li>
            <li>
                <span class="font-weight-bold">Correction des conjugaisons verbales des verbes finissants par suru</span>
                (mais n'étant pas suru) <a href="https://lexiquejaponais.fr/recherche/saluer"
                                           target="_blank">exemple</a>
            </li>
            <li>
                <span class="font-weight-bold">Ajout de l'historique des 30 derniers jours sur les profils</span>
            </li>
        </ul>
    </div><br/>

    <div id="v1.2" class="changelog-version">
        <div class="flexible">
            <h4 class="text-uppercase font-weight-bolder">Version 1.2
                <span class="font-weight-lighter changelog-date">- 27 Décembre 2020<span>
            </h4>
        </div>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold green-text">Nouvelles fonctionnalités</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Ajout d'une description</span> aux mots japonais 📃
            </li>
            <li>
                <span class="font-weight-bold">Ajout des kanjis utilisés par le mot japonais</span> sur les fiches des
                mots 🉐
            </li>
            <li>
                <span class="font-weight-bold">Valeur dans les devinettes !</span> Désormais, quand vous devez trouver
                le mot japonais d'un mot français, vous pouvez répondre en romaji, kana ou kanji mais selon la réponse
                les points obtenus diffèrent !
                <ul class="list-unstyled">
                    <li>Pour une traduction en romaji : + 15 sakuras</li>
                    <li>Pour une traduction en kana : + 30 sakuras</li>
                    <li>Pour une traduction en kanji : + 45 sakuras</li>
                </ul>
                Si vous souhaitez mettre le clavier japonais en azerty sur windows, voici une solution :
                <a href="https://guidedujaponais.fr/ma-selection/utilitaires/utilitaires-pc-pour-le-japonais/mettre-clavier-japonais-en-azerty/"
                   target="_blank">Lien</a>
            </li>
            <li>
                <span class="font-weight-bold">Vous pouvez choisir de mettre les kanjis ou non</span> dans l'énigme ! 😁
            </li>
            <li>
                <span class="font-weight-bold">Ajout de la page des kanas</span> pour pouvoir mieux les connaîtres ^-^
                <a href="index.php?p=kana">Lien</a> (Il ne faut pas hésiter à cliquer sur chacun d'eux pour les voir en
                plus grand !)
            </li>
            <li>
                <span class="font-weight-bold">Les kanjis sur leur fiche de kanji</span> sont désormais cliquables,
                comme ça on peut les voir en plus grand également !
            </li>
            <li>
                <span class="font-weight-bold">Ajout d'un historique pour les énigmes</span> ainsi qu'une page qui lui
                est associée ! <a href="index.php?p=history">Lien</a> 😉
            </li>
            <li>
                <span class="font-weight-bold">Ajout des temps verbaux =D</span>
            </li>
        </ul>
        <hr class="black">

        <h5 class="text-uppercase font-weight-bold orange-text">Correction de bugs & Mises à jour</h5>
        <ul class="list-unstyled changelog-list">
            <li>
                <span class="font-weight-bold">Correction de nombreux bugs</span> côté administratif notamment dans
                l'ajout des mots
            </li>
            <li>
                <span class="font-weight-bold">Refonte de la base de données</span>, notamment dans la conception de
                celle-ci dans le lien entre chaque langue
            </li>
            <li>
                <span class="font-weight-bold">Correction d'un bug sur les énigmes lorsque la première lettre contient un accent</span>
            </li>
            <li>
                <span class="font-weight-bold">Modification pour les url de recherche</span> afin de ne plus devoir
                écrire l'id du type de mot en question
            </li>
            <li>
                <span class="font-weight-bold">Mise à jour du blackthème</span> car il avait quelques bugs... :(
            </li>
            <li>
                <span class="font-weight-bold">Il est désormais possible de ne plus mettre les accents</span> dans les
                énigmes !
            </li>
        </ul>
    </div><br/>

    <div id="v1.1" class="changelog-version">
        <div class="flexible">
            <h4 class="text-uppercase font-weight-bolder">Version 1.1
                <span class="font-weight-lighter changelog-date">- 3 Décembre 2020<span>
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
            <li>
                <span class="font-weight-bold">Ajout d'une traduction en japonais pour les types des mots</span>
            </li>
        </ul>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>