<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Product extends REST_Controller
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
        $this->load->model("admin_model");

        date_default_timezone_set('Asia/Jakarta');
    }

    
    public function list_category_post()
    {
        $code = $this->input->post('cod3');
        $posts = array();
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');

                $limit =  $this->input->post('limit');
                $page =  $this->input->post('page');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            if(empty($page)) {
                                $page = 0;
                            } else {
                                $page = $page-1;
                            }
            
                            $page = $page*$limit;
                            
                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();
                               
                                $post = $this->admin_model->get_category_product($limit,$page)->result();
                                foreach($post as $p) {
                                    $img = "";
                                    if(!empty($p->image)) {
                                        $img = base_url() . $this->settings->info->upload_path_relative . "/" . $p->image;
                                    }
                                    $p->image = $img;
                                    $posts[] = $p;
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
                'data' => $post
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

    public function list_event_post()
    {
        $code = $this->input->post('cod3');
        $posts = array();
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $region = $this->input->post('region');

                $limit =  $this->input->post('limit');
                $page =  $this->input->post('page');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            if(empty($page)) {
                                $page = 0;
                            } else {
                                $page = $page-1;
                            }
            
                            $page = $page*$limit;
                            
                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();
                               
                                $post = $this->admin_model->get_list_event($region,$limit,$page)->result();
                                foreach($post as $p) {
                                    $img = "";
                                    if(!empty($p->image)) {
                                        $img = base_url() . $this->settings->info->upload_path_relative . "/" . $p->image;
                                    }

                                    $p->format_date = date('d F Y H:i A',  $p->timestamp);

                                    $p->image = $img;

                                    $posts[] = $p;
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
                'data' => $post
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

    public function list_post()
    {
        $code = $this->input->post('cod3');
        $posts = array();
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $categoryid = $this->input->post('category');

                $limit =  $this->input->post('limit');
                $page =  $this->input->post('page');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            if(empty($page)) {
                                $page = 0;
                            } else {
                                $page = $page-1;
                            }
            
                            $page = $page*$limit;
                            
                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();
                               
                                $post = $this->admin_model->get_list_product($categoryid,$limit,$page)->result();
                                foreach($post as $p) {
                                    $img = "";
                                    if(!empty($p->image)) {
                                        $img = base_url() . $this->settings->info->upload_path_relative . "/" . $p->image;
                                    }
                                    $img_seller = "";
                                    if(!empty($p->seller_image)) {
                                        $img_seller = base_url() . $this->settings->info->upload_path_relative . "/" . $p->seller_image;
                                    }

                                    $p->price = "Rp ".number_format($p->price);
                                    $p->image = $img;
                                    $p->seller_image = $img_seller;
                                    $posts[] = $p;
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
                'data' => $post
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

    public function detail_post()
    {
        $code = $this->input->post('cod3');
        $posts = array();
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $id = $this->input->post('id');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();
                               
                                $post = $this->admin_model->get_product_detail($id)->result();
                                foreach($post as $p) {
                                    $img = "";
                                    if(!empty($p->image)) {
                                        $img = base_url() . $this->settings->info->upload_path_relative . "/" . $p->image;
                                    }
                                    $img_seller = "";
                                    if(!empty($p->seller_image)) {
                                        $img_seller = base_url() . $this->settings->info->upload_path_relative . "/" . $p->seller_image;
                                    }

                                    $p->price = "Rp ".number_format($p->price);
                                    $p->image = $img;
                                    $p->seller_image = $img_seller;
                                    $posts[] = $p;
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
                'data' => $post
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
