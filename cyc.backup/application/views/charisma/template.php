<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
   
    <?php include "phpmu-title.php"; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta http-equiv="imagetoolbar" content="no">
    <meta name="language" content="Indonesia">
    <meta name="revisit-after" content="7">
    <meta name="webcrawlers" content="all">
    <meta name="rating" content="general">
    <meta name="spiders" content="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="<?php echo base_url()."template/".template();?>/css/vendor_12.css">
    <!-- Main Template Styles-->
    <link id="mainStyles" rel="stylesheet" media="screen" href="<?php echo base_url()."template/".template();?>/css/styles_2.css">
    <!--
    <link  rel="stylesheet" href="<?php echo base_url()."template/".template();?>/chosen/bootstrap-chosen.css">
    !-->
    <!-- Modernizr-->
    <script src="<?php echo base_url()."template/".template();?>/js/modernizr.min.js"></script>
    <style>
      .text-blues {
        color:#374490;
      }
      .pointer {
        cursor: pointer;
      }
      </style>
      
    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script src="<?php echo base_url()."template/".template();?>/js/vendor_21.js"></script>
    <script src="<?php echo base_url()."template/".template();?>/js/scripts_21.js"></script>

  </head>
  <body>
	<?php include "header.php"; ?>

  <?php echo $contents; ?>

    <footer class="site-footer bg-blue text-white" style="min-height:300px;">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <!-- Logo-->
            <div class="site-branding d-flex">
              <a class="site-logo align-self-center" href="<?= base_url(); ?>"><img src="<?php echo base_url("icon/logo1.png");?>" alt="charisma"></a>
            </div>
          </div>

          <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                      <span class="text-md"><a href="<?= base_url(); ?>" class="text-white text-decoration-none">Home</a></span><br>
                      <span class="text-md"><a href="<?= base_url("crazy"); ?>" class="text-white text-decoration-none">Crazy Sale</a></span><br>
                      <span class="text-md"><a href="<?= base_url("list-product"); ?>" class="text-white text-decoration-none">List Product</a></span><br>
                      <span class="text-md"><a href="<?= base_url("outlet"); ?>" class="text-white text-decoration-none">Outlets</a></span><br>
                      <span class="text-md"><a href="<?= base_url("download"); ?>" class="text-white text-decoration-none">Download</a></span><br>
                    </div>
                    <div class="col-sm-6">
                      <span class="text-md"><a href="<?= base_url(); ?>" class="text-white text-decoration-none">Notification</a></span><br>
                      <span class="text-md"><a href="<?= base_url("contact"); ?>" class="text-white text-decoration-none">Kontak</a></span><br>
                      <span class="text-md"><a href="<?= base_url("news"); ?>" class="text-white text-decoration-none">News</a></span><br>
                      <?php
                      if(!empty($this->session->id)) { ?>
                      <span class="text-md"><a href="<?= base_url("utama/reqwhole"); ?>" class="text-white text-decoration-none">Request Wholesale</a></span>
                      <?php } ?>
                    </div>
                </div>
          </div>

          <div class="col-sm-2"></div>

          <div class="col-sm-3">
            <span class="text-bold">Download Pesen Aja Apps</span><br>
            <img src="<?= base_url("icon/google.png"); ?>" alt="visa" class="img-footer">
            <img src="<?= base_url("icon/apple.png"); ?>" alt="visa" class="img-footer">
          </div>
        
        </div>

      </div>
      
    </footer>

    <button style="display:none;" id="successcart" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-check-circle" data-toast-title="Product" data-toast-message="successfuly added to cart!"></button>
<button style="display:none;" id="wrongcart" data-toast data-toast-type="danger" data-toast-position="topRight" data-toast-icon="icon-check-circle" data-toast-title="Product" data-toast-message="error added to cart!"></button>
    
    <!-- Default Order Modal-->
    <div class="modal fade" id="showmodalregister" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span id="title-headerregister"></span></h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-showregister padding-top-1x padding-bottom-1x">
            <div id="loading-register" class="text-center">
                  <img src="<?= base_url("loading.gif"); ?>" alt="loading"  width="18"> <small>Loading...</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    </body>
    <script>
      
   $(document).on("click", "#openlogin", function() {
    

    var dataURL3 = $(this).attr('data-href');
    var header = $(this).attr('data-header');
    
    //console.log(dataURL3);
    $('#title-headerregister').html(header);

    $("#loading-register").show(); // Tampilkan loadingnya
    $.ajax({
      type: "POST", // Method pengiriman data bisa dengan GET atau POST
      url: dataURL3, // Isi dengan url/path file php yang dituju
      data: {}, // data yang akan dikirim ke file yang dituju
      success: function(response){ // Ketika proses pengiriman berhasil
        setTimeout(function(){
          $("#loading-register").hide(); // Sembunyikan loadingnya
          var modal3 = $('.modal-showregister');
          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          $(modal3).html(response).show();
        }, 100);
      },
      error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
        alert(thrownError); // Munculkan alert error
      }
    });

    });

    
   $(document).on("click", "#openregister", function() {
    

    var dataURL3 = $(this).attr('data-href');
    var header = $(this).attr('data-header');
    //console.log(dataURL3);
    $('#title-headerregister').html(header);

    $("#loading-register").show(); // Tampilkan loadingnya
    $.ajax({
      type: "POST", // Method pengiriman data bisa dengan GET atau POST
      url: dataURL3, // Isi dengan url/path file php yang dituju
      data: {}, // data yang akan dikirim ke file yang dituju
      success: function(response){ // Ketika proses pengiriman berhasil
        setTimeout(function(){
          $("#loading-register").hide(); // Sembunyikan loadingnya
          var modal3 = $('.modal-showregister');
          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          $(modal3).html(response).show();
        }, 100);
      },
      error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
        alert(thrownError); // Munculkan alert error
      }
    });

    });

    function changePrice() {
    //console.log("door");
    var harga = $("input[name=harga]").val();
    var qty = $("input[name=qty]").val();

    var dataString = 'harga='+harga+'&qty='+qty;
    
    $.ajax({
        type:'POST',
        data:dataString,
        url:'<?= base_url("api/checkprice"); ?>',
        success:function(data) {
        
          if(data.status == 1) {

            $('#price').html(data.price);
          } else {
            alert(data);
          }
        }
    });
  }

</script>

</html>