<?php
require '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;
use Faker\Factory;
use JasonGrimes\Paginator;

$faker = Factory::create();

$pdo = new PDO("mysql:host=mysql; dbname=laravel;charset=utf8;", "user", "secret");
$queryFactory = new QueryFactory('mysql');

// $insert = $queryFactory->newInsert();
// $insert->into('posts');
// for ($i = 0; $i < 30; $i++) {
//     $insert->cols([
//         'title' => $faker->words(3, true),
//         'content' => $faker->text
//     ]);
//     $insert->addRow();
// }

// $sth = $pdo->prepare($insert->getStatement());
// $sth->execute($insert->getBindValues());

// $result = $sth->fetch(PDO::FETCH_ASSOC);
// var_dump($result);
// die;

$select = $queryFactory->newSelect();
$select
    ->cols(['*'])
    ->from('posts');
$sth = $pdo->prepare($select->getStatement());
$sth->execute($select->getBindValues());
$totalItems = $sth->fetchAll(PDO::FETCH_ASSOC);

$select = $queryFactory->newSelect();
$select
    ->cols(['*'])
    ->from('posts')
    ->setPaging(3)
    ->page($_GET['page'] ?? 1);

// prepare
$sth = $pdo->prepare($select->getStatement());

$sth->execute($select->getBindValues());

// get result
$items = $sth->fetchAll(PDO::FETCH_ASSOC);

$itemsPerPage = 3;
$currentPage = $_GET['page'] ?? 1;
$urlPattern = '?page=(:num)';

$paginator = new Paginator(count($totalItems), $itemsPerPage, $currentPage, $urlPattern);

foreach ($items as $item) {
    echo $item['id'] . PHP_EOL . $item['title'] . '<br>';
}
?>

<body>
    <ul class="pagination">
        <?php if ($paginator->getPrevUrl()) : ?>
            <li><a href="<?php echo $paginator->getPrevUrl(); ?>">&laquo; Previous</a></li>
        <?php endif; ?>

        <?php foreach ($paginator->getPages() as $page) : ?>
            <?php if ($page['url']) : ?>
                <li <?php echo $page['isCurrent'] ? 'class="active"' : ''; ?>>
                    <a href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
                </li>
            <?php else : ?>
                <li class="disabled"><span><?php echo $page['num']; ?></span></li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($paginator->getNextUrl()) : ?>
            <li><a href="<?php echo $paginator->getNextUrl(); ?>">Next &raquo;</a></li>
        <?php endif; ?>
    </ul>

    <p>
        <?php echo $paginator->getTotalItems(); ?> found.
        Showing
        <?php echo $paginator->getCurrentPageFirstItem(); ?>
        -
        <?php echo $paginator->getCurrentPageLastItem(); ?>
    </p>
</body>

</html>

