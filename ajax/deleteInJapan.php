<?php

require_once '../model/frontend.php';
require_once '../model/backend.php';

if ($_POST['lang'] == 'fr') deleteFrancais($_POST['id']);
else if ($_POST['lang'] == 'en') deleteAnglais($_POST['id']);
echo 'success';