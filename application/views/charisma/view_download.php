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
    width:auto;
    height:10em;
}

</style>

<section class="mt-2 mb-5">
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
                        //var_dump($download);
                        foreach($download as $gc) {
                            $url = base_url("download/detail/$gc->id_kategori");
                            $id = $gc->id_kategori;
                           // $url = API_URL."master/download/$id";
                            echo '<div class="col-sm-3 margin-bottom-1x">
                            <a href="'.$url.'" class="text-decoration-none">
                                        <div class="card text-center bg-download" style="border-radius:20px;">
                                            <div class="card-body">
                                                <img src="'.$gc->image.'" class="img-download mb-2">
                                                <p class="card-text text-white">'.$gc->nama_kategori.'</p>
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