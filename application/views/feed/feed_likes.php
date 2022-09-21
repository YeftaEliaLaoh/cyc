<?php foreach($likes->result() as $r) : ?>
	<div class="post-like-area">
<?php echo $this->common->get_user_display(array("username" => $r->username, "avatar" => $r->avatar, "online_timestamp" => $r->online_timestamp, "first_name" => $r->first_name, "last_name" => $r->last_name)) ?>
</div>
<?php endforeach; ?>