<?php
$fsize = "text-sm";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-xs";
  $fsize_head = "text-xs";
}

//var_dump($product);
//echo $product->id_product;
?>
<section class="mt-2 mb-5">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>"><?= $title; ?></h3>
            </div>
            
          </div>
        </div>
                
        <div class="container padding-bottom-3x padding-top-1x">
            <div class="row">
                <!-- Poduct Gallery-->
                <div class="col-md-4 order-1">
                  
                    <?php
                    $gambar_url = $product->img;
                    $gambar_detail = $product->img_detail;
                    $harga_nf = $product->harga;
                    $harga = harga($harga_nf);
                    $nama = $product->nama_product;
                    $id_product = $product->id_product;
                    ?>
                    <div class="product-gallery">
                        <div class="gallery-wrapper">
                     
                        </div>
                        <div class="product-carousel owl-carousel gallery-wrapper">
                            <?php
                            if(!empty($gambar_detail)) {
                                $k = 0;
                                foreach($gambar_detail as $g) {
                                    $k++;
                                    echo '<div class="gallery-item" data-hash="'.$k.'"><a href="'.$g.'" data-size="1000x667"><img src="'.$g.'" alt="Product-'.$k.'"></a></div>';
                                }
                            } else {
                                $k = 1;
                                $g = $gambar_url;
                                echo '<div class="gallery-item" data-hash="'.$k.'"><a href="'.$g.'" data-size="1000x667"><img src="'.$g.'" alt="Product-'.$k.'"></a></div>';
                            }
                            ?>
                        </div>
                        <ul class="product-thumbnails">
                            <?php
                            if(!empty($gambar_detail)) {
                                $k2 = 0;
                                foreach($gambar_detail as $g) {
                                    $k2++;
                                    if($k2 == 1) { $class = 'class="active"'; } else { $class = ""; }
                                    echo '<li '.$class.'><a href="#'.$k2.'"><img src="'.$g.'" alt="Product-'.$k2.'"></a></li>';
                                }
                            } else {
                                $k2 = 1;
                                $g = $gambar_url;
                                echo '<div class="gallery-item" data-hash="'.$k.'"><a href="'.$g.'" data-size="1000x667"><img src="'.$g.'" alt="Product-'.$k.'"></a></div>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Product Info-->
                <div class="col-md-8 order-2" style="padding-left:20px;">
                    <div class="padding-top-2x mt-2 hidden-md-up"></div>
                    <!--
                    <div class="sp-categories pb-3"><i class="icon-tag"></i><a href="#">Drones,</a><a href="#">Action cameras</a></div>
                    !-->
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="mt-2 mb-2">
                        <h1 class="text-lg text-primary text-medium"><?= $nama; ?></h1>
                        <span class="text-lg"><span id="price" class="text-danger text-bold"><?= $harga; ?></span>            </span></div>
                        
                    </div>
                    <input type="hidden" name="harga" value="<?= $harga_nf; ?>">
                    <input type="hidden" name="id" value="<?= $id_product; ?>">
                    <input type="hidden" name="weight" value="<?= $product->weight; ?>">
                    <input type="hidden" name="nama_product" value="<?= $product->nama_product; ?>">
                    <input type="hidden" name="img" value="<?= $product->img; ?>">
                    <input type="hidden" name="harga" value="<?= $product->harga; ?>">
                    <div class="form-group">
                        <span class="text-bold">Jumlah</span>
                        <div class="form-group mt-1 mb-0">
                                <div class="number-input">
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown();changePrice();"></button>
                                    <input class="quantity" id="number" min="1" name="qty" value="1" onchange="changePrice();" type="number">
                                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp();changePrice();" class="plus"></button>
                                </div>
                            </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="reg-varian">Varian Warna</label>
                        <?php
                        if(!empty($varian)) {
                            $var = '<select name="varian" id="varian" class="form-control">';
                            foreach($varian as $v) {
                                $var .= '<option value="'.$v->id_variant.';'.$v->nama_variant.'">'.$v->nama_variant.'</option>';
                            }
                                
                            $var .= '</select>';
                        } else {
                            $var = "";
                        }
                        echo $var;
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="reg-catatan">Catatan Untuk Penjual (Optional)</label>
                        <input type="text" name="catatan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="reg-catatan">Rincian Produk</label>
                        <div class="card">
                            <div class="card card-body"><?= $product->deskripsi; ?></div>
                        </div>
                        
                    </div>

                </div>
                
            </div>
            
        </div>
        <div class="text-center">
            <button class="col-xl-8 btn btn-primary margin-bottom-none" onclick="addcart();" style="color:#ffffff;">Pesan Sekarang</button>
        </div>
</section>

<!-- Photoswipe container-->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>
    
<script>
        
function addcart() {

  var id = $("input[name=id]").val();
  var v = $('#varian').val(); 
  var qty = $("input[name=qty]").val();

  var w = $("input[name=weight]").val();
  var nama = $("input[name=nama_product]").val();
  var img = $("input[name=img]").val();
  var harga = $("input[name=harga]").val();
    
    var dataString = 'v='+v+'&id='+id+'&qty='+qty+'&w='+w+'&nama='+nama+'&img='+img+'&harga='+harga;
    console.log(dataString);
    $.ajax({
        type:'POST',
        data:dataString,
        url:'<?= base_url("api/addcart"); ?>',
        success:function(data) {
          if(data.status == 1) {
              $( "#successcart" ).trigger( "click");
              window.location.href='<?= base_url('checkout') ?>';
          } else {
           // alert(data);
            $( "#wrongcart" ).trigger( "click");
          }
        }
    });

}
</script>