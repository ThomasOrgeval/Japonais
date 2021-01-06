<?php

define('BASE_URL', 'https://lexiquejaponais.fr/');
require_once '../model/frontend.php';
$values = getKana($_POST['romaji']);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header text-center">
            <img src="./resources/svgs/sakura_login.svg" style="width: 40px">
            <h4 class="modal-title w-100 font-weight-bold"><?= $values['romaji'] ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-content">
            <div class="text-center" style="margin-top: 10px;">
                <h5 class="font-weight-bold">Hiragana</h5>
                <span style="font-size: 100px"><?= $values['hiragana'] ?></span>
            </div>
            <hr class="black">
            <div class="text-center" style="padding-bottom: 10px">
                <h5 class="font-weight-bold">Katakana</h5>
                <span style="font-size: 100px"><?= $values['katakana'] ?></span>
            </div>
        </div>
    </div>
</div>