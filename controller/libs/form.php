<?php

function input($id): string
{
    $value = $_POST[$id] ?? '';
    return "<input type='text' class='form-control' id='$id' name='$id' value=\"$value\">";
}

function inputRequired($id): string
{
    $value = $_POST[$id] ?? '';
    return "<input type='text' class='form-control' id='$id' name='$id' value=\"$value\" required>";
}

function inputReadonly($id): string
{
    $value = $_POST[$id] ?? '';
    return "<input type='text' class='form-control' id='$id' name='$id' value=\"$value\" readonly>";
}

function inputNumber($id): string
{
    $value = $_POST[$id] ?? '0';
    return "<input type='number' class='form-control' id='$id' name='$id' value='$value'>";
}

function textarea($id): string
{
    $value = $_POST[$id] ?? '';
    return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
}

function select($id, $list = array(), $label = 'Choisir une entrée'): string
{
    $return = "<select class='form-select' id='$id' name='$id' required><option>$label</option>";
    foreach ($list as $k => $value) {
        $selected = '';
        if (isset($_POST[$id]) && $k == $_POST[$id]) $selected = ' selected';
        $return .= "<option value='$k' $selected>$value</option>";
    }
    $return .= "</select>";
    return $return;
}

function selectFormListe($list, $id, $arraylist = array()): string
{
    $return = "<select class='form-control' id='$id' name='$id'>";
    foreach ($arraylist as $k => $value) {
        $selected = '';
        if (isset($list) && $k == $list) {
            $selected = ' selected="selected"';
        }
        $return .= "<option value='$k' $selected>$value</option>";
    }
    $return .= "</select>";
    return $return;
}