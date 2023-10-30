<?php

namespace api\models;

use yii\helpers\Url;

class Endpoint
{
    public $title;
    public $url;

    public function __construct($title)
    {
        $this->title = $title;
        $this->url = Url::to(['/' . $title], true);
    }
}
