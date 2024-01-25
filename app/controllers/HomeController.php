<?php

namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class HomeController
{
    private $templates;

    public function __construct(){
        $this->templates = new Engine('../app/views');

    }
    public function index($vars)
    {

        $db=new QueryBuilder();
        $posts = $db->getAll('posts');
        // Render a template
        echo $this->templates->render('homepage', ['posts' => $posts]);
        // d($vars);exit;
    }

    public function about($vars)
    {
     echo $this->templates->render('about', ['name' => 'Page about Jonathan']);
    }
}
