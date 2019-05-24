<?php

class Controller_Posts extends Controller
{
    public function post()
    {
        if ((int)$this->request->get["post_id"] > 0) {
            $this->loadModel("posts");
            $data["post_data"] = $this->model->posts->getPost($this->request->get["post_id"]);

            $header_data = [
                "title" => $data["post_data"]["title"] . " - News Crawler",
                "canonical" => "/index.php?route=posts/post&post_id=" . $data["post_data"]["post_id"]
            ];

            $data["header"] = $this->getController("common", "header", $header_data);

            $data["footer"] = $this->getController("common", "footer");


            $this->responseView("post", $data);
        }
    }

    public function posts()
    {
        $this->loadModel("posts");
        $data["posts"] = $this->model->posts->getPosts($this->request->get);

        $this->loadModel("sources");
        $data["sources"] = $this->model->sources->getSources();

        $header_data = [
            "title" => "News Crawler",
            "canonical" => "/"
        ];

        $data["header"] = $this->renderView("header", $header_data);

        $data["footer"] = $this->renderView("footer", []);


        $this->responseView("posts", $data);
    }

    public function posts_json()
    {
        $this->loadModel("posts");
        $data = $this->model->posts->getPosts($this->request->get);

        $this->responseJSON(true, $data);
    }
}