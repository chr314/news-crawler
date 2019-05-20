<?php

class Controller_Common extends Controller
{

    public function header($data)
    {
        $this->loadModel("sources");
        $data["sources"] = $this->model->sources->getSources();

        return $this->renderView("header", $data);
    }

    public function footer($data)
    {
        return $this->renderView("footer", $data);
    }
}