<?php
$fsize = "text-sm";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-xs";
  $fsize_head = "text-xs";
}
?>

<style>
    
#img-res-product {
	width: 25em;
	height: auto;
	overflow: hidden;
	display: block;
	margin-left: auto;
	margin-right: auto;
}
.textoverlay {
    padding-top:10px;
    width:200px;
    margin:0 auto;
}
</style>
    
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Subcategory Product</h3>
            </div>
            
          </div>
        </div>
        
        <div class="card bg-grey">
            <div class="card-body">
              <div class="row">
              <?php
              foreach($product as $gc) {
                  $harga = harga($gc->harga);
                echo '<a href="'.base_url('product/'.$gc->id_product).'" class="text-decoration-none"><div class="col-4"> 
                    <img src="'.$gc->img.'" id="img-res-product" alt="'.$gc->nama_product.'">
                <div class="textoverlay text-center">
                    <h3 class="text-bold '.$fsize.' text-center text-blues">'.$gc->nama_product.'</h3>
                    <span class="text-danger text-bold">'.$harga.'</span>
                </div> </div></a>';
              }
              ?>
              </div>
              
                  
            </div>
          </div>
    </section><!-- End Crazy !-->