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
<?php echo form_open_multipart(site_url("admin/edit_product_pro/" . $product->ID), array("class" => "form-horizontal")) ?>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_81") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="name" value="<?php echo $product->name ?>">
                    </div>
            </div>

            <div class="form-group">
                    <label for="price-in" class="col-md-3 label-heading">Price</label>
                    <div class="col-md-9">
                         <input type="text" class="form-control" id="price-in" name="price" value="<?php echo $product->price ?>">
                    </div>
            </div>

            <div class="form-group">
                    <label for="desc-in" class="col-md-3 label-heading">Description</label>
                    <div class="col-md-9">
                        <textarea name="desc" style="height:200px;" class="form-control"><?= $product->description; ?></textarea>
                    </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 label-heading">Image</label>
              <div class="col-sm-9">
              <img src="<?php echo base_url() ?>/<?php echo $this->settings->info->upload_path_relative ?>/<?php echo $product->image ?>" width="200px" />
                  <input type="file" name="userfile" /> 
              </div>
          </div>

            <div class="form-group">
                    <label for="category-in" class="col-md-3 label-heading">Category</label>
                    <div class="col-md-9">
                        <select name="category" class="form-control" required>
                          <option value=""></option>
                          <?php
                          foreach($category as $p) {
                            if($p->ID == $product->category_id) { $sel ="selected='selected'"; } else { $sel = ""; }
                            echo "<option value='$p->ID' $sel>$p->name</option>";
                          }
                          ?>
                        </select>
                    </div>
            </div>

            <div class="form-group">
                    <label for="seller-in" class="col-md-3 label-heading">Seller</label>
                    <div class="col-md-9">
                        <select name="seller" class="form-control" required>
                          <option value=""></option>
                          <?php
                          foreach($seller as $p2) {
                            if($p2->ID == $product->seller_id) { $sel2 ="selected='selected'"; } else { $sel2 = ""; }
                            echo "<option value='$p2->ID' $sel2>$p2->name</option>";
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