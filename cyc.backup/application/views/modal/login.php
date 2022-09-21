<div class="row">
    <div class="container">
        <form method="post" action='#' id='form_login'  class="col-sm-12">
            <div class="alert-login"></div>
            <div class="form-group input-group">
                <input class="form-control" type="text" placeholder="User Id" name="email" required><span class="input-group-addon"><i class="icon-mail"></i></span>
            </div>
            <div class="form-group input-group">
                <input class="form-control" type="password" placeholder="Password" name="passw" required><span class="input-group-addon"><i class="icon-lock"></i></span>
            </div>
            <div class="d-flex flex-wrap justify-content-between padding-bottom-1x">
                <div class="custom-control custom-checkbox">
                </div><a class="navi-link text-normal" onclick="forgot();" href="#">Forgot password?</a>
            </div>
            <div class="text-center">
            
                <button class="col-xl-11 btn btn-primary margin-bottom-none" id="login-submit" type="submit" style="color:#ffffff;">Login</button>
            </div>
        </form>

        <form method="post" style="display:none;" action='#' id='form_forgot'  class="col-sm-12">
            
            <h3 class="text-center">Reset Password</h3>
            <p>Enter your email to receive instructions on how to reset your password.</p>
            <div class="alert-forgot"></div>
            <div class="success-forgot"></div>
            <div class="form-group input-group">
                <input class="form-control" type="text" placeholder="Your Email" name="email_forgot" required><span class="input-group-addon"><i class="icon-mail"></i></span>
            </div>

            <div class="text-center">
            
                <button class="col-xl-11 btn btn-primary margin-bottom-none" id="forgot-submit" type="submit" style="color:#ffffff;">Reset Password</button><br>
                <span>Or return to <a href="#" onclick="notforgot();" class="text-decoration-none">LOGIN</a></span>
            </div>
        </form>
    </div>
</div>

<script>
function forgot() {
    $("#form_login").hide();
    $("#form_forgot").show();
}
function notforgot() {
    $("#form_login").show();
    $("#form_forgot").hide();
}


$('#form_forgot').submit(function(e) {
          e.preventDefault();
          var email = $('input[name=email_forgot]').val();
          var dataString = 'email='+email;
          
          $("#forgot-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#forgot-submit').attr('disabled',false);
          $.ajax({
          type:'POST',
          data:dataString,
          url:"<?= base_url('api/forgot'); ?>",
          success:function(data) {
            var message = data.message;
            if(data.status == 1) {
                $(".success-forgot").html('<div class="alert alert-success alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-alert-triangle"></i>&nbsp;&nbsp;<span class="text-medium text-green">'+message+'</div>');
              setTimeout(function(){
                location.reload();
              }, 1000);
              
            } else {
              $(".alert-forgot").html('<div class="alert alert-danger alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-alert-triangle"></i>&nbsp;&nbsp;<span class="text-medium">'+message+'</div>');
            }
            $("#forgot-submit").html('Kirim');
            $('#forgot-submit').removeAttr('disabled');
            
          }
          });
    });

$('#form_login').submit(function(e) {
          e.preventDefault();
          var email = $('input[name=email]').val(); 
          var password = $("input[name=passw]").val();
          var dataString = 'email='+email+'&password='+password;
          
          $("#login-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#login-submit').attr('disabled',false);
          $.ajax({
          type:'POST',
          data:dataString,
          url:"<?= base_url('api/login_user'); ?>",
          success:function(data) {
            console.log(data);
            var message = data.message;
            if(data.status == 1) {
              location.reload();
            } else {
              $(".alert-login").html('<div class="alert alert-danger alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-alert-triangle"></i>&nbsp;&nbsp;<span class="text-medium">'+message+'</div>');
            }
            $("#login-submit").html('Masuk');
            $('#login-submit').removeAttr('disabled');
            
          }
          });
          
    });
</script>