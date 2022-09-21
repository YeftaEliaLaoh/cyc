<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller
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
    }

    /*
     * Get All Products
     */

    /*
     * Set Product
     */

     public function logout_get() {
        $this->session->sess_destroy();
		redirect(base_url());
     }

     public function register_user_post()
    {
       
       $url = API_URL."member/reg";
       /*
        $post = array(
            "email" => $email,
            "password" => $passw,
        );
        */
        $post = $this->input->post();
        $obj = postlogin($url, $post);
        //var_dump($obj);
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
               $status = 1;
               $msg = "Register Berhasil, mohon cek email untuk konfirmasi.";
               
            } else {
                $status = -1;
                $msg =  $obj->message;
            }
        } else {
            $status = -1;
            $msg = "Register Failed";
        }

        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    
    public function edit_member_post()
    {
       
       $url = API_URL."member/reg";
       /*
        $post = array(
            "email" => $email,
            "password" => $passw,
        );
        */
        $id_member = $this->input->post("id_member");
        $nama_member = $this->input->post("nama_member");
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $dob = $this->input->post("dob");
        $alamat = $this->input->post("alamat");
        $type = $this->input->post("type");
        $phone = $this->input->post("phone");
        //$photo = $this->input->post("photo");
        if(!empty($_FILES['designImage']['tmp_name'])) {
            $cfile = new CURLFile($_FILES['designImage']['tmp_name'], $_FILES['designImage']['type'],$_FILES['designImage']['name']);
           
        $post = array("id_member"=>$id_member,"nama_member"=>$nama_member,"email"=>$email,"password"=>$password,"dob"=>$dob,"alamat"=>$alamat,
            "phone"=>$phone,"type"=>$type,"photo"=>$cfile);
        } else {
            $post = array("id_member"=>$id_member,"nama_member"=>$nama_member,"email"=>$email,"password"=>$password,"dob"=>$dob,"alamat"=>$alamat,
        "type"=>$type,"phone"=>$phone);
        }

       
        $obj = postwithfiles($url, $post);
        //var_dump($obj);
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
               $status = 1;
               $msg = "Update Berhasil";
               
            } else {
                $status = -1;
                $msg =  $obj->message;
            }
        } else {
            $status = -1;
            $msg = "Update Failed";
        }

        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    public function upgrade_post()
    {
       
       $url = API_URL."member/upd_account";
       /*
        $post = array(
            "email" => $email,
            "password" => $passw,
        );
        */
        $id_member = $this->input->post("id_member");
        $type = $this->input->post("type");
        $bergerak_dibidang = $this->input->post("bergerak_dibidang");
        $pertanyaan1 = $this->input->post("pertanyaan1");
        $produk_biasa_dipakai = $this->input->post("produk_biasa_dipakai");
        $pertanyaan2 = $this->input->post("pertanyaan2");

        $post = array(
            "id_member" => $id_member,
            "type" => $type,
            "bergerak_dibidang" => $bergerak_dibidang,
            "pertanyaan1" => $pertanyaan1,
            "produk_biasa_dipakai" => $produk_biasa_dipakai,
            "pertanyaan2" => $pertanyaan2
        );
       
        
        //echo $file_name_with_full_path;
        $obj = postregister($url, $post);
        //var_dump($obj);
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
               $status = 1;
               $msg = "Update Berhasil";
               
            } else {
                $status = -1;
                $msg =  $obj->message;
            }
        } else {
            $status = -1;
            $msg = "Update Failed";
        }

        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    public function login_user_post()
    {
       $email = $this->input->post("email");
       $passw = $this->input->post("password");
       $url = API_URL."member/login";
        $post = array(
            "email" => $email,
            "password" => $passw
        );
        $obj = postlogin($url, $post);
        
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
                //$status = 1;
                $status = 1;
               $msg = $obj->err_msg;
               $d = $obj->data;
               $id = $d->id_member;
               $nama = $d->nama;
               $dob = $d->dob;
               $email = $d->email;
               $type = $d->type;
               $type_name = $d->type_name;
               $photo = $d->photo;
               $bergerak_dibidang = $d->bergerak_dibidang;
               $produk_biasa_dipakai = $d->produk_biasa_dipakai;
    
               $this->session->set_userdata(array('id'=>$id,'nama'=>$nama,'email'=>$email,'type'=>$type,'type_name'=>$type_name,'photo'=>$photo,'bergerak_dibidang'=>$bergerak_dibidang
               ,'produk_biasa_dipakai'=>$produk_biasa_dipakai));
               
            } else {
                $status = -1;
               $msg =  $obj->err_msg;
            }
        } else {
            $status = -1;
            $msg = "Login Failed";
        }
        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    
    public function checkout_post()
    {
       $id_city = $this->input->post("kota");
       $alamat = $this->input->post("alamat");
       $kirim = $this->input->post("kirim");
       $notes = $this->input->post("notes");

       $u = explode(';', $kirim);
        $courir_service = $u[0];
        $ongkir = $u[1];

        $cart =  $this->session->userdata('cart');
        $items = array();
        foreach($cart as $c) {
            $items[] = array("id_product"=>$c['id'],"id_variant"=>$c['varian'],"quantity"=>$c['qty']);
        }

       $url = API_URL."transaksi";
       $id_member = $this->session->id;
        $post = array(
            "id_member" => $id_member,
            "alamat" => $alamat,
            "id_city" => $id_city,
            "ongkir"=>$ongkir,
            "courir_service" => $courir_service,
            "notes" => $notes,
            "items" => json_encode($items)
        );
        
        $obj = postlogin($url, $post);
        
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
                //$status = 1;
                $status = 1;
                $msg = $obj->message;
                $this->session->unset_userdata("cart");
            } else {
                $status = -1;
               $msg =  $obj->err_msg;
            }
        } else {
            $status = -1;
            $msg = "Submit Failed";
        }
        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
       
        
    }

    
    public function chat_post()
    {
       $content = $this->input->post("content");
       $id_member = $this->session->id;

       $url = API_URL."member/chat";
        $post = array(
            "user_id_member" => $id_member,
            "content" => $content
        );
        
        $obj = postlogin($url, $post);
        
        $msg = "";
        $status = 0;
        if(!empty($obj->err_code)) {
            if($obj->err_code == 00) {
                //$status = 1;
                $status = 1;
                $msg = $obj->message;
            } else {
                $status = -1;
               $msg =  $obj->err_msg;
            }
        } else {
            $status = -1;
            $msg = "Submit Failed";
        }
        
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
       
        
    }

    
    public function updatetotal_post()
    {
       $subtotal = $this->input->post("s");
       $kirim = $this->input->post("k");
       
        $status = 1;
        $u = explode(';', $kirim);
        $courir_service = $u[0];
        $ongkir = $u[1];
        $total = harga($subtotal+$ongkir);
        $kirim = harga($ongkir);

        $message = [
            'status' => $status,
            'biayakirim' => $kirim,
            'total' => $total
        ];    
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    public function checkprice_post()
    {
       $harga = $this->input->post("harga");
       $qty = $this->input->post("qty");
       

        $msg = "";
        $status = 0;
        $price = 0;
        if(!empty($harga)) {
            //$status = 1;
            $status = 1;
            $price = harga($harga*$qty);
           
        } else {
            $status = -1;
           $msg =  "Harga Kosong";
        }
        
        $message = [
            'status' => $status,
            'message' => $msg,
            'price' => $price
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    
    
    public function cekongkir_post()
    {
        $kota = $this->input->post('kota');
        $w = $this->input->post('weight');
		//$type = $this->input->get('type');
        $url = API_URL."transaksi/cek_ongkir";
        $post = array(
            "id_city" => $kota,
            "weight" => $w
        );
        $obj = postlogin($url, $post);
        
        $data = "";
        if(!empty($obj)) {
            $data = "<option value=''>Pilih Pengiriman</option>";
            if(!empty($obj->data)) {
                foreach($obj->data as $r) {
                    $harga = harga($r->biaya);
                    $name = $r->service_charisma.' '.$harga;
                    if(!empty($r->id_service_charisma)) {
                        $data .= "<option value='".$r->id_service_charisma.";".$r->biaya."'>".$name."</option>";
                    } else {
                        $data = "";
                    }
                    
                }
            } else {
                $data = "";
            }

        }
        $callback = array('data_kirim'=>$data); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

        echo json_encode($callback);
    }

    
    public function kota_post()
    {
        $p = $this->input->post('provinsi');
		//$type = $this->input->get('type');
        $url = 'transaksi/city?province='.$p;
        $gc = url_get($url);
        if(!empty($gc->data)) {
			$kota = $gc->data;
		} else {
			$kota = array();
		}
        
        $data = "";
        if(!empty($kota)) {
            $data = "<option value=''>Pilih Kota</option>";
            foreach($kota as $r) {
                $data .= "<option value='".$r->id_city."'>".$r->nama_city."</option>";
            }
        }
        $callback = array('data_kota'=>$data); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

        echo json_encode($callback);
    }

    public function addcart_post()
    {
        $id = $this->input->post("id");
        $v = $this->input->post("v");
        $qty = $this->input->post("qty");
        $w = $this->input->post("w");
        $nama = $this->input->post("nama");
        $img = $this->input->post("img");
        $harga = $this->input->post("harga");

        $u = explode(';', $v);
        $id_var = $u[0];
        $nama_var = $u[1];

        $old_products =  $this->session->userdata('cart');
        
        if(empty($old_products)) {
            $products[] = array("qty"=>$qty,"id"=>$id,"varian"=>$id_var,"nama_varian"=>$nama_var,"weight"=>$w,"nama"=>$nama,"img"=>$img,"harga"=>$harga);
             $this->session->set_userdata('cart', $products);
        } else {
            $products = array("qty"=>$qty,"id"=>$id,"varian"=>$id_var,"nama_varian"=>$nama_var,"weight"=>$w,"nama"=>$nama,"img"=>$img,"harga"=>$harga);
            array_push($old_products, $products);
            $this->session->set_userdata('cart', $old_products);
        }
        $status = 1;
        $msg = "Berhasil";
        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    
    public function deletecart_post() {
        $id = $this->input->post('id');

        $k = 0;
        $b = 0;
        foreach($_SESSION['cart'] as $d) {
            // echo $d['id'][$id];
            $k++;
            if($d['id'] == $id) {
                $b = $k;
            }
            
        }
        
        if(!empty($b)) {
            $b = $b-1;
            unset($_SESSION['cart'][$b]);
        }
        
        
        echo $str;
         
     }


    public function forgot_post()
    {
       $email = $this->input->post("email");
       $url = API_URL."member/forgot";
       $post = array(
        "email" => $email
        );
        //$obj = post_to_url($url,$post);
        $obj = postlogin($url, $post);
        $msg = "Wrong Email";
        $status = 0;
        if($obj->err_code == 00) {
            //$status = 1;
            $status = 1;
            if(!empty($obj->err_msg)) {
                $msg = $obj->err_msg;
            }
            
        } else {
            $status = -1;
            $msg = $obj->err_msg;
        }

        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }

    public function register_post()
    {
        $a = $this->input->post("name");
       $b = $this->input->post("email");
       $c = $this->input->post("dob");
       $d = $this->input->post("phone");
       $e = $this->input->post("address");
       $f = $this->input->post("password");
       $g = $this->input->post("type");
       $h = $this->input->post("bidang");
       $i = $this->input->post("produk");
       $p1 = $this->input->post("pertanyaan1");
       $p2 = $this->input->post("pertanyaan2");

       $url = API_URL."member/reg";
       $post = array(
        "nama_member" => $a,
        "email" => $b,
        "password" => $f,
        "dob" => $c,
        "alamat" => $e,
        "phone" => $d,
        "type" => $g,"pertanyaan1" => $p1,"pertanyaan2" => $p2,"bergerak_dibidang" => $h,"produk_biasa_dipakai" => $i
        );
        //$obj = post_to_url($url,$post);
        $obj = postlogin($url, $post);
        $msg = "Wrong Email";
        $status = 0;
        if($obj->err_code == 00) {
            //$status = 1;
            $status = 1;
            if(!empty($obj->err_msg)) {
                $msg = $obj->err_msg;
            }
            
        } else {
            $status = -1;
            $msg = $obj->err_msg;
        }

        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }

    public function shipmentaction_post()
    {
        $hs = "4";
        $company = $this->input->post("company");
        $caddress = $this->input->post("add");
        $daddress = $this->input->post("delivery_address");
        $dunit = $this->input->post("dimensi");
        $email = $this->input->post("email");

        $timearrival = tgl_simpan($this->input->post("datd"));
        $timedeparture = tgl_simpan($this->input->post("datl"));
        $ftype = $this->input->post("freight");
        if($ftype == 1) {
            $ftype = "Sea Freight";
        } else if($ftype == 2) {
            $ftype = "Air Freight";
        } else {
            $ftype = "In Land";
        }
        $goodsdesc = $this->input->post("desc");
        $goodstype = $this->input->post("goods");
        $name = $this->input->post("name");
        $ndelivery = 0;
        $ndestination = 0;
        $npickup = 0;
        $phone = $this->input->post("phone");

        $paddress = $this->input->post("pick_address");
        $pdci = dc_name($this->input->post("cid"));
        $pdco = dc_name($this->input->post("cod"));
        $pddi = $this->input->post("did");

        $plci = dc_name($this->input->post("cil"));
        $plco = dc_name($this->input->post("col"));
        $pldi = $this->input->post("dil");
        $pod = $this->input->post("pd");
        $pol = $this->input->post("pl");

        $saddress = $this->input->post("adl");

        $status = "I";
        $weightunit = $this->input->post("weight");
        $ym = $this->input->post("message");

        
        if(!empty($this->session->userdata('products_truck'))) {
            $ptruck = $this->session->userdata('products_truck');
            foreach($ptruck as $p) {
                $detail_truck[] = array("type"=>$p['type'],"qty"=>$p['qty']);
            }
        } else {
            $detail_truck = array();
        }

        if(!empty($this->session->userdata('products_sea'))) {
            $psea = $this->session->userdata('products_sea');
            foreach($psea as $p3) {
                $detail_freight[] = array("type"=>$p3['type'],"qty"=>$p3['qty'],"weight"=>$p3['weight']);
            }
        } else {
            $detail_freight = array();
        }

        if(!empty($this->session->userdata('products'))) {
            $prod = $this->session->userdata('products');
            foreach($prod as $p2) {
                $height = $p2['h'];
                $width = $p2['w'];
                $length = $p2['l'];
                $type = $p2['type'];
                $weight = $p2['weight'];
                $qty = $p2['qty'];
                $obs = array();
              
                
                $details[] = array("height"=>$height,"length"=>$length,"qty"=>$qty,"type"=>$type,"weight"=>$weight,"width"=>$width,"changed"=>false,"observers"=>$obs);
            }
        } else {
            $details = array();
        }
       
      
        //$detail_freight = array();
        //$detail_truck[] = array("type"=>2,"qty"=>2);
        //$detail_truck = array();
       /*
        $height = 10;
        $length = 10;
        $qty = 1;
        $type = "pallet";
        $weight = "10.0";
        $width = "10.0";
        $obs = array();
        $details[] = array("height"=>$height,"length"=>$length,"qty"=>$qty,"type"=>$type,"weight"=>$weight,"width"=>$width,"changed"=>false,"observers"=>$obs);
       */
     // $details = array();
        $post = array(
            "cargo_value_hs_code" => $hs,
            "company" => $company,
            "consigneeaddress" => $caddress,
            "delivery_address" => $daddress,
            "dimensionalUnit" => $dunit,
            "email" => $email,
            "estimatetimearrival" => $timearrival,
            "estimatetimedeparture" => $timedeparture,
            "freighttype" => $ftype,
            "goodsdescription" => $goodsdesc,
            "goodstype" => $goodstype,
            "name" => $name,
            "need_delivery" => $ndelivery,
            "need_destination" => $ndestination,
            "need_pickup" => $npickup,
            "phone" => $phone,
            "pickup_address" => $paddress,
            "pod_city" => $pdci,
            "pod_country" => $pdco,
            "pod_district" => $pddi,
            "pol_city" => $plci,
            "pol_country" => $plco,
            "pol_district" => $pldi,
            "portofdischarge" => $pod,
            "portofloading" => $pol,
            "shipmen_inquery_id" => null,
            "shipperAddress" => $saddress,
            "status" => $status,
            "weightunit" => $weightunit,
            "yourmessage" => $ym,
            "pod_country_wpc" => 1,
            "pod_city_wpc" => 1,
            "goods_type_wpc" => 1,
            "freight_type_wpc" => 1,
            "dimensional_unit_wpc" => 1,
            "weight_unit_wpc" => 1,
            "pol_country_wpc" => 1,
            "pol_city_wpc" => 1,
            "detail_truck" => $detail_truck,
            "detail_freight" => $detail_freight,
            "detail" => $details
        );
        $json = json_encode($post);
       $token = $this->session->token;
       //$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQxYWFmYTEwNGQ2MGEzN2I5OGIwMzBjMWNjMDIxMTRiNzJhOTNkOTkxNjliYmIwYTI3MzNiOTNmZWY2YTIzMjhlOTMwOWYwMTdhODFjNTQ0In0.eyJhdWQiOiIyIiwianRpIjoiNDFhYWZhMTA0ZDYwYTM3Yjk4YjAzMGMxY2MwMjExNGI3MmE5M2Q5OTE2OWJiYjBhMjczM2I5M2ZlZjZhMjMyOGU5MzA5ZjAxN2E4MWM1NDQiLCJpYXQiOjE1NzM1Njc0OTIsIm5iZiI6MTU3MzU2NzQ5MiwiZXhwIjoxNTczNjUzODkyLCJzdWIiOiIxNyIsInNjb3BlcyI6WyIqIl19.a2mZP3DXU8pEGlC3-4qWgR28jBR6U5Q2IlMA_JeH1PxHXG5_Anm9LYq98tg-amtTscAeXc8bFbl1p7HtQEZbYsiSuycOWxAaVWlV_VCGwFs6ZUjdOfBvWFy-N-e65oDckfxU0d2teTFKgvOOadtZZ1D5QErEmASOVTTld4J61RMIPp5GvrLy_O_1NtvSiMXjNRp5rpfQ9km7P8syka-0BiU-rEkVrw3HRpJV6H--fACYdgIa_loBkOack1X27J3i1B7ZDhiG2V-iVcbx08dqjlzMmqlWdp2mnH8oV2QmRVr7wl6EpGlXviGacMND3xbqenmMEggAd7rutQdqkjbM9gKM4-Fl4jU0VoyPv-8PqJZdSoJB2kqq597kTQkN8gi5-OF5djeYZP5rU2CcFWbMCVKQ7PSkkHTwrX59e2-F51IniNyJwoedOkDL-_0xJtAU90KMmew9DXpvYc_B_BoxrugTyLD3Xd9W-JA41f1bl7zUCYDhJQSiArt2AOo7oWs20X0tvDQwuwEb5knc1AKFH8sNL5Ka2uAn-Hm8D6-Mt1pvO2uXioH1uhuTxspjonmPdLlubplJU2111Do0M5b8rnoxzYxr3-7sOHukWOp1CEsCFis0o4hqhy8rzN2ju7_EpJfg8c_gQIgL2EM3otO2GaYSthPivKkgGmnHoIJWMJY";
       $url = API_URL."action_shipment_inquery";
       $obj = post_token($url,$json,$token);

       
       if(!empty($obj)) {
            if($obj->error_code == 2) {
                $status = 1;
                $msg = $obj->message;
            } else {
                $status = -1;
                $msg = $obj->message;
            }
       } else {
           $status = -1;
           $msg = "Server Error";
       }
        
        $message = [
            'status' => $status,
            'message' => $json
        ];

        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        //echo $json;
       // var_dump($obj);
        
    }

    public function district_post() {
        $c = dc_id($this->input->post('c'));
        
        $data = "";
        $token = $this->session->token;
        $mc = json_decode(get_url("meta_location?city=$c",$token));
        $py = $mc->payload;
       // $data['goods'] = $goods;
        $district = $py->re;
        $data .= "<option value=''>Please Select</option>";
        foreach($district as $r) {
            $data .= "<option value='$r->id'>$r->local_name</option>";
        }
      
        $callback = array('data_kota'=>$data); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

        echo json_encode($callback);
     }

     public function city_post() {
        $c = dc_id($this->input->post('c'));

        $data = "";
        $token = $this->session->token;
        $mc = json_decode(get_url("meta_location?country=$c",$token));
        $py = $mc->payload;
       // $data['goods'] = $goods;
        $district = $py->ci;
        $data .= "<option value=''>Please Select</option>";
        foreach($district as $r) {
            $data .= "<option value='$r->id;$r->local_name'>$r->local_name</option>";
        }
      
        $callback = array('data_kota'=>$data); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

        echo json_encode($callback);
     }

     public function subgroup_post() {
        $val = $this->input->post('c');
       
        $data = "";
        $token = $this->session->token;

        $url = API_URL."select_sub_prod_group";
        $post = array(
            "prod_group" => $val
        );
       // var_dump($post);
        $mc = post_token2($url,$post,$token);
        
        $py = $mc->payload;
       // $data['goods'] = $goods;
        $pgroup = $py->prod_group;
        $data .= "<option value=''>Please Select</option>";
        foreach($pgroup as $r) {
            $data .= "<option value='$r->sub_prod_group'>$r->name</option>";
        }
      
        $callback = array('data_kota'=>$data); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

        echo json_encode($callback);
     }

     public function addproduct_post() {
        $freight = $this->input->post('freight');
        $type = $this->input->post('type');
        $l = $this->input->post('l');
        $w = $this->input->post('w');
        $h = $this->input->post('h');

        $weight = $this->input->post('weight');
        $vol = $this->input->post('vol');
        $qty = $this->input->post('qty');
        $datetime = date('YmdHis');
        /*
        $str = "";
        if($freight == 1) { //sea sea
           // $str = $this->addproductsea($type,$qty,$weight,$datetime);
        } else if($freight == 2) { // air air
            $str = $this->addproductair($type,$l,$w,$h,$weight,$vol,$qty,$datetime);
        } else if($freight == 3) { // trucking
            //$str = $this->addproducttruck($type,$qty,$datetime);
        }
        */
        $str = $this->addproductnew($type,$l,$w,$h,$weight,$vol,$qty,$datetime);
        
        echo $str;
     }

     function addproducttruck_post() {
        $weight = $this->input->post('weight');
        $type = $this->input->post('type');
        $qty = $this->input->post('qty');
        $datetime = date('YmdHis');

        $old_products =  $this->session->userdata('products_truck');
        
        if(empty($old_products)) {
            $products[] = array("type"=>$type,"qty"=>$qty,"id"=>$datetime);
             $this->session->set_userdata('products_truck', $products);
        } else {
            $products =array("type"=>$type,"qty"=>$qty,"id"=>$datetime);
            array_push($old_products, $products);
            $this->session->set_userdata('products_truck', $old_products);
        }
        
        
        //$products = array();
        // note the []
        $str = $this->showproducttruck();

        return $str;
     }

     function showproducttruck() {
        $prod = $this->session->userdata('products_truck');

        $str = "";
        $qty = 0;
        $weight = 0;

        $token = $this->session->token;
        $w = json_decode(get_url('truck_type',$token));
        $py = $w->payload;
        $truck = $py;

        $opt = "";


        foreach($prod as $p) {
            $qty = $qty+$p['qty'];

            $id = "'$p[id]'";
            foreach($truck as $c) {
                $cid = $c->id;
                $cname = $c->name;
                if($p['type'] == $cid) { $sel = "selected='selected'"; } else { $sel = ''; }
                $opt .= '<option value="'.$cid.'" '.$sel.'>'.$cname.'</option>';
            }

            $str .= '<div class="col-md-12 mt-2 card border-dark">
                <div class="card-body">
                    <div class="col-sm-12 text-right" onclick="deleteproducttype(1,'.$id.');" style="cursor:pointer;">
                            <i class="icon-cross" style="margin-top:-0.5%;"></i>
                    </div>

                    <div class="row">

                    <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-fn">Truck Type</label>
                                <select name="type_t" class="form-control">
                                    <option value=""></option>'.$opt.'

                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="reg-fn">Qty (unit)</label>
                                <input type="number" class="form-control" value="'.$p['qty'].'" name="qty">
                            </div>
                        </div>
                        

                    </div>

                </div>
            </div>';
            
           
        }

        $str .= '<div class="row">
                   

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Total Truck</label>
                            <input type="text" name="total" value='.$qty.' class="form-control" id="total" disabled>
                        </div>
                    </div>

                </div>';
        return $str;
     }

     function addproductsea_post() {
        $weight = $this->input->post('weight');
        $type = $this->input->post('type');
        $qty = $this->input->post('qty');
        $datetime = date('YmdHis');

        $old_products =  $this->session->userdata('products_sea');
        
        if(empty($old_products)) {
            $products[] = array("type"=>$type,"weight"=>$weight,"qty"=>$qty,"id"=>$datetime);
             $this->session->set_userdata('products_sea', $products);
        } else {
            $products =array("type"=>$type,"weight"=>$weight,"qty"=>$qty,"id"=>$datetime);
            array_push($old_products, $products);
            $this->session->set_userdata('products_sea', $old_products);
        }
        
        
        //$products = array();
        // note the []
        $str = $this->showproductsea();

        echo $str;
     }

     function showproductsea() {
        $prod = $this->session->userdata('products_sea');

        $str = "";
        $qty = 0;
        $weight = 0;

        $token = $this->session->token;
        $w = json_decode(get_url('full_container_type',$token));
        $py = $w->payload;
        $container = $py;

        $opt = "";


        foreach($prod as $p) {
            $qty = $qty+$p['qty'];
            $weight = $weight+$p['weight'];
            $id = "'$p[id]'";
            foreach($container as $c) {
                $cid = $c->id;
                $cname = $c->name;
                if($p['type'] == $cid) { $sel = "selected='selected'"; } else { $sel = ''; }
                $opt .= '<option value="'.$cid.'" '.$sel.'>'.$cname.'</option>';
            }

            $str .= '<div class="col-md-12 mt-2 card border-dark">
                <div class="card-body">
                    <div class="col-sm-12 text-right" onclick="deleteproducttype(2,'.$id.');" style="cursor:pointer;">
                            <i class="icon-cross" style="margin-top:-0.5%;"></i>
                    </div>

                    <div class="row">

                    <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-fn">Container Type</label>
                                <select name="type_t" class="form-control">
                                    <option value=""></option>'.$opt.'

                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="reg-fn">Qty (unit)</label>
                                <input type="number" class="form-control" value="'.$p['qty'].'" name="qty">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="reg-fn">Gross Weight</label>
                                <input type="number" class="form-control" value="'.$p['weight'].'" name="weight">
                            </div>
                        </div>
                        

                    </div>

                </div>
            </div>';
            
           
        }

        $str .= '<div class="row">
                   

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Total Qty</label>
                            <input type="text" name="total_sea" value='.$qty.' class="form-control" id="total_sea" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Weight (kgs)</label>
                            <input type="number" value='.$weight.' class="form-control" name="weight_t_sea" id="weight_t_sea" disabled>
                        </div>
                    </div>

                </div>';
        return $str;
     }

     function addproductnew($type,$l,$w,$h,$weight,$vol,$qty,$datetime) {
        $old_products =  $this->session->userdata('products');
        
        if(empty($old_products)) {
            $products[] = array("type"=>$type,"l"=>$l,"w"=>$w,"h"=>$h,"weight"=>$weight,"vol"=>$vol,"qty"=>$qty,"id"=>$datetime);
             $this->session->set_userdata('products', $products);
        } else {
            $products = array("type"=>$type,"l"=>$l,"w"=>$w,"h"=>$h,"weight"=>$weight,"vol"=>$vol,"qty"=>$qty,"id"=>$datetime);
            array_push($old_products, $products);
            $this->session->set_userdata('products', $old_products);
        }
        
        
        //$products = array();
        // note the []
        $str = $this->showproductair();
        return $str;
     }

     function showproductair() {
        $prod = $this->session->userdata('products');
        $str = "";
        $tcarton = 0;
        $vcarton = 0;
        $wcarton = 0;
        $qtycarton = 0;
        $tpalet = 0;
        $vpalet = 0;
        $wpalet = 0;
        $qtypalet = 0;


        foreach($prod as $p) {
            if($p['type'] == 2) { 
                $typ = "Carton"; 
                $tcarton++; 
                $vcarton = $vcarton+$p['vol']; 
                $wcarton = $wcarton+$p['weight']; 
                $qtycarton = $vcarton+$p['qty'];  
            } 
            else { 
                $typ = "Pallet"; 
                $tpalet++; 
                $vpalet = $vpalet+$p['vol']; 
                $wpalet = $wpalet+$p['weight']; 
                $qtypalet = $qtypalet+$p['qty']; 
            }
            $id = "'$p[id]'";
            $str .= '<div class="col-md-12 mt-2 card border-dark">
                <div class="card-body">
                    <div class="col-sm-12 text-right" onclick="deleteproduct('.$id.');" style="cursor:pointer;">
                            <i class="icon-cross" style="margin-top:-0.5%;"></i>
                    </div>

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-fn">Type</label>
                                <input type="text" class="form-control" value="'.$typ.'" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">L (cm)</label>
                                <input type="number" class="form-control" value="'.$p['l'].'" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">W (cm)</label>
                                <input type="number" class="form-control" value="'.$p['w'].'" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">H (cm)</label>
                                <input type="number" class="form-control" value="'.$p['h'].'" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">Vol (cm3)</label>
                                <input type="number" class="form-control" value="'.$p['vol'].'" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">Weight (kgs)</label>
                                <input type="number" class="form-control"  value="'.$p['weight'].'" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reg-fn">Qty (unit)</label>
                                <input type="number" class="form-control" value="'.$p['qty'].'" disabled>
                            </div>
                        </div>

                        

                    </div>

                </div>
            </div>';
            
           
        }
        $total = $tcarton+$tpalet;
        $vol_t = $vcarton+$vpalet;
        $weight_t = $wcarton+$wpalet;
        $qty_t = $qtycarton+$qtypalet;
        
        $str .= '<div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="reg-fn">Total Pallet</label>
                            <input type="text" name="tpallet" value='.$tpalet.'  class="form-control" id="tpallet" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Vol (cm3)</label>
                            <input type="number" value='.$vpalet.'  class="form-control" name="volp" id="volp" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Weight (kgs)</label>
                            <input type="number" value='.$wpalet.'  class="form-control" name="weightp" id="weightp" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Qty (unit)</label>
                            <input type="number" value='.$qtypalet.'  class="form-control" name="qtyp" id="qtyp" disabled>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="reg-fn">Total Carton</label>
                            <input type="text" name="tcarton" value='.$tcarton.' class="form-control" id="tcarton" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Vol (cm3)</label>
                            <input type="number" value='.$vcarton.' class="form-control" name="vcarton" id="vcarton" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Weight (kgs)</label>
                            <input type="number" value='.$wcarton.' class="form-control" name="wcarton" id="wcarton" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Qty (unit)</label>
                            <input type="number" value='.$qtycarton.' class="form-control" name="qtycarton" id="qtycarton" disabled>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="reg-fn">Total All</label>
                            <input type="text" name="total" value='.$total.' class="form-control" id="total" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Vol (cm3)</label>
                            <input type="number" value='.$vol_t.' class="form-control" name="vol_t" id="vol_t" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Weight (kgs)</label>
                            <input type="number" value='.$weight_t.' class="form-control" name="weight_t" id="weight_t" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="reg-fn">Qty (unit)</label>
                            <input type="number" value='.$qty_t.' class="form-control" name="qty_t" id="qty_t" disabled>
                        </div>
                    </div>
                </div>';
        return $str;
     }

     public function deleteproducttype_post() {
        $id = $this->input->post('id');
        $freight = $this->input->post('freight');
       
        
        if($freight == 1) {
            $k = 0;
            $b = 0;

            foreach($_SESSION['products_sea'] as $d) {
                // echo $d['id'][$id];
                $k++;
                if($d['id'] == $id) {
                    $b = $k;
                }
                
            }
            
            if(!empty($b)) {
                $b = $b-1;
                unset($_SESSION['products_sea'][$b]);
            }
            //$str = "";
            $str = $this->showproductsea();
            
        }
       
        else if($freight == 3) {
            $k = 0;
            $b = 0;
            foreach($_SESSION['products_truck'] as $d) {
                // echo $d['id'][$id];
                $k++;
                if($d['id'] == $id) {
                    $b = $k;
                }
                
            }
            
            if(!empty($b)) {
                $b = $b-1;
                unset($_SESSION['products_truck'][$b]);
            }

            $str = $this->showproducttruck();
        }
        
       // $str = "test";
        
        
        echo $str;
         
     }

     public function deleteproduct_post() {
        $id = $this->input->post('id');
        $freight = $this->input->post('freight');
       
        
        if($freight == 1) {
            $k = 0;
            $b = 0;
            foreach($_SESSION['products_sea'] as $d) {
                // echo $d['id'][$id];
                $k++;
                if($d['id'] == $id) {
                    $b = $k;
                }
                
            }
            
            if(!empty($b)) {
                $b = $b-1;
                unset($_SESSION['products_sea'][$b]);
            }

            $str = $this->showproductsea();
        }
        else if($freight == 2) {
            // echo $id;
            $k = 0;
            $b = 0;
            foreach($_SESSION['products'] as $d) {
                // echo $d['id'][$id];
                $k++;
                if($d['id'] == $id) {
                    $b = $k;
                }
                
            }

            if(!empty($b)) {
                $b = $b-1;
                unset($_SESSION['products'][$b]);
            }

            $str = $this->showproductair();
        } 
        else if($freight == 3) {
            $k = 0;
            $b = 0;
            foreach($_SESSION['products_truck'] as $d) {
                // echo $d['id'][$id];
                $k++;
                if($d['id'] == $id) {
                    $b = $k;
                }
                
            }
            
            if(!empty($b)) {
                $b = $b-1;
                unset($_SESSION['products_truck'][$b]);
            }

            $str = $this->showproducttruck();
        }
        
        
        echo $str;
         
     }

     public function freight_post() {
         $type = $this->input->post("type");
         $token = $this->session->token;
         $str = "";
         if($type == 1) {
            $str = $this->products();
            $str .= $this->seafreight();
         } else if($type == 2) {
            $str = $this->products();
         } else if($type == 3) {
            $str = $this->products();
            $str .= $this->truckfreight();
         }
         echo $str;
     }

     function seafreight() {
         
        $token = $this->session->token;
        $w = json_decode(get_url('full_container_type',$token));
        $py = $w->payload;
        $container = $py;

        $opt = "";
        foreach($container as $c) {
            $cid = $c->id;
            $cname = $c->name;
            $opt .= '<option value="'.$cid.'">'.$cname.'</option>';
        }

        $str = '<p class="text-sm text-center mt-3">Inquiry for Full Container Load</p>
        <h6 class="text-bold">FULL CONTAINER SHIPMENT</h6>
        <div class="col-md-12 card border-primary">
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="reg-fn">Container Type</label>
                        <select name="type_t" class="form-control">
                            <option value=""></option>'.$opt.'

                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="reg-fn">Qty (unit)</label>
                        <input type="number" class="form-control" name="qty_type">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="reg-fn">Gross Weight</label>
                        <input type="number" class="form-control" name="weight_type">
                    </div>
                </div>

                <div class="col-sm-12 text-right" onclick="addproducttype(1);" style="cursor:pointer;">
                    <i class="icon-circle-plus" style="margin-top:-0.5%;"></i><strong class="ml-1">Add More</strong>
                </div>

            </div>

        </div>
    </div>

    <div id="product_content2"></div>';
         return $str;
     }

     function truckfreight() {
        $token = $this->session->token;
        $w = json_decode(get_url('truck_type',$token));
        $py = $w->payload;
        $truck = $py;

        $opt = "";
        foreach($truck as $c) {
            $cid = $c->id;
            $cname = $c->name;
            $opt .= '<option value="'.$cid.'">'.$cname.'</option>';
        }

        $str = '<p class="text-sm text-center">Inquiry for Trucking</p>
        <h6 class="text-bold">TRANSPORTATION</h6>
        <div class="col-md-12 card border-primary">
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="reg-fn">Truck Type</label>
                        <select name="type_t" class="form-control">
                            '.$opt.'
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="reg-fn">Qty (unit)</label>
                        <input type="number" class="form-control" name="qty_type">
                    </div>
                </div>

                <div class="col-sm-12 text-right" onclick="addproducttype(2);" style="cursor:pointer;">
                    <i class="icon-circle-plus" style="margin-top:-0.5%;"></i><strong class="ml-1">Add More</strong>
                </div>

            </div>

        </div>
    </div>

    <div id="product_content2"></div>';
         return $str;
    }

     function products() {
         $str = '<div class="col-md-12 card border-primary">
         <div class="card-body">

             <div class="row">

                 <div class="col-sm-12">
                     <div class="form-group">
                         <label for="reg-fn">Type</label>
                         <select name="type" class="form-control">
                             <option value="1">Pallet</option>
                             <option value="2">Carton</option>
                         </select>
                     </div>
                 </div>

                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">L (cm)</label>
                         <input type="number" class="form-control" onchange="change_vol();" name="l">
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">W (cm)</label>
                         <input type="number" class="form-control" onchange="change_vol();" name="w">
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">H (cm)</label>
                         <input type="number" class="form-control" onchange="change_vol();" name="h">
                     </div>
                 </div>

                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">Vol (cm3)</label>
                         <input type="number" class="form-control" id="vol" name="vol" disabled>
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">Weight (kgs)</label>
                         <input type="number" class="form-control" name="weight">
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label for="reg-fn">Qty (unit)</label>
                         <input type="number" class="form-control" name="qty">
                     </div>
                 </div>

                 <div class="col-sm-12 text-right" onclick="addproduct();" style="cursor:pointer;">
                     <i class="icon-circle-plus" style="margin-top:-0.5%;"></i><strong class="ml-1">Add More</strong>
                 </div>

             </div>

         </div>
     </div>

     <div id="product_content"></div>';
        return $str;
     }

     function checkpo_post() {
        $po = $this->input->post("val");
         
        $token = $this->session->token;
        $url = API_URL."po_no";
        $post = array(
            "po_no" => $po
        );
        $obj = post_token($url,$post,$token);
        
        //echo $obj->error_code;
        
        if($obj->error_code == 2) {
            $status = 1;
            $msg = "Available";
        } else {
            $status = -1;
            $msg = "Not Available";
        }

        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }

    function getaddress_post() {
        $val = $this->input->post("val");
         
        $token = $this->session->token;
        $url = API_URL."get_customer_address";
        $post = array(
            "cust_code" => $val
        );
       // var_dump($post);
        $obj = post_token2($url,$post,$token);
        
        //echo $obj->error_code;
        $address = "";
        
        if($obj->error_code == 2) {
            $status = 1;
            $py = $obj->payload;
            foreach($py as $p) {
                $address = $p->address1;
            }
            

           $msg = "success";
        } else {
            $status = -1;
            $msg = "Not Available";
        }
      
        $message = [
            'status' => $status,
            'message' => $msg,
            'address' => $address
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
    }

    function getdetailtransport_post() {
        $val = $this->input->post("val");
        
        $a = explode(";",$val);
        $outlet = "";
        $contact = "";
        $tel = "";
        if(!empty($a)) {
            $driver_phone = $a[1];
            $driver_name = $a[2];
            $transport_type = $a[3];
        }
        $status = 1;
        $msg = "success";
      
        $message = [
            'status' => $status,
            'message' => $msg,
            "transport_type" => $transport_type
        ];

        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
    }

    function getdetailtransport2_post() {
        $val = $this->input->post("val");
        
        $a = explode(";",$val);
        $outlet = "";
        $contact = "";
        $tel = "";
        if(!empty($a)) {
            $driver_phone = $a[1];
            $driver_name = $a[0];
        }
        $status = 1;
        $msg = "success";
      
        $message = [
            'status' => $status,
            'message' => $msg,
            'driver_name' =>$driver_name,
            'driver_phone' => $driver_phone
        ];

        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
    }

    function getcontactpo_post() {
        $val = $this->input->post("val");
        
        $a = explode(";",$val);
        $outlet = "";
        $contact = "";
        $tel = "";
        if(!empty($a)) {
            $outlet = $a[0];
            $contact = $a[1];
            $tel = $a[2];
        }
        
         
        $token = $this->session->token;
        $url = API_URL."po_no";
        $post = array(
            "outlet" => $outlet
        );
       // var_dump($post);
        $obj = post_token2($url,$post,$token);
        
        //echo $obj->error_code;
        $address = "";

        $po = "";
        
        if($obj->error_code == 2) {
            $status = 1;
            $py = $obj->payload;
            //$po = $py;
            $po .= "<option value=''>Please Select</option>";
            foreach($py as $y) {
                $po .= "<option value='$y->order_ref'>$y->order_ref</option>";
            }

           $msg = "success";
        } else {
            $status = -1;
            $msg = "Not Available";
        }
      
        $message = [
            'status' => $status,
            'message' => $msg,
            'pic' =>$contact,
            'phone' => $tel,
            "cust_code" => $outlet,
            'po' => $po
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
    }

    function addinventory_post() {
        $qty = explode(",",$this->input->post("qty"));
        $pc = explode(",",$this->input->post("prod_code"));
        $str = explode(",",$this->input->post("str"));

        
        foreach($qty as $q => $k) {
            if(!empty($k)) {
                $qty_k = $k;
                $prod_code = $pc[$q];
                $strr = $str[$q];
                $a = explode(";",$strr);
                $prod_name = $a[0];
                $uom = $a[1];

               // echo $qty_k.' '.$prod_code.' '.$prod_name.' '.$uom.'<br>';
                $this->addinv($qty_k,$prod_code,$prod_name,$uom);
            }
        }

        $status = 1;
        $msg = "success";

        $message = [
            'status' => $status,
            'message' => $msg
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
    }

    function addinv($qty,$prod_code,$prod_name,$uom) {
        $old_products =  $this->session->userdata('inventory');
        
        if(empty($old_products)) {
            $products[] = array("qty"=>$qty,"prod_code"=>$prod_code,"prod_name"=>$prod_name,"uom"=>$uom);
             $this->session->set_userdata('inventory', $products);
        } else {
            $products = array("qty"=>$qty,"prod_code"=>$prod_code,"prod_name"=>$prod_name,"uom"=>$uom);
            array_push($old_products, $products);
            $this->session->set_userdata('inventory', $old_products);
        }
        return 1;
     }

     public function orderaction_post()
    {

        $po = $this->input->post("po");
        $sotype = $this->input->post("sotype");
        $outlet = $this->input->post("outlet");
        $address = $this->input->post("address");

        $delivery_date = tgl_simpan($this->input->post("delivery_date"));
        $exdate = tgl_simpan($this->input->post("expired_date"));
        $remark = $this->input->post("remark");

        $inbound = $this->input->post("inbound");
        $status_order = $this->input->post("status");
        $batch = $this->input->post("batch");
       

        $status = "I";

        

        if(!empty($this->session->userdata('inventory'))) {
            $prod = $this->session->userdata('inventory');
            foreach($prod as $p2) {
                $pcode = $p2['prod_name'];
                $pname = $p2['prod_code'];
                $qty = $p2['qty'];
                $uom = $p2['uom'];
              
                
                $details[] = array("product_code"=>$pcode,"product_name"=>$pname,"quantity"=>$qty,"uom"=>$uom,"exclude_expired_date"=>$exdate,"inbound_po"=>$inbound,"inventory_status"=>"G","batch"=>$batch);
            }
        } else {
            $details = array();
        }

        $post = array(
            "order_id" => null,
            "customer_po" => $po,
            "so_type" => $sotype,
            "outlet" => $outlet,
            "address" => $address,
            "date_order" => $delivery_date,
            "remark" => $remark,
            "status_order" => "",
            "status" => $status,
            "detail_order" => $details
        );
        $json = json_encode($post);
       $token = $this->session->token;
       //$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQxYWFmYTEwNGQ2MGEzN2I5OGIwMzBjMWNjMDIxMTRiNzJhOTNkOTkxNjliYmIwYTI3MzNiOTNmZWY2YTIzMjhlOTMwOWYwMTdhODFjNTQ0In0.eyJhdWQiOiIyIiwianRpIjoiNDFhYWZhMTA0ZDYwYTM3Yjk4YjAzMGMxY2MwMjExNGI3MmE5M2Q5OTE2OWJiYjBhMjczM2I5M2ZlZjZhMjMyOGU5MzA5ZjAxN2E4MWM1NDQiLCJpYXQiOjE1NzM1Njc0OTIsIm5iZiI6MTU3MzU2NzQ5MiwiZXhwIjoxNTczNjUzODkyLCJzdWIiOiIxNyIsInNjb3BlcyI6WyIqIl19.a2mZP3DXU8pEGlC3-4qWgR28jBR6U5Q2IlMA_JeH1PxHXG5_Anm9LYq98tg-amtTscAeXc8bFbl1p7HtQEZbYsiSuycOWxAaVWlV_VCGwFs6ZUjdOfBvWFy-N-e65oDckfxU0d2teTFKgvOOadtZZ1D5QErEmASOVTTld4J61RMIPp5GvrLy_O_1NtvSiMXjNRp5rpfQ9km7P8syka-0BiU-rEkVrw3HRpJV6H--fACYdgIa_loBkOack1X27J3i1B7ZDhiG2V-iVcbx08dqjlzMmqlWdp2mnH8oV2QmRVr7wl6EpGlXviGacMND3xbqenmMEggAd7rutQdqkjbM9gKM4-Fl4jU0VoyPv-8PqJZdSoJB2kqq597kTQkN8gi5-OF5djeYZP5rU2CcFWbMCVKQ7PSkkHTwrX59e2-F51IniNyJwoedOkDL-_0xJtAU90KMmew9DXpvYc_B_BoxrugTyLD3Xd9W-JA41f1bl7zUCYDhJQSiArt2AOo7oWs20X0tvDQwuwEb5knc1AKFH8sNL5Ka2uAn-Hm8D6-Mt1pvO2uXioH1uhuTxspjonmPdLlubplJU2111Do0M5b8rnoxzYxr3-7sOHukWOp1CEsCFis0o4hqhy8rzN2ju7_EpJfg8c_gQIgL2EM3otO2GaYSthPivKkgGmnHoIJWMJY";
       $url = API_URL."order/action_order";
       $obj = post_token($url,$json,$token);

       
       if(!empty($obj)) {
            if($obj->error_code == 2) {
                $status = 1;
                $msg = $obj->message;
            } else {
                $status = -2;
                $msg = $obj->message;
            }
       } else {
           $status = -1;
           $msg = "Server Error";
       }
        
        $message = [
            'status' => $status,
            'message' => $msg
        ];

        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        
        
    }


}
