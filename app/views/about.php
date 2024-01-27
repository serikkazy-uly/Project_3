
<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<?= $flash->display(); ?> <!-- Display flash messages -->

<h1>user Page</h1>
<p><?= $this->e($name); ?></p>

