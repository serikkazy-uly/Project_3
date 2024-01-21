<?php

use App\QueryBuilder;

$db = new QueryBuilder();

// $posts = $db->getAll('posts');


// Insert
// $db->insert([ //change up yor query inser or select
//     'title' => 'Laura',
//     // 'email' => 'damir89@gmail.com'// for example
// ], 'posts');
// exit;

// Update
// $db->update([ //change up yor query inser or select
//     'title' => 'Laura_Damir',
//     // 'email' => 'damir89@gmail.com'// for example
// ], 7, 'posts');
// // var_dump($db);
// exit;


// Пример использования findOne
$user = $db->findOne(7, 'posts');

if ($user) {
    // Обработка найденного пользователя
} else {
    // Пользователь с указанным идентификатором не найден
    echo "Пользователь не найден";
}
// var_dump($user);


// Пример использования delete
$db->delete(7, 'posts');

// var_dump($db);
// Теперь проверим, что запись с идентификатором 1 удалена
$deletedUser = $db->findOne(7, 'posts');
// var_dump($deletedUser);

if ($deletedUser) {
    // Если запись найдена, значит delete не сработал
    echo "Запись не удалена";
} else {
    // Если запись не найдена, значит delete сработал успешно
    echo "Запись удалена успешно";
}
