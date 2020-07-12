<?php

require_once 'debug.php';

$csv = array_map('str_getcsv', file('MOCK_DATA_TEST_TI.csv'));

foreach ($csv as $k => &$v) {
    if ($k > 0 && $v[6] != '') {
        $v[6] = preg_replace('![^0-9]+!', '', $v[6]);
    }
    if ($k > 0 && $v[8] != '') {
        $v[8] = date('d.m.y' ,strtotime($v[8]));
    }
}

$file = fopen('MOCK_DATA_TEST_TI.csv', 'w');
foreach ($csv as $fields) {
    fputcsv($file, $fields);
}
fclose($file);
