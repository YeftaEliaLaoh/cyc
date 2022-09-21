<form method="post" class="login-box" action="#">
   <input type="hidden" name="id" value="<?= $id; ?>">
   <input type="hidden" name="cod3" value="0k30c3">
   <div class="form-group input-group">
        <input class="form-control" type="text"  value="<?= $title; ?>" readonly><span class="input-group-addon"><i class="icon-list"></i></span>
    </div>
   <div class="form-group input-group">
        <input class="form-control" type="email" placeholder="Masukkan Email" name="email2" value="<?= $email; ?>" required><span class="input-group-addon"><i class="icon-mail"></i></span>
    </div>
    <div class="form-group input-group">
        <input class="form-control" type="text" placeholder="Masukkan Nama" name="nama" value="<?= $nama; ?>" required><span class="input-group-addon"><i class="icon-user"></i></span>
    </div>
    <div class="form-group input-group">
        <textarea name="pesan" class="form-control" placeholder="Masukkan Pesan"></textarea><span class="input-group-addon"><i class="icon-message-square"></i></span>
    </div>
    <div class="text-center text-sm-right">
        <button class="btn btn-primary margin-bottom-none" id="proses_spl" type="submit">Kirim</button>
    </div>
</form>


<script>
$("#proses_spl").click(function(e) {
		  e.preventDefault();
		  var id = $('input[name=id]').val(); 
		  var pesan = $("textarea[name=pesan]").val();
		  var email = $("input[name=email2]").val();
          var nama = $("input[name=nama]").val();
          var cod3 = $("input[name=cod3]").val();
		  
		  var dataString = 'pesan='+pesan+'&id='+id+'&email='+email+'&nama='+nama+'&cod3='+cod3;
		  
		 // alert(dataString);
		  
		  $.ajax({
			type:'POST',
			data:dataString,
			url:'<?= base_url("api/ask_produk"); ?>',
			success:function(data) {
			
			  if(data.status == 1) {
				   window.alert('Berhasil dikirim ke Indosteger.');
				  
				  location.reload();
			  } else {
				  alert(data.message);
			  }
			}
		  });
		  
		  
		  
});
</script>