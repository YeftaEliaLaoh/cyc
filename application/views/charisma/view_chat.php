<?php
$fsize = "text-lg";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-sm";
  $fsize_head = "text-sm";
}
?>
<style>
    .chat-message {
    width: 100%;
    padding:10px;
	min-height: 380px;
	background-position: center;
	background-color: #ffffff;
	background-repeat: no-repeat;
	background-size: cover;
	overflow: hidden
}
</style>
<section class="container mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>">Chat</h3>
            </div>
            
          </div>
        </div>
<div class="chat-message mb-3" style="overflow-y: scroll; height:100px;">
    
<?php
$str = "";
foreach($chat as $c) {
    if($c->user_id_from == $this->session->id) {
        $str .= '<div class="row ml-1 mb-3"><div class="col-lg-5">
            
        </div>
        <div class="col-lg-6 ml-5 card bg-primary">
            <div class="media mb-4">
                <div class="media-body">
                    <h6>Me</h6>
                    <span class="d-block text-sm text-white">'.$c->content.'</span>
                </div>
            </div>
        </div></div>';
    } else {
        $str .= '<div class="row ml-1 mb-3"><div class="col-lg-6 card bg-grey mb-2">
        <div class="media mb-4">
            <div class="media-body">
                <h6>'.$c->dari.'</h6>
                <span class="d-block text-sm text-white">'.$c->content.'</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        
    </div></div>';
    }
}
echo $str;
?>
<!--
        <div class="col-lg-6 card bg-grey mb-2">
            <div class="media mb-4">
                <div class="media-body">
                    <h6>Dedi</h6>
                    <span class="d-block text-sm text-black2">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            
        </div>


        <div class="col-lg-5">
            
        </div>
        <div class="col-lg-6 ml-5 card bg-primary">
            <div class="media mb-4">
                <div class="media-body">
                    <h6>Me</h6>
                    <span class="d-block text-sm text-black2">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                </div>
            </div>
        </div>
        !-->
        <!--
        <div class="col-lg-6 card bg-primary" style="float:right;">
            <div class="media mb-4">
                <div class="media-body text-right">
                <span class="d-block text-sm text-black2">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                </div>
            </div>
        </div>
        !-->
    
    <div id="buttomchat"></div>
</div>
<div class="row">
    <div class="form-group col-10">
        <div class="input-group form-group">
            <span class="input-group-btn">
                <button><i class="icon-cross"></i></button>
            </span>
            <form method="post" action='#' id='form_chat'  class="col-sm-12">
            <input class="form-control form-control-square" placeholder="Type a Message" type="text" name="content">
        </div>
        
    </div>
    <div class="form-group col-2">
         <button class="btn btn-square btn-black" id="chat-submit" type="submit" style="padding:0px;margin-top:-0.3%;"><span class="icon_send"></span></button>
        </div>
</div>
</section>

<script>
$('#form_chat').submit(function(e) {
          e.preventDefault();

          var form = $(this);

          $("#chat-submit").html('<i class="fa fa-spinner fa-spin"></i>Loading');
          $('#chat-submit').attr('disabled',false);
          $.ajax({
          type:'POST',
          data:form.serialize(),
          url:"<?= base_url('api/chat'); ?>",
          success:function(data) {
            console.log(data);
            var message = data.message;
            if(data.status == 1) {
             // $( "#successcart" ).trigger( "click");
              window.location.href='<?= base_url("chat") ?>';
            } else {
                $( "#wrongcart" ).trigger( "click");
            }
            $("#checkout-submit").html('<span class="icon_send"></span>');
            $('#checkout-submit').removeAttr('disabled');
            
          }
          });
          
    });
    </script>