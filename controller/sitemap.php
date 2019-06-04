<?php

class Controller_Sitemap extends Controller
{

    public function xml()
    {
        $this->loadModel("posts");
        $this->loadModel("settings");

        $domain = $this->model->settings->getSettingByName("domain");
        $protocol = $this->model->settings->getSettingByName("use_ssl") == "true" ? "https://" : "http://";

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($this->model->posts->getPosts() as $post) {
            $url = $protocol . $domain . "/index.php?route=posts/post&amp;post_id=" . $post["post_id"];
            $date = date("Y-m-d", strtotime($post["publish_time"]));
            $xml .= "<url><loc>{$url}</loc><lastmod>{$date}</lastmod></url>";
        }

        $xml .= '</urlset>';

        header("Content-type: text/xml");

        echo $xml;
    }

    public function text()
    {
        $this->loadModel("posts");
        $this->loadModel("settings");

        $domain = $this->model->settings->getSettingByName("domain");
        $protocol = $this->model->settings->getSettingByName("use_ssl") == "true" ? "https://" : "http://";

        header("Content-type: text/plain");

        foreach ($this->model->posts->getPosts() as $post) {
            echo $protocol . $domain . "/index.php?route=posts/post&post_id=" . $post["post_id"] . "\n";
        }
    }

}