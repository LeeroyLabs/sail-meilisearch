<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$_ENV['SEARCH_ENGINE'] = 'meilisearch';
$_ENV['MEILI_HOST'] = 'localhost';
$_ENV['MEILI_PORT'] = 7700;
$_ENV['MEILI_INDEX'] = 'data';
$_ENV['MEILI_MASTER_KEY'] = '4r3aw5SsNG3TbHsMNJnUtaJy';

$search = new Leeroy\Search\MeiliSearch\Adapter();
print_r($search->search('avengers'));