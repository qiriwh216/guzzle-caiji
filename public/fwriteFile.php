<?php

set_time_limit(0);
require '../vendor/autoload.php';

$rules = [
    'title' => ['span.topic-title:lt(5)', 'text'],
    'link' => ['a.topic-title-wrap:lt(5)', 'href']
];

$url = "https://learnku.com/laravel";

$client = new \App\Handle\ClientHandle();
$data = $client->queryBody($url, $rules);
$data = array_map(function ($item) {
    return $item['post'];
}, $data);

//
$handle = fopen('2.php','w');
$str = "<?php\n".var_export($data, true).";";
fwrite($handle,$str);
fclose($handle);