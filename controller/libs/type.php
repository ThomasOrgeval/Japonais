<?php

function add_selection_type($type, $base)
{
    $type = testType($type)->fetch()['type'];
    $add = array();
    $end2 = substr($base['romaji'], strlen($base['romaji']) - 2);
    $end3 = substr($base['romaji'], strlen($base['romaji']) - 3);

    $romaji = substr($base['romaji'], 0, -2);
    $kana = substr($base['kana'], 0, -3);
    $kanji = substr($base['kanji'], 0, -3);

    $exceptFirstGroupe = [
        "Kaeru", "Miru"
    ];

    switch ($type) {

        case 'Verbe' :
            if ($base['romaji'] == 'Suru') { // Groupe 3 irréguliers
                $romaji = "Shi";
                $kanji = "し";

                $add = ["Verbe - Groupe 3 (Irrégulier)" => [
                    "Non présent" => [
                        "Kanji" => ["Affirmatif neutre" => "する", "Négatif neutre" => $kanji . "ない", "Affirmatif polie" => $kanji . "ます", "Négatif polie" => $kanji . "ません"],
                        "Romaji" => ["Affirmatif neutre" => "Suru", "Négatif neutre" => $romaji . "nai", "Affirmatif polie" => $romaji . "masu", "Négatif polie" => $romaji . "masen"]
                    ], // Non présent

                    "Passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "た", "Négatif neutre" => $kanji . "なかった", "Affirmatif polie" => $kanji . "ました", "Négatif polie" => $kanji . "ませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "ta", "Négatif neutre" => $romaji . "nakatta", "Affirmatif polie" => $romaji . "mashita", "Négatif polie" => $romaji . "masen deshita"]
                    ], // Passé

                    "Impératif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "て", "Négatif neutre" => $kanji . "るな", "Affirmatif polie" => $kanji . "てください", "Négatif polie" => $kanji . "ないでください"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te", "Négatif neutre" => $romaji . "runa", "Affirmatif polie" => $romaji . "te kudasai", "Négatif polie" => $romaji . "nai de kudasai"]
                    ], // Impératif

                    "Volutive" => [
                        "Kanji" => ["Neutre" => $kanji . "よう", "Négatif neutre" => $kanji . "まい", "Poli" => $kanji . "ましょう", "Négatif polie" => $kanji . "ますまい"],
                        "Romaji" => ["Neutre" => $romaji . "you", "Négatif neutre" => $romaji . "mai", "Poli" => $romaji . "mashou", "Négatif polie" => $romaji . "masumai"]
                    ], // Volontaire

                    "Présent progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ている", "Négatif neutre" => $kanji . "ていない", "Affirmatif polie" => $kanji . "ています", "Négatif polie" => $kanji . "ていません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te iru", "Négatif neutre" => $romaji . "te inai", "Affirmatif polie" => $romaji . "te imasu", "Négatif polie" => $romaji . "te imasen"]
                    ], // Présent progressif

                    "Passé progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ていた", "Négatif neutre" => $kanji . "ていなかった", "Affirmatif polie" => $kanji . "ていました", "Négatif polie" => $kanji . "ていませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te ita", "Négatif neutre" => $romaji . "te inakatta", "Affirmatif polie" => $romaji . "te imashita", "Négatif polie" => $romaji . "te imasen deshita"]
                    ], // Passé progressif

                    "Conditionnel" => [
                        "Kanji" => ["-Eba" => "すれば", "-Tara" => $kanji . "たら"],
                        "Romaji" => ["-Eba" => "Sureba", "-Tara" => $romaji . "tara"]
                    ], // Conditionnel

                    "Potentiel" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "rareru", "Négatif neutre" => $romaji . "rarenai", "Affirmatif polie" => $romaji . "raremasu", "Négatif polie" => $romaji . "raremasen"]
                    ], // Potentiel

                    "Causatif (Factitif)" => [
                        "Kanji" => ["Affirmatif neutre" => "させる", "Négatif neutre" => "させない", "Affirmatif polie" => "させます", "Négatif polie" => "させません"],
                        "Romaji" => ["Affirmatif neutre" => "Saseru", "Négatif neutre" => "Sasenai", "Affirmatif polie" => "Sasemasu", "Négatif polie" => "Sasemasen"]
                    ], // Causatif

                    "Passif (Subir)" => [
                        "Kanji" => ["Affirmatif neutre" => "られる", "Négatif neutre" => "られない", "Affirmatif polie" => "られます", "Négatif polie" => "られません"],
                        "Romaji" => ["Affirmatif neutre" => "Rareru", "Négatif neutre" => "Rarenai", "Affirmatif polie" => "Raremasu", "Négatif polie" => "Raremasen"]
                    ], // Causatif passif

                    "Causatif passif (Contrainte)" => [
                        "Kanji" => ["Affirmatif neutre" => "させられる", "Négatif neutre" => "させられない", "Affirmatif polie" => "させられます", "Négatif polie" => "させられません"],
                        "Romaji" => ["Affirmatif neutre" => "Saserareru", "Négatif neutre" => "Saserarenai", "Affirmatif polie" => "Saseraremasu", "Négatif polie" => "Saseraremasen"]
                    ], // Causatif passif

                    "Vouloir présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たい", "Négatif neutre" => $kanji . "たくない", "Affirmatif polie" => $kanji . "たいです", "Négatif polie" => $kanji . "たくないです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "tai", "Négatif neutre" => $romaji . "takunai", "Affirmatif polie" => $romaji . "tai desu", "Négatif polie" => $romaji . "takunai desu"]
                    ], // Vouloir présent

                    "Vouloir passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たかった", "Négatif neutre" => $kanji . "たくなった", "Affirmatif polie" => $kanji . "たかったです", "Négatif polie" => $kanji . "たくなったです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "takatta", "Négatif neutre" => $romaji . "takunakatta", "Affirmatif polie" => $romaji . "takatta desu", "Négatif polie" => $romaji . "takunakatta desu"]
                    ] // Vouloir passé
                ]];

            } elseif ($base['romaji'] == 'Kuru') { // Groupe 3 irréguliers
                $romaji = "Ki";
                $romajiNeg = "Ko";
                $kana = "き";
                $kanaNeg = "こ";
                $kanji = "来";

                $add = ["Verbe - Groupe 3 (Irrégulier)" => [
                    "Non présent" => [
                        "Kanji" => ["Affirmatif neutre" => "来る", "Négatif neutre" => $kanji . "ない", "Affirmatif polie" => $kanji . "ます", "Négatif polie" => $kanji . "ません"],
                        "Kana" => ["Affirmatif neutre" => "くる", "Négatif neutre" => $kanaNeg . "ない", "Affirmatif polie" => $kana . "ます", "Négatif polie" => $kana . "ません"],
                        "Romaji" => ["Affirmatif neutre" => "Kuru", "Négatif neutre" => $romajiNeg . "nai", "Affirmatif polie" => $romaji . "masu", "Négatif polie" => $romaji . "masen"]
                    ], // Non présent

                    "Passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "た", "Négatif neutre" => $kanji . "なかった", "Affirmatif polie" => $kanji . "ました", "Négatif polie" => $kanji . "ませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . "た", "Négatif neutre" => $kanaNeg . "なかった", "Affirmatif polie" => $kana . "ました", "Négatif polie" => $kana . "ませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "ta", "Négatif neutre" => $romajiNeg . "nakatta", "Affirmatif polie" => $romaji . "mashita", "Négatif polie" => $romaji . "masen deshita"]
                    ], // Passé

                    "Impératif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "て", "Négatif neutre" => $kanji . "なさるな", "Affirmatif polie" => $kanji . "てください", "Négatif polie" => $kanji . "ないでください"],
                        "Kana" => ["Affirmatif neutre" => $kana . "て", "Négatif neutre" => $kana . "なさるな", "Affirmatif polie" => $kana . "てください", "Négatif polie" => $kana . "ないでください"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te", "Négatif neutre" => $romaji . "nasaruna", "Affirmatif polie" => $romaji . "te kudasai", "Négatif polie" => $romaji . "nai de kudasai"]
                    ], // Impératif

                    "Volutive" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "よう", "Négatif neutre" => $kanji . "まい", "Affirmatif polie" => $kanji . "ましょう", "Négatif polie" => $kanji . "ますまい"],
                        "Kana" => ["Affirmatif neutre" => $kana . "よう", "Négatif neutre" => $kana . "まい", "Affirmatif polie" => $kana . "ましょう", "Négatif polie" => $kana . "ますまい"],
                        "Romaji" => ["Affirmatif neutre" => $romajiNeg . "you", "Négatif neutre" => $romaji . "mai", "Affirmatif polie" => $romaji . "mashou", "Négatif polie" => $romaji . "masumai"]
                    ], // Volontaire

                    "Présent progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ている", "Négatif neutre" => $kanji . "ていない", "Affirmatif polie" => $kanji . "ています", "Négatif polie" => $kanji . "ていません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "ている", "Négatif neutre" => $kana . "ていない", "Affirmatif polie" => $kana . "ています", "Négatif polie" => $kana . "ていません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te iru", "Négatif neutre" => $romaji . "te inai", "Affirmatif polie" => $romaji . "te imasu", "Négatif polie" => $romaji . "te imasen"]
                    ], // Présent progressif

                    "Passé progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ていた", "Négatif neutre" => $kanji . "ていなかった", "Affirmatif polie" => $kanji . "ていました", "Négatif polie" => $kanji . "ていませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . "ていた", "Négatif neutre" => $kana . "ていなかった", "Affirmatif polie" => $kana . "ていました", "Négatif polie" => $kana . "ていませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te ita", "Négatif neutre" => $romaji . "te inakatta", "Affirmatif polie" => $romaji . "te imashita", "Négatif polie" => $romaji . "te imasen deshita"]
                    ], // Passé progressif

                    "Conditionnel" => [
                        "Kanji" => ["-Eba" => $kanji . "れば", "-Tara" => $kanji . "たら"],
                        "Kana" => ["-Eba" => "くれば", "-Tara" => $kana . "たら"],
                        "Romaji" => ["-Eba" => "Kureba", "-Tara" => $romaji . "tara",]
                    ], // Conditionnel

                    "Causatif (Factitif)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させる", "Négatif neutre" => $kanji . "させない", "Affirmatif polie" => $kanji . "させます", "Négatif polie" => $kanji . "させません"],
                        "Kana" => ["Affirmatif neutre" => $kanaNeg . "させる", "Négatif neutre" => $kanaNeg . "させない", "Affirmatif polie" => $kanaNeg . "させます", "Négatif polie" => $kanaNeg . "させません"],
                        "Romaji" => ["Affirmatif neutre" => $romajiNeg . "saseru", "Négatif neutre" => $romajiNeg . "sasenai", "Affirmatif polie" => $romajiNeg . "sasemasu", "Négatif polie" => $romajiNeg . "sasemasen"]
                    ], // Causatif

                    "Passif (Subir)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                        "Kana" => ["Affirmatif neutre" => $kanaNeg . "られる", "Négatif neutre" => $kanaNeg . "られない", "Affirmatif polie" => $kanaNeg . "られます", "Négatif polie" => $kanaNeg . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romajiNeg . "rareru", "Négatif neutre" => $romajiNeg . "rarenai", "Affirmatif polie" => $romajiNeg . "raremasu", "Négatif polie" => $romajiNeg . "raremasen"]
                    ], // Causatif passif

                    "Causatif passif (Contrainte)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させられる", "Négatif neutre" => $kanji . "させられない", "Affirmatif polie" => $kanji . "させられます", "Négatif polie" => $kanji . "させられません"],
                        "Kana" => ["Affirmatif neutre" => $kanaNeg . "させられる", "Négatif neutre" => $kanaNeg . "させられない", "Affirmatif polie" => $kanaNeg . "させられます", "Négatif polie" => $kanaNeg . "させられません"],
                        "Romaji" => ["Affirmatif neutre" => $romajiNeg . "saserareru", "Négatif neutre" => $romajiNeg . "saserarenai", "Affirmatif polie" => $romajiNeg . "saseraremasu", "Négatif polie" => $romajiNeg . "saseraremasen"]
                    ], // Causatif passif

                    "Vouloir présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たい", "Négatif neutre" => $kanji . "たくない", "Affirmatif polie" => $kanji . "たいです", "Négatif polie" => $kanji . "たくないです"],
                        "Kana" => ["Affirmatif neutre" => $kana . "たい", "Négatif neutre" => $kana . "たくない", "Affirmatif polie" => $kana . "たいです", "Négatif polie" => $kana . "たくないです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "tai", "Négatif neutre" => $romaji . "takunai", "Affirmatif polie" => $romaji . "tai desu", "Négatif polie" => $romaji . "takunai desu"]
                    ], // Vouloir présent

                    "Vouloir passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たかった", "Négatif neutre" => $kanji . "たくなった", "Affirmatif polie" => $kanji . "たかったです", "Négatif polie" => $kanji . "たくなったです"],
                        "Kana" => ["Affirmatif neutre" => $kana . "たかった", "Négatif neutre" => $kana . "たくなった", "Affirmatif polie" => $kana . "たかったです", "Négatif polie" => $kana . "たくなったです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "takatta", "Négatif neutre" => $romaji . "takunakatta", "Affirmatif polie" => $romaji . "takatta desu", "Négatif polie" => $romaji . "takunakatta desu"]
                    ] // Vouloir passé
                ]];

            } elseif (($end3 == 'eru' || $end3 == 'iru') && !in_array($base['romaji'], $exceptFirstGroupe)) { // Groupe 2 ichidan

                $add = ["Verbe - Groupe 2 (Ichidan)" => [
                    "Non présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "る", "Négatif neutre" => $kanji . "ない", "Affirmatif polie" => $kanji . "ます", "Négatif polie" => $kanji . "ません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "る", "Négatif neutre" => $kana . "ない", "Affirmatif polie" => $kana . "ます", "Négatif polie" => $kana . "ません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "ru", "Négatif neutre" => $romaji . "nai", "Affirmatif polie" => $romaji . "masu", "Négatif polie" => $romaji . "masen"]
                    ], // Non présent

                    "Passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "た", "Négatif neutre" => $kanji . "なかった", "Affirmatif polie" => $kanji . "ました", "Négatif polie" => $kanji . "ませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . "た", "Négatif neutre" => $kana . "なかった", "Affirmatif polie" => $kana . "ました", "Négatif polie" => $kana . "ませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "ta", "Négatif neutre" => $romaji . "nakatta", "Affirmatif polie" => $romaji . "mashita", "Négatif polie" => $romaji . "masen deshita"]
                    ], // Passé

                    "Impératif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "なさい", "Négatif neutre" => $kanji . "るな", "Affirmatif polie" => $kanji . "てください", "Négatif polie" => $kanji . "ないでください"],
                        "Kana" => ["Affirmatif neutre" => $kana . "なさい", "Négatif neutre" => $kana . "るな", "Affirmatif polie" => $kana . "てください", "Négatif polie" => $kana . "ないでください"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "nasai", "Négatif neutre" => $romaji . "runa", "Affirmatif polie" => $romaji . "te kudasai", "Négatif polie" => $romaji . "nai de kudasai"]
                    ], // Impératif

                    "Volutive" => [
                        "Kanji" => ["Neutre" => $kanji . "よう", "Négatif neutre" => $kanji . "まい", "Poli" => $kanji . "ましょう", "Négatif polie" => $kanji . "ますまい"],
                        "Kana" => ["Neutre" => $kana . "よう", "Négatif neutre" => $kana . "まい", "Poli" => $kana . "ましょう", "Négatif polie" => $kana . "ますまい"],
                        "Romaji" => ["Neutre" => $romaji . "you", "Négatif neutre" => $romaji . "mai", "Poli" => $romaji . "mashou", "Négatif polie" => $romaji . "masumai"]
                    ], // Volontaire

                    "Présent progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ている", "Négatif neutre" => $kanji . "ていない", "Affirmatif polie" => $kanji . "ています", "Négatif polie" => $kanji . "ていません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "ている", "Négatif neutre" => $kana . "ていない", "Affirmatif polie" => $kana . "ています", "Négatif polie" => $kana . "ていません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te iru", "Négatif neutre" => $romaji . "te inai", "Affirmatif polie" => $romaji . "te imasu", "Négatif polie" => $romaji . "te imasen"]
                    ], // Présent progressif

                    "Passé progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "ていた", "Négatif neutre" => $kanji . "ていなかった", "Affirmatif polie" => $kanji . "ていました", "Négatif polie" => $kanji . "ていませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . "ていた", "Négatif neutre" => $kana . "ていなかった", "Affirmatif polie" => $kana . "ていました", "Négatif polie" => $kana . "ていませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "te ita", "Négatif neutre" => $romaji . "te inakatta", "Affirmatif polie" => $romaji . "te imashita", "Négatif polie" => $romaji . "te imasen deshita"]
                    ], // Passé progressif

                    "Conditionnel" => [
                        "Kanji" => ["-Eba" => $kanji . "れば", "-Tara" => $kanji . "たら"],
                        "Kana" => ["-Eba" => $kana . "れば", "-Tara" => $kana . "たら"],
                        "Romaji" => ["-Eba" => $romaji . "reba", "-Tara" => $romaji . "tara"]
                    ], // Conditionnel

                    "Potentiel" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "られる", "Négatif neutre" => $kana . "られない", "Affirmatif polie" => $kana . "られます", "Négatif polie" => $kana . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "rareru", "Négatif neutre" => $romaji . "rarenai", "Affirmatif polie" => $romaji . "raremasu", "Négatif polie" => $romaji . "raremasen"]
                    ], // Potentiel

                    "Causatif (Factitif)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させる", "Négatif neutre" => $kanji . "させない", "Affirmatif polie" => $kanji . "させます", "Négatif polie" => $kanji . "させません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "させる", "Négatif neutre" => $kana . "させない", "Affirmatif polie" => $kana . "させます", "Négatif polie" => $kana . "させません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "saseru", "Négatif neutre" => $romaji . "sasenai", "Affirmatif polie" => $romaji . "sasemasu", "Négatif polie" => $romaji . "sasemasen"]
                    ], // Causatif

                    "Passif (Subir)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "られる", "Négatif neutre" => $kana . "られない", "Affirmatif polie" => $kana . "られます", "Négatif polie" => $kana . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "rareru", "Négatif neutre" => $romaji . "rarenai", "Affirmatif polie" => $romaji . "raremasu", "Négatif polie" => $romaji . "raremasen"]
                    ], // Causatif passif

                    "Causatif passif (Contrainte)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させられる", "Négatif neutre" => $kanji . "させられない", "Affirmatif polie" => $kanji . "させられます", "Négatif polie" => $kanji . "させられません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "させられる", "Négatif neutre" => $kana . "させられない", "Affirmatif polie" => $kana . "させられます", "Négatif polie" => $kana . "させられません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "saserareru", "Négatif neutre" => $romaji . "saserarenai", "Affirmatif polie" => $romaji . "saseraremasu", "Négatif polie" => $romaji . "saseraremasen"]
                    ], // Causatif passif

                    "Vouloir présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たい", "Négatif neutre" => $kanji . "たくない", "Affirmatif polie" => $kanji . "たいです", "Négatif polie" => $kanji . "たくないです"],
                        "Kana" => ["Affirmatif neutre" => $kana . "たい", "Négatif neutre" => $kana . "たくない", "Affirmatif polie" => $kana . "たいです", "Négatif polie" => $kana . "たくないです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "tai", "Négatif neutre" => $romaji . "takunai", "Affirmatif polie" => $romaji . "tai desu", "Négatif polie" => $romaji . "takunai desu"]
                    ], // Vouloir présent

                    "Vouloir passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "たかった", "Négatif neutre" => $kanji . "たくなった", "Affirmatif polie" => $kanji . "たかったです", "Négatif polie" => $kanji . "たくなったです"],
                        "Kana" => ["Affirmatif neutre" => $kana . "たかった", "Négatif neutre" => $kana . "たくなった", "Affirmatif polie" => $kana . "たかったです", "Négatif polie" => $kana . "たくなったです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . "takatta", "Négatif neutre" => $romaji . "takunakatta", "Affirmatif polie" => $romaji . "takatta desu", "Négatif polie" => $romaji . "takunakatta desu"]
                    ] // Vouloir passé
                ]];

            } else { // Groupe 1 Godan

                if ($end2 == 'ru') {

                } elseif ($end2 == 'ku') {

                } elseif ($end2 == 'gu') {

                } elseif ($end2 == 'su') {

                } elseif ($end2 == 'nu') {

                } elseif ($end2 == 'mu') {

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "む", "Négatif neutre" => $kanji . "まない", "Affirmatif polie" => $kanji . "みます", "Négatif polie" => $kanji . "みません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "む", "Négatif neutre" => $kana . "まない", "Affirmatif polie" => $kana . "みます", "Négatif polie" => $kana . "みません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "mu", "Négatif neutre" => $romaji . "manai", "Affirmatif polie" => $romaji . "mimasu", "Négatif polie" => $romaji . "mimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "んだ", "Négatif neutre" => $kanji . "まなかった", "Affirmatif polie" => $kanji . "みました", "Négatif polie" => $kanji . "みませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "んだ", "Négatif neutre" => $kana . "まなかった", "Affirmatif polie" => $kana . "みました", "Négatif polie" => $kana . "みませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nda", "Négatif neutre" => $romaji . "manakatta", "Affirmatif polie" => $romaji . "mimashita", "Négatif polie" => $romaji . "mimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "みなさい", "Affirmatif polie" => $kanji . "んでください", "Négatif polie" => $kanji . "まないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "みなさい", "Affirmatif polie" => $kana . "んでください", "Négatif polie" => $kana . "まないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "minasai", "Affirmatif polie" => $romaji . "nde kudasai", "Négatif polie" => $romaji . "manai de kudasai"]
                        ], // Impératif

                        "Volutive" => [
                            "Kanji" => ["Neutre" => $kanji . "もう", "Négatif neutre" => $kanji . "むまい", "Poli" => $kanji . "みましょう", "Négatif polie" => $kanji . "みますまい"],
                            "Kana" => ["Neutre" => $kana . "もう", "Négatif neutre" => $kana . "むまい", "Poli" => $kana . "みましょう", "Négatif polie" => $kana . "みますまい"],
                            "Romaji" => ["Neutre" => $romaji . "mou", "Négatif neutre" => $romaji . "mumai", "Poli" => $romaji . "mimashou", "Négatif polie" => $romaji . "mimasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "んでいる", "Négatif neutre" => $kanji . "んでいない", "Affirmatif polie" => $kanji . "んでいます", "Négatif polie" => $kanji . "んでいません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "んでいる", "Négatif neutre" => $kana . "んでいない", "Affirmatif polie" => $kana . "んでいます", "Négatif polie" => $kana . "んでいません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nde iru", "Négatif neutre" => $romaji . "nde inai", "Affirmatif polie" => $romaji . "nde imasu", "Négatif polie" => $romaji . "nde imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "んでいた", "Négatif neutre" => $kanji . "んでいなかった", "Affirmatif polie" => $kanji . "んでいました", "Négatif polie" => $kanji . "んでいませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "んでいた", "Négatif neutre" => $kana . "んでいなかった", "Affirmatif polie" => $kana . "んでいました", "Négatif polie" => $kana . "んでいませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nde ita", "Négatif neutre" => $romaji . "nde inakatta", "Affirmatif polie" => $romaji . "nde imashita", "Négatif polie" => $romaji . "nde imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "めば", "-Tara" => $kanji . "んだら"],
                            "Kana" => ["-Eba" => $kana . "めば", "-Tara" => $kana . "んだら"],
                            "Romaji" => ["-Eba" => $romaji . "meba", "-Tara" => $romaji . "ndara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "める", "Négatif neutre" => $kanji . "めない", "Affirmatif polie" => $kanji . "めます", "Négatif polie" => $kanji . "めません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "める", "Négatif neutre" => $kana . "めない", "Affirmatif polie" => $kana . "めます", "Négatif polie" => $kana . "めません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "meru", "Négatif neutre" => $romaji . "menai", "Affirmatif polie" => $romaji . "memasu", "Négatif polie" => $romaji . "memasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ませる", "Négatif neutre" => $kanji . "ませない", "Affirmatif polie" => $kanji . "ませます", "Négatif polie" => $kanji . "ませません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ませる", "Négatif neutre" => $kana . "ませない", "Affirmatif polie" => $kana . "ませます", "Négatif polie" => $kana . "ませません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "maseru", "Négatif neutre" => $romaji . "masenai", "Affirmatif polie" => $romaji . "masemasu", "Négatif polie" => $romaji . "masemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "まれる", "Négatif neutre" => $kanji . "まれない", "Affirmatif polie" => $kanji . "まれます", "Négatif polie" => $kanji . "まれません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "まれる", "Négatif neutre" => $kana . "まれない", "Affirmatif polie" => $kana . "まれます", "Négatif polie" => $kana . "まれません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "mareru", "Négatif neutre" => $romaji . "marenai", "Affirmatif polie" => $romaji . "maremasu", "Négatif polie" => $romaji . "maremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ませられる", "Négatif neutre" => $kanji . "ませられない", "Affirmatif polie" => $kanji . "ませられます", "Négatif polie" => $kanji . "ませられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ませられる", "Négatif neutre" => $kana . "ませられない", "Affirmatif polie" => $kana . "ませられます", "Négatif polie" => $kana . "ませられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "maserareru", "Négatif neutre" => $romaji . "maserarenai", "Affirmatif polie" => $romaji . "maseraremasu", "Négatif polie" => $romaji . "maseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "みたい", "Négatif neutre" => $kanji . "みたくない", "Affirmatif polie" => $kanji . "みたいです", "Négatif polie" => $kanji . "みたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "みたい", "Négatif neutre" => $kana . "みたくない", "Affirmatif polie" => $kana . "みたいです", "Négatif polie" => $kana . "みたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "mitai", "Négatif neutre" => $romaji . "mitakunai", "Affirmatif polie" => $romaji . "mitai desu", "Négatif polie" => $romaji . "mitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "みたかった", "Négatif neutre" => $kanji . "みたくなった", "Affirmatif polie" => $kanji . "みたかったです", "Négatif polie" => $kanji . "みたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "みたかった", "Négatif neutre" => $kana . "みたくなった", "Affirmatif polie" => $kana . "みたかったです", "Négatif polie" => $kana . "みたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "mitakatta", "Négatif neutre" => $romaji . "mitakunakatta", "Affirmatif polie" => $romaji . "mitakatta desu", "Négatif polie" => $romaji . "mitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } elseif ($end2 == 'bu') {

                } elseif ($end2 == 'tu') {

                } else { // End = 'u'

                }

            }
            break;
        case 'Adjectif':
            $add = ["Adjectif" => "value"];
            break;
        case 'Nom':
            $add = ["Nom" => "value"];
            break;

        default:
            return null;
    }

    return $add;
}