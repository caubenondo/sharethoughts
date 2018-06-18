<?php require APPROOT.'/views/inc/header.php'?>
<?php flash('post_message');?>
   <a href="<?= URLROOT;?>/posts" class="btn btn-light"><i class='fa fa-backward'></i> Back</a>
   <br>
   <h1><?= $data['post']->title;?></h1>
   <div class="bg-secondary text-white p-2 mb-3">
        Written by <?= $data['user']->name;?> on <?= $data['post']->created_at;?>
   </div>
   <p>
    <?= $data['post']->body;?>
   </p>

   <?php if($data['post']->user_id==$_SESSION['user_id']) : ?>
        <hr>
        <!-- edit button -->
        <a href="<?php echo URLROOT;?>/posts/edit/<?= $data['post']->id;?>" class="btn btn-dark">Edit</a>

        <!-- delete button -->
        <form class='float-right' action="<?= URLROOT;?>/posts/delete/<?= $data['post']->id;?>" method='post'>
            <input type="submit" value="Delete" class='btn btn-danger'>
        </form>
   <?php endif;?>

   <hr>
   <p class="text-muted">
        You can edit or delete posts that are created by you.
   </p>
<?php require APPROOT.'/views/inc/footer.php'?>