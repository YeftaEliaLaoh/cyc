<?php 
foreach($inventory as $v) { ?>
<div class="col-md-12 card border-dark mb-3">
    <div class="card-body">
        <div class="col-sm-12 text-right" onclick="deleteinv('<?= $v['prod_code'] ?>');" style="cursor:pointer;">
                <i class="icon-cross" style="margin-top:-0.5%;"></i>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <label for="reg-fn">Code</label>
                <input class="form-control" type="text" value="<?= $v['prod_code']; ?>" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="reg-fn">Product Name</label>
                <input class="form-control" type="text"  value="<?= $v['prod_name']; ?>"  disabled value="">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="reg-fn">Qty (Unit)</label>
                <input class="form-control" type="text"  value="<?= $v['qty']; ?>"  disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="reg-fn">UOM</label>
                <input class="form-control" type="text"  value="<?= $v['uom']; ?>"  disabled>
                </div>
            </div>
        </div>

    </div>
</div>
<?php } ?>

<script>
    
function deleteinv(id) {
    var dataURL3 = '<?= base_url("neworder/deleteinventory"); ?>';

    $("#loadingmodal").show();
    
    $.ajax({
         type: "POST", // Method pengiriman data bisa dengan GET atau POST
         url: dataURL3, // Isi dengan url/path file php yang dituju
         data: {id:id}, // data yang akan dikirim ke file yang dituju
         success: function(response){ // Ketika proses pengiriman berhasil
           setTimeout(function(){
             $("#loadingmodal").hide(); // Sembunyikan loadingnya
             var modal3 = $('#inventory');
             // set isi dari combobox kota
             // lalu munculkan kembali combobox kotanya
             $(modal3).html(response).show();
            // $("#ttl").hide();
           }, 100);
         },
         error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
           alert(thrownError); // Munculkan alert error
         }
       });
}
</script>