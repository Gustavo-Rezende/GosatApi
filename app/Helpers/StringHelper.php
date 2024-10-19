<?php

function limparString($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = preg_replace('/[^a-zA-Z0-9]/', '', $string);
    $string = str_replace(' ', '_', $string);
    $string = strtolower($string);

    return $string;
}
