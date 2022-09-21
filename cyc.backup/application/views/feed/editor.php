<?php

if(isset($postAs)) {
  $imgurl = base_url() ."/". $this->settings->info->upload_path_relative ."/". $postAsImg;
} else {
  $imgurl = base_url() ."/". $this->settings->info->upload_path_relative ."/".$this->user->info->avatar;
}

?>

	<?php echo form_open_multipart(site_url("feed/add_post"), array("id" => "social-form")) ?>
  <input type="hidden" name="targetid" value="<?php if(isset($targetid)) echo $targetid ?>">
  <input type="hidden" name="target_type" value="<?php if(isset($target_type)) echo $target_type ?>">
<div class="editor-wrapper">
<div class="editor-content">
<div class="clearfix editor-textarea-wrapper">
<div class="editor-user-icon"><img src="<?php echo $imgurl ?>" class="user-icon-big" id="editor-poster-icon">
</div>

<div class="editor-textarea-part"><textarea name="content" class="editor-textarea" id="editor-textarea" placeholder="<?php if(isset($editor_placeholder)) : ?><?php echo $editor_placeholder ?><?php else : ?><?php echo lang("ctn_495") ?><?php endif; ?>"></textarea>
  <?php if(isset($postAs)) : ?>
    <input type="hidden" name="post_as" value="<?php echo $postAsDefault ?>" id="post_as">
<div class="editor-user-option">
<div class="btn-group">
    <span class="glyphicon glyphicon-chevron-down faded-icon dropdown-toggle click" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
  <ul class="dropdown-menu">
    <li <?php if($postAsDefault == "page") echo "class='nodisplay postastoggle'" ?> id='page-postas'><a href="javascript:void(0)" onclick="set_post_as('page', '<?php echo base_url() ?>/<?php echo $this->settings->info->upload_path_relative ?>/<?php echo $postAsImg ?>')"><?php echo lang("ctn_505") ?> <?php echo $postAs ?></a></li>
    <li <?php if($postAsDefault == "user") echo "class='nodisplay postastoggle'" ?> id='user-postas'><a href="javascript:void(0)" onclick="set_post_as('user', '<?php echo base_url() ?>/<?php echo $this->settings->info->upload_path_relative ?>/<?php echo $this->user->info->avatar ?>')"><?php echo lang("ctn_505") ?> <?php echo $this->user->info->first_name ?></a></li>
  </ul>
</div>
</div>
<?php endif; ?>
</div>
</div>
</div>
<div class="editor-footer">
<button type="button" class="editor-button" title="<?php echo lang("ctn_499") ?>" data-toggle="modal" data-target="#imageModal"><span class="glyphicon glyphicon-picture"></span></button> <button type="button" class="editor-button" title="<?php echo lang("ctn_496") ?>" data-toggle="modal" data-target="#videoModal"><span class="glyphicon glyphicon-facetime-video"></span></button> <button type="button" class="editor-button" value="<?php echo lang("ctn_497") ?>" data-toggle="modal" data-target="#locationModal"><span class="glyphicon glyphicon-map-marker"></span></button> <button type="button" class="editor-button" value="<?php echo lang("ctn_339") ?>" data-toggle="modal" data-target="#userModal"><span class="glyphicon glyphicon-user"></span></button>  
  <button class="editor-button dropdown-toggle" type="button" data-toggle="dropdown" title="<?php echo lang("ctn_347") ?>"><span class="glyphicon glyphicon-heart"></span></button>
  <ul class="dropdown-menu">
    <li>
      <?php $smiles = $this->common->get_smiles(); ?>
      <?php foreach($smiles as $k=>$v) : ?>
        <button type="button" class="nobutton" onclick="add_smile('<?php echo $k ?>')"><?php echo $v ?></button>
      <?php endforeach; ?>
    </li>
  </ul>
  <input type="submit" class="btn btn-primary btn-sm pull-right" value="<?php echo lang("ctn_506") ?>">


</div>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_507") ?></h4>
      </div>
      <div class="modal-body ui-front form-horizontal">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="button" class="btn btn-primary" value="<?php echo lang("ctn_356") ?>" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_508") ?></h4>
      </div>
      <div class="modal-body ui-front form-horizontal">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="button" class="btn btn-primary" data-dismiss="modal" value="<?php echo lang("ctn_356") ?>">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_509") ?></h4>
      </div>
      <div class="modal-body ui-front form-horizontal">
          <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_497") ?></label>
                    <div class="col-md-8">
                      <input type="text" name="location" id="map_name" class="form-control map_name">
                    </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="button" class="btn btn-primary" data-dismiss="modal" value="<?php echo lang("ctn_356") ?>">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_510") ?></h4>
      </div>
      <div class="modal-body ui-front form-horizontal">
          <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading"><?php echo lang("ctn_504") ?></label>
                    <div class="col-md-8">
                        <select class="js-example-basic-multiple" style="width: 100%;" name="with_users[]" id="with_users" multiple="multiple">
                        
                        </select>
                    </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="button" class="btn btn-primary" value="<?php echo lang("ctn_356") ?>" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>

<?php echo form_close() ?>
</div>

<div class="modal fade" id="likeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_511") ?></h4>
      </div>
      <div class="modal-body ui-front" id="post-likes">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="editPost">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_494") ?></h4>
      </div>
      <div class="modal-body ui-front form-horizontal" id="editPost">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
      </div>
    </div>
  </div>
</div>