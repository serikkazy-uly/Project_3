<html>

<head>
    <title><?= $this->e($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="/home">Homepage</a></li>
        <li><a href="/user">user</a></li>
        <!-- <li><a href="#"></a></li>
        <li><a href="#"></a></li> -->
    </ul>
</nav>
    <?= $this->section('content') ?>
</body>

</html>