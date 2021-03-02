<?php
set_time_limit(0);
require '../vendor/autoload.php';
$rules = [
    'title' => ['span.topic-title:eq(1)', 'text'],
    'link' => ['a.topic-title-wrap:eq(1)', 'href']
];
$url = "https://learnku.com/laravel";

$client = new \App\Handle\ClientHandle();
$data = $client->queryBody($url, $rules);
$data = array_map(function ($item) {
    return $item['post'];
}, $data);


$sql = "INSERT INTO `posts`(`title`, `review`, `comment`, `content`,`created_at`,`updated_at`) VALUES";


$data = array_filter($data,function($item){
    return count($item) == 6;
});

sort($data);

foreach ($data as $key => $item) {
    $item['content'] = base64_encode($item['content']);
    $value = "'" . implode("','", array_values($item)) . "'";
    $sql .= "($value)";
    if (count($data) - 1 != $key) {
        $sql .= ",";
    }
}

$db = new \App\Handle\PdoHandle();

try {
    $db->source->query($sql);
    echo '采集入库成功!';
} catch (PDOException $exception) {
    echo $exception->getMessage();
}