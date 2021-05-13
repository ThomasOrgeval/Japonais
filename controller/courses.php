<?php

/**
 * Kana
 */

function kana()
{
    $kana = listKana();
    $_POST['kana'][''] = array();
    $_POST['kana']['k'] = array();
    $_POST['kana']['g'] = array();
    $_POST['kana']['s'] = array();
    $_POST['kana']['z'] = array();
    $_POST['kana']['t'] = array();
    $_POST['kana']['d'] = array();
    $_POST['kana']['n'] = array();
    $_POST['kana']['h'] = array();
    $_POST['kana']['b'] = array();
    $_POST['kana']['p'] = array();
    $_POST['kana']['m'] = array();
    $_POST['kana']['y'] = array();
    $_POST['kana']['r'] = array();
    $_POST['kana']['w'] = array();

    $_POST['kana']['ky'] = array();
    $_POST['kana']['gy'] = array();
    $_POST['kana']['sh'] = array();
    $_POST['kana']['j'] = array();
    $_POST['kana']['ch'] = array();
    $_POST['kana']['ny'] = array();
    $_POST['kana']['hy'] = array();
    $_POST['kana']['by'] = array();
    $_POST['kana']['py'] = array();
    $_POST['kana']['my'] = array();
    $_POST['kana']['ry'] = array();

    $excepts = ['cha', 'cho', 'chu', 'sha', 'sho', 'shu', 'ja', 'jo', 'ju', 'n'];
    foreach ($kana as $item) {
        if (substr($item['romaji'], 1, 1) != 'y' && !in_array($item['romaji'], $excepts)) {
            switch (substr($item['romaji'], 0, 1)) {
                case 'k':
                    array_push($_POST['kana']['k'], $item);
                    break;
                case 'g':
                    array_push($_POST['kana']['g'], $item);
                    break;
                case 's':
                    array_push($_POST['kana']['s'], $item);
                    break;
                case 'z':
                case 'j':
                    if ($item['hiragana'] === 'づ') {
                        array_push($_POST['kana']['d'], $item);
                        array_push($_POST['kana']['d'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    } else {
                        array_push($_POST['kana']['z'], $item);
                    }
                    break;
                case 't':
                case 'c':
                    array_push($_POST['kana']['t'], $item);
                    break;
                case 'd':
                    array_push($_POST['kana']['d'], $item);
                    break;
                case 'n':
                    array_push($_POST['kana']['n'], $item);
                    break;
                case 'h':
                case 'f':
                    array_push($_POST['kana']['h'], $item);
                    break;
                case 'p':
                    array_push($_POST['kana']['p'], $item);
                    break;
                case 'b':
                    array_push($_POST['kana']['b'], $item);
                    break;
                case 'm':
                    array_push($_POST['kana']['m'], $item);
                    break;
                case 'y':
                    array_push($_POST['kana']['y'], $item);
                    break;
                case 'r':
                    array_push($_POST['kana']['r'], $item);
                    break;
                case 'w':
                    array_push($_POST['kana']['w'], $item);
                    break;
                default:
                    array_push($_POST['kana'][''], $item);
            }
        } else {
            switch (substr($item['romaji'], 0, 2)) {
                case 'ky':
                    array_push($_POST['kana']['ky'], $item);
                    if ($item['romaji'] == 'kyu') {
                        array_push($_POST['kana']['ky'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ky'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'gy':
                    array_push($_POST['kana']['gy'], $item);
                    if ($item['romaji'] == 'gyu') {
                        array_push($_POST['kana']['gy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['gy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'sh':
                    array_push($_POST['kana']['sh'], $item);
                    if ($item['romaji'] == 'shu') {
                        array_push($_POST['kana']['sh'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['sh'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ch':
                    array_push($_POST['kana']['ch'], $item);
                    if ($item['romaji'] == 'chu') {
                        array_push($_POST['kana']['ch'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ch'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ny':
                    array_push($_POST['kana']['ny'], $item);
                    if ($item['romaji'] == 'nyu') {
                        array_push($_POST['kana']['ny'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ny'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'hy':
                    array_push($_POST['kana']['hy'], $item);
                    if ($item['romaji'] == 'hyu') {
                        array_push($_POST['kana']['hy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['hy'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'by':
                    array_push($_POST['kana']['by'], $item);
                    if ($item['romaji'] == 'byu') {
                        array_push($_POST['kana']['by'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['by'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'py':
                    array_push($_POST['kana']['py'], $item);
                    if ($item['romaji'] == 'pyu') {
                        array_push($_POST['kana']['py'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['py'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'my':
                    array_push($_POST['kana']['my'], $item);
                    if ($item['romaji'] == 'myu') {
                        array_push($_POST['kana']['my'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['my'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                case 'ry':
                    array_push($_POST['kana']['ry'], $item);
                    if ($item['romaji'] == 'ryu') {
                        array_push($_POST['kana']['ry'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['ry'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                    }
                    break;
                default:
                    if ($item['hiragana'] == 'ん') {
                        array_push($_POST['kana']['w'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['w'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        array_push($_POST['kana']['w'], $item);
                    } else {
                        array_push($_POST['kana']['j'], $item);
                        if ($item['romaji'] == 'ju') {
                            array_push($_POST['kana']['j'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                            array_push($_POST['kana']['j'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
                        }
                    }
                    break;
            }
        }
    }
    array_push($_POST['kana']['y'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
    array_push($_POST['kana']['y'], ['hiragana' => '', 'katakana' => '', 'romaji' => '']);
    require 'view/frontend/courses/kana.php';
}

/**
 * Nombres
 */

function number()
{
    $_POST['data'] = (array)json_decode(file_get_contents('./resources/database/nombre.json'))['nombre'];
    require 'view/frontend/courses/number.php';
}

/**
 * Musics
 */

function musics()
{
    $_POST['musics'] = selectMusics();
    require 'view/frontend/courses/musics.php';
}

function music_show()
{
    $_POST['music'] = selectMusic($_GET['slug']);

    $romaji = explode("<p>", $_POST['music']['romaji']);
    $romaji = array_map(function ($v) {
        return "<p>" . $v;
    }, $romaji);

    $japonais = explode("<p>", $_POST['music']['japonais']);
    $japonais = array_map(function ($v) {
        return "<p>" . $v;
    }, $japonais);

    $francais = explode("<p>", $_POST['music']['francais']);
    $francais = array_map(function ($v) {
        return "<p>" . $v;
    }, $francais);

    $_POST['music']['romaji'] = $romaji;
    $_POST['music']['japonais'] = $japonais;
    $_POST['music']['francais'] = $francais;
    require 'view/frontend/courses/music.php';
}