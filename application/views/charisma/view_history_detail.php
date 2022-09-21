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
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Detail Order</h3>
            </div>
            
          </div>
        </div>


        <div class="container">
            <?php 
            if(!empty($product)) {
            ?>
            <div class="">Status</div>
            <div  class="text-blue text-bold"><?= $product->nama_status; ?></div>
            <hr class="margin-bottom-1x">

            <div class="">Tanggal Pembelian</div>
            <div  class="text-bold"><?= $product->tgl; ?></div>
            <hr class="margin-bottom-1x">

            <div class="">Nomor Invoice</div>
            <div  class="text-bold"><?= $product->no_invoice; ?></div>
            <hr class="margin-bottom-1x">

            <div class="">Daftar Produk</div>
            <?php
            if(!empty($product->list_item)) {
              foreach($product->list_item as $l) {
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="media mb-4"><img class="d-flex rounded align-self-center mr-4" src="<?= $l->img; ?>" width="64" alt="<?= $l->nama_product; ?>">
                            <div class="media-body">
                                <h6 class="mt-0 mb-1 text-gray-dark"><?= $l->nama_product; ?></h6>
                                <span class="d-block text-sm text-gray-dark">Total Pembayaran :
                                    <span class="col-9 ml-2 text-danger text-bold text-lg"><?= harga($l->harga); ?></span>
                                </span>
                                
                            </div>
                        </div>
                        
                    </div>

                </div>
            <?php
              }
           } ?>
            <hr class="margin-bottom-1x">

            <div class=""><p class="text-lg text-medium">Detail Pengiriman</p></div>
            <table>
                <tr><td>Nama Toko </td><td>:</td><td>test</td></tr>
                <tr><td>Kurir Pengiriman </td><td>:</td><td><?= $product->courir_service; ?></td></tr>
                <tr><td>Nomor Resi </td><td>:</td><td>test</td></tr>
                <tr><td>Alamat Pengiriman </td><td>:</td><td><?= $product->alamat; ?></td></tr>
            </table>

            <div class=""><p class="text-lg text-medium">Informasi Pembayaran</p></div>
            <table>
                <tr><td>Total Pembayaran </td><td>:</td><td><?= harga($product->total); ?></td></tr>
            </table>


            <div class=""><p class="text-lg text-medium">Akun Bank</p></div>
            <table class="mb-5">
                <tr><td>Bank Mandiri An Charisma</td><td>:</td><td>test</td></tr>
                <tr><td>Bank BCA An Charisma </td><td>:</td><td>test</td></tr>
            </table>


            <?php
            }
            ?>
            
        </div>
        
</section><!-- End Crazy !-->