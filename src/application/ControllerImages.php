<?php

use VanDragt\Carbon;

if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
}

class ControllerImages extends Carbon\Controller
{

    // single image

    function records()
    {
        $this->Records = new Carbon\Collection();
        $this->Records->setCollection(
            array(
                Carbon\Filesystem::url_to_path('/content/images/' . implode($this->args, "/")),
            )
        );
    }

    function model()
    {
        $this->Model = new ModelFile($this->Records->getCollection());
    }

    function view()
    {
        parent::view();

        $this->View = new Carbon\File($this->Model->contents);
        $this->View->render();
    }

}