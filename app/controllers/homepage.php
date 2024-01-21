<?php

use App\QueryBuilder;

$db = new QueryBuilder();

// $posts = $db->getAll('posts');

$db->update([ //change up yor query inser or select
    
    'title' => 'Laura',
    // 'email' => 'damir89@gmail.com'// for example
], 2, 'posts');

// var_dump($db);