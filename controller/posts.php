<?php

class Controller_Posts extends Controller
{
    public function post()
    {
        if ((int)$this->request->get["post_id"] > 0) {
            $this->loadModel("posts");
            $data["post_data"] = $this->model->posts->getPost($this->request->get["post_id"]);

            $this->responseView("post", $data);
        }
    }
}