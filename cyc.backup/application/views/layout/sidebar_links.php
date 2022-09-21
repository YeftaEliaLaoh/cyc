<ul class="newnav nav nav-sidebar">
           <?php if($this->user->loggedin && isset($this->user->info->user_role_id) && 
           ($this->user->info->admin || $this->user->info->admin_settings || $this->user->info->admin_members || $this->user->info->admin_payment)

           ) : ?>
              <li id="admin_sb">
                <a data-toggle="collapse" data-parent="#admin_sb" href="#admin_sb_c" class="collapsed <?php if(isset($activeLink['admin'])) echo "active" ?>" >
                  <span class="glyphicon glyphicon-wrench sidebar-icon sidebar-icon-red"></span> <?php echo lang("ctn_157") ?>
                  <span class="plus-sidebar"><span class="glyphicon <?php if(isset($activeLink['admin'])) : ?>glyphicon-menu-down<?php else : ?>glyphicon-menu-right<?php endif; ?>"></span></span>
                </a>
                <div id="admin_sb_c" class="panel-collapse collapse sidebar-links-inner <?php if(isset($activeLink['admin'])) echo "in" ?>">
                  <ul class="inner-sidebar-links">
                    <?php if($this->user->info->admin || $this->user->info->admin_settings) : ?>
                      <!--
                      <li class="<?php if(isset($activeLink['admin']['settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/settings") ?>"><?php echo lang("ctn_158") ?></a></li>
                  
                      <li class="<?php if(isset($activeLink['admin']['social_settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/social_settings") ?>"> <?php echo lang("ctn_159") ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['themes'])) echo "active" ?>"><a href="<?php echo site_url("admin/themes") ?>"> <?php echo lang("ctn_171_1") ?></a></li>
                      
                      !-->
                      <!-- <li class="<?php if(isset($activeLink['admin']['page_categories'])) echo "active" ?>"><a href="<?php echo site_url("admin/page_categories") ?>"> <?php echo lang("ctn_529") ?></a></li> -->
                      <li class="<?php if(isset($activeLink['admin']['event'])) echo "active" ?>"><a href="<?php echo site_url("admin/event") ?>"><?php echo "Events"; ?></a></li>
                      <!--
                      <li class="<?php if(isset($activeLink['admin']['gallery'])) echo "active" ?>"><a href="<?php echo site_url("admin/gallery") ?>"><?php echo "Gallery"; ?></a></li>
                      !-->
                      <li class="<?php if(isset($activeLink['admin']['music'])) echo "active" ?>"><a href="<?php echo site_url("admin/music") ?>"><?php echo "Music"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['tnc'])) echo "active" ?>"><a href="<?php echo site_url("admin/tnc") ?>"><?php echo "Term & Privacy"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['seller'])) echo "active" ?>"><a href="<?php echo site_url("admin/seller") ?>"><?php echo "Seller"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['product_category'])) echo "active" ?>"><a href="<?php echo site_url("admin/product_category") ?>"><?php echo "Product Category"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['product'])) echo "active" ?>"><a href="<?php echo site_url("admin/product") ?>"><?php echo "Product"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['provinces'])) echo "active" ?>"><a href="<?php echo site_url("admin/provinces") ?>"><?php echo "Region"; ?></a></li>
                      <li class="<?php if(isset($activeLink['admin']['city'])) echo "active" ?>"><a href="<?php echo site_url("admin/city") ?>"><?php echo "City"; ?></a></li>
                    <?php endif; ?>
                    <?php if($this->user->info->admin || $this->user->info->admin_members) : ?>
                    <li class="<?php if(isset($activeLink['admin']['members'])) echo "active" ?>"><a href="<?php echo site_url("admin/members") ?>"> <?php echo lang("ctn_160") ?></a></li>
                    <!-- <li class="<?php if(isset($activeLink['admin']['custom_fields'])) echo "active" ?>"><a href="<?php echo site_url("admin/custom_fields") ?>"> <?php echo lang("ctn_346") ?></a></li> -->
                    <li class="<?php if(isset($activeLink['admin']['reports'])) echo "active" ?>"><a href="<?php echo site_url("admin/reports") ?>"> <?php echo lang("ctn_530") ?></a></li>
                    <?php endif; ?>
                    <?php if($this->user->info->admin) : ?>
                    <!-- <li class="<?php if(isset($activeLink['admin']['user_roles'])) echo "active" ?>"><a href="<?php echo site_url("admin/user_roles") ?>"> <?php echo lang("ctn_316") ?></a></li> -->
                    <?php endif; ?>
                    <?php if($this->user->info->admin || $this->user->info->admin_members) : ?>
                    <li class="<?php if(isset($activeLink['admin']['user_groups'])) echo "active" ?>"><a href="<?php echo site_url("admin/user_groups") ?>"> <?php echo lang("ctn_161") ?></a></li>
                    <!-- <li class="<?php if(isset($activeLink['admin']['ipblock'])) echo "active" ?>"><a href="<?php echo site_url("admin/ipblock") ?>"> <?php echo lang("ctn_162") ?></a></li> -->
                    <?php endif; ?>
                    <?php if($this->user->info->admin) : ?>
                      <li class="<?php if(isset($activeLink['admin']['email_templates'])) echo "active" ?>"><a href="<?php echo site_url("admin/email_templates") ?>"> <?php echo lang("ctn_163") ?></a></li>
                    <?php endif; ?>
                    <?php if($this->user->info->admin || $this->user->info->admin_members) : ?>
                      <li class="<?php if(isset($activeLink['admin']['email_members'])) echo "active" ?>"><a href="<?php echo site_url("admin/email_members") ?>"> <?php echo lang("ctn_164") ?></a></li>
                    <?php endif; ?>
                  </ul>
                </div>
              </li>
            <?php endif; ?>
            <li class="<?php if(isset($activeLink['home']['general'])) echo "active" ?>"><a href="<?php echo site_url() ?>"><span class="glyphicon glyphicon-home sidebar-icon sidebar-icon-blue"></span> <?php echo lang("ctn_154") ?> <span class="sr-only">(current)</span></a></li>
            <li class="<?php if(isset($activeLink['members']['general'])) echo "active" ?>"><a href="<?php echo site_url("members") ?>"><span class="glyphicon glyphicon-user sidebar-icon sidebar-icon-green"></span> <?php echo lang("ctn_155") ?></a></li>
            <li class="<?php if(isset($activeLink['settings']['general'])) echo "active" ?>"><a href="<?php echo site_url("user_settings") ?>"><span class="glyphicon glyphicon-cog sidebar-icon sidebar-icon-pink"></span> <?php echo lang("ctn_156") ?></a></li>
            
      
          </ul>