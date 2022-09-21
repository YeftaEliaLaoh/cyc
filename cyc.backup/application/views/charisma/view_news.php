<?php
$fsize = "text-sm";
$fsize_head = "";
if(mobile()) {
  $fsize = "text-xs";
  $fsize_head = "text-xs";
}
?>

<style>
    
#img-res-product {
	width: 10em;
	height: auto;
	overflow: hidden;
	display: block;
	margin-left: auto;
	margin-right: auto;
}
.textoverlay {
    padding-top:10px;
    width:200px;
    margin:0 auto;
}
</style>
    
<section class="mt-2">
        <div class="container">
          <div class="row">
            <div class="col-6">
              <h3 class="text-blues text-medium <?= $fsize_head; ?>"><?= $title; ?></h3>
            </div>
            
          </div>
        </div>
            <div class="container">
                <div class="row">
                        <div class="col-2">&nbsp;</div>

                        <div class="col-8">
                <?php
                
                foreach($news as $gc) {
                    $link = "news/detail/$gc->id_news";
                    $a = $gc->description;
                    $b = (strip_tags($a));
                    $isi = substr($b,0,250); 
				    $isi = substr($b,0,strrpos($isi," "));

                     echo '<a href="'.$link.'" class="text-decoration-none"><div class="media mb-4"><img class="mr-4" id="img-res-product" src="'.$gc->img.'" width="64" alt="'.$gc->title.'">
                        <div class="media-body">
                        <h6 class="mt-0 mb-1">'.$gc->title.'</h6>
                        <span class="d-block text-sm text-muted">'.$isi.'</span>
                        </div>
                    </div></a>';
                }
                
                ?>
                        </div>
                        <div class="col-2"></div>
            </div>
                    
                    <!--
                    <nav class="pagination">
                        <div class="column">
                        <ul class="pages">
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li>...</li>
                            <li><a href="#">12</a></li>
                        </ul>
                        </div>
                        <div class="column text-right hidden-xs-down"><a class="btn btn-outline-secondary btn-sm" href="#">Next&nbsp;<i class="icon-chevron-right"></i></a></div>
                    </nav>
                    !-->
                
            </div>
             
          </div>
    </section><!-- End Crazy !-->