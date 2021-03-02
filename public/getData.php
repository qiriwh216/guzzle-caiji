<?php
require '../vendor/autoload.php';

$db = new \App\Handle\PdoHandle();
//查询
$sql = "select * from `posts` limit 0,10";

$pdoStatement = $db->source->query($sql);
$data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

foreach ($data as &$item){
    $item['content'] = base64_decode($item['content']);
}

var_dump($data);