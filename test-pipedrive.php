<?php

require_once 'debug.php';

$api_token = '6cef9e6dfc6926cf231394492fe77ab8094cbe37';
$company_domain = 'home2';

$entities = [
    'notes' => array('content', ''),
    'organizations' => array('name', 'org_id'),
    'persons' => array('name', 'person_id'),
    'deals' => array('title', 'deal_id'),
    'activities' => array('subject', '')
];

function one_foreach (array $result, array $field)
{
    foreach ($result['data'] as $key => $value) {
    $value_field = $value[$field[0]];
    debug('#' . ($key + 1) . ': ' . $value_field);
    }
}

function two_foreach(array $result, array $field, array $notes)
{
    foreach ($result['data'] as $key => $value) {
        $value_field = $value[$field[0]];
        foreach ($notes as $note) {
            if ($key == $note[$field[1]] && $note[$field[1]] != null) {
                debug('_ ' . $note['content']);
            }
        }
        debug('#' . ($key + 1) . ': ' . $value_field);
    }
}

foreach ($entities as $entity => $field) {
    $url = 'https://'.$company_domain.'.pipedrive.com/api/v1/'.$entity.'?api_token=' . $api_token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($output, true);

    if (empty($result['data'])) {
        exit('No '.$entity.' created yet');
    }

    if ($entity == 'notes') {
        $notes = $result['data'];
        //var_dump($notes);
    } else if ($entity == 'organizations') {
        two_foreach($result, $field, $notes);
    } else if ($entity == 'persons') {
        two_foreach($result, $field, $notes);
    } else if ($entity == 'deals') {
        two_foreach($result, $field, $notes);
    } else {
        one_foreach($result, $field);
    }
}