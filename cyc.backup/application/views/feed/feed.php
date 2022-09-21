<?php foreach($posts->result() as $r) : ?>
<?php 
  include("feed_single.php"); ?>
<?php endforeach; ?>
<?php if(isset($a_url) && $posts->num_rows() > 0) : ?>
<a href="<?php echo $a_url ?>" class="load_next"><?php echo lang("ctn_512") ?></a>
<?php endif; ?>