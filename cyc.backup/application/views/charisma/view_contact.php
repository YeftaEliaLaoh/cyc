<?php
$fsize = "text-lg";
$fsize_head = "";
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
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Kontak</h3>
            </div>
            
          </div>
        </div>

        <div class="container text-center">
            <img src="<?= base_url("icon/logo1.png"); ?>" class="img-kontak mb-3">
            <h3 class="title mt-3"><span>Kami siap melayani anda</span></h3>
            <div class="sub">
                <span>021-692 5999 / 2269 2092</span><br>
                <span>0857 8111 0909</span><br>
                <span>0877 8286 0909</span><br>
                <span>Senin - Sabtu 08:00 - 17:00 WIB</span>
            </div>
        </div>
        
</section><!-- End Crazy !-->