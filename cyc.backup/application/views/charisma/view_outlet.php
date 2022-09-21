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
                        <div class="row">
                    
                    <input type="text" class="form-control mb-3" placeholder="Nearby Outlet">
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
                        foreach($outlet as $gc) {
                            $i++;
                            //$judul = remove_box($gc->judul);
                            $change = 'background-color: rgb(249, 249, 249);';
                            $judul = str_replace($change, '', $gc->judul);
                           // echo '<span class="text-left title"> Outlet Charisma '.$i.'</span>';
                            echo '<div class="col-sm-12 margin-bottom-1x">
                               <div class="card text-center bg-download text-white" style="padding:20px;border-radius:20px;">
                               <p class="text-center mt-2"><img src="'.base_url("icon/logo1.png").'" class="img-kontak mb-3"></p>
                                <span class="text-left">'.$judul.'</span>
                               </div>
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