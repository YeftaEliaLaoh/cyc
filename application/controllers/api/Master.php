<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Master extends REST_Controller
{

    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['set_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['productDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['convert_get']['limit'] = 500; // 500 requests per hour per user/key
       // $this->load->model(array('Api_model', 'admin/Products_model'));
        $this->allowed_img_types = $this->config->item('allowed_img_types');

        $this->load->model("login_model");
		$this->load->model("user_model");
		$this->load->model("home_model");
        $this->load->model("register_model");
        $this->load->helper('email');
        $this->load->model("feed_model");
		$this->load->model("image_model");
        $this->load->model("page_model");
        
        date_default_timezone_set('Asia/Jakarta');
    }

    
    function checkGambar($site_url,$val,$path)
    {
        $banner_img = "";
        if(!empty($val)) {
            $url = $site_url.$path.$val;
            
            $banner_img = $url;
        } 
        return $banner_img;
    }

    public function listmusic_post() 
	{
		$code = $this->input->post('cod3');
        if(isset($code)) {
           
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $name =  $this->input->post('name');
                $artist = $this->input->post('artist');
                    $warning = '';
                    $list = array();
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {
                        $status = 1;
                        $msg = "success";

                        $check = $this->user_model->get_user_by_token($token);
                        $member = array();
                        if($check->num_rows() > 0) {
                            $status = 1;

                            $msg = "success";
                            $user = $check->row();

                            $list2 = $this->page_model->get_list_music($name,$artist);
                            foreach($list2 as $l) {
                                if(!empty($l->music)) {
                                    $music = base_url("uploads/music/$l->music");
                                } else { $music = ""; }

                                if(!empty($l->image)) {
                                    $image = base_url("uploads/$l->image");
                                } else { $image = ""; }

                                $l->music = $music;
                                $l->image = $image;
                                
                                $list[] = $l;
                            }
                            
                        } else {
                            $status = -2;
                            $msg = lang("error_85");

                        }


                            
                    } else {
                        $status = -2;
                        $msg = "Empty Token";
                    }
                   
                   
            }
            else {
                $msg = "Wrong Code";
                $status = -2;

            }

            $message = [
                'status' => $status,
                'message' => $msg,
                'list' => $list
            ];
            
            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
        else {
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong key'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    
    public function getcategory_post() 
	{
		$code = $this->input->post('cod3');
        if(isset($code)) {
           
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $type =  $this->input->post('type');
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {
                        $status = 1;
                        $msg = "success";

                        $check = $this->user_model->get_user_by_token($token);
                        $member = array();
                        if($check->num_rows() > 0) {
                            $status = 1;

                            $msg = "success";
                            $user = $check->row();

                            $list = $this->page_model->get_postthread_category($type)->result();
                            
                        } else {
                            $status = -2;
                            $msg = lang("error_85");

                        }


                            
                    } else {
                        $status = -2;
                        $msg = "Empty Token";
                    }
                   
                   
            }
            else {
                $msg = "Wrong Code";
                $status = -2;

            }

            $message = [
                'status' => $status,
                'message' => $msg,
                'list' => $list
            ];
            
            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
        else {
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong key'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function listcategory_post() 
	{
		$code = $this->input->post('cod3');
        if(isset($code)) {
            $post = array();
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $type =  $this->input->post('type');
                $categoryid =  $this->input->post('category_id');
                
                $page = intval($this->input->post("page"));

                if(empty($page)) {
                    $page = 0;
                } else {
                    $page = $page-1;
                }
                $limit = 1000;

                $page = $page*$limit;

                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {
                        $status = 1;
                        $msg = "success";

                        $check = $this->user_model->get_user_by_token($token);
                        $member = array();
                        if($check->num_rows() > 0) {
                            $status = 1;
                            $msg = "success";
                            $user = $check->row();

                            $list = $this->page_model->list_postthread_category($user->ID, $page,$categoryid)->result();
                            
                            foreach($list as $l) {
                                /*
                                $l->image_file_name = $this->checkGambar(base_url(),$l->image_file_name,"uploads/");
                                $l->avatar = $this->checkGambar(base_url(),$l->avatar,"uploads/");
                                $datetime = date('d F Y H:i:s',$l->timestamp);
                                */
                                $l->avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $l->avatar;
                                if($l->premium_planid == 1) {
                                    $l->premium_planname = "Badge";
                                } else {
                                    $l->premium_planname = "User";
                                }

                                
                                if(!empty($l->image_file_name)) {
                                    $l->image_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $l->image_file_name;
                                }
                                if(!empty($l->video_file_name)) {
                                    $l->video_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $l->video_file_name;
                                }

                                $l->format_date = date('d F Y H:i A',  $l->timestamp);
                                $l->users_tag = array();
                                if($l->user_flag) {
                                         
                                    $users_tag = $this->feed_model->get_feed_users($l->ID);
                                    $us = "";
                                    $c = $users_tag->num_rows(); 
                                    $v=0;
                                    $user_t = array();
                                    foreach($users_tag->result() as $u) {
                                        $v++;
                                        $and = "";
                                        if($v == ($c-1) && $c > 0) {
                                           $and = " ".lang("ctn_302")." ";
                                        } 
                                       
                                        $us .= $u->first_name.' '.$u->last_name.$and;
                                        $img = base_url() . $this->settings->info->upload_path_relative . "/" . $u->avatar;
                                        $user_t[] = array("ID"=>$u->ID,"full_name"=>$u->first_name.' '.$u->last_name,"avatar"=>$img);
                                    }
                                    $l->users_tag = $user_t;
                                    $l->content = $l->content." ".lang("ctn_517")." ".$us;
                                } 
                                /*
                                
                                $post[] = array("ID"=>$l->ID,"content"=>$l->content,"userid"=>$l->userid,"username"=>$l->username,"first_name"=>$l->first_name,"last_name"=>$l->last_name,
                                "avatar"=>$avatar,"timestamp"=>$l->timestamp,"likes"=>$l->likes,"comments"=>$l->comments,"datetime"=>$datetime,"image_file_name"=>$image_file_name,"image_file_url"=>$l->image_file_url,"video_file_name"=>$l->video_file_name);
                                */
                                $post[] = $l;
                            }
                            
                            
                        } else {
                            $status = -2;
                            $msg = lang("error_85");

                        }


                            
                    } else {
                        $status = -2;
                        $msg = "Empty Token";
                    }
                   
                   
            }
            else {
                $msg = "Wrong Code";
                $status = -2;

            }

            $message = [
                'status' => $status,
                'message' => $msg,
                'post' => $post
            ];
            
            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
        else {
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong key'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
