
	  <style>
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
<div class="row">
    <div class="container">
        <div class="text-center" id="type_div">
            <button class="col-xl-11 btn btn-primary" onclick="type_reg(1);">B TO B</button>
            <button class="col-xl-11 btn btn-primary" onclick="type_reg(2);">B TO C</button>
        </div>

        <form method="post" id="form_register" enctype='multipart/form-data'  style="display:none;" class="col-sm-12">
            <input type="hidden" name="type" value="" id="type">
            
            <div class="alert-register"></div>
            <div id="topp"></div>
            <div id="targetOuter" class="text-center">
                <div id="targetLayer"></div>
                <img src="<?= base_url("icon/photo.png"); ?>" style="cursor:pointer;" class="icon-choose-image" />
                <div class="icon-choose-image" >
                <input name="designImage" id="userImage2" type="file" class="inputFile" onChange="showPreview(this);" />
                <input type='hidden' name='dsn' id='dsn'>
                </div>
            </div>
            <div class="alert-login"></div>
            <div class="form-group">
                <label for="reg-name">Name</label>
                <input class="form-control" type="text" id="reg-name" name="nama_member" required="">
            </div>
            <div class="form-group">
                <label for="reg-dob">Date Of Birth</label>
                <input class="form-control" type="date" id="date-input" id="reg-dob" name="dob" required="">
            </div>
            <div class="form-group">
                <label for="reg-phone">Phone Number</label>
                <input class="form-control" type="text" id="reg-phone" name="phone" required="">
            </div>
            <div class="form-group">
                <label for="reg-address">Address</label>
                <input class="form-control" type="text" id="reg-address" name="alamat" required="">
            </div>
            <div class="form-group">
                <label for="reg-email">Email</label>
                <input class="form-control" type="text" id="reg-email" name="email" required="">
            </div>
            <div class="form-group">
                <label for="reg-pwd">Password</label>
                <input class="form-control" type="password" id="reg-pwd" name="password" required="">
            </div>
            <div class="form-group">
                <label for="reg-bidang">Bergerak dibidang apakah Anda ?</label>
                <div class="col-sm-6 form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-1" value="Perusahaan Fashion" name="bergerak_dibidang" required>
                        <label class="custom-control-label" for="ex-radio-1">Perusahaan Fashion</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-2" value="Konveksi" name="bergerak_dibidang" required>
                        <label class="custom-control-label" for="ex-radio-2">Konveksi</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio-3" value="Reseller" name="bergerak_dibidang" required>
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
                        <input class="custom-control-input" type="radio" id="ex-radio2-1" value="Aksesoris Besi" name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-1">Aksesoris Besi</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio2-2" value="Aksesoris Garmen" name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-2">Aksesoris Garmen</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="ex-radio2-3" value="Bahan" name="produk_biasa_dipakai" required>
                        <label class="custom-control-label" for="ex-radio2-3">Bahan</label>
                    </div>
                </div>
                <div class="col-sm-11">
                    <input class="form-control" type="text" id="reg-pertanyaan2" name="pertanyaan2" placeholder="Note">
                </div>
                
            </div>

            <div class="success-register"></div>

            <div class="text-center">
                <button class="col-xl-11 btn btn-primary margin-bottom-none" id="daftar-submit" type="submit" style="color:#ffffff;">Submit</button>
            </div>
        </form>

    </div>
</div>


<script>

function type_reg(val) {
    $("#type").val(val);
    $("#type_div").hide();
    $("#form_register").show();
}
      
$("#form_register").submit(function(e) {
        e.preventDefault();
        
        var form = $(this);
         $("#daftar-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#daftar-submit').attr('disabled',false);
      // alert(dataString);
        
        $.ajax({
        type:'POST',
        data: form.serialize(),
        url:'<?= base_url("api/register_user"); ?>',
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
          $("#daftar-submit").html('Daftar');
            $('#daftar-submit').removeAttr('disabled');
        }
        });
        
  });
  </script>

<script type="text/javascript">
		
    function showPreview(objFileInput) {
		if (objFileInput.files[0]) {
			var fileReader = new FileReader();
			fileReader.onload = function (e) {
				$("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
				$("#targetLayer").css('opacity','0.7');
				$(".icon-choose-image").css('opacity','0.5');
			}
			fileReader.readAsDataURL(objFileInput.files[0]);
		}
	}

    $("#loadingmodal").show();
  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
    
        $("#loadingmodal").hide();
      // Kita sembunyikan dulu untuk loadingnya
    $("#loading").hide();
    
    
        $("#provinsi_reg").change(function(){ // Ketika user mengganti atau memilih data provinsi
        //console.log("cari");
        $("#kota_reg").hide(); // Sembunyikan dulu combobox kota nya
        $("#loading").show(); // Tampilkan loadingnya
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?= base_url("api/home/kota"); ?>", // Isi dengan url/path file php yang dituju
            data: {provinsi : $("#provinsi_reg").val()}, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
            },
            success: function(response){ // Ketika proses pengiriman berhasil
            setTimeout(function(){
                $("#loading").hide(); // Sembunyikan loadingnya

                // set isi dari combobox kota
                // lalu munculkan kembali combobox kotanya
                $("#kota_reg").html(response.data_kota).show();
            }, 100);
            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(thrownError); // Munculkan alert error
            }
        });
        });
        
        
        $("#loading2").hide();
        $("#kota_reg").change(function(){ // Ketika user mengganti atau memilih data provinsi
        $("#kecamatan_reg").hide(); // Sembunyikan dulu combobox kota nya
        $("#loading2").show(); // Tampilkan loadingnya
        
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?= base_url("api/home/kecamatan"); ?>", // Isi dengan url/path file php yang dituju
            data: {kota : $("#kota_reg").val()}, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
            },
            success: function(response){ // Ketika proses pengiriman berhasil
            setTimeout(function(){
                $("#loading2").hide(); // Sembunyikan loadingnya

                // set isi dari combobox kota
                // lalu munculkan kembali combobox kotanya
                $("#kecamatan_reg").html(response.data_kecamatan).show();
            }, 100);
            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(thrownError); // Munculkan alert error
            }
        });
        });
        
    });
    </script>