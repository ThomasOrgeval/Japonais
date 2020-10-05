<?php

require './model/frontend.php';
require './controller/form.php';
require './controller/session.php';
require './controller/csrf.php';

/**
 * Chargement de pages
 */

function accueil()
{
    $groupes = listGroupe();
    require './view/frontend/index.php';
}

function groupe()
{
    $groupes = listGroupe();
    require './view/frontend/groupe.php';
}

function groupe_edit() {
    if (isset($_GET['id'])) {
        $groupe = testGroupe($_GET['id']);
        if ($groupe->rowCount() == 0) {
            setFlash('Il n\'y a pas de groupe avec cet ID', 'danger');
            header('Location: index.php?p=groupe');
        }
        $_POST = $groupe->fetch();
    }
    require 'view/frontend/groupe_edit.php';
}

/**
 * Groupe
 * @throws Exception
 */

function addGroupe($libelle, $id)
{
    if ($id > 0) {
        $addGroupe = editGroupe($id, $libelle);
    } else {
        $addGroupe = createGroupe($libelle);
    }

    if ($addGroupe === false) {
        setFlash("Le groupe n'a pas été ajouté", 'danger');
        throw new Exception();
    } else {
        setFlash('Le groupe a bien été ajouté');
        header('Location: index.php?p=groupe');
    }
}

function deleteGroupe($id)
{
    $deleteGroupe = supprGroupe($id);
    if ($deleteGroupe === false) {
        setFlash('Le groupe n\'a pas été supprimé', 'danger');
        throw new Exception();
    } else {
        setFlash('Le groupe a bien été supprimé');
        header('Location: index.php?p=groupe');
    }
}