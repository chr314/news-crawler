<?php

class Wordpress implements CrawlerInterface
{
    protected $source_id;

    public function __construct($source_id = null)
    {
        if ($source_id) {
            $this->source_id = (int)$source_id;
        }
    }

    public function setSource($source_id)
    {
        $this->source_id = (int)$source_id;
    }

    public function downloadNewPosts()
    {
        if (empty($this->source_id)) {
            return;
        }

        $model_sources = new Model_Sources();
        $model_settings = new Model_Settings();
        $model_posts = new Model_Posts();

        $source_data = $model_sources->getSource($this->source_id);
        $search_term = $model_settings->getSettingByName("crawler_search_term");
        $requests_delay = (int)$model_settings->getSettingByName("crawler_requests_delay");
        $last_post = $model_posts->getPosts(["sort" => "publish_time", "order" => "desc", "per_page" => 1, "page" => 1, "source_id" => $this->source_id]);
        $last_post_time = count($last_post) > 0 ? date("Y-m-d\TH:i:s", strtotime($last_post[0]["publish_time"])) : "";


        $log = new Model_Crawler_Log();

        $page = 1;
        while (true) {
            $request_url = $source_data["url"] . "wp-json/wp/v2/posts?search=" . $search_term . "&per_page=100&page=" . $page
                . (!empty($last_post) ? "&after=" . $last_post_time : "");

            echo " *request " . $request_url . "\n";
            $resp = Curl::get($request_url);
            echo " *response " . $resp . "\n";
            $json = json_decode($resp, true);

            if (!empty($json) && is_array($json) && !isset($json["code"])) {
                $data = [];

                foreach ($json as $post) {
                    $data[] = [
                        "source_post_id" => (int)$post["id"],
                        "source_author_id" => (int)$post["author"],
                        "title" => html_entity_decode($post["title"]["rendered"]),
                        "content" => html_entity_decode($post["content"]["rendered"]),
                        "source_url" => $post["link"],
                        "slug" => $post["slug"],
                        "source_id" => (int)$this->source_id,
                        "publish_time" => $post["date"]
                    ];
                }
                $log->addLog($this->source_id, $request_url, count($data));
                $model_posts->addPosts($data);
                $page++;

                sleep($requests_delay);
            } else {
                break;
            }
        }
    }

}




