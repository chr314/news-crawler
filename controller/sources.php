<?php

class Controller_Sources extends Controller
{

    public function sources_json()
    {
        $this->loadModel("sources");
        $data = $this->model->sources->getSources($this->request->get);

        $this->responseJSON(true, $data);
    }
}