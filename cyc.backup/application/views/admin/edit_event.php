<?php
echo '<link rel="stylesheet" href="'.base_url().'scripts/libraries/datetimepicker/jquery.datetimepicker.css" />
<script src="'.base_url().'scripts/libraries/datetimepicker/jquery.datetimepicker.full.min.js"></script>';
?>

<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra form-inline">
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo lang("ctn_454") ?></li>
</ol>

<div class="panel panel-default">
<div class="panel-body">
<?php echo form_open_multipart(site_url("admin/edit_event_pro/" . $event->ID), array("class" => "form-horizontal")) ?>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_81") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="name" value="<?php echo $event->name ?>">
                    </div>
            </div>

            <div class="form-group">
                    <label for="location-in" class="col-md-3 label-heading">Location</label>
                    <div class="col-md-9">
                         <input type="text" class="form-control" id="location-in" name="location" value="<?php echo $event->location ?>">
                    </div>
            </div>

            <div class="form-group">
                    <label for="desc-in" class="col-md-3 label-heading">Description</label>
                    <div class="col-md-9">
                        <textarea name="desc" style="height:200px;" class="form-control"><?= $event->description; ?></textarea>
                    </div>
            </div>

            <div class="form-group">
                    <label for="price-in" class="col-md-3 label-heading">Date & Time</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control datetimepicker" value="<?php echo date("Y/m/d H:i", $event->timestamp) ?>" name="timestamp" id="timestamp">
                    </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 label-heading">Image</label>
              <div class="col-sm-9">
              <img src="<?php echo base_url() ?>/<?php echo $this->settings->info->upload_path_relative ?>/<?php echo $event->image ?>" width="200px" />
                  <input type="file" name="userfile" /> 
              </div>
          </div>

            <div class="form-group">
                    <label for="category-in" class="col-md-3 label-heading">Region</label>
                    <div class="col-md-9">
                        <select name="province" class="form-control" required>
                          <option value=""></option>
                          <?php
                          foreach($provinces as $p) {
                            if($p->id == $event->province_id) { $sel ="selected='selected'"; } else { $sel = ""; }
                            echo "<option value='$p->id' $sel>$p->name</option>";
                          }
                          ?>
                        </select>
                    </div>
            </div>

             
<input type="submit" class="btn btn-primary btn-sm form-control" value="<?php echo lang("ctn_13") ?>" />
<?php echo form_close() ?>
</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function() {

  $('.datetimepicker').datetimepicker({
      format : '<?php echo $this->settings->info->calendar_picker_format ?>'
    });
  });
</script>