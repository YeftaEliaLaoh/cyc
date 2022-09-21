<form method="post" action='#' id='form_product'>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Qty Available</th>
                <th>Qty Ordered</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach($product as $p) {
                $i++;
                echo ' <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$p->prod_name.'</td>
                <td>'.$p->qty_available.'</td>
                <td><input type="text" class="form-control" name="qty[]" value="0">
                <input type="hidden" name="prod_code[]" value="'.$p->prod_code.'">
                <input type="hidden" name="str[]" value="'.$p->prod_name.';'.$p->loose_uom.'"></td>
            </tr>';
            }
           ?>
        </tbody>
    </table>
</div>

<div class="col-md-12">
    <div class="text-center">
        <button class="btn btn-black nextBtn col-4" type="submit">Submit</button>
    </div>
</div>
        </form>

<script>
function show_inventory() {
    var dataURL3 = '<?= base_url("neworder/showinventory"); ?>';
    $.ajax({
         type: "POST", // Method pengiriman data bisa dengan GET atau POST
         url: dataURL3, // Isi dengan url/path file php yang dituju
         data: {}, // data yang akan dikirim ke file yang dituju
         success: function(response){ // Ketika proses pengiriman berhasil
           setTimeout(function(){
             $("#loadingmodal").hide(); // Sembunyikan loadingnya
             var modal3 = $('#inventory');
             // set isi dari combobox kota
             // lalu munculkan kembali combobox kotanya
             $(modal3).html(response).show();
             //$("#ttl").hide();
           }, 100);
         },
         error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
           alert(thrownError); // Munculkan alert error
         }
       });
}
$("#form_product").submit(function(e) {
    e.preventDefault();
        
        var qty = $("input[name='qty[]']")
              .map(function(){return $(this).val();}).get();
        var prod_code = $("input[name='prod_code[]']")
              .map(function(){return $(this).val();}).get();
        var str = $("input[name='str[]']")
              .map(function(){return $(this).val();}).get();
        
        var dataString = 'qty='+qty+'&prod_code='+prod_code+'&str='+str;
        
        //$("#loadingmodal").show();
        //console.log(dataString);
    
    $.ajax({
    type:'POST',
    data:dataString,
    url:'<?= base_url("api/addinventory"); ?>',
    success:function(data) {
        //var message = data.message;
       // console.log(data);
        if(data.status == 1) {
            $("#loadingmodal").hide();
            $('#showmodal3').modal('toggle');
            show_inventory();
        } else {
            
            console.log(data);
        }
    }
    });
    
    
    //console.log("hoii");
    
    
});
</script>