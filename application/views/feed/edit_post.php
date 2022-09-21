<?php echo form_open_multipart(site_url("feed/edit_post_pro/" . $post->ID), array("id" => "social-form-edit")) ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_494") ?></h4>
</div>
<div class="modal-body ui-front form-horizontal" id="editPost">
	<div class="form-group">
	  <textarea name="content" class="editor-textarea edit-textarea edit-editor-textarea" id="editor-textarea" placeholder="<?php echo lang("ctn_495") ?>"><?php echo $post->content ?></textarea>
	 </div>
	 <div class="editor-footer">
		<button type="button" class="editor-button" value="" id="edit-image"><span class="glyphicon glyphicon-picture"></span></button> <button type="button" class="editor-button" title="<?php echo lang("ctn_496") ?>" id="edit-video"><span class="glyphicon glyphicon-facetime-video"></span></button> <button type="button" class="editor-button" id="edit-location" title="<?php echo lang("ctn_497") ?>"><span class="glyphicon glyphicon-map-marker"></span></button> <button type="button" class="editor-button" id="edit-users" title="<?php echo lang("ctn_132") ?>"><span class="glyphicon glyphicon-user"></span></button> <button class="editor-button dropdown-toggle" type="button" data-toggle="dropdown" title="<?php echo lang("ctn_498") ?>"><span class="glyphicon glyphicon-heart"></span></button>
  <ul class="dropdown-menu">
    <li>
      <?php $smiles = $this->common->get_smiles(); ?>
      <?php foreach($smiles as $k=>$v) : ?>
        <button type="button" class="nobutton" onclick="edit_smile('<?php echo $k ?>')"><?php echo $v ?></button>
      <?php endforeach; ?>
    </li>
  </ul>
	</div>
	<div id="edit-location-area" class="nodisplay">
	 <div class="form-group">
	 <label for="p-in" class="col-md-1 control-label"><span class="glyphicon glyphicon-map-marker"></span></label>
        <div class="col-md-11">
            <input type="text" class="form-control map_name" name="location" value="<?php echo $post->location ?>">
        </div>
	 </div>
	 </div>
	 <div id="edit-image-area" class="nodisplay">
		<?php if(isset($post->imageid)) : ?>
		<?php if(!empty($post->image_file_name)) : ?>
		<p><img src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $post->image_file_name ?>" class="preview-image"></p>
		<?php else : ?>
		<p><img src="<?php echo $post->image_file_url ?>" class="preview-image"></p>
		<?php endif; ?>
		<?php endif; ?>
		<div class="form-group">
	            <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_499") ?></label>
	            <div class="col-md-8">
	                <input type="file" class="form-control" name="image_file">
	            </div>
	    </div>
	    <div class="form-group">
	            <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_500") ?></label>
	            <div class="col-md-8">
	                <input type="text" class="form-control" name="image_url" placeholder="http://www ...">
	            </div>
	    </div>
    </div>
    <div id="edit-video-area" class="nodisplay">
    <?php if(isset($post->videoid)) : ?>
	<?php if(!empty($post->video_file_name)) : ?>
		 <video class="video-preview" controls>
		 	<?php if($post->video_extension == ".mp4") : ?>
			  <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $post->video_file_name ?>" type="video/mp4">
			<?php elseif($post->video_extension == ".ogg" || $post->video_extension == ".ogv") : ?>
		      <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $post->video_file_name ?>" type="video/ogg">
			<?php elseif($post->video_extension == ".webm") : ?>
		      <source src="<?php echo base_url() ?><?php echo $this->settings->info->upload_path_relative ?>/<?php echo $post->video_file_name ?>" type="video/webm">
			<?php endif; ?>
			<?php echo lang("ctn_501") ?>
		 </video> 
	<?php elseif(!empty($post->youtube_id)) : ?>
		<p><iframe class="video-preview" src="https://www.youtube.com/embed/<?php echo $post->youtube_id ?>" frameborder="0" allowfullscreen></iframe></p>
	<?php endif; ?>
	<?php endif; ?>
	<div class="form-group">
            <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_502") ?></label>
            <div class="col-md-8">
                <input type="file" class="form-control" name="video_file">
            </div>
    </div>
    <div class="form-group">
            <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_503") ?></label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="youtube_url" placeholder="http://www ...">
            </div>
    </div>
    </div>
    <div id="edit-users-area" class="nodisplay">
    <div class="form-group">
	    <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_504") ?></label>
	    <div class="col-md-8">
	        <select class="js-example-basic-multiple with_users" style="width: 100%;" name="with_users[]" multiple="multiple">
	       	<?php foreach($users->result() as $r) : ?>
	       		<option value="<?php echo $r->username ?>" selected><?php echo $r->first_name ?> <?php echo $r->last_name ?></option>
	       	<?php endforeach; ?>
	        </select>
	    </div>
    </div>
    </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
<input type="submit" class="btn btn-primary" value="<?php echo lang("ctn_494") ?>">
</div>

<?php echo form_close() ?>