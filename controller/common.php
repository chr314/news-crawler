<?php

class Controller_Common extends Controller
{

    public function header($data)
    {
        return $this->renderView("header", $data);
    }

    public function footer($data)
    {
        return $this->renderView("footer", $data);
    }
}