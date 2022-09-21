<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra form-inline">
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo "Edit Themes" ?></li>
</ol>

<div class="panel panel-default">
<div class="panel-body">
<?php echo form_open(site_url("admin/edit_themes_pro/" . $category->id), array("class" => "form-horizontal")) ?>
<div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_81") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="name" value="<?php echo $category->name ?>">
                    </div>
            </div>
             <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_271_1") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="color" value="<?php echo $category->color ?>">
                    </div>
            </div>
<input type="submit" class="btn btn-primary btn-sm form-control" value="<?php echo lang("ctn_13") ?>" />
<?php echo form_close() ?>
</div>
</div>

</div>