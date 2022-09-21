<?php
$fsize = "text-sm";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-xs";
  $fsize_head = "text-xs";
}
?>

<style>
.title {
    color:#000;
    font-weight:bold;
    font-size:25px;
}


.img-kontak {
    width:25%;
}

</style>
    <?php
    $a = $product->description;
    ?>
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>"><?= $title; ?></h3>
            </div>
            
          </div>
        </div>

        <div class="container text-center">
            <img src="<?= $product->img; ?>" class="img-kontak mb-3">
            <h3 class="title mt-3"><span><?= $product->title; ?></span></h3>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-10"><?= $a; ?></div>
                <div class="col-1"></div>
            </div>
        </div>
             
          </div>
    </section><!-- End Crazy !-->