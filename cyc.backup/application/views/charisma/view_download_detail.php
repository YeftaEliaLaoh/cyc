<?php
$fsize = "text-sm";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-xs";
  $fsize_head = "text-xs";
}
?>

<style>
.title {
    color:#000;
    font-weight:bold;
    font-size:25px;
}

.bg-download {
    background-color:#1b245d;
}

.img-download {
    width:40px;
    height:40px;
}

</style>

<section class="mt-2 mb-5" <?= $height; ?>>
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>"><?= $title; ?></h3>
            </div>
            
          </div>
        </div>

        <div class="container text-center">
            <div class="container">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-9">
                        <div class="row">


                        <?php
                        
                        foreach($download as $gc) {
                            //$url = base_url("download/detail/$gc->id_kategori");
                            $url = API_URL."master/download/$gc->id_catalogue";
                            echo '<div class="col-sm-12 margin-bottom-1x">
                            <a href="'.$url.'" class="text-decoration-none" target="_blank">
                               <div class="card text-center bg-download" style="border-radius:20px;">
                                   <div class="row text-white" style="padding:10px;">
                                       <div class="col-3"><img src="'.base_url("icon/logo1.png").'"></div>
                                       <div class="col-7 text-left">'.$gc->judul.'</div>
                                       <div class="col-2"><img class="img-download" src="'.base_url("icon/download.png").'"></div>
                                   </div>
                               </div>
                               </a>
                            </div>';
                        }
                        
                        ?>
                            

                        
                        </div>
                            
                    </div>
                    <div class="col-1"></div>

                </div>

            </div>
        </div>
             
          </div>
    </section><!-- End Crazy !-->