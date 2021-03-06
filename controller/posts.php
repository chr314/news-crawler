<?php

class Controller_Posts extends Controller
{
    public function post()
    {
        if ((int)$this->request->get["post_id"] > 0) {
            $this->loadModel("posts");
            $this->loadModel("settings");
            $data["post_data"] = $this->model->posts->getPost($this->request->get["post_id"]);

            $header_data = [
                "title" => $data["post_data"]["title"] . " - " . $this->model->settings->getSettingByName("site_name"),
                "canonical" => "/index.php?route=posts/post&post_id=" . $data["post_data"]["post_id"],
                "styles" => ["/assets/css/post.css"]
            ];

            $footer_data = [
                "scripts" => ["https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js", "/assets/js/post.js?v=1.0.2"]
            ];

            $data["header"] = $this->getController("common", "header", $header_data);
            $data["footer"] = $this->getController("common", "footer", $footer_data);

            $data["disqus_site_subdomain"] = $this->model->settings->getSettingByName("disqus_site_subdomain");
            $data["domain"] = $this->model->settings->getSettingByName("domain");

            $this->responseView("post", $data);
        }
    }

    public function posts()
    {
        $this->loadModel("settings");

        $header_data = [
            "title" => $this->model->settings->getSettingByName("site_name"),
            "canonical" => "/"
        ];

        $footer_data = [
            "scripts" => ["https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js", "/assets/js/posts.js?v=1.1.0"]
        ];

        $data["header"] = $this->getController("common", "header", $header_data);
        $data["footer"] = $this->getController("common", "footer", $footer_data);

        $this->responseView("posts", $data);
    }

    public function posts_json()
    {
        $this->loadModel("posts");
        $get = $this->request->get;
        $filters = [
            "page" => $get["page"] ?? 1,
            "per_page" => $get["per_page"] ?? 20
        ];

        if (!empty($get["search"])) {
            $filters["search"] = $get["search"];
        }

        if (!empty($get["source_id"]) && (int)$get["source_id"] > 0) {
            $filters["source_id"] = (int)$get["source_id"];
        }

        if (!empty($get["sort"])) {
            $filters["sort"] = $get["sort"];
        } else {
            $filters["sort"] = "publish_time";
        }

        if (!empty($get["order"])) {
            $filters["order"] = $get["order"];
        } else {
            $filters["order"] = "desc";
        }

        $posts = $this->model->posts->getPosts($filters);

        $data = [];

        foreach ($posts as $post) {
            $data[] = [
                "post_id" => (int)$post["post_id"],
                "title" => html_entity_decode($post["title"]),
                "content" => html_entity_decode(mb_substr(strip_tags($post["content"]), 0, 500)) . "...",
                "datetime" => date("d/m/Y", strtotime($post["publish_time"])),
            ];
        }

        $this->responseJSON(true, $data);
    }
}