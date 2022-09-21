<?php
$fsize = "text-lg";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-sm";
  $fsize_head = "text-sm";
}
?>
<style>
    .chat-message {
    width: 100%;
    padding:10px;
	min-height: 380px;
	background-position: center;
	background-color: #ffffff;
	background-repeat: no-repeat;
	background-size: cover;
	overflow: hidden
}
</style>
<section class="container mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Profile</h3>
            </div>
            
          </div>
        </div>
        
</section>
<?php
if(!empty($profile->photo)) {
    $photo = $profile->photo;
} else {
    $photo = base_url("icon/user.jpg");
}
?>
<div class="container padding-bottom-3x mb-2">
      <div class="row">
        <div class="col-lg-4">
          <aside class="user-info-wrapper">
            <div class="user-cover" style="background-image: url(img/account/user-cover-img.jpg);">
              <a href="#"><div class="info-label" data-toggle="tooltip" title="" data-original-title="Point Anda "><i class="icon-award"></i> <?= $profile->total_point; ?> points</div></a>
            </div>
            <div class="user-info">
              <div class="user-avatar"><img src="<?= $photo; ?>" alt="User"></div>
              <div class="user-data">
                <h4 class="h5"><?= $profile->nama; ?></h4><span>Bergabung <?= $profile->tgl_reg; ?></span>
              </div>
            </div>
          </aside>
          <nav class="list-group">
            <a class="list-group-item" href="<?= base_url("profile") ?>"><i class="icon-user"></i>Profile</a>
            <a class="list-group-item active" href="<?= base_url("utama/reqwhole") ?>"><i class="icon-user"></i>Request Wholesale</a>
            <a class="list-group-item with-badge" href="<?= base_url("history/waiting") ?>"><i class="icon-user"></i>Lihat Riwayat Pembelanjaan</a>
            <a class="list-group-item with-badge" href="<?= base_url("api/logout") ?>"><i class="icon-shield-off"></i>Logout</a>
          </nav>
        </div>
        <div class="col-lg-7 ml-3">
          <div class="padding-top-2x mt-2 hidden-lg-up"></div>
          <div class="success-register"></div>
          <div class="alert-register"></div>
         
          <form class="row" method="post" id="form_register" enctype='multipart/form-data' >
          <!--
          <form method="post" id="form_register" enctype='multipart/form-data'  class="col-sm-12">
           !-->
              <input type="hidden" name="id_member" value="<?= $profile->id_member; ?>">

            <div class="col-md-6">
              <div class="form-group">
                <label for="reg-name">Type </label>
                <select name="type" class="form-control">
                    <option value="1" <?php if($profile->type == 1) { echo "selected='selected'"; } ?>>B to B</option>
                    <option value="2" <?php if($profile->type == 2) { echo "selected='selected'"; } ?>>B to C</option>
                </select>
              </div>
            </div>

            <div class="form-group">
                <label for="reg-bidang">Bergerak dibidang apakah Anda ?</label>
                <div class="col-sm-6 form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-1"
                        <?php if($this->session->bergerak_dibidang == "Perusahaan Fashion") { echo "checked"; } ?>
                         value="Perusahaan Fashion" name="bergerak_dibidang" required>
                        <label class="custom-control-label" for="ex-radio-1">Perusahaan Fashion</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-2" value="Konveksi" 
                        <?php if($this->session->bergerak_dibidang == "Konveksi") { echo "checked"; } ?>
                        name="bergerak_dibidang" required>
                        <label class="custom-control-label" for="ex-radio-2">Konveksi</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-3" value="Reseller" 
                        <?php if($this->session->bergerak_dibidang == "Reseller") { echo "checked"; } ?>
                        name="bergerak_dibidang" required>
                        <label class="custom-control-label" for="ex-radio-3">Reseller</label>
                    </div>
                </div>
                <div class="col-sm-11">
                    <input class="form-control" type="text" id="reg-pertanyaan1" name="pertanyaan1" placeholder="Note">
                </div>
                
            </div>

            <div class="form-group">
                <label for="reg-bidang">Produk apa yang biasa Anda pakai ?</label>
                <div class="col-sm-6 form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio2-1" value="Aksesoris Besi" 
                        <?php if($this->session->produk_biasa_dipakai == "Aksesoris besi" || $this->session->produk_biasa_dipakai == "Aksesoris Besi") { echo "checked"; } ?> 
                        name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-1">Aksesoris Besi</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio2-2" value="Aksesoris Garmen" 
                        <?php if($this->session->produk_biasa_dipakai == "Aksesoris Garmen") { echo "checked"; } ?> 
                        name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-2">Aksesoris Garmen</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio2-3" value="Bahan" 
                        <?php if($this->session->produk_biasa_dipakai == "Bahan") { echo "checked"; } ?> 
                        name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-3">Bahan</label>
                    </div>
                </div>
                <div class="col-sm-11">
                    <input class="form-control" type="text" id="reg-pertanyaan2" name="pertanyaan2" placeholder="Note">
                </div>
                
            </div>

            <div class="col-12">
              <hr class="mt-2 mb-3">
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <!--
                <button class="btn btn-primary margin-right-none" type="button" id="daftar-submit" type="submit">Update Profile</button>
                !-->
                <button class="btn btn-primary margin-right-none" id="daftar-submit" type="submit" style="color:#ffffff;">Update Profile</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>

    <script>
        
$("#form_register").submit(function(e) {
        e.preventDefault();
        
        var form = $(this);
         $("#daftar-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#daftar-submit').attr('disabled',false);
      // alert(dataString);
        
        $.ajax({
        type:'POST',
        data: form.serialize(),
        url:'<?= base_url("api/upgrade"); ?>',
        success:function(data) {
            console.log(data);
          var message = data.message;
         // var errcode = data.err_code;
          if(data.status == 1) {
            //location.reload();
            $(".success-register").html('<div class="alert alert-success alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-alert-triangle"></i>&nbsp;&nbsp;<span class="text-medium text-green">'+message+'</div>');
              setTimeout(function(){
                location.reload();
              }, 2000);
          } else {
            
            $(".alert-register").html('<div class="alert alert-danger alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-alert-triangle"></i>&nbsp;&nbsp;<span class="text-medium">'+message+'</div>');
            
          }
          $("#daftar-submit").html('Update Profile');
            $('#daftar-submit').removeAttr('disabled');
        }
        });
        
  });
  </script>