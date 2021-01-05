<?php

if (!empty($_POST['text'])) {
    $mail = 'learn@lexiquejaponais.fr';
    $header = 'From: ' . $_POST['user'] . ' <support@lexiquejaponais.fr>' . "\r\n" .
        'Reply-To: support@lexiquejaponais.fr' . "\r\n" .
        'X-Mailer: PHP/' . PHP_VERSION . "\r\n" .
        "Content-type: text/html; charset=utf-8";
    $message = '<html lang="fr">
                <head>
                    <title>Message - lexiquejaponais.fr</title>
                    <meta charset="utf-8" />
                </head>
                <body>
                    <p> ' . nl2br($_POST['text']) . ' </p>
                </body>
                </html>';
    mail($mail, $_POST['user'] . " - lexiquejaponais.fr", $message, $header);
    echo 'success';
} elseif (empty($_POST['text'])) echo 'empty';
