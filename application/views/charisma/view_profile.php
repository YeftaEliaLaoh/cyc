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

#targetOuter{	
	position:relative;
    text-align: center;
    background-color: #F0E8E0;
    margin: 20px auto;
    width: 100px;
    height: 100px;
    border-radius: 4px;
    cursor:pointer;
}
.btnSubmit {
    background-color: #565656;
    border-radius: 4px;
    padding: 10px;
    border: #333 1px solid;
    color: #FFFFFF;
    width: 100px;
	cursor:pointer;
}
.inputFile {
    padding: 5px 0px;
	margin-top:8px;	
    background-color: #FFFFFF;
    width: 48px;	
    overflow: hidden;
	opacity: 0;	
	cursor:pointer;
}
.icon-choose-image {
    position: absolute;
    opacity: 0.1;
    top: 50%;
    left: 50%;
    margin-top: -24px;
    margin-left: -24px;
    width: 48px;
    height: 48px;
}
.upload-preview {border-radius:4px;}
#body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#body-overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}

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
            <a class="list-group-item active" href="<?= base_url("profile") ?>"><i class="icon-user"></i>Profile</a>
            <a class="list-group-item with-badge" href="<?= base_url("utama/reqwhole") ?>"><i class="icon-user"></i>Request Wholesale</a>
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
              <input type="hidden" name="type" value="<?= $profile->type; ?>">
            <div class="col-md-6">
              <div class="form-group">
                <label for="reg-name">Full Name</label>
                <input class="form-control" type="text"  id="reg-name" name="nama_member"  value="<?= $profile->nama; ?>" required="">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="account-email">E-mail</label>
                <input class="form-control" type="email" name="email" id="account-email" value="<?= $profile->email; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="reg-name">Image</label>
                <div id="targetOuter" class="text-center">
                    <div id="targetLayer"></div>
                    <img src="<?= base_url("icon/photo.png"); ?>" style="cursor:pointer;" class="icon-choose-image" />
                    <div class="icon-choose-image" >
                    <input name="designImage" id="userImage2" type="file" class="inputFile" onChange="showPreview(this);" />
                    </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="account-phone">Telepon</label>
                <input class="form-control" type="text" id="reg-phone" name="phone" value="<?= $profile->phone; ?>" required="">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="account-alamat">Alamat</label>
                <input class="form-control" type="text" id="reg-address" name="alamat" value="<?= $profile->alamat; ?>" required="">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="account-tgl">Tanggal Lahir</label>
                <input class="form-control" type="text" id="date-input" id="reg-dob" name="dob" value="<?= tgl_view2($profile->dob); ?>">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="account-pass">Ubah Password</label>
                <input class="form-control" type="password"  id="reg-pwd" value="<?= $profile->current_pass; ?>" name="password">
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
     function showPreview(objFileInput) {
          if (objFileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
              $("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
              $("#targetLayer").css('opacity','0.7');
              $(".icon-choose-image").css('opacity','0.5');
            }
            fileReader.readAsDataURL(objFileInput.files[0]);
            //console.log(objFileInput.files[0]);
          }
      }

$("#form_register").submit(function(e) {
        e.preventDefault();
        
        //var form = $(this);
        var form = new FormData(this);
         $("#daftar-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
         $('#daftar-submit').attr('disabled',false);
      // alert(dataString);\
        
        $.ajax({
        type:'POST',
        data: form,
        url:'<?= base_url("api/edit_member"); ?>',
        contentType: false,
        processData:false,
        success:function(data) {
            //console.log(data);
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