<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>

<?php foreach ($postsInView as $post) : ?>
    <?= $this->e($post['title']); ?> <br>
<?php endforeach; ?>
