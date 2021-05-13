<?php

function add_selection_type($type, $base)
{
    $type = testType($type)->fetch()['type'];
    $end1 = substr($base['romaji'], strlen($base['romaji']) - 1);
    $end2 = substr($base['romaji'], strlen($base['romaji']) - 2);
    $end3 = substr($base['romaji'], strlen($base['romaji']) - 3);

    $exceptFirstGroupe = listExceptions();

    switch ($type) {

        case 'Verbe' :
            $romaji = substr($base['romaji'], 0, -2);
            $kana = substr($base['kana'], 0, -3);
            $kanji = substr($base['kanji'], 0, -3);

            if ($base['romaji'] == 'Suru' || substr($base['romaji'], strlen($base['romaji']) - 4) == 'suru') { // Groupe 3 irréguliers
                if ($base['romaji'] != 'Suru') {
                    $romaji = substr($base['romaji'], 0, -4);
                    $kana = substr($base['kana'], 0, -6);
                    $kanji = substr($base['kanji'], 0, -6);

                    $romajiSu = 'su';
                    $romajiNeg = "shi";
                    $romajiSase = "sase";
                    $romajiRare = "rare";
                } else {
                    $romajiSu = 'Su';
                    $romajiNeg = "Shi";
                    $romajiSase = "Sase";
                    $romajiRare = "Rare";
                }
                $kanjiNeg = "し";

                $add = ["Verbe - Groupe 3 (Irrégulier)" => [
                    "Non présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "する", "Négatif neutre" => $kanji . $kanjiNeg . "ない", "Affirmatif polie" => $kanji . $kanjiNeg . "ます", "Négatif polie" => $kanji . $kanjiNeg . "ません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "する", "Négatif neutre" => $kana . $kanjiNeg . "ない", "Affirmatif polie" => $kana . $kanjiNeg . "ます", "Négatif polie" => $kana . $kanjiNeg . "ません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiSu . "ru", "Négatif neutre" => $romaji . $romajiNeg . "nai", "Affirmatif polie" => $romaji . $romajiNeg . "masu", "Négatif polie" => $romaji . $romajiNeg . "masen"]
                    ], // Non présent

                    "Passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "た", "Négatif neutre" => $kanji . $kanjiNeg . "なかった", "Affirmatif polie" => $kanji . $kanjiNeg . "ました", "Négatif polie" => $kanji . $kanjiNeg . "ませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "た", "Négatif neutre" => $kana . $kanjiNeg . "なかった", "Affirmatif polie" => $kana . $kanjiNeg . "ました", "Négatif polie" => $kana . $kanjiNeg . "ませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "ta", "Négatif neutre" => $romaji . $romajiNeg . "nakatta", "Affirmatif polie" => $romaji . $romajiNeg . "mashita", "Négatif polie" => $romaji . $romajiNeg . "masen deshita"]
                    ], // Passé

                    "Impératif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "て", "Négatif neutre" => $kanji . $kanjiNeg . "るな", "Affirmatif polie" => $kanji . $kanjiNeg . "てください", "Négatif polie" => $kanji . $kanjiNeg . "ないでください"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "て", "Négatif neutre" => $kana . $kanjiNeg . "るな", "Affirmatif polie" => $kana . $kanjiNeg . "てください", "Négatif polie" => $kana . $kanjiNeg . "ないでください"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "te", "Négatif neutre" => $romaji . $romajiNeg . "runa", "Affirmatif polie" => $romaji . $romajiNeg . "te kudasai", "Négatif polie" => $romaji . $romajiNeg . "nai de kudasai"]
                    ], // Impératif

                    "Volitive" => [
                        "Kanji" => ["Neutre" => $kanji . $kanjiNeg . "よう", "Négatif neutre" => $kanji . $kanjiNeg . "まい", "Poli" => $kanji . $kanjiNeg . "ましょう", "Négatif polie" => $kanji . $kanjiNeg . "ますまい"],
                        "Kana" => ["Neutre" => $kana . $kanjiNeg . "よう", "Négatif neutre" => $kana . $kanjiNeg . "まい", "Poli" => $kana . $kanjiNeg . "ましょう", "Négatif polie" => $kana . $kanjiNeg . "ますまい"],
                        "Romaji" => ["Neutre" => $romaji . $romajiNeg . "you", "Négatif neutre" => $romaji . $romajiNeg . "mai", "Poli" => $romaji . $romajiNeg . "mashou", "Négatif polie" => $romaji . $romajiNeg . "masumai"]
                    ], // Volontaire

                    "Présent progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "ている", "Négatif neutre" => $kanji . $kanjiNeg . "ていない", "Affirmatif polie" => $kanji . $kanjiNeg . "ています", "Négatif polie" => $kanji . $kanjiNeg . "ていません"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "ている", "Négatif neutre" => $kana . $kanjiNeg . "ていない", "Affirmatif polie" => $kana . $kanjiNeg . "ています", "Négatif polie" => $kana . $kanjiNeg . "ていません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "te iru", "Négatif neutre" => $romaji . $romajiNeg . "te inai", "Affirmatif polie" => $romaji . $romajiNeg . "te imasu", "Négatif polie" => $romaji . $romajiNeg . "te imasen"]
                    ], // Présent progressif

                    "Passé progressif" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "ていた", "Négatif neutre" => $kanji . $kanjiNeg . "ていなかった", "Affirmatif polie" => $kanji . $kanjiNeg . "ていました", "Négatif polie" => $kanji . $kanjiNeg . "ていませんでした"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "ていた", "Négatif neutre" => $kana . $kanjiNeg . "ていなかった", "Affirmatif polie" => $kana . $kanjiNeg . "ていました", "Négatif polie" => $kana . $kanjiNeg . "ていませんでした"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "te ita", "Négatif neutre" => $romaji . $romajiNeg . "te inakatta", "Affirmatif polie" => $romaji . $romajiNeg . "te imashita", "Négatif polie" => $romaji . $romajiNeg . "te imasen deshita"]
                    ], // Passé progressif

                    "Conditionnel" => [
                        "Kanji" => ["-Eba" => $kanji . $kanji . "れば", "-Tara" => $kanji . $kanjiNeg . "たら"],
                        "Kana" => ["-Eba" => $kana . $kanji . "れば", "-Tara" => $kana . $kanjiNeg . "たら"],
                        "Romaji" => ["-Eba" => $romaji . $romajiSu . "reba", "-Tara" => $romaji . $romajiNeg . "tara"]
                    ], // Conditionnel

                    "Potentiel" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "られる", "Négatif neutre" => $kanji . $kanjiNeg . "られない", "Affirmatif polie" => $kanji . $kanjiNeg . "られます", "Négatif polie" => $kanji . $kanjiNeg . "られません"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "られる", "Négatif neutre" => $kana . $kanjiNeg . "られない", "Affirmatif polie" => $kana . $kanjiNeg . "られます", "Négatif polie" => $kana . $kanjiNeg . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "rareru", "Négatif neutre" => $romaji . $romajiNeg . "rarenai", "Affirmatif polie" => $romaji . $romajiNeg . "raremasu", "Négatif polie" => $romaji . $romajiNeg . "raremasen"]
                    ], // Potentiel

                    "Causatif (Factitif)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させる", "Négatif neutre" => $kanji . "させない", "Affirmatif polie" => $kanji . "させます", "Négatif polie" => $kanji . "させません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "させる", "Négatif neutre" => $kana . "させない", "Affirmatif polie" => $kana . "させます", "Négatif polie" => $kana . "させません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiSase . "ru", "Négatif neutre" => $romaji . $romajiSase . "nai", "Affirmatif polie" => $romaji . $romajiSase . "masu", "Négatif polie" => $romaji . $romajiSase . "masen"]
                    ], // Causatif

                    "Passif (Subir)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "られる", "Négatif neutre" => $kana . "られない", "Affirmatif polie" => $kana . "られます", "Négatif polie" => $kana . "られません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiRare . "ru", "Négatif neutre" => $romaji . $romajiRare . "nai", "Affirmatif polie" => $romaji . $romajiRare . "masu", "Négatif polie" => $romaji . $romajiRare . "masen"]
                    ], // Causatif passif

                    "Causatif passif (Contrainte)" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . "させられる", "Négatif neutre" => $kanji . "させられない", "Affirmatif polie" => $kanji . "させられます", "Négatif polie" => $kanji . "させられません"],
                        "Kana" => ["Affirmatif neutre" => $kana . "させられる", "Négatif neutre" => $kana . "させられない", "Affirmatif polie" => $kana . "させられます", "Négatif polie" => $kana . "させられません"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiSase . strtolower($romajiRare) . "ru", "Négatif neutre" => $romaji . $romajiSase . strtolower($romajiRare) . "nai", "Affirmatif polie" => $romaji . $romajiSase . strtolower($romajiRare) . "masu", "Négatif polie" => $romaji . $romajiSase . strtolower($romajiRare) . "masen"]
                    ], // Causatif passif

                    "Vouloir présent" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "たい", "Négatif neutre" => $kanji . $kanjiNeg . "たくない", "Affirmatif polie" => $kanji . $kanjiNeg . "たいです", "Négatif polie" => $kanji . $kanjiNeg . "たくないです"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "たい", "Négatif neutre" => $kana . $kanjiNeg . "たくない", "Affirmatif polie" => $kana . $kanjiNeg . "たいです", "Négatif polie" => $kana . $kanjiNeg . "たくないです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "tai", "Négatif neutre" => $romaji . $romajiNeg . "takunai", "Affirmatif polie" => $romaji . $romajiNeg . "tai desu", "Négatif polie" => $romaji . $romajiNeg . "takunai desu"]
                    ], // Vouloir présent

                    "Vouloir passé" => [
                        "Kanji" => ["Affirmatif neutre" => $kanji . $kanjiNeg . "たかった", "Négatif neutre" => $kanji . $kanjiNeg . "たくなった", "Affirmatif polie" => $kanji . $kanjiNeg . "たかったです", "Négatif polie" => $kanji . $kanjiNeg . "たくなったです"],
                        "Kana" => ["Affirmatif neutre" => $kana . $kanjiNeg . "たかった", "Négatif neutre" => $kana . $kanjiNeg . "たくなった", "Affirmatif polie" => $kana . $kanjiNeg . "たかったです", "Négatif polie" => $kana . $kanjiNeg . "たくなったです"],
                        "Romaji" => ["Affirmatif neutre" => $romaji . $romajiNeg . "takatta", "Négatif neutre" => $romaji . $romajiNeg . "takunakatta", "Affirmatif polie" => $romaji . $romajiNeg . "takatta desu", "Négatif polie" => $romaji . $romajiNeg . "takunakatta desu"]
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

                    "Volitive" => [
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

                    "Volitive" => [
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

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "る", "Négatif neutre" => $kanji . "らない", "Affirmatif polie" => $kanji . "ります", "Négatif polie" => $kanji . "りません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "る", "Négatif neutre" => $kana . "らない", "Affirmatif polie" => $kana . "ります", "Négatif polie" => $kana . "りません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "ru", "Négatif neutre" => $romaji . "ranai", "Affirmatif polie" => $romaji . "rimasu", "Négatif polie" => $romaji . "rimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "らなかった", "Affirmatif polie" => $kanji . "りました", "Négatif polie" => $kanji . "りませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "らなかった", "Affirmatif polie" => $kana . "りました", "Négatif polie" => $kana . "りませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "ranakatta", "Affirmatif polie" => $romaji . "rimashita", "Négatif polie" => $romaji . "rimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "りなさい", "Affirmatif polie" => $kanji . "ってください", "Négatif polie" => $kanji . "らないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "りなさい", "Affirmatif polie" => $kana . "ってください", "Négatif polie" => $kana . "らないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "rinasai", "Affirmatif polie" => $romaji . "tte kudasai", "Négatif polie" => $romaji . "ranai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "よう", "Négatif neutre" => $kanji . "るまい", "Poli" => $kanji . "りましょう", "Négatif polie" => $kanji . "りますまい"],
                            "Kana" => ["Neutre" => $kana . "よう", "Négatif neutre" => $kana . "るまい", "Poli" => $kana . "りましょう", "Négatif polie" => $kana . "りますまい"],
                            "Romaji" => ["Neutre" => $romaji . "you", "Négatif neutre" => $romaji . "rumai", "Poli" => $romaji . "rimashou", "Négatif polie" => $romaji . "rimasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte iru", "Négatif neutre" => $romaji . "tte inai", "Affirmatif polie" => $romaji . "tte imasu", "Négatif polie" => $romaji . "tte imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っていた", "Négatif neutre" => $kanji . "っていなかった", "Affirmatif polie" => $kanji . "っていました", "Négatif polie" => $kanji . "っていませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っていた", "Négatif neutre" => $kana . "っていなかった", "Affirmatif polie" => $kana . "っていました", "Négatif polie" => $kana . "っていませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte ita", "Négatif neutre" => $romaji . "tte inakatta", "Affirmatif polie" => $romaji . "tte imashita", "Négatif polie" => $romaji . "tte imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "れば", "-Tara" => $kanji . "ったら"],
                            "Kana" => ["-Eba" => $kana . "れば", "-Tara" => $kana . "ったら"],
                            "Romaji" => ["-Eba" => $romaji . "reba", "-Tara" => $romaji . "ttara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "れる", "Négatif neutre" => $kanji . "れない", "Affirmatif polie" => $kanji . "れます", "Négatif polie" => $kanji . "れません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "れる", "Négatif neutre" => $kana . "れない", "Affirmatif polie" => $kana . "れます", "Négatif polie" => $kana . "れません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "reru", "Négatif neutre" => $romaji . "renai", "Affirmatif polie" => $romaji . "remasu", "Négatif polie" => $romaji . "remasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "らせる", "Négatif neutre" => $kanji . "らせない", "Affirmatif polie" => $kanji . "らせます", "Négatif polie" => $kanji . "らせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "らせる", "Négatif neutre" => $kana . "らせない", "Affirmatif polie" => $kana . "らせます", "Négatif polie" => $kana . "らせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "raseru", "Négatif neutre" => $romaji . "rasenai", "Affirmatif polie" => $romaji . "rasemasu", "Négatif polie" => $romaji . "rasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "られる", "Négatif neutre" => $kanji . "られない", "Affirmatif polie" => $kanji . "られます", "Négatif polie" => $kanji . "られません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "られる", "Négatif neutre" => $kana . "られない", "Affirmatif polie" => $kana . "られます", "Négatif polie" => $kana . "られません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "rareru", "Négatif neutre" => $romaji . "rarenai", "Affirmatif polie" => $romaji . "raremasu", "Négatif polie" => $romaji . "raremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "らせられる", "Négatif neutre" => $kanji . "らせられない", "Affirmatif polie" => $kanji . "らせられます", "Négatif polie" => $kanji . "らせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "らせられる", "Négatif neutre" => $kana . "らせられない", "Affirmatif polie" => $kana . "らせられます", "Négatif polie" => $kana . "らせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "raserareru", "Négatif neutre" => $romaji . "raserarenai", "Affirmatif polie" => $romaji . "raseraremasu", "Négatif polie" => $romaji . "raseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "りたい", "Négatif neutre" => $kanji . "りたくない", "Affirmatif polie" => $kanji . "りたいです", "Négatif polie" => $kanji . "りたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "りたい", "Négatif neutre" => $kana . "りたくない", "Affirmatif polie" => $kana . "りたいです", "Négatif polie" => $kana . "りたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "ritai", "Négatif neutre" => $romaji . "ritakunai", "Affirmatif polie" => $romaji . "ritai desu", "Négatif polie" => $romaji . "ritakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "りたかった", "Négatif neutre" => $kanji . "りたくなった", "Affirmatif polie" => $kanji . "りたかったです", "Négatif polie" => $kanji . "りたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "りたかった", "Négatif neutre" => $kana . "りたくなった", "Affirmatif polie" => $kana . "りたかったです", "Négatif polie" => $kana . "りたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "ritakatta", "Négatif neutre" => $romaji . "ritakunakatta", "Affirmatif polie" => $romaji . "ritakatta desu", "Négatif polie" => $romaji . "ritakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } elseif ($end2 == 'ku') {

                    if ($base['romaji'] == 'Iku') {
                        $add = ["Verbe - Groupe 1 (Godan)" => [
                            "Non présent" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "く", "Négatif neutre" => $kanji . "かない", "Affirmatif polie" => $kanji . "きます", "Négatif polie" => $kanji . "きません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "く", "Négatif neutre" => $kana . "かない", "Affirmatif polie" => $kana . "きます", "Négatif polie" => $kana . "きません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "ku", "Négatif neutre" => $romaji . "kanai", "Affirmatif polie" => $romaji . "kimasu", "Négatif polie" => $romaji . "kimasen"]
                            ], // Non présent

                            "Passé" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "かなかった", "Affirmatif polie" => $kanji . "きました", "Négatif polie" => $kanji . "きませんでした"],
                                "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "かなかった", "Affirmatif polie" => $kana . "きました", "Négatif polie" => $kana . "きませんでした"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "kanakatta", "Affirmatif polie" => $romaji . "kimashita", "Négatif polie" => $romaji . "kimasen deshita"]
                            ], // Passé

                            "Impératif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きなさい", "Affirmatif polie" => $kanji . "ってください", "Négatif polie" => $kanji . "かないでください"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きなさい", "Affirmatif polie" => $kana . "ってください", "Négatif polie" => $kana . "かないでください"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kinasai", "Affirmatif polie" => $romaji . "tte kudasai", "Négatif polie" => $romaji . "kanai de kudasai"]
                            ], // Impératif

                            "Volitive" => [
                                "Kanji" => ["Neutre" => $kanji . "こう", "Négatif neutre" => $kanji . "くまい", "Poli" => $kanji . "きましょう", "Négatif polie" => $kanji . "きますまい"],
                                "Kana" => ["Neutre" => $kana . "こう", "Négatif neutre" => $kana . "くまい", "Poli" => $kana . "きましょう", "Négatif polie" => $kana . "きますまい"],
                                "Romaji" => ["Neutre" => $romaji . "kou", "Négatif neutre" => $romaji . "kumai", "Poli" => $romaji . "kimashou", "Négatif polie" => $romaji . "kimasumai"]
                            ], // Volontaire

                            "Présent progressif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "tte iru", "Négatif neutre" => $romaji . "tte inai", "Affirmatif polie" => $romaji . "tte imasu", "Négatif polie" => $romaji . "tte imasen"]
                            ], // Présent progressif

                            "Passé progressif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "っていた", "Négatif neutre" => $kanji . "っていなかった", "Affirmatif polie" => $kanji . "っていました", "Négatif polie" => $kanji . "っていませんでした"],
                                "Kana" => ["Affirmatif neutre" => $kana . "っていた", "Négatif neutre" => $kana . "っていなかった", "Affirmatif polie" => $kana . "っていました", "Négatif polie" => $kana . "っていませんでした"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "tte ita", "Négatif neutre" => $romaji . "tte inakatta", "Affirmatif polie" => $romaji . "tte imashita", "Négatif polie" => $romaji . "tte imasen deshita"]
                            ], // Passé progressif

                            "Conditionnel" => [
                                "Kanji" => ["-Eba" => $kanji . "けば", "-Tara" => $kanji . "ったら"],
                                "Kana" => ["-Eba" => $kana . "けば", "-Tara" => $kana . "ったら"],
                                "Romaji" => ["-Eba" => $romaji . "keba", "-Tara" => $romaji . "ttara"]
                            ], // Conditionnel

                            "Potentiel" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "ける", "Négatif neutre" => $kanji . "けない", "Affirmatif polie" => $kanji . "けます", "Négatif polie" => $kanji . "けません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "ける", "Négatif neutre" => $kana . "けない", "Affirmatif polie" => $kana . "けます", "Négatif polie" => $kana . "けません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "keru", "Négatif neutre" => $romaji . "kenai", "Affirmatif polie" => $romaji . "kemasu", "Négatif polie" => $romaji . "kemasen"]
                            ], // Potentiel

                            "Causatif (Factitif)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かせる", "Négatif neutre" => $kanji . "かせない", "Affirmatif polie" => $kanji . "かせます", "Négatif polie" => $kanji . "かせません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かせる", "Négatif neutre" => $kana . "かせない", "Affirmatif polie" => $kana . "かせます", "Négatif polie" => $kana . "かせません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kaseru", "Négatif neutre" => $romaji . "kasenai", "Affirmatif polie" => $romaji . "kasemasu", "Négatif polie" => $romaji . "kasemasen"]
                            ], // Causatif

                            "Passif (Subir)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かれる", "Négatif neutre" => $kanji . "かれない", "Affirmatif polie" => $kanji . "かれます", "Négatif polie" => $kanji . "かれません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かれる", "Négatif neutre" => $kana . "かれない", "Affirmatif polie" => $kana . "かれます", "Négatif polie" => $kana . "かれません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kareru", "Négatif neutre" => $romaji . "karenai", "Affirmatif polie" => $romaji . "karemasu", "Négatif polie" => $romaji . "karemasen"]
                            ], // Causatif passif

                            "Causatif passif (Contrainte)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かせられる", "Négatif neutre" => $kanji . "かせられない", "Affirmatif polie" => $kanji . "かせられます", "Négatif polie" => $kanji . "かせられません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かせられる", "Négatif neutre" => $kana . "かせられない", "Affirmatif polie" => $kana . "かせられます", "Négatif polie" => $kana . "かせられません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kaserareru", "Négatif neutre" => $romaji . "kaserarenai", "Affirmatif polie" => $romaji . "kaseraremasu", "Négatif polie" => $romaji . "kaseraremasen"]
                            ], // Causatif passif

                            "Vouloir présent" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きたい", "Négatif neutre" => $kanji . "きたくない", "Affirmatif polie" => $kanji . "きたいです", "Négatif polie" => $kanji . "きたくないです"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きたい", "Négatif neutre" => $kana . "きたくない", "Affirmatif polie" => $kana . "きたいです", "Négatif polie" => $kana . "きたくないです"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kitai", "Négatif neutre" => $romaji . "kitakunai", "Affirmatif polie" => $romaji . "kitai desu", "Négatif polie" => $romaji . "kitakunai desu"]
                            ], // Vouloir présent

                            "Vouloir passé" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きたかった", "Négatif neutre" => $kanji . "きたくなった", "Affirmatif polie" => $kanji . "きたかったです", "Négatif polie" => $kanji . "きたくなったです"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きたかった", "Négatif neutre" => $kana . "きたくなった", "Affirmatif polie" => $kana . "きたかったです", "Négatif polie" => $kana . "きたくなったです"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kitakatta", "Négatif neutre" => $romaji . "kitakunakatta", "Affirmatif polie" => $romaji . "kitakatta desu", "Négatif polie" => $romaji . "kitakunakatta desu"]
                            ] // Vouloir passé
                        ]];
                    } else {
                        $add = ["Verbe - Groupe 1 (Godan)" => [
                            "Non présent" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "く", "Négatif neutre" => $kanji . "かない", "Affirmatif polie" => $kanji . "きます", "Négatif polie" => $kanji . "きません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "く", "Négatif neutre" => $kana . "かない", "Affirmatif polie" => $kana . "きます", "Négatif polie" => $kana . "きません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "ku", "Négatif neutre" => $romaji . "kanai", "Affirmatif polie" => $romaji . "kimasu", "Négatif polie" => $romaji . "kimasen"]
                            ], // Non présent

                            "Passé" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "かなかった", "Affirmatif polie" => $kanji . "きました", "Négatif polie" => $kanji . "きませんでした"],
                                "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "かなかった", "Affirmatif polie" => $kana . "きました", "Négatif polie" => $kana . "きませんでした"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "kanakatta", "Affirmatif polie" => $romaji . "kimashita", "Négatif polie" => $romaji . "kimasen deshita"]
                            ], // Passé

                            "Impératif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きなさい", "Affirmatif polie" => $kanji . "いてください", "Négatif polie" => $kanji . "かないでください"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きなさい", "Affirmatif polie" => $kana . "いてください", "Négatif polie" => $kana . "かないでください"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kinasai", "Affirmatif polie" => $romaji . "ite kudasai", "Négatif polie" => $romaji . "kanai de kudasai"]
                            ], // Impératif

                            "Volitive" => [
                                "Kanji" => ["Neutre" => $kanji . "こう", "Négatif neutre" => $kanji . "くまい", "Poli" => $kanji . "きましょう", "Négatif polie" => $kanji . "きますまい"],
                                "Kana" => ["Neutre" => $kana . "こう", "Négatif neutre" => $kana . "くまい", "Poli" => $kana . "きましょう", "Négatif polie" => $kana . "きますまい"],
                                "Romaji" => ["Neutre" => $romaji . "kou", "Négatif neutre" => $romaji . "kumai", "Poli" => $romaji . "kimashou", "Négatif polie" => $romaji . "kimasumai"]
                            ], // Volontaire

                            "Présent progressif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "ite iru", "Négatif neutre" => $romaji . "ite inai", "Affirmatif polie" => $romaji . "ite imasu", "Négatif polie" => $romaji . "ite imasen"]
                            ], // Présent progressif

                            "Passé progressif" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "いていた", "Négatif neutre" => $kanji . "いていなかった", "Affirmatif polie" => $kanji . "いていました", "Négatif polie" => $kanji . "いていませんでした"],
                                "Kana" => ["Affirmatif neutre" => $kana . "いていた", "Négatif neutre" => $kana . "いていなかった", "Affirmatif polie" => $kana . "いていました", "Négatif polie" => $kana . "いていませんでした"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "ite ita", "Négatif neutre" => $romaji . "ite inakatta", "Affirmatif polie" => $romaji . "ite imashita", "Négatif polie" => $romaji . "ite imasen deshita"]
                            ], // Passé progressif

                            "Conditionnel" => [
                                "Kanji" => ["-Eba" => $kanji . "けば", "-Tara" => $kanji . "いたら"],
                                "Kana" => ["-Eba" => $kana . "けば", "-Tara" => $kana . "いたら"],
                                "Romaji" => ["-Eba" => $romaji . "keba", "-Tara" => $romaji . "itara"]
                            ], // Conditionnel

                            "Potentiel" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "ける", "Négatif neutre" => $kanji . "けない", "Affirmatif polie" => $kanji . "けます", "Négatif polie" => $kanji . "けません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "ける", "Négatif neutre" => $kana . "けない", "Affirmatif polie" => $kana . "けます", "Négatif polie" => $kana . "けません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "keru", "Négatif neutre" => $romaji . "kenai", "Affirmatif polie" => $romaji . "kemasu", "Négatif polie" => $romaji . "kemasen"]
                            ], // Potentiel

                            "Causatif (Factitif)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かせる", "Négatif neutre" => $kanji . "かせない", "Affirmatif polie" => $kanji . "かせます", "Négatif polie" => $kanji . "かせません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かせる", "Négatif neutre" => $kana . "かせない", "Affirmatif polie" => $kana . "かせます", "Négatif polie" => $kana . "かせません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kaseru", "Négatif neutre" => $romaji . "kasenai", "Affirmatif polie" => $romaji . "kasemasu", "Négatif polie" => $romaji . "kasemasen"]
                            ], // Causatif

                            "Passif (Subir)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かれる", "Négatif neutre" => $kanji . "かれない", "Affirmatif polie" => $kanji . "かれます", "Négatif polie" => $kanji . "かれません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かれる", "Négatif neutre" => $kana . "かれない", "Affirmatif polie" => $kana . "かれます", "Négatif polie" => $kana . "かれません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kareru", "Négatif neutre" => $romaji . "karenai", "Affirmatif polie" => $romaji . "karemasu", "Négatif polie" => $romaji . "karemasen"]
                            ], // Causatif passif

                            "Causatif passif (Contrainte)" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "かせられる", "Négatif neutre" => $kanji . "かせられない", "Affirmatif polie" => $kanji . "かせられます", "Négatif polie" => $kanji . "かせられません"],
                                "Kana" => ["Affirmatif neutre" => $kana . "かせられる", "Négatif neutre" => $kana . "かせられない", "Affirmatif polie" => $kana . "かせられます", "Négatif polie" => $kana . "かせられません"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kaserareru", "Négatif neutre" => $romaji . "kaserarenai", "Affirmatif polie" => $romaji . "kaseraremasu", "Négatif polie" => $romaji . "kaseraremasen"]
                            ], // Causatif passif

                            "Vouloir présent" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きたい", "Négatif neutre" => $kanji . "きたくない", "Affirmatif polie" => $kanji . "きたいです", "Négatif polie" => $kanji . "きたくないです"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きたい", "Négatif neutre" => $kana . "きたくない", "Affirmatif polie" => $kana . "きたいです", "Négatif polie" => $kana . "きたくないです"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kitai", "Négatif neutre" => $romaji . "kitakunai", "Affirmatif polie" => $romaji . "kitai desu", "Négatif polie" => $romaji . "kitakunai desu"]
                            ], // Vouloir présent

                            "Vouloir passé" => [
                                "Kanji" => ["Affirmatif neutre" => $kanji . "きたかった", "Négatif neutre" => $kanji . "きたくなった", "Affirmatif polie" => $kanji . "きたかったです", "Négatif polie" => $kanji . "きたくなったです"],
                                "Kana" => ["Affirmatif neutre" => $kana . "きたかった", "Négatif neutre" => $kana . "きたくなった", "Affirmatif polie" => $kana . "きたかったです", "Négatif polie" => $kana . "きたくなったです"],
                                "Romaji" => ["Affirmatif neutre" => $romaji . "kitakatta", "Négatif neutre" => $romaji . "kitakunakatta", "Affirmatif polie" => $romaji . "kitakatta desu", "Négatif polie" => $romaji . "kitakunakatta desu"]
                            ] // Vouloir passé
                        ]];
                    }

                } elseif ($end2 == 'gu') {

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぐ", "Négatif neutre" => $kanji . "がない", "Affirmatif polie" => $kanji . "ぎます", "Négatif polie" => $kanji . "ぎません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぐ", "Négatif neutre" => $kana . "がない", "Affirmatif polie" => $kana . "ぎます", "Négatif polie" => $kana . "ぎません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gu", "Négatif neutre" => $romaji . "ganai", "Affirmatif polie" => $romaji . "gimasu", "Négatif polie" => $romaji . "gimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "がなかった", "Affirmatif polie" => $kanji . "ぎました", "Négatif polie" => $kanji . "ぎませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "がなかった", "Affirmatif polie" => $kana . "ぎました", "Négatif polie" => $kana . "ぎませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "ganakatta", "Affirmatif polie" => $romaji . "gimashita", "Négatif polie" => $romaji . "gimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぎなさい", "Affirmatif polie" => $kanji . "ってください", "Négatif polie" => $kanji . "がないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぎなさい", "Affirmatif polie" => $kana . "ってください", "Négatif polie" => $kana . "がないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "ginasai", "Affirmatif polie" => $romaji . "tte kudasai", "Négatif polie" => $romaji . "ganai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "ごう", "Négatif neutre" => $kanji . "ぐまい", "Poli" => $kanji . "ぎましょう", "Négatif polie" => $kanji . "ぎますまい"],
                            "Kana" => ["Neutre" => $kana . "ごう", "Négatif neutre" => $kana . "ぐまい", "Poli" => $kana . "ぎましょう", "Négatif polie" => $kana . "ぎますまい"],
                            "Romaji" => ["Neutre" => $romaji . "gou", "Négatif neutre" => $romaji . "gumai", "Poli" => $romaji . "gimashou", "Négatif polie" => $romaji . "gimasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte iru", "Négatif neutre" => $romaji . "tte inai", "Affirmatif polie" => $romaji . "tte imasu", "Négatif polie" => $romaji . "tte imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っていた", "Négatif neutre" => $kanji . "っていなかった", "Affirmatif polie" => $kanji . "っていました", "Négatif polie" => $kanji . "っていませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っていた", "Négatif neutre" => $kana . "っていなかった", "Affirmatif polie" => $kana . "っていました", "Négatif polie" => $kana . "っていませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte ita", "Négatif neutre" => $romaji . "tte inakatta", "Affirmatif polie" => $romaji . "tte imashita", "Négatif polie" => $romaji . "tte imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "げば", "-Tara" => $kanji . "ったら"],
                            "Kana" => ["-Eba" => $kana . "げば", "-Tara" => $kana . "ったら"],
                            "Romaji" => ["-Eba" => $romaji . "geba", "-Tara" => $romaji . "ttara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "げる", "Négatif neutre" => $kanji . "げない", "Affirmatif polie" => $kanji . "げます", "Négatif polie" => $kanji . "げません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "げる", "Négatif neutre" => $kana . "げない", "Affirmatif polie" => $kana . "げます", "Négatif polie" => $kana . "げません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "geru", "Négatif neutre" => $romaji . "genai", "Affirmatif polie" => $romaji . "gemasu", "Négatif polie" => $romaji . "gemasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "がせる", "Négatif neutre" => $kanji . "がせない", "Affirmatif polie" => $kanji . "がせます", "Négatif polie" => $kanji . "がせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "がせる", "Négatif neutre" => $kana . "がせない", "Affirmatif polie" => $kana . "がせます", "Négatif polie" => $kana . "がせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gaseru", "Négatif neutre" => $romaji . "gasenai", "Affirmatif polie" => $romaji . "gasemasu", "Négatif polie" => $romaji . "gasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "がれる", "Négatif neutre" => $kanji . "がれない", "Affirmatif polie" => $kanji . "がれます", "Négatif polie" => $kanji . "がれません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "がれる", "Négatif neutre" => $kana . "がれない", "Affirmatif polie" => $kana . "がれます", "Négatif polie" => $kana . "がれません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gareru", "Négatif neutre" => $romaji . "garenai", "Affirmatif polie" => $romaji . "garemasu", "Négatif polie" => $romaji . "garemasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "がせられる", "Négatif neutre" => $kanji . "がせられない", "Affirmatif polie" => $kanji . "がせられます", "Négatif polie" => $kanji . "がせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "がせられる", "Négatif neutre" => $kana . "がせられない", "Affirmatif polie" => $kana . "がせられます", "Négatif polie" => $kana . "がせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gaserareru", "Négatif neutre" => $romaji . "gaserarenai", "Affirmatif polie" => $romaji . "gaseraremasu", "Négatif polie" => $romaji . "gaseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぎたい", "Négatif neutre" => $kanji . "ぎたくない", "Affirmatif polie" => $kanji . "ぎたいです", "Négatif polie" => $kanji . "ぎたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぎたい", "Négatif neutre" => $kana . "ぎたくない", "Affirmatif polie" => $kana . "ぎたいです", "Négatif polie" => $kana . "ぎたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gitai", "Négatif neutre" => $romaji . "gitakunai", "Affirmatif polie" => $romaji . "gitai desu", "Négatif polie" => $romaji . "gitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぎたかった", "Négatif neutre" => $kanji . "ぎたくなった", "Affirmatif polie" => $kanji . "ぎたかったです", "Négatif polie" => $kanji . "ぎたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぎたかった", "Négatif neutre" => $kana . "ぎたくなった", "Affirmatif polie" => $kana . "ぎたかったです", "Négatif polie" => $kana . "ぎたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "gitakatta", "Négatif neutre" => $romaji . "gitakunakatta", "Affirmatif polie" => $romaji . "gitakatta desu", "Négatif polie" => $romaji . "gitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } elseif ($end3 == 'tsu') {

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "つ", "Négatif neutre" => $kanji . "たない", "Affirmatif polie" => $kanji . "ちます", "Négatif polie" => $kanji . "ちません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "つ", "Négatif neutre" => $kana . "たない", "Affirmatif polie" => $kana . "ちます", "Négatif polie" => $kana . "ちません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tsu", "Négatif neutre" => $romaji . "tanai", "Affirmatif polie" => $romaji . "chimasu", "Négatif polie" => $romaji . "chimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "たなかった", "Affirmatif polie" => $kanji . "ちました", "Négatif polie" => $kanji . "ちませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "たなかった", "Affirmatif polie" => $kana . "ちました", "Négatif polie" => $kana . "ちませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "tanakatta", "Affirmatif polie" => $romaji . "chimashita", "Négatif polie" => $romaji . "chimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ちなさい", "Affirmatif polie" => $kanji . "ってください", "Négatif polie" => $kanji . "たないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ちなさい", "Affirmatif polie" => $kana . "ってください", "Négatif polie" => $kana . "たないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "chinasai", "Affirmatif polie" => $romaji . "tte kudasai", "Négatif polie" => $romaji . "tanai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "とう", "Négatif neutre" => $kanji . "つまい", "Poli" => $kanji . "ちましょう", "Négatif polie" => $kanji . "ちますまい"],
                            "Kana" => ["Neutre" => $kana . "とう", "Négatif neutre" => $kana . "つまい", "Poli" => $kana . "ちましょう", "Négatif polie" => $kana . "ちますまい"],
                            "Romaji" => ["Neutre" => $romaji . "tou", "Négatif neutre" => $romaji . "tsumai", "Poli" => $romaji . "chimashou", "Négatif polie" => $romaji . "chimasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte iru", "Négatif neutre" => $romaji . "tte inai", "Affirmatif polie" => $romaji . "tte imasu", "Négatif polie" => $romaji . "tte imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っていた", "Négatif neutre" => $kanji . "っていなかった", "Affirmatif polie" => $kanji . "っていました", "Négatif polie" => $kanji . "っていませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っていた", "Négatif neutre" => $kana . "っていなかった", "Affirmatif polie" => $kana . "っていました", "Négatif polie" => $kana . "っていませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte ita", "Négatif neutre" => $romaji . "tte inakatta", "Affirmatif polie" => $romaji . "tte imashita", "Négatif polie" => $romaji . "tte imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "てば", "-Tara" => $kanji . "つなら"],
                            "Kana" => ["-Eba" => $kana . "てば", "-Tara" => $kana . "つなら"],
                            "Romaji" => ["-Eba" => $romaji . "teba", "-Tara" => $romaji . "tsu nara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "てる", "Négatif neutre" => $kanji . "てない", "Affirmatif polie" => $kanji . "てます", "Négatif polie" => $kanji . "てません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "てる", "Négatif neutre" => $kana . "てない", "Affirmatif polie" => $kana . "てます", "Négatif polie" => $kana . "てません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "teru", "Négatif neutre" => $romaji . "tenai", "Affirmatif polie" => $romaji . "temasu", "Négatif polie" => $romaji . "temasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "たせる", "Négatif neutre" => $kanji . "たせない", "Affirmatif polie" => $kanji . "たせます", "Négatif polie" => $kanji . "たせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "たせる", "Négatif neutre" => $kana . "たせない", "Affirmatif polie" => $kana . "たせます", "Négatif polie" => $kana . "たせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "taseru", "Négatif neutre" => $romaji . "tasenai", "Affirmatif polie" => $romaji . "tasemasu", "Négatif polie" => $romaji . "tasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "たれる", "Négatif neutre" => $kanji . "たれない", "Affirmatif polie" => $kanji . "たれます", "Négatif polie" => $kanji . "たれません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "たれる", "Négatif neutre" => $kana . "たれない", "Affirmatif polie" => $kana . "たれます", "Négatif polie" => $kana . "たれません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tareru", "Négatif neutre" => $romaji . "tarenai", "Affirmatif polie" => $romaji . "taremasu", "Négatif polie" => $romaji . "taremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "たせられる", "Négatif neutre" => $kanji . "たせられない", "Affirmatif polie" => $kanji . "たせられます", "Négatif polie" => $kanji . "たせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "たせられる", "Négatif neutre" => $kana . "たせられない", "Affirmatif polie" => $kana . "たせられます", "Négatif polie" => $kana . "たせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "taserareru", "Négatif neutre" => $romaji . "taserarenai", "Affirmatif polie" => $romaji . "taseraremasu", "Négatif polie" => $romaji . "taseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ちたい", "Négatif neutre" => $kanji . "ちたくない", "Affirmatif polie" => $kanji . "ちたいです", "Négatif polie" => $kanji . "ちたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ちたい", "Négatif neutre" => $kana . "ちたくない", "Affirmatif polie" => $kana . "ちたいです", "Négatif polie" => $kana . "ちたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "chitai", "Négatif neutre" => $romaji . "chitakunai", "Affirmatif polie" => $romaji . "chitai desu", "Négatif polie" => $romaji . "chitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ちたかった", "Négatif neutre" => $kanji . "ちたくなった", "Affirmatif polie" => $kanji . "ちたかったです", "Négatif polie" => $kanji . "ちたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ちたかった", "Négatif neutre" => $kana . "ちたくなった", "Affirmatif polie" => $kana . "ちたかったです", "Négatif polie" => $kana . "ちたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "chitakatta", "Négatif neutre" => $romaji . "chitakunakatta", "Affirmatif polie" => $romaji . "chitakatta desu", "Négatif polie" => $romaji . "chitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } elseif ($end2 == 'su') {

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "す", "Négatif neutre" => $kanji . "さない", "Affirmatif polie" => $kanji . "します", "Négatif polie" => $kanji . "しません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "す", "Négatif neutre" => $kana . "さない", "Affirmatif polie" => $kana . "します", "Négatif polie" => $kana . "しません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "su", "Négatif neutre" => $romaji . "sanai", "Affirmatif polie" => $romaji . "shimasu", "Négatif polie" => $romaji . "shimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "した", "Négatif neutre" => $kanji . "さなかった", "Affirmatif polie" => $kanji . "しました", "Négatif polie" => $kanji . "しませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "した", "Négatif neutre" => $kana . "さなかった", "Affirmatif polie" => $kana . "しました", "Négatif polie" => $kana . "しませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shita", "Négatif neutre" => $romaji . "sanakatta", "Affirmatif polie" => $romaji . "shimashita", "Négatif polie" => $romaji . "simasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "しなさい", "Affirmatif polie" => $kanji . "してください", "Négatif polie" => $kanji . "さないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "しなさい", "Affirmatif polie" => $kana . "してください", "Négatif polie" => $kana . "さないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shinasai", "Affirmatif polie" => $romaji . "shite kudasai", "Négatif polie" => $romaji . "sanai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "そう", "Négatif neutre" => $kanji . "すまい", "Poli" => $kanji . "しましょう", "Négatif polie" => $kanji . "しますまい"],
                            "Kana" => ["Neutre" => $kana . "そう", "Négatif neutre" => $kana . "すまい", "Poli" => $kana . "しましょう", "Négatif polie" => $kana . "しますまい"],
                            "Romaji" => ["Neutre" => $romaji . "sou", "Négatif neutre" => $romaji . "sumai", "Poli" => $romaji . "shimashou", "Négatif polie" => $romaji . "shimasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "している", "Négatif neutre" => $kanji . "していない", "Affirmatif polie" => $kanji . "しています", "Négatif polie" => $kanji . "していません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "している", "Négatif neutre" => $kana . "していない", "Affirmatif polie" => $kana . "しています", "Négatif polie" => $kana . "していません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shite iru", "Négatif neutre" => $romaji . "shite inai", "Affirmatif polie" => $romaji . "shite imasu", "Négatif polie" => $romaji . "shite imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "していた", "Négatif neutre" => $kanji . "していなかった", "Affirmatif polie" => $kanji . "していました", "Négatif polie" => $kanji . "していませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "していた", "Négatif neutre" => $kana . "していなかった", "Affirmatif polie" => $kana . "していました", "Négatif polie" => $kana . "していませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shite ita", "Négatif neutre" => $romaji . "shite inakatta", "Affirmatif polie" => $romaji . "shite imashita", "Négatif polie" => $romaji . "shite imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "せば", "-Tara" => $kanji . "したら"],
                            "Kana" => ["-Eba" => $kana . "せば", "-Tara" => $kana . "したら"],
                            "Romaji" => ["-Eba" => $romaji . "seba", "-Tara" => $romaji . "shitara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "せる", "Négatif neutre" => $kanji . "せない", "Affirmatif polie" => $kanji . "せます", "Négatif polie" => $kanji . "せません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "せる", "Négatif neutre" => $kana . "せない", "Affirmatif polie" => $kana . "せます", "Négatif polie" => $kana . "せません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "seru", "Négatif neutre" => $romaji . "senai", "Affirmatif polie" => $romaji . "semasu", "Négatif polie" => $romaji . "semasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "させる", "Négatif neutre" => $kanji . "させない", "Affirmatif polie" => $kanji . "させます", "Négatif polie" => $kanji . "させません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "させる", "Négatif neutre" => $kana . "させない", "Affirmatif polie" => $kana . "させます", "Négatif polie" => $kana . "させません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "saseru", "Négatif neutre" => $romaji . "sasenai", "Affirmatif polie" => $romaji . "sasemasu", "Négatif polie" => $romaji . "sasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "される", "Négatif neutre" => $kanji . "されない", "Affirmatif polie" => $kanji . "されます", "Négatif polie" => $kanji . "されません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "される", "Négatif neutre" => $kana . "されない", "Affirmatif polie" => $kana . "されます", "Négatif polie" => $kana . "されません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "sareru", "Négatif neutre" => $romaji . "sarenai", "Affirmatif polie" => $romaji . "saremasu", "Négatif polie" => $romaji . "saremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "させられる", "Négatif neutre" => $kanji . "させられない", "Affirmatif polie" => $kanji . "させられます", "Négatif polie" => $kanji . "させられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "させられる", "Négatif neutre" => $kana . "させられない", "Affirmatif polie" => $kana . "させられます", "Négatif polie" => $kana . "させられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "saserareru", "Négatif neutre" => $romaji . "saserarenai", "Affirmatif polie" => $romaji . "saseraremasu", "Négatif polie" => $romaji . "saseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "したい", "Négatif neutre" => $kanji . "したくない", "Affirmatif polie" => $kanji . "したいです", "Négatif polie" => $kanji . "したくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "したい", "Négatif neutre" => $kana . "したくない", "Affirmatif polie" => $kana . "したいです", "Négatif polie" => $kana . "したくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shitai", "Négatif neutre" => $romaji . "shitakunai", "Affirmatif polie" => $romaji . "shitai desu", "Négatif polie" => $romaji . "shitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "したかった", "Négatif neutre" => $kanji . "したくなった", "Affirmatif polie" => $kanji . "したかったです", "Négatif polie" => $kanji . "したくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "したかった", "Négatif neutre" => $kana . "したくなった", "Affirmatif polie" => $kana . "したかったです", "Négatif polie" => $kana . "したくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "shitakatta", "Négatif neutre" => $romaji . "shitakunakatta", "Affirmatif polie" => $romaji . "shitakatta desu", "Négatif polie" => $romaji . "shitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } elseif ($end2 == 'nu') {

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぬ", "Négatif neutre" => $kanji . "なない", "Affirmatif polie" => $kanji . "にます", "Négatif polie" => $kanji . "にません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぬ", "Négatif neutre" => $kana . "なない", "Affirmatif polie" => $kana . "にます", "Négatif polie" => $kana . "にません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nu", "Négatif neutre" => $romaji . "nanai", "Affirmatif polie" => $romaji . "nimasu", "Négatif polie" => $romaji . "nimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "んだ", "Négatif neutre" => $kanji . "ななかった", "Affirmatif polie" => $kanji . "にました", "Négatif polie" => $kanji . "にませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "んだ", "Négatif neutre" => $kana . "ななかった", "Affirmatif polie" => $kana . "にました", "Négatif polie" => $kana . "にませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nda", "Négatif neutre" => $romaji . "nanakatta", "Affirmatif polie" => $romaji . "nimashita", "Négatif polie" => $romaji . "nimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "になさい", "Affirmatif polie" => $kanji . "んでください", "Négatif polie" => $kanji . "なないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "になさい", "Affirmatif polie" => $kana . "んでください", "Négatif polie" => $kana . "なないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "ninasai", "Affirmatif polie" => $romaji . "nde kudasai", "Négatif polie" => $romaji . "nanai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "のう", "Négatif neutre" => $kanji . "ぬまい", "Poli" => $kanji . "にましょう", "Négatif polie" => $kanji . "にますまい"],
                            "Kana" => ["Neutre" => $kana . "のう", "Négatif neutre" => $kana . "ぬまい", "Poli" => $kana . "にましょう", "Négatif polie" => $kana . "にますまい"],
                            "Romaji" => ["Neutre" => $romaji . "nou", "Négatif neutre" => $romaji . "numai", "Poli" => $romaji . "nimashou", "Négatif polie" => $romaji . "nimasumai"]
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
                            "Kanji" => ["-Eba" => $kanji . "ねば", "-Tara" => $kanji . "んだら"],
                            "Kana" => ["-Eba" => $kana . "ねば", "-Tara" => $kana . "んだら"],
                            "Romaji" => ["-Eba" => $romaji . "neba", "-Tara" => $romaji . "ndara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ねる", "Négatif neutre" => $kanji . "ねない", "Affirmatif polie" => $kanji . "ねます", "Négatif polie" => $kanji . "ねません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ねる", "Négatif neutre" => $kana . "ねない", "Affirmatif polie" => $kana . "ねます", "Négatif polie" => $kana . "ねません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "neru", "Négatif neutre" => $romaji . "nenai", "Affirmatif polie" => $romaji . "nemasu", "Négatif polie" => $romaji . "nemasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "なせる", "Négatif neutre" => $kanji . "なせない", "Affirmatif polie" => $kanji . "なせます", "Négatif polie" => $kanji . "なせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "なせる", "Négatif neutre" => $kana . "なせない", "Affirmatif polie" => $kana . "なせます", "Négatif polie" => $kana . "なせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "naseru", "Négatif neutre" => $romaji . "nasenai", "Affirmatif polie" => $romaji . "nasemasu", "Négatif polie" => $romaji . "nasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "なれる", "Négatif neutre" => $kanji . "なれない", "Affirmatif polie" => $kanji . "なれます", "Négatif polie" => $kanji . "なれません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "なれる", "Négatif neutre" => $kana . "なれない", "Affirmatif polie" => $kana . "なれます", "Négatif polie" => $kana . "なれません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nareru", "Négatif neutre" => $romaji . "narenai", "Affirmatif polie" => $romaji . "naremasu", "Négatif polie" => $romaji . "naremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "なせられる", "Négatif neutre" => $kanji . "なせられない", "Affirmatif polie" => $kanji . "なせられます", "Négatif polie" => $kanji . "なせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "なせられる", "Négatif neutre" => $kana . "なせられない", "Affirmatif polie" => $kana . "なせられます", "Négatif polie" => $kana . "なせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "naserareru", "Négatif neutre" => $romaji . "naserarenai", "Affirmatif polie" => $romaji . "naseraremasu", "Négatif polie" => $romaji . "naseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "にたい", "Négatif neutre" => $kanji . "にたくない", "Affirmatif polie" => $kanji . "にたいです", "Négatif polie" => $kanji . "にたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "にたい", "Négatif neutre" => $kana . "にたくない", "Affirmatif polie" => $kana . "にたいです", "Négatif polie" => $kana . "にたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nitai", "Négatif neutre" => $romaji . "nitakunai", "Affirmatif polie" => $romaji . "nitai desu", "Négatif polie" => $romaji . "nitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "にたかった", "Négatif neutre" => $kanji . "にたくなった", "Affirmatif polie" => $kanji . "にたかったです", "Négatif polie" => $kanji . "にたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "にたかった", "Négatif neutre" => $kana . "にたくなった", "Affirmatif polie" => $kana . "にたかったです", "Négatif polie" => $kana . "にたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nitakatta", "Négatif neutre" => $romaji . "nitakunakatta", "Affirmatif polie" => $romaji . "nitakatta desu", "Négatif polie" => $romaji . "nitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

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

                        "Volitive" => [
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

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ぶ", "Négatif neutre" => $kanji . "ばない", "Affirmatif polie" => $kanji . "びます", "Négatif polie" => $kanji . "びません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ぶ", "Négatif neutre" => $kana . "ばない", "Affirmatif polie" => $kana . "びます", "Négatif polie" => $kana . "びません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "bu", "Négatif neutre" => $romaji . "banai", "Affirmatif polie" => $romaji . "bimasu", "Négatif polie" => $romaji . "bimasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "んだ", "Négatif neutre" => $kanji . "ばなかった", "Affirmatif polie" => $kanji . "びました", "Négatif polie" => $kanji . "びませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "んだ", "Négatif neutre" => $kana . "ばなかった", "Affirmatif polie" => $kana . "びました", "Négatif polie" => $kana . "びませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "nda", "Négatif neutre" => $romaji . "banakatta", "Affirmatif polie" => $romaji . "bimashita", "Négatif polie" => $romaji . "bimasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "びなさい", "Affirmatif polie" => $kanji . "んでください", "Négatif polie" => $kanji . "ばないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "びなさい", "Affirmatif polie" => $kana . "んでください", "Négatif polie" => $kana . "ばないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "binasai", "Affirmatif polie" => $romaji . "nde kudasai", "Négatif polie" => $romaji . "banai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "ぼう", "Négatif neutre" => $kanji . "ぶまい", "Poli" => $kanji . "びましょう", "Négatif polie" => $kanji . "びますまい"],
                            "Kana" => ["Neutre" => $kana . "ぼう", "Négatif neutre" => $kana . "ぶまい", "Poli" => $kana . "びましょう", "Négatif polie" => $kana . "びますまい"],
                            "Romaji" => ["Neutre" => $romaji . "bou", "Négatif neutre" => $romaji . "bumai", "Poli" => $romaji . "bimashou", "Négatif polie" => $romaji . "bimasumai"]
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
                            "Kanji" => ["-Eba" => $kanji . "べば", "-Tara" => $kanji . "んだら"],
                            "Kana" => ["-Eba" => $kana . "べば", "-Tara" => $kana . "んだら"],
                            "Romaji" => ["-Eba" => $romaji . "beba", "-Tara" => $romaji . "ndara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "べる", "Négatif neutre" => $kanji . "べない", "Affirmatif polie" => $kanji . "べます", "Négatif polie" => $kanji . "べません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "べる", "Négatif neutre" => $kana . "べない", "Affirmatif polie" => $kana . "べます", "Négatif polie" => $kana . "べません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "beru", "Négatif neutre" => $romaji . "benai", "Affirmatif polie" => $romaji . "bemasu", "Négatif polie" => $romaji . "bemasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ばせる", "Négatif neutre" => $kanji . "ばせない", "Affirmatif polie" => $kanji . "ばせます", "Négatif polie" => $kanji . "ばせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ばせる", "Négatif neutre" => $kana . "ばせない", "Affirmatif polie" => $kana . "ばせます", "Négatif polie" => $kana . "ばせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "baseru", "Négatif neutre" => $romaji . "basenai", "Affirmatif polie" => $romaji . "basemasu", "Négatif polie" => $romaji . "basemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ばれる", "Négatif neutre" => $kanji . "ばれない", "Affirmatif polie" => $kanji . "ばれます", "Négatif polie" => $kanji . "ばれません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ばれる", "Négatif neutre" => $kana . "ばれない", "Affirmatif polie" => $kana . "ばれます", "Négatif polie" => $kana . "ばれません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "bareru", "Négatif neutre" => $romaji . "barenai", "Affirmatif polie" => $romaji . "baremasu", "Négatif polie" => $romaji . "baremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "ばせられる", "Négatif neutre" => $kanji . "ばせられない", "Affirmatif polie" => $kanji . "ばせられます", "Négatif polie" => $kanji . "ばせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "ばせられる", "Négatif neutre" => $kana . "ばせられない", "Affirmatif polie" => $kana . "ばせられます", "Négatif polie" => $kana . "ばせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "baserareru", "Négatif neutre" => $romaji . "baserarenai", "Affirmatif polie" => $romaji . "baseraremasu", "Négatif polie" => $romaji . "baseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "びたい", "Négatif neutre" => $kanji . "びたくない", "Affirmatif polie" => $kanji . "びたいです", "Négatif polie" => $kanji . "びたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "びたい", "Négatif neutre" => $kana . "びたくない", "Affirmatif polie" => $kana . "びたいです", "Négatif polie" => $kana . "びたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "bitai", "Négatif neutre" => $romaji . "bitakunai", "Affirmatif polie" => $romaji . "bitai desu", "Négatif polie" => $romaji . "bitakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "びたかった", "Négatif neutre" => $kanji . "びたくなった", "Affirmatif polie" => $kanji . "びたかったです", "Négatif polie" => $kanji . "びたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "びたかった", "Négatif neutre" => $kana . "びたくなった", "Affirmatif polie" => $kana . "びたかったです", "Négatif polie" => $kana . "びたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "bitakatta", "Négatif neutre" => $romaji . "bitakunakatta", "Affirmatif polie" => $romaji . "bitakatta desu", "Négatif polie" => $romaji . "bitakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                } else { // End = 'u'

                    $romaji = substr($base['romaji'], 0, -1);

                    $add = ["Verbe - Groupe 1 (Godan)" => [
                        "Non présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "う", "Négatif neutre" => $kanji . "わない", "Affirmatif polie" => $kanji . "います", "Négatif polie" => $kanji . "いません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "う", "Négatif neutre" => $kana . "わない", "Affirmatif polie" => $kana . "います", "Négatif polie" => $kana . "いません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "u", "Négatif neutre" => $romaji . "wanai", "Affirmatif polie" => $romaji . "imasu", "Négatif polie" => $romaji . "imasen"]
                        ], // Non présent

                        "Passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "った", "Négatif neutre" => $kanji . "わなかった", "Affirmatif polie" => $kanji . "いました", "Négatif polie" => $kanji . "いませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "った", "Négatif neutre" => $kana . "わなかった", "Affirmatif polie" => $kana . "いました", "Négatif polie" => $kana . "いませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tta", "Négatif neutre" => $romaji . "wanakatta", "Affirmatif polie" => $romaji . "imashita", "Négatif polie" => $romaji . "imasen deshita"]
                        ], // Passé

                        "Impératif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "いなさい", "Affirmatif polie" => $kanji . "ってください", "Négatif polie" => $kanji . "わないでください"],
                            "Kana" => ["Affirmatif neutre" => $kana . "いなさい", "Affirmatif polie" => $kana . "ってください", "Négatif polie" => $kana . "わないでください"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "inasai", "Affirmatif polie" => $romaji . "tte kudasai", "Négatif polie" => $romaji . "wanai de kudasai"]
                        ], // Impératif

                        "Volitive" => [
                            "Kanji" => ["Neutre" => $kanji . "おう", "Négatif neutre" => $kanji . "うまい", "Poli" => $kanji . "いましょう", "Négatif polie" => $kanji . "いますまい"],
                            "Kana" => ["Neutre" => $kana . "おう", "Négatif neutre" => $kana . "うまい", "Poli" => $kana . "いましょう", "Négatif polie" => $kana . "いますまい"],
                            "Romaji" => ["Neutre" => $romaji . "ou", "Négatif neutre" => $romaji . "umai", "Poli" => $romaji . "imashou", "Négatif polie" => $romaji . "imasumai"]
                        ], // Volontaire

                        "Présent progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っている", "Négatif neutre" => $kanji . "っていない", "Affirmatif polie" => $kanji . "っています", "Négatif polie" => $kanji . "っていません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っている", "Négatif neutre" => $kana . "っていない", "Affirmatif polie" => $kana . "っています", "Négatif polie" => $kana . "っていません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte iru", "Négatif neutre" => $romaji . "tte inai", "Affirmatif polie" => $romaji . "tte imasu", "Négatif polie" => $romaji . "tte imasen"]
                        ], // Présent progressif

                        "Passé progressif" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "っていた", "Négatif neutre" => $kanji . "っていなかった", "Affirmatif polie" => $kanji . "っていました", "Négatif polie" => $kanji . "っていませんでした"],
                            "Kana" => ["Affirmatif neutre" => $kana . "っていた", "Négatif neutre" => $kana . "っていなかった", "Affirmatif polie" => $kana . "っていました", "Négatif polie" => $kana . "っていませんでした"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "tte ita", "Négatif neutre" => $romaji . "tte inakatta", "Affirmatif polie" => $romaji . "tte imashita", "Négatif polie" => $romaji . "tte imasen deshita"]
                        ], // Passé progressif

                        "Conditionnel" => [
                            "Kanji" => ["-Eba" => $kanji . "えば", "-Tara" => $kanji . "ったら"],
                            "Kana" => ["-Eba" => $kana . "えば", "-Tara" => $kana . "ったら"],
                            "Romaji" => ["-Eba" => $romaji . "eba", "-Tara" => $romaji . "ttara"]
                        ], // Conditionnel

                        "Potentiel" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "える", "Négatif neutre" => $kanji . "えない", "Affirmatif polie" => $kanji . "えます", "Négatif polie" => $kanji . "えません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "える", "Négatif neutre" => $kana . "えない", "Affirmatif polie" => $kana . "えます", "Négatif polie" => $kana . "えません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "eru", "Négatif neutre" => $romaji . "enai", "Affirmatif polie" => $romaji . "emasu", "Négatif polie" => $romaji . "emasen"]
                        ], // Potentiel

                        "Causatif (Factitif)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "わせる", "Négatif neutre" => $kanji . "わせない", "Affirmatif polie" => $kanji . "わせます", "Négatif polie" => $kanji . "わせません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "わせる", "Négatif neutre" => $kana . "わせない", "Affirmatif polie" => $kana . "わせます", "Négatif polie" => $kana . "わせません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "waseru", "Négatif neutre" => $romaji . "wasenai", "Affirmatif polie" => $romaji . "wasemasu", "Négatif polie" => $romaji . "wasemasen"]
                        ], // Causatif

                        "Passif (Subir)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "われる", "Négatif neutre" => $kanji . "われない", "Affirmatif polie" => $kanji . "われます", "Négatif polie" => $kanji . "われません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "われる", "Négatif neutre" => $kana . "われない", "Affirmatif polie" => $kana . "われます", "Négatif polie" => $kana . "われません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "wareru", "Négatif neutre" => $romaji . "warenai", "Affirmatif polie" => $romaji . "waremasu", "Négatif polie" => $romaji . "waremasen"]
                        ], // Causatif passif

                        "Causatif passif (Contrainte)" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "わせられる", "Négatif neutre" => $kanji . "わせられない", "Affirmatif polie" => $kanji . "わせられます", "Négatif polie" => $kanji . "わせられません"],
                            "Kana" => ["Affirmatif neutre" => $kana . "わせられる", "Négatif neutre" => $kana . "わせられない", "Affirmatif polie" => $kana . "わせられます", "Négatif polie" => $kana . "わせられません"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "waserareru", "Négatif neutre" => $romaji . "waserarenai", "Affirmatif polie" => $romaji . "waseraremasu", "Négatif polie" => $romaji . "waseraremasen"]
                        ], // Causatif passif

                        "Vouloir présent" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "いたい", "Négatif neutre" => $kanji . "いたくない", "Affirmatif polie" => $kanji . "いたいです", "Négatif polie" => $kanji . "いたくないです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "いたい", "Négatif neutre" => $kana . "いたくない", "Affirmatif polie" => $kana . "いたいです", "Négatif polie" => $kana . "いたくないです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "itai", "Négatif neutre" => $romaji . "itakunai", "Affirmatif polie" => $romaji . "itai desu", "Négatif polie" => $romaji . "itakunai desu"]
                        ], // Vouloir présent

                        "Vouloir passé" => [
                            "Kanji" => ["Affirmatif neutre" => $kanji . "いたかった", "Négatif neutre" => $kanji . "いたくなった", "Affirmatif polie" => $kanji . "いたかったです", "Négatif polie" => $kanji . "いたくなったです"],
                            "Kana" => ["Affirmatif neutre" => $kana . "いたかった", "Négatif neutre" => $kana . "いたくなった", "Affirmatif polie" => $kana . "いたかったです", "Négatif polie" => $kana . "いたくなったです"],
                            "Romaji" => ["Affirmatif neutre" => $romaji . "itakatta", "Négatif neutre" => $romaji . "itakunakatta", "Affirmatif polie" => $romaji . "itakatta desu", "Négatif polie" => $romaji . "itakunakatta desu"]
                        ] // Vouloir passé
                    ]];

                }
            }
            break;
        case 'Adjectif':
            $romaji = substr($base['romaji'], 0, -1);
            $kana = substr($base['kana'], 0, -3);
            $kanji = substr($base['kanji'], 0, -3);

            if ($end1 == "i") {
                $add = ["Adjectif (Keiyoushi)" => [
                    "Kanji" => ["Affirmative neutre" => $kanji . "い", "Négative neutre" => $kanji . "くない"],
                    "Kana" => ["Affirmative neutre" => $kana . "い", "Négative neutre" => $kana . "くない"],
                    "Romaji" => ["Affirmative neutre" => $romaji . "i", "Négative neutre" => $romaji . "kunai"]
                ]];
            } else $add = ["Adjectif" => "value"];
            break;
        case 'Nom':
            $add = ["Nom" => "value"];
            break;

        default:
            return null;
    }

    return $add;
}