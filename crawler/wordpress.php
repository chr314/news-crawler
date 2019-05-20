<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../model/sources.php";
require_once __DIR__ . "/../model/posts.php";
require_once __DIR__ . "/../model/crawler_log.php";

require_once __DIR__ . "/Curl.php";


$sources = new Model_Sources();

$sources_rows = $sources->getSources();


foreach ($sources_rows as $row) {
    if ($row["crawler_method"] == "wordpress") {
        for ($x = 1; $x < 11; $x++) {
            download_wp_posts($row["url"], $row["source_id"], $x);
        }
    }
}

function download_wp_posts($url, $source_id, $page = 1)
{
    $posts = new Model_Posts();
    $log = new Model_Crawler_Log();


    $resp = Curl::get($url . "wp-json/wp/v2/posts?search=musk&per_page=100&page=" . $page);
    $json = json_decode($resp, true);

    $data = [];

    foreach ($json as $post) {
        $data[] = [
            "source_post_id" => (int)$post["id"],
            "title" => $post["title"]["rendered"],
            "content" => $post["content"]["rendered"],
            "source_url" => $post["link"],
            "slug" => $post["slug"],
            "source_id" => (int)$source_id,
            "publish_time" => $post["date_gmt"]
        ];
    }
    $log->addLog($source_id, $url . "wp-json/wp/v2/posts?per_page=100&page=" . $page, count($data));
    $posts->addPosts($data);
}