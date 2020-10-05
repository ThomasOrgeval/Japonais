<?php

function connexiondb()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=japonais', 'root', '');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
    } catch (Exception $e) {
        echo 'Connexion impossible à la base de données';
        echo $e->getMessage(); // affiche le message d'erreur
        die();
    }
    return $db;
}

/**
 * Groupes
 */

function createGroupe() {

}