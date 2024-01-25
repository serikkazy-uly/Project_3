<?php

namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
class HomeController
{
    public function index($vars)
    {
        // Create new Plates instance
        $templates = new Engine('../app/views');

        // Render a template
        echo $templates->render('homepage', ['name' => 'Jonathan']);

        // d($vars);exit;
        $db = new QueryBuilder();
    }

    public function about($vars)
    {

     $templates = new Engine('../app/views');
     echo $templates->render('about', ['name' => 'Page about Jonathan']);
    }
}
