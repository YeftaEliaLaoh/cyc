<?php
$plink = "";
$plheader = "";
?>
<!-- Topbar On Desktop !-->
<header class="site-header navbar-sticky"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Navbar-->
        <div class="navbar">
            
          <div class="topbar d-flex justify-content-between">
            <!-- Logo-->
            <div class="site-branding d-flex">
              <a class="site-logo align-self-center" href="<?= base_url(); ?>"><img src="<?php echo base_url("icon/logo1.png");?>" alt="charisma"></a>
            </div>
            
            <!-- Search / Categories-->
            <div class="search-box-wrap d-flex col-4">
              <div class="search-box-inner align-self-center">
                <div class="search-box d-flex">
                  
                
                  <div class="form-gr">
                    <form class="input-group" method="post" action="<?= base_url("listproduct/search"); ?>" id='form-search'>
                      <div class="input-group">
                        <input class="form-control form-control-lg" type="text" name="keyword" placeholder="Search...">
                        
                        <span class="input-group-addon"><i class="icon-search"></i></span>
                      </div>
                    </form>
                  </div>
                  

                </div>
              </div>
            </div>
            <?php
            if(!empty($this->session->id)) { ?>
            <div class="toolbar d-flex" style="margin-right:5%;margin-top:1%;">
            <div class="btn-group">
              <a href="<?= base_url("checkout") ?>">
                <img src="<?= base_url("icon/cart.png"); ?>">
              </a>
            </div>
            <div class="btn-group">
              <a href="<?= base_url("chat") ?>">
               <img src="<?= base_url("icon/chat.png"); ?>">
              </a>
            </div>
             
              <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome <?= $this->session->nama; ?> </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="<?= base_url('profile'); ?>">Profile</a>
                  <a class="dropdown-item" href="<?= base_url('api/logout'); ?>">Logout</a>
                </div>
              </div>
            </div>
            <?php
            } else {?>
            <div class="toolbar d-flex" style="margin-right:5%;">
              <a class="btn hidden-on-mobile text-white" style="margin-top:6%;font-size:2em;" id='openregister'  href="#" data-book-id='1' data-toggle='modal' data-target='#showmodalregister' data-header="Daftar" data-href='<?= base_url("register"); ?>'>Register</a> 
              <span class="btn hidden-on-mobile text-white" style="margin-top:6%;font-size:2em;">|</span>
              <a class="btn hidden-on-mobile text-white" style="margin-top:6%;font-size:2em;" id='openlogin' href="#" data-book-id='1' data-toggle='modal' data-target='#showmodalregister' data-header="Login" data-href='<?= base_url("register/login"); ?>'>Login</a>
            </div>
            <?php } ?>
        </div>
        </div>
      </header>