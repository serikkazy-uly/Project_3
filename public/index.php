<?php
if( !session_id() ) {
    session_start();
}
    
require '../vendor/autoload.php';
use function Tamtamchik\SimpleFlash\flash;

if (true) {
    flash()->message('Hot!');
}

echo flash()->display();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    



</body>

</html>