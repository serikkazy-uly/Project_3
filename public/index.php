<?php

require '../vendor/autoload.php';

// Create new Plates instance
$templates = new League\Plates\Engine('../app/views');
// var_dump($templates);die;

// Render a template
// echo $templates->render('homepage', ['name' => 'Jonathan']);
echo $templates->render('about', ['title' => 'Jonathan']);
