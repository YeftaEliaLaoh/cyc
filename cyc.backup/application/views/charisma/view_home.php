<?php
$fsize = "text-md";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-sm";
  $fsize_head = "text-sm";
}
?>
<!-- Promo banner-->
<section class="padding-bottom-2x mt-2">
  <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false,&quot;autoplay&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true }">
    <?php
    $k = 0;
    if(!empty($banner)) {
      foreach($banner as $b) {
        $k++;
        echo '<img style="height:30vw;" src="'.$b.'" alt="Image'.$k.'">';
      }
    }
    
    ?>
    
  </div>
</section>

<section class="mb-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-danger text-medium <?= $fsize_head; ?>">Crazy Sale</h3>
            </div>
            <div class="col-5">
              <h5 class="text-grey text-normal text-right pointer" onclick="location.href='<?= base_url('crazy'); ?>'">Lihat lainnya <span class="text-grey text-xlg text-bold"><img src="<?= base_url("icon/arrow.png"); ?>"></span></h3>
            </div>
          </div>
        </div>

        <div class="card bg-grey">
            <div class="card-body">
              
              <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false,&quot;margin&quot;: 20, &quot;loop&quot;: false, &quot;autoplay&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:4}, &quot;470&quot;:{&quot;items&quot;:4},&quot;630&quot;:{&quot;items&quot;:4},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
                <?php
                if(!empty($crazy)) {
                  foreach($crazy as $c) {
                    $charga = harga($c->harga);
                    echo '<a href="'.base_url('product/'.$c->id_product).'" class="text-decoration-none"><div> <img src="'.$c->img.'" alt="'.$c->nama_product.'">
                    <div class="textoverlay"><span class="text-bold text-blues '.$fsize.'">'.$c->nama_product.'</span>
                    <p class="'.$fsize.' text-danger mb-0">'.$charga.'</p></div> </div></a>';
                  
                  }
                }
                ?>
              </div>
            </div>

        </div>

</section><!-- End Crazy !-->
    
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Produk Terbaru</h3>
            </div>
            <div class="col-5">
              <h5 class="text-grey text-normal text-right pointer" onclick="location.href='<?= base_url('list-product'); ?>'">Lihat lainnya <span class="text-grey text-xlg text-bold"><img src="<?= base_url("icon/arrow.png"); ?>"></span></h3>
              <!--
              <p class="text-muted <?= $fsize; ?> text-right">Lihat lainnya <span class="text-muted <?= $fsize; ?> text-bold">></span></p>
              !-->
            </div>
          </div>
        </div>
        
        <div class="card bg-grey">
          <div class="card-body">
                
                <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false,&quot;margin&quot;: 20, &quot;loop&quot;: false, &quot;autoplay&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:4}, &quot;470&quot;:{&quot;items&quot;:4},&quot;630&quot;:{&quot;items&quot;:4},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
                  <?php
                  if(!empty($new)) {
                    foreach($new as $n) {
                      $nharga = harga($n->harga);
                      echo '<a href="'.base_url('product/'.$n->id_product).'" class="text-decoration-none"><div> <img src="'.$n->img.'" alt="'.$n->nama_product.'">
                      <div class="textoverlay"><span class="text-bold text-blues '.$fsize.'">'.$n->nama_product.'</span>
                      </div> </div></a>';
                    
                    }
                  }
                  ?>
                </div>
            </div>
        </div>
    </section><!-- End Produk terbaru !-->

    
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Kategori</h3>
            </div>
            <div class="col-5">
              <h5 class="text-grey text-normal text-right pointer" onclick="location.href='<?= base_url('category'); ?>'">Lihat lainnya <span class="text-grey text-xlg text-bold"><img src="<?= base_url("icon/arrow.png"); ?>"></span></h3>
              <!--
              <p class="text-lg text-right"><a href="<?= base_url("category"); ?>" class="text-decoration-none text-muted ">Lihat lainnya <span class="text-muted text-lg text-bold">></span></a></p>
              !-->
            </div>
          </div>
        </div>
        
        <div class="card bg-grey">
            <div class="card-body">
              
            <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false,&quot;margin&quot;: 20, &quot;loop&quot;: false, &quot;autoplay&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:4}, &quot;470&quot;:{&quot;items&quot;:4},&quot;630&quot;:{&quot;items&quot;:4},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
              <?php
              foreach($category as $gc) {
                $urlc = base_url("category/$gc->id_kategori");
                echo '<div><a href="'.$urlc.'" class="text-decoration-none"> <img src="'.$gc->image.'" alt="'.$gc->nama_kategori.'">
                <div class="textoverlay"><h3 class="text-bold '.$fsize.' text-blues">'.$gc->nama_kategori.'</h3>
                </div> </a></div>';
              }
              ?>
                
              
              </div>
              
                  
            </div>
          </div>
    </section><!-- End Crazy !-->