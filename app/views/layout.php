<html>

<head>
    <title><?= $this->e($title) ?></title>
</head>
<nav>
    <ul>
        <li><a href="/home">Homepage</a></li>
        <li><a href="/about">About</a></li>
        <!-- <li><a href="#"></a></li>
        <li><a href="#"></a></li> -->
    </ul>
</nav>
<body>
    <?= $this->section('content') ?>
</body>

</html>