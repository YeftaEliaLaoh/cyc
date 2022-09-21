<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra"> 
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo "Term and Conditions & Privacy" ?></li>
</ol>

<p><?php echo lang("ctn_90") ?></p>

<hr>

<div class="panel panel-default">
<div class="panel-body">
<?php echo form_open_multipart(site_url("admin/tnc_pro"), array("class" => "form-horizontal")) ?>

<div class="form-group">
    <label for="name-in" class="col-sm-2 control-label">Term And Conditions</label>
    <div class="col-sm-10">
  
        <textarea name="tnc" style="height:200px;" class="form-control"><?php echo $row->tnc ?></textarea>
    </div>
</div>


<div class="form-group">
    <label for="name-in" class="col-sm-2 control-label">Privacy Policy</label>
    <div class="col-sm-10">
  
        <textarea name="privacy" style="height:200px;" class="form-control"><?php echo $row->privacy_policy ?></textarea>
    </div>
</div>

<input type="submit" class="btn btn-primary form-control" value="<?php echo lang("ctn_13") ?>" />
<?php echo form_close() ?>
</div>
</div>
</div>