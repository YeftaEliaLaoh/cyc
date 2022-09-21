<?php
$fsize = "text-lg";
$fsize_head = "";
//var_dump($cart);
if(mobile()) {
  $fsize = "text-sm";
  $fsize_head = "text-sm";
}
?>
<style>
.title {
    color:#1e265d;
    font-weight:bold;
    font-size:25px;
}
.title span {
    display:inline-block;
    border-bottom:3px solid #1e265d;
    padding-bottom:4px;
}

.sub {
    color:#1e265d;
    font-size:20px;
    font-weight:600;
    margin-bottom:15%;
}

.img-kontak {
    width:25%;
}

</style>
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Check Out</h3>
            </div>
            
          </div>
        </div>

        <?php if(!empty($cart)) { ?>

        <div class="row">
            <div class="container">
                <form method="post" action='#' id='form_checkout'  class="col-sm-12">
                    <input type="hidden" name="weight" value="<?= $weight; ?>" id="weight">
                    <input type="hidden" name="subtotal" value="<?= $subtotal; ?>" id="subtotal">
                    <div class="alert-checkout"></div>
                    <div class="form-group">
                        <label for="reg-alamat">Alamat</label>
                        <input class="form-control" type="text" id="reg-alamat" name="alamat" required="">
                    </div>
                    <div class="form-group">
                        <label for="reg-provinsi">Provinsi</label>
                        <select name="provinsi" placeholder="Pilih Provinsi" id="provinsi_reg" class="form-control" required>
                            <option>Pilih Provinsi</option>
                            <?php
                            foreach($provinsi as $p) {
                                echo '<option value="'.$p->id_provinsi.'">'.$p->nama_provinsi.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reg-dob">Kota</label>
                        <select name="kota" placeholder="Pilih Kota" id="kota_reg" class="form-control" required>
                            <option>Pilih Kota</option>
                        </select>
                        <div id="loading" style="margin-top: 15px;">
                            <img src="<?= base_url("loading.gif"); ?>" alt="loading" width="18"> <small>Loading...</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg-dob">Opsi Pengiriman</label>
                        <select name="kirim" id="kirim" class="form-control" onchange="changekirim(this.value);" required>
                             <option>Pilih Pengiriman</option>
                        </select>
                        <div id="loading2" style="display:none;margin-top: 15px;">
                            <img src="<?= base_url("loading.gif"); ?>" alt="loading" width="18"> <small>Loading...</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg-dob">Pesanan</label>

                        <?php
                        
                        foreach($cart as $c) {
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="media mb-4"><img class="d-flex rounded align-self-center mr-4" src="<?= $c['img']; ?>" width="64" alt="<?= $c['nama']; ?>">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1 text-blue"><?= $c['nama']; ?><br><span class="text-md"><?= $c['nama_varian']; ?></span></h6>
                                        <div class="row mt-2 text-blue">
                                            <span class="col-9 ml-2 text-danger text-bold text-lg"><?= harga($c['harga'])." / PCS"; ?></span>
                                            <div class="text-lg col-2 text-right"> x <?= $c['qty']; ?>&nbsp;<a class="remove-from-cart text-decoration-none" href="#" onclick="deletecart('<?= $c['id'] ?>');" data-toggle="tooltip" title="" data-original-title="Remove item" aria-describedby="tooltip198431"><i class="icon-trash-2"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <?php } 
                        ?>

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row text-blue">
                                    <div class="col-6">Subtotal Produk</div>
                                    <div class="col-6"><?= $subtotal_f; ?></div>
                                    <div class="col-6">Biaya Pengiriman</div>
                                    <div class="col-6"><span id="biayakirim">-</span></div>
                                    <div class="col-6">Total Pesanan</div>
                                    <div class="col-6"><span id="total"><?= $subtotal_f; ?></span></div>
                                </div>
                            </div>

                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row text-blue">
                                    <div class="col-12">Notes / Pesanan</div>
                                    <div class="col-12"><input type="text" name="notes" class="form-control"></div>
                                    <div class="col-12">Silahkan tinggalkan Pesan</div>
                                </div>
                            </div>

                        </div>
                        <p class="text-blue" style="font-style:italic;">Pesanan anda akan kami cek dan akan kami konfirmasi dalam 1 x 24 jam melalui email, whatsapp dan fitur didalam notifikasi yang tersedia didalam apps ini.</p>

                    </div>
                    <div class="text-center">
                    
                        <button class="col-xl-11 btn btn-primary margin-bottom-none" id="checkout-submit" type="submit" style="color:#ffffff;">Pesan Sekarang</button>
                    </div>
                </form>

            </div>
        </div>
        <?php } else {
            echo '<div class="container" style="height:30em;">No Data</div>';
        } ?>
        
</section><!-- End Crazy !-->

<script>
    $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
    
    $("#loadingmodal").hide();
  // Kita sembunyikan dulu untuk loadingnya
    $("#loading").hide();

    $("#kota_reg").change(function(){
        $("#kirim").hide(); // Sembunyikan dulu combobox kota nya
        $("#loading2").show(); // Tampilkan loadingnya

        $.ajax({
                type: "POST", // Method pengiriman data bisa dengan GET atau POST
                url: "<?= base_url("api/cekongkir"); ?>", // Isi dengan url/path file php yang dituju
                data: {kota : $("#kota_reg").val(),weight : $("#weight").val()}, // data yang akan dikirim ke file yang dituju
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
                    $("#kirim").html(response.data_kirim).show();
                }, 100);
                },
                error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(thrownError); // Munculkan alert error
                }
        });
    });


    $("#provinsi_reg").change(function(){ // Ketika user mengganti atau memilih data provinsi
            //console.log("cari");
            $("#kota_reg").hide(); // Sembunyikan dulu combobox kota nya
            $("#loading").show(); // Tampilkan loadingnya
             $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?= base_url("api/kota"); ?>", // Isi dengan url/path file php yang dituju
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
    });

    
function deletecart(id) {
    var dataURL3 = '<?= base_url("api/deletecart"); ?>';
    
    $.ajax({
         type: "POST", // Method pengiriman data bisa dengan GET atau POST
         url: dataURL3, // Isi dengan url/path file php yang dituju
         data: {id:id}, // data yang akan dikirim ke file yang dituju
         success: function(response){ // Ketika proses pengiriman berhasil
            location.reload();
         },
         error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
           alert(thrownError); // Munculkan alert error
         }
       });
}

 
function changekirim(k) {
    
  var s = $("input[name=subtotal]").val(); 
 // var k = $("input[name=kirim]").val();

    var dataURL3 = '<?= base_url("api/updatetotal"); ?>';
    
    $.ajax({
         type: "POST", // Method pengiriman data bisa dengan GET atau POST
         url: dataURL3, // Isi dengan url/path file php yang dituju
         data: {s:s,k:k}, // data yang akan dikirim ke file yang dituju
         success: function(data){ // Ketika proses pengiriman berhasil
         console.log(data);
            $("#biayakirim").html(data.biayakirim);
            $("#total").html(data.total);
         },
         error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
           alert(thrownError); // Munculkan alert error
         }
       });
}

     
$('#form_checkout').submit(function(e) {
          e.preventDefault();

          var form = $(this);

          $("#checkout-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#checkout-submit').attr('disabled',false);
          $.ajax({
          type:'POST',
          data:form.serialize(),
          url:"<?= base_url('api/checkout'); ?>",
          success:function(data) {
            console.log(data);
            var message = data.message;
            if(data.status == 1) {
              $( "#successcart" ).trigger( "click");
              window.location.href='<?= base_url("history") ?>';
            } else {
                $( "#wrongcart" ).trigger( "click");
            }
            $("#checkout-submit").html('Pesan Sekarang');
            $('#checkout-submit').removeAttr('disabled');
            
          }
          });
          
    });
    </script>