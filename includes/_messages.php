<?php if(!empty($success)):?>
    <div class=""><p><?=$success;?></p></div>
<?php endif?>

<?php if(!empty($errors)):?>
    <div class = "alert alert-danger">
    <?php foreach ($errors as $error) :?>
    <p> <?= $error?> </p>
    <?php endforeach;?>
    </div>
<?php endif;?>