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
<?= style_penjualan(); ?>
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">History Order</h3>
            </div>
            
          </div>
        </div>

        <section class="container padding-top-1x padding-bottom-2x">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <?php
                $menu = get_menu(1);
                if(!empty($menu)) {
                    foreach($menu as $m) {
                        $nama = $m->name;
                        $url = $m->url;
                        
                        if($link == $url) { $active = "active"; } else { $active = ""; }
                        $urls = base_url($url);
                        
                        echo '<li class="nav-item '.$active.'"><a class="nav-link" href="'.$urls.'">'.$nama.'</a></li>';
                    }
                    
                }
            ?>
            </ul>
        </section>

        <div class="container">
            <?php 
            if(!empty($product)) {
                foreach($product as $p) { ?>
                <a href="<?= base_url("history/detail/$p->id_transaksi") ?>" class="text-decoration-none">
                <div class="card mb-3">
                    <div class="card-header text-lg bg-blue-dark text-white"><?= $p->tgl; ?><br>Invoice No <?= $p->no_invoice; ?></div>
                    <div class="card-body">
                        <div class="media mb-4"><img class="d-flex rounded align-self-center mr-4" src="<?= $p->img; ?>" width="64" alt="">
                            <div class="media-body">
                                <h6 class="mt-0 mb-1 text-gray-dark"><?= $p->nama_product; ?></h6>
                                <span class="d-block text-sm text-gray-dark">Total Pembayaran :
                                    <span class="col-9 ml-2 text-danger text-bold text-lg"><?= harga($p->total); ?></span>
                                </span>
                                
                            </div>
                        </div>
                        
                    </div>

                </div>
                </a>

                <?php

                }
            }
            ?>
            
        </div>
        
</section><!-- End Crazy !-->