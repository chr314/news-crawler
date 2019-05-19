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
                "canonical" => "/index.php?route=posts/post&post_id=" . $data["post_data"]["post_id"]];

            $data["header"] = $this->renderView("header", $header_data);
            $data["footer"] = $this->renderView("header", []);


            $this->responseView("post", $data);
        }
    }
}