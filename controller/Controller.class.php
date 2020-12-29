<?php

class Controller
{
    public $view = 'admin';
    public $title;
    public $description;
    public $longtitle;

    function __construct($pageName = 'index')
    {
        $this->title = Config::get('site')['name'].' | '.$this->title;
    }

    public function index($data) {
        return [];
    }

    public function getPageInfo() {
        return [
            'title' => $this->title, // идет в метатэг <title>
            'longtitle' => $this->longtitle, // идет в h1 на странице
            'description' => $this->description,
        ];
    }
}