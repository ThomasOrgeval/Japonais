<?php

require './model/Token.php';

class Database
{
    function db()
    {
        if ($_SERVER['HTTP_HOST'] === 'localhost') {
            $db = new PDO('mysql:host=localhost;dbname=lexiqumjaponais;charset=utf8', 'root', '');
        } else {
            $var = (array) json_decode(file_get_contents('https://lexiquejaponais.fr/model/env.json'));
            $db = new PDO('mysql:host=' . $var['HTTP_HOST'] . '; dbname=' . $var['HTTP_DBNAME'] . '; charset=utf8', $var['HTTP_USER'], $var['HTTP_MDP']);
        }
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Affiche toutes les alertes
        return $db;
    }
}