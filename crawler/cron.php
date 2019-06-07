<?php

require_once __DIR__ . "/../Autoloader.php";
require_once __DIR__ . "/Curl.php";
require_once __DIR__ . "/CrawlerInterface.php";
require_once __DIR__ . "/Wordpress.php";

$model_sources = new Model_Sources();

$sources = $model_sources->getSources();

foreach ($sources as $source) {
    if ($source["crawler_method"] === "wordpress") {
        $wp = new Wordpress($source["source_id"]);
        $wp->downloadNewPosts();
    }
}