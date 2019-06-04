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

            $data["header"] = $this->getController("common", "header", $header_data);
            $data["footer"] = $this->getController("common", "footer");

            $this->responseView("post", $data);
        }
    }

    public function posts()
    {
        $this->loadModel("posts");
        $this->loadModel("settings");
        $data["posts"] = $this->model->posts->getPosts($this->request->get);

        $header_data = [
            "title" => $this->model->settings->getSettingByName("site_name"),
            "canonical" => "/"
        ];

        $data["header"] = $this->getController("common", "header", $header_data);
        $data["footer"] = $this->getController("common", "footer");

        $this->responseView("posts", $data);
    }

    public function posts_json()
    {
        $this->loadModel("posts");
        $data = $this->model->posts->getPosts($this->request->get);

        $this->responseJSON(true, $data);
    }
}