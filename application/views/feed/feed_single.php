<?php
$r->content = $this->common->replace_user_tags($r->content);
$r->content = $this->common->replace_hashtags($r->content);
$r->content = $this->common->convert_smiles($r->content);
$script = '';

if($r->post_as == "page") {
	$r->avatar = $r->page_avatar;
	$r->first_name = $r->page_name;
	$r->last_name = "";
	if(!empty($r->page_slug)) {
		$slug = $r->page_slug;
	} else {
		$slug = $r->pageid;
	}
	$url = site_url("pages/view/" . $slug);
} else {
	$url = site_url("profile/" . $r->username);
}
?>
<div class="feed-wrapper" id="feed-post-<?php echo $r->ID ?>">
<div class="feed-header clearfix">
<div class="feed-header-user">
<img src="<?php echo base_url() ?>/<?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->avatar ?>" class="user-icon-big">
</div>
<div class="feed-header-info">
<?php if(isset($r->p_username)) : ?> 
<?php // Posting to someone's profile ?>
<p><a href="<?php echo site_url("profile/" . $r->p_username) ?>"><?php echo $r->p_first_name ?> <?php echo $r->p_last_name ?></a> <span class="glyphicon glyphicon-circle-arrow-right"></span> <a href="<?php echo site_url("profile/" . $r->username) ?>"><?php echo $r->first_name ?> <?php echo $r->last_name ?></a></p>

<p class="feed-timestamp"><?php echo $this->common->get_time_string_simple($this->common->convert_simple_time($r->timestamp)) ?> <?php if($r->location) : ?>- <?php echo lang("ctn_516") ?> <a href="https://www.google.com/maps/place/<?php echo urlencode($r->location) ?>"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $r->location ?></a><?php endif; ?> 

	<?php if($r->user_flag) : ?> - <?php echo lang("ctn_517") ?> 
<?php $users = $this->feed_model->get_feed_users($r->ID); ?>
<?php $c = $users->num_rows(); $v=0; ?>

<?php foreach($users->result() as $user) : ?>
	<?php $v++; ?>
<a href="<?php echo site_url("profile/" . $user->username) ?>"><?php echo $user->first_name ?> <?php echo $user->last_name ?></a><?php if($v == ($c-1) && $c > 0) : ?> <?php echo lang("ctn_302") ?><?php elseif($c == $v) : ?><?php else : ?>, <?php endif; ?>
<?php endforeach; ?>

<?php endif; ?></p>

<?php else : ?>
	<?php // User is posting on a page ?>
	<?php if(isset($r->page_name) && $r->post_as != "page") : ?>
		<p><a href="<?php echo $url ?>"><?php echo $r->first_name ?> <?php echo $r->last_name ?></a> <span class="glyphicon glyphicon-circle-arrow-right"></span> <a href="<?php echo site_url("pages/view/" . $r->pageid) ?>"><?php echo $r->page_name ?></a></p>

		<p class="feed-timestamp"><?php echo $this->common->get_time_string_simple($this->common->convert_simple_time($r->timestamp)) ?>
			<?php if($r->location) : ?>- <?php echo lang("ctn_516") ?> <a href="https://www.google.com/maps/place/<?php echo urlencode($r->location) ?>"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $r->location ?></a><?php endif; ?> 
			<?php if($r->user_flag) : ?> <?php echo lang("ctn_517") ?> 
			<?php $users = $this->feed_model->get_feed_users($r->ID); ?>
			<?php $c = $users->num_rows(); $v=0; ?>
			<?php foreach($users->result() as $user) : ?>
				<?php $v++; ?>
			<a href="<?php echo site_url("profile/" . $user->username) ?>"><?php echo $user->first_name ?> <?php echo $user->last_name ?></a><?php if($v == ($c-1) && $c > 0) : ?> <?php echo lang("ctn_302") ?><?php elseif($c == $v) : ?><?php else : ?>, <?php endif; ?>
			<?php endforeach; ?>
			<?php endif; ?>
		    </p>
	<?php else : ?>
		<?php // Normal post ?>
		<p><a href="<?php echo $url ?>"><?php echo $r->first_name ?> <?php echo $r->last_name ?></a>
			<?php if($r->user_flag) : ?> <?php echo lang("ctn_517") ?> 
			<?php $users = $this->feed_model->get_feed_users($r->ID); ?>
			<?php $c = $users->num_rows(); $v=0; ?>
			<?php foreach($users->result() as $user) : ?>
				<?php $v++; ?>
			<a href="<?php echo site_url("profile/" . $user->username) ?>"><?php echo $user->first_name ?> <?php echo $user->last_name ?></a><?php if($v == ($c-1) && $c > 0) : ?> <?php echo lang("ctn_302") ?><?php elseif($c == $v) : ?><?php else : ?>, <?php endif; ?>
			<?php endforeach; ?>
			<?php endif; ?></p>
			<p class="feed-timestamp"><?php echo $this->common->get_time_string_simple($this->common->convert_simple_time($r->timestamp)) ?> <?php if($r->location) : ?>- <?php echo lang("ctn_516") ?> <a href="https://www.google.com/maps/place/<?php echo urlencode($r->location) ?>"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $r->location ?></a><?php endif; ?> </p>
	<?php endif; ?>


<?php endif; ?>
</div>


<div class="feed-header-dropdown">
<div class="btn-group">
    <span class="glyphicon glyphicon-chevron-down faded-icon dropdown-toggle click" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
  <ul class="dropdown-menu">
  	<li><a href="javascript:void(0)" onclick="save_post(<?php echo $r->ID ?>)" id="save_post_<?php echo $r->ID ?>"><?php if(!isset($r->savepostid)) : ?><?php echo lang("ctn_518") ?></a><?php else : ?><?php echo lang("ctn_519") ?><?php endif; ?></li>
  	<li><a href="javascript:void(0)" onclick="subscribe_post(<?php echo $r->ID ?>)" id="subscribe_post_<?php echo $r->ID ?>"><?php if(!isset($r->subid)) : ?><?php echo lang("ctn_520") ?></a><?php else : ?><?php echo lang("ctn_521") ?><?php endif; ?></li>
  	<?php if($r->userid == $this->user->info->ID || ($r->pageid > 0 && $r->post_as == "page" && isset($r->roleid) && $r->roleid == 1) || $this->common->has_permissions(array("admin", "post_admin"), $this->user)) : ?>
    <li><a href="javascript:void(0)" onclick="delete_post(<?php echo $r->ID ?>)"><?php echo lang("ctn_522") ?></a></li>
    <li><a href="javascript:void(0);" onclick="edit_post(<?php echo $r->ID ?>)"><?php echo lang("ctn_55") ?></a></li>
    <?php endif; ?>
  </ul>
</div>
</div>

</div>
<div class="feed-content">
<?php echo $r->content ?>
<?php if($r->site_flag) : ?>
	<?php $sites = $this->feed_model->get_feed_urls($r->ID); ?>
	<?php foreach($sites->result() as $site) : ?>
		<div class="feed-url-spot clearfix">
		<div class="pull-left feed-url-spot-image">
			<?php if($site->image) : ?>
			<img src="<?php echo $site->image ?>" width="100%">
			<?php endif; ?>
		</div>
		<p><a href="<?php echo $site->url ?>"><?php echo $site->title ?></a></p>
		<p><?php echo $site->description ?></p>
	</div>
	<?php endforeach; ?>
<?php endif; ?>
	
<?php if($r->template == "album") : ?>
	<?php
	// Display all images in post
	$images = $this->feed_model->get_feed_images($r->ID);
	$script .= '$(".album-images-'.$r->ID.'").viewer();';
	?>
	<div>
  	<ul class="album-images album-images-<?php echo $r->ID ?>">
  	<?php foreach($images->result() as $rr) : ?>
  		<?php if(isset($rr->albumid)) : ?>
  			<?php $r->albumid = $rr->albumid; $r->album_name = $rr->album_name; ?>
  		<?php endif; ?>
	<li class="album-image">
	<?php if(isset($rr->file_name)) : ?>
	    <img src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $rr->file_name ?>" width="140" alt="<?php echo $rr->name . "<br>" . $rr->description ?>">
	  <?php else : ?>
	    <img src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/default_album.png" width="140" alt="<?php echo $rr->name . "<br>" . $rr->description ?>">
	  <?php endif; ?>
	  <p><?php echo $rr->name ?></p>
	</li>
	<?php endforeach; ?>
  </ul>
  <?php if(isset($r->albumid)) : ?>
  	<?php if($r->pageid > 0) {
  		$url = site_url("pages/view_album/" . $r->albumid); 
  	} else {
  		$url = site_url("profile/view_album/" . $r->albumid);
  	}
  	?>
			<p class="small-text"><i><?php echo lang("ctn_523") ?>: <a href="<?php echo $url ?>"><?php echo $r->album_name ?></a></i></p>
		<?php endif; ?>
	</div>
<?php elseif($r->template == "event") : ?>
	<div class="editor-event">
		<span class="glyphicon glyphicon-calendar big-event-icon"></span>
		<p><strong><a href="<?php echo site_url("pages/view_event/" . $r->eventid) ?>"><?php echo $r->event_title ?></a></strong></p>
		<p><?php echo $r->event_description ?></p>
		 <p><span class="glyphicon glyphicon-time"></span> <?php echo $r->event_start ?> ~ <?php echo $r->event_end ?> </p>
	</div>
<?php else : ?>
	<?php if(isset($r->imageid)) : ?>
		<?php if(isset($r->images)) : ?>
		<?php foreach($r->images as $img) : ?>
			<?php if(!empty($img->image_file_name)) : ?>
			<p><img src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->image_file_name ?>" width="100%"></p>
			<?php else : ?>
			<p><img src="<?php echo $img->image_file_url ?>"></p>
			<?php endif; ?>
		<?php endforeach; ?>
		
		<?php if(isset($r->albumid)) : ?>
			<?php if($r->pageid > 0) {
					$url = site_url("pages/view_album/" . $r->albumid); 
				} else {
					$url = site_url("profile/view_album/" . $r->albumid);
				}
  		?>
			<p class="small-text"><i><?php echo lang("ctn_523") ?>: <a href="<?php echo $url ?>"><?php echo $r->album_name ?></a></i></p>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if(isset($r->videoid)) : ?>
		<?php if(!empty($r->video_file_name)) : ?>
			 <video width="100%" controls>
			 	<?php if($r->video_extension == ".mp4") : ?>
				  <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->video_file_name ?>" type="video/mp4">
				<?php elseif($r->video_extension == ".ogg" || $r->video_extension == ".ogv") : ?>
			      <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->video_file_name ?>" type="video/ogg">
				<?php elseif($r->video_extension == ".webm") : ?>
			      <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $r->video_file_name ?>" type="video/webm">
				<?php endif; ?>
				<?php echo lang("ctn_501") ?>
			 </video> 
		<?php elseif(!empty($r->youtube_id)) : ?>
		<p><iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $r->youtube_id ?>" frameborder="0" allowfullscreen></iframe></p>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
</div>
<div class="feed-content-stats">
<a href="#" onclick="get_post_likes(<?php echo $r->ID ?>)" class="feed-stat <?php if($r->likes <= 0) : ?>nodisplay<?php endif; ?>" id="likes-click-<?php echo $r->ID ?>"><span class="glyphicon glyphicon-thumbs-up"></span> <span id="feed-likes-<?php echo $r->ID ?>"> <?php echo $r->likes ?></span></a> <a href="javascript:void(0)" onclick="load_comments(<?php echo $r->ID ?>)" class="<?php if($r->comments <= 0) : ?>nodisplay<?php endif; ?>"><span class="glyphicon glyphicon-comment"></span> <span id="feed-comments-<?php echo $r->ID ?>"> <?php echo $r->comments ?></span></a>
</div>
<div class="feed-footer">
<button type="button" id="like-button-<?php echo $r->ID ?>" class="editor-button faded-icon <?php if(isset($r->likeid)) : ?>active-like<?php endif; ?>" onclick="like_feed_post(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-thumbs-up"></span> <span id="like-button-like-<?php echo $r->ID ?>"><?php echo lang("ctn_337") ?></span></button> <button type="button" class="editor-button faded-icon" onclick="load_comments(<?php echo $r->ID ?>)"><span class="glyphicon glyphicon-comment"></span> <?php echo lang("ctn_524") ?></button>
</div>
<div class="feed-comment-area" id="feed-comment-<?php echo $r->ID ?>">

</div>
</div>
<?php if(!empty($script)) : ?>
<script type="text/javascript">
			$(document).ready(function() {
				<?php echo $script ?>
			});
</script>
<?php endif; ?>