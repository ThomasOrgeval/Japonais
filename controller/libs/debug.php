<?php

function debug()
{
    return '<div class="row">
                <div class="col-sm-4">
                    <h2>Server</h2>
                    <?php var_dump($_SERVER); ?>
                </div>
                <div class="col-sm-4">
                    <h2>Constants</h2>
                    <?php var_dump(get_defined_constants()); ?>
                </div>
                <div class="col-sm-4">
                    <h2>Session</h2>
                    <?php var_dump($_SESSION); ?>
                    <?php var_dump($_POST); ?>
                </div>
            </div>';
}