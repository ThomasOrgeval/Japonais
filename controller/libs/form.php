<?php

function input($id)
{
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<input type='text' class='form-control' id='$id' name='$id' value='$value'>";
}

function inputRequired($id)
{
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<input type='text' class='form-control' id='$id' name='$id' value='$value' required>";
}

function inputReadonly($id)
{
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<input type='text' class='form-control' id='$id' name='$id' value='$value' readonly>";
}

function inputNumber($id)
{
    $value = isset($_POST[$id]) ? $_POST[$id] : '0';
    return "<input type='number' class='form-control' id='$id' name='$id' value='$value'>";
}

function textarea($id)
{
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
}

function select($id, $list = array())
{
    $return = "<select class='form-control' id='$id' name='$id'>";
    foreach ($list as $k => $value) {
        $selected = '';
        if (isset($_POST[$id]) && $k == $_POST[$id]) {
            $selected = ' selected="selected"';
        }
        $return .= "<option value='$k' $selected>$value</option>";
    }
    $return .= "</select>";
    return $return;
}

function selectFormListe($list, $id, $arraylist = array())
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