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
    color:#1b245d;
    font-weight:bold;
    font-size:20px;
}

.bg-download {
    background-color:#1b245d;
}

.img-kontak {
    width:25%;
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
                    
                        <?php
                        echo '<div class="col-sm-12 margin-bottom-1x">
                        <a href="'.base_url("outlet/factory").'" class="text-decoration-none">
                          <div class="card text-center bg-download text-white" style="padding:20px;border-radius:20px;">
                          <p class="text-center mt-2"><img src="'.base_url("icon/logo1.png").'" class="img-kontak mb-3"></p>
                          <span class="text-left">Our Factory<br> Jl. Raya Narogong KM12, Pangkalan 2 No. 2<br> Bantar Gebang - Bekasi</span>
                          </div>
                          </a>
                      </div>';
                        $i = 0;
                        foreach($factory as $gc) {
                            $judul = $gc->judul;
                            $img = $gc->img;
                            $slide = null;
                            if(!empty($img)){
                                $slide .= '<div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false,&quot;margin&quot;: 20, &quot;loop&quot;: false, &quot;autoplay&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2}, &quot;470&quot;:{&quot;items&quot;:2},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:2},&quot;1200&quot;:{&quot;items&quot;:2}} }">';
                                foreach($img as $im) {
                                   // $slide .= $im;
                                   $slide .= "<img src='$im'>";
                                }
                                $slide .= "</div>";
                            }
                            
                            echo '<div class="card bg-white text-center mb-3">
                            <div class="card-header bg-secondary text-lg">'.$judul.'</div>
                            <div class="card-body">
                              '.$slide.'
                            </div>
                          </div>';
                        }
                        
                        ?>
                            
                            
                    </div>
                    <div class="col-1"></div>

                </div>

            </div>
        </div>
             
          </div>
    </section><!-- End Crazy !-->