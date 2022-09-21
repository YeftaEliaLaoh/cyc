<?php
$fsize = "text-lg";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-sm";
  $fsize_head = "text-sm";
}
?>
    
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Sub Kategori</h3>
            </div>
            
          </div>
        </div>
        
        <div class="card bg-grey">
            <div class="card-body">
              <div class="row">
              <?php
              foreach($subcategory as $gc) {
                echo '<div class="col-3"> <img src="'.$gc->image.'" id="img-res-square" alt="'.$gc->nama_kategori.'">
                <div class="textoverlay"><h3 class="text-bold '.$fsize.' text-center text-blues">'.$gc->nama_kategori.'</h3>
                </div> </div>';
              }
              ?>
              </div>
              
                  
            </div>
          </div>
    </section><!-- End Crazy !-->