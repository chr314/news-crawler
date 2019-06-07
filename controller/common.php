<?php

class Controller_Common extends Controller
{

    public function header($data = [])
    {
        $this->loadModel("sources");
        $this->loadModel("settings");
        $data["sources"] = $this->model->sources->getSources();

        $data["site_name"] = $this->model->settings->getSettingByName("site_name");
        $data["site_description"] = $this->model->settings->getSettingByName("site_description");

        if (empty($data["title"])) {
            $data["title"] = $data["site_name"];
        }

        return $this->renderView("common/header", $data);
    }

    public function footer($data = [])
    {
        return $this->renderView("common/footer", $data);
    }
}