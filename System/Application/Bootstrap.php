<?php

$open = fopen(dirname(__DIR__)."/../.env", 'r');
while (!feof($open)) {
    $trim = trim(fgets($open), ' ');
    $exp = explode('=', $trim);
    if (!empty($exp[1]) && $exp[0] != "BASE_PATH") $_ENV[$exp[0]] = trim($exp[1]);
    if ($exp[0] == "BASE_PATH") define("__BASEPATH__", $exp[1]);
}
fclose($open);