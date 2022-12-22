<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$_ENV['SEARCH_ENGINE'] = 'meilisearch';
$_ENV['MEILI_HOST'] = 'localhost';
$_ENV['MEILI_PORT'] = 7700;
$_ENV['MEILI_INDEX'] = 'data';
$_ENV['MEILI_MASTER_KEY'] = '4r3aw5SsNG3TbHsMNJnUtaJy';

$search = new Leeroy\Search\MeiliSearch\Adapter();


$search->store([
    'id' => 'abcdefgh1234567',
    'title' => 'Hello World',
    'content' => 'xxxx xxxxx xxxxx xxxx xxxxx xxxx hello xxxxxxxxxx'
]);

sleep(2);

print_r($search->search('hello'));

$search->remove('abcdefgh1234567');

print_r($search->search('avengers'));
