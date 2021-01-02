<?php

if (!empty($_POST['text'])) {
    $mail = 'orgevalthomas@gmail.com';
    $header = 'From: ' . $_POST['text'] . ' <support@lexiquejaponais.fr>' . "\r\n" .
        'Reply-To: support@lexiquejaponais.fr' . "\r\n" .
        'X-Mailer: PHP/' . PHP_VERSION . "\r\n" .
        "Content-type: text/html; charset=utf-8";
    $message = '<html lang="fr">
                <head>
                    <title>Message - lexiquejaponais.fr</title>
                    <meta charset="utf-8" />
                </head>
                <body>
                    <span> ' . $_POST['text'] . ' </span>
                </body>
                </html>';
    mail($mail, "Message - lexiquejaponais.fr", $message, $header);
} elseif (empty($_POST['text'])) echo 'empty';
