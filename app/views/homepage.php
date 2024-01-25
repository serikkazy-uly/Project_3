<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>


<?php foreach($posts as $post):?>
    <?php echo $post['title'] ?> <br>

    <?php endforeach;?>
