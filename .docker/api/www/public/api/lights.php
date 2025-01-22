<?php

function listLights(string $url)
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url.'/lights',
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
		CURLOPT_CUSTOMREQUEST => "GET"
    );

    $ch = curl_init();
    curl_setopt_array($ch,$defaults);
    if( ! $result = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);

    return $result;
}

function simpleJson($json) {
    $array = json_decode($json, true);

    $lights = [];
    foreach ($array as $key => $value) {
        $status = $value['state']['on'] ? 'on' : 'off';
        $lights[] = [
            'id'    => $key,
            'name'  => $value['name'],
            'type'  => $value['type'],
            'status' => $status
        ];
    }

    return json_encode(['lights' => $lights], JSON_PRETTY_PRINT);
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    if($_ENV['WITH_BULBS'] != true || empty($_ENV['URL_API_HUE'])) {
        // Si on a un soucis avec le pont on simule une liste d'ampoule
        echo file_get_contents(__DIR__.'/fake.json');
    } else {
        echo simpleJson(listLights($_ENV['URL_API_HUE']));
    }
}