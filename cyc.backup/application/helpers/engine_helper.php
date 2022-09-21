<?php 
    function cek_session_admin(){
        $ci = & get_instance();
        /*
        $session = $ci->session->userdata('level');
        if ($session == ''){
            redirect(base_url());
        }
        */
    }

    function style_penjualan() {
        $a = "<style>
        .text-blue {
            color:blue;
        }
        .nav-tabs {
              overflow-x: auto;
              overflow-y: hidden;
              display: -webkit-box;
              display: -moz-box;
            }
            .nav-tabs .nav-link {
                transition: color .3s;
                color: #000;
                font-size: 12px;
                font-weight: bold;
                letter-spacing: .05em;
                text-decoration: none;
                text-transform: uppercase;
            }
            .nav-tabs>li {
              float: none;
            }
            .nav-tabs .nav-item {
                border-right: none;
                border-left: none;
                border-top: none;
                border-bottom:1px solid #ccc;
            }
            .nav-tabs .nav-item.active {
                font-weight: bold;
                background-color: transparent;
                border-right: none;
                border-left: none;
                border-top: none;
                color: #000;
                border-bottom: 4px solid #1235a9;
            }
            .nav-tabs .nav-link.active {
                font-weight: bold;
                background-color: transparent;
                border-right: none;
                border-left: none;
                border-top: none;
                color: #000;
            }
            .nav-tabs .nav-item.show .nav-link, .nav-tabs {
                color: #495057;
                background-color: #fff;
                border-color: #ccc;
            }
            .nav-tabs .nav-link {
                border: 1px solid transparent;
                border-top-left-radius: .25rem;
                border-top-right-radius: .25rem;
            }

            .bg-blue-dark {
                background-color: #1b245d;
            }
        
        </style>";
        return $a;
    }

    function get_menu() {
        $menu[] = (object) array(
            'name' => 'Waiting',
            'url' => 'history/waiting'
        );
        $menu[] = (object) array(
            'name' => 'Approve',
            'url' => 'history/approve'
        );
        $menu[] = (object) array(
            'name' => 'Reject',
            'url' => 'history/reject'
        );

        $menu[] = (object) array(
            'name' => 'Dikirimkan',
            'url' => 'history/dikirim'
        );


        return $menu;
    }

    function menu(){
        $ci = & get_instance();

        $menu[] = (object) array(
            'menu_id' => '1',
            'menu_name' => 'Company Profile',
            'url' => 'compro'
        );
        $menu[] = (object) array(
            'menu_id' => '2',
            'menu_name' => 'Shipment Inquiry',
            'url' => 'shipment'
        );
        $menu[] = (object) array(
            'menu_id' => '3',
            'menu_name' => 'New Order',
            'url' => 'neworder'
        );
        $menu[] = (object) array(
            'menu_id' => '4',
            'menu_name' => 'History Order',
            'url' => 'historyorder'
        );
        $menu[] = (object) array(
            'menu_id' => '5',
            'menu_name' => 'Order Tracking',
            'url' => 'ordertracking'
        );
        $menu[] = (object) array(
            'menu_id' => '6',
            'menu_name' => 'New SI',
            'url' => 'si'
        );
        $menu[] = (object) array(
            'menu_id' => '7',
            'menu_name' => 'Order In Progress',
            'url' => 'orderinprogress'
        );
        $menu[] = (object) array(
            'menu_id' => '8',
            'menu_name' => 'Delivery Tasks',
            'url' => 'deliverytask'
        );
        /*
        $menu[] = (object) array(
            'menu_id' => '9',
            'menu_name' => 'Track All',
            'url' => 'trackall'
        );
        */
        $menu[] = (object) array(
            'menu_id' => '10',
            'menu_name' => 'Attendance',
            'url' => 'attendance'
        );
        $menu[] = (object) array(
            'menu_id' => '11',
            'menu_name' => 'Contact Us',
            'url' => 'contactus'
        );
        $menu[] = (object) array(
            'menu_id' => '12',
            'menu_name' => 'Chat',
            'url' => 'chat'
        );
        
        //$menu = (object) $details;
        
        return $menu;
    }

    function login($email,$password,$url) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://andtechnology.me/charisma/api/member/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n$email\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\n$password\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "Postman-Token: 0a512f42-724d-4036-a60b-f6b351391e8a",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    
    function postwithfiles($url, $data) {
        /*
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
*/
        $post = curl_init();

        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($post, CURLOPT_TIMEOUT, 30);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $data);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($post, CURLOPT_USERAGENT,'Firefox/2.0.0.13');
       // curl_setopt($post, CURLOPT_HTTPHEADER, array("content-type: multipart/form-data"));

        //$result = curl_exec($post);

        //curl_close($post);
        //return json_decode($result);
        $response = curl_exec($post);
        $err = curl_error($post);

        curl_close($post);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    
    function postregister($url, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');

        $post = curl_init();

        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($post, CURLOPT_TIMEOUT, 30);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($post, CURLOPT_USERAGENT,'Firefox/2.0.0.13');
       // curl_setopt($post, CURLOPT_HTTPHEADER, array("content-type: multipart/form-data"));

        //$result = curl_exec($post);

        //curl_close($post);
        //return json_decode($result);
        $response = curl_exec($post);
        $err = curl_error($post);

        curl_close($post);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

     
    function postlogin($url, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');

        $post = curl_init();

        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($post, CURLOPT_TIMEOUT, 30);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($post, CURLOPT_USERAGENT,'Firefox/2.0.0.13');

        //$result = curl_exec($post);

        //curl_close($post);
        //return json_decode($result);
        $response = curl_exec($post);
        $err = curl_error($post);

        curl_close($post);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    
    function checknull($val) {
        if(empty($val)) {
            $val = "";
        }
        return $val;
    }
    
    function url_post($url,$data) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL.$url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 11259766-b941-4510-8b3e-d4a24d31a777",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
    
    function post_to_url($url,$data) {

       
        $curl = curl_init();

        $fields = '{';
        foreach ($data as $key => $value) {
            
            $fields .= "\r\n  \"$key\": \"$value\",";
           // $fields .= $key . '=' . $value . '&';
        }
        $fields = rtrim($fields,',');
        $fields .= '}';

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Postman-Token: 7162f2cb-3eb4-4cd9-994b-076df9b7af66",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    function post_test() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "8888",
        CURLOPT_URL => "http://124.158.147.21:8888/wpc/public/api/action_shipment_inquery",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"cargo_value_hs_code\": \"4\",\r\n  \"company\": \"tt\",\r\n  \"consigneeaddress\": \"Jakarta\",\r\n  \"delivery_address\": \"shhs\",\r\n  \"detail_truck\": [\r\n    {\r\n      \"type\": \"2\",\r\n      \"qty\": \"2\"\r\n    }\r\n  ],\r\n  \"detail_freight\": [\r\n  ],\r\n  \"detail\": [\r\n  ],\r\n  \"dimensionalUnit\": \"CM\",\r\n  \"email\": \"bernardwi89@gmail.com\",\r\n  \"estimatetimearrival\": \"2019-09-10\",\r\n  \"estimatetimedeparture\": \"2019-09-09\",\r\n  \"freighttype\": \"Air Freight\",\r\n  \"goodsdescription\": \"Macam macam\",\r\n  \"goodstype\": \"Dangerous Goods\",\r\n  \"name\": \"Sandy\",\r\n  \"need_delivery\": 0,\r\n  \"need_destination\": 0,\r\n  \"need_pickup\": 0,\r\n  \"phone\": \"56\",\r\n  \"pickup_address\": \"sju\",\r\n  \"pod_city\": \"Semarang\",\r\n  \"pod_country\": \"test Country\",\r\n  \"pod_district\": \"Bali\\r\",\r\n  \"pol_city\": \"Mataram\",\r\n  \"pol_country\": \"Indonesia\\r\\n\",\r\n  \"pol_district\": \"Bali\\r\",\r\n  \"portofdischarge\": \"test Port OF Discart\",\r\n  \"portofloading\": \"aa\",\r\n  \"shipmen_inquery_id\": null,\r\n  \"shipperAddress\": \"Jakarta\",\r\n  \"status\": \"I\",\r\n  \"weightunit\": \"KGS\",\r\n  \"yourmessage\": \"gg\",\r\n  \"pod_country_wpc\": 1,\r\n  \"pod_city_wpc\": 1,\r\n  \"goods_type_wpc\": 1,\r\n  \"freight_type_wpc\": 1,\r\n  \"dimensional_unit_wpc\": 1,\r\n  \"weight_unit_wpc\": 1,\r\n  \"pol_country_wpc\": 1,\r\n  \"pol_city_wpc\": 1\r\n}",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA1MmQzNTRjMWMxYzhmNGVhNTBmMWE1NzU1NTA1NTFiYTQwNGE0MjQyMWVmZDY5MmYwMWY1NGRmNjVlNzNmNzlkYTA2MGQ0MTQ3MzQxNDJkIn0.eyJhdWQiOiIyIiwianRpIjoiMDUyZDM1NGMxYzFjOGY0ZWE1MGYxYTU3NTU1MDU1MWJhNDA0YTQyNDIxZWZkNjkyZjAxZjU0ZGY2NWU3M2Y3OWRhMDYwZDQxNDczNDE0MmQiLCJpYXQiOjE1NzMzNTUzNzYsIm5iZiI6MTU3MzM1NTM3NiwiZXhwIjoxNTczNDQxNzc2LCJzdWIiOiIxNyIsInNjb3BlcyI6WyIqIl19.GoDZAFdrxBOOXLlT09GWZK4zSVtHgvlQReLVNlpe8NLo3rfkYRZtS3NJmHBtwEFHPs1LkFAQxM1wrVOHRU4NGTgcuWEjiVya9Z3h_Szf8DW8of-Xx2C8gx6Q70hyDlXO0gwECm5bFpEmTKYGyd4g9xvNh7EEary-Iy0NL8VN5cMYTrgYFpd5bJDTCfWu5XA-grJKxcw6HLa2fbklHLBx06zb6dKdGns5Qa6AP7MnpbP0Mc09NChBpRfmwnvVkNKBBxzpiamv1vDC-A4Na1H44saqg3lLJcaeYwvWadAIUHYUDdtAFdkomJPuTswBJQmJmDMtdxY59lQDNym0p0pvJRcH4ebgqblS2LPZtcbogNwGSwrtKxAx3HPecGo8ecZIfM_E4hKtIeRimKtaEH1ZC4liYbv1qClb_k0XxQaVG7Ntv95E0S0Mb8fQ1QgXm0C2aZvuHco-1pDnMNijhZyAD1NUvOhSO58-q0gYyhzaH1RHNlv1Q7FvIpUKnepCdXZ3ZPkz5KGrjLr3riumuGy1mV-ee1XUVDJ0sW2g3H3j206pRJxRwme-vuSLAUk0lAb39bv7VY0s9jMp9sMa0LNVehbomZxZCtBeWepTDiSpp4jOl0P8obgbx5x0d761dJmqy3c987r7hprhd9tHMD02WzDd7L6sEK5S5aLnqUuUxVI",
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: c6e43955-1328-5dfe-26cc-17bd57b127c7"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function post_files2($url,$data) {
        $curl = curl_init();

        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');

       // $fields = 'id_member=45&nama_member=dedi&email=dedotz89@gmail.com&password=n123456&dob=12/02/2016&alamat=Grogol, Pertamburan&type=1&phone=0988888888&photo=C:\Users\asus\Pictures\sinkarkes_logo.png';
/*
        $fields = '------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="id_member" 45
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="nama_member" dedii
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="email" dedotz89@gmail.com
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="password"\r\n\r\n123456\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="photo"; filename="E:\xampp_new\tmp\php4A6D.tmp\r\nContent-Type: image/png\r\n\r\n\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="dob"\r\n\r\n12/02/2016\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="alamat"\r\n\r\nGrogol, Pertamburan\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="type"\r\n\r\n1\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="phone"\r\n\r\n0988888888\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--';
        */
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://andtechnology.me/charisma/api/member/reg",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array(
            "Postman-Token: 20d8cbe7-83f3-4791-90b6-4d54e3cf9706",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }

    function post_files($url,$data) {
        $curl = curl_init();

        $fields = '------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="id_member"\r\n\r\n'.$data['id_member'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="nama_member"\r\n\r\n'.$data['nama_member'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="email"\r\n\r\n'.$data['email'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="password"\r\n\r\n'.$data['password'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="photo"; filename="'.$data['filename'].'\r\nContent-Type: '.$data['file_type'].'\r\n\r\n\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="dob"\r\n\r\n'.$data['dob'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="alamat"\r\n\r\n'.$data['alamat'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="type"\r\n\r\n'.$data['file_type'].'\r\n
        ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="phone"\r\n\r\n'.$data['phone'].'\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--';
/*
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://andtechnology.me/charisma/api/member/reg",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array(
            "Postman-Token: 20d8cbe7-83f3-4791-90b6-4d54e3cf9706",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
        return $response;
        }
*/
        
        return $fields;
    }

    function style_wizard() {
        $str = '<style>
        .stepwizard-step p {
            margin-top: 10px;
        }
        
        .stepwizard-row {
            display: table-row;
        }
        
        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }
        
        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }
        
        .stepwizard-row:before {
            top: 18px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        
        }
        
        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }
        
        .btn-circle {
          width: 30px;
          height: 30px;
          text-align: center;
          padding: 6px 0;
          font-size: 12px;
          line-height: 1.428571429;
          border-radius: 15px;
        }
        .has-error .form-control {
            border-color: #a94442;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        }
        
        </style>';
        return $str;
    }

    function post_token($url,$data,$token) {

        $curl = curl_init();
        /*
        $fields = '{';
        foreach ($data as $key => $value) {
            
            $fields .= "\r\n  \"$key\": \"$value\",";
           // $fields .= $key . '=' . $value . '&';
        }
        $fields = rtrim($fields,',');
        $fields .= '}';
        */

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Authorization: Bearer $token",
            "Content-Type: application/json",
            "Postman-Token: 7162f2cb-3eb4-4cd9-994b-076df9b7af66",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }


    function post_token2($url,$data,$token) {

        $curl = curl_init();
        
        $fields = '{';
        foreach ($data as $key => $value) {
            
            $fields .= "\r\n  \"$key\": \"$value\",";
           // $fields .= $key . '=' . $value . '&';
        }
        $fields = rtrim($fields,',');
        $fields .= '}';
        

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Authorization: Bearer $token",
            "Content-Type: application/json",
            "Postman-Token: 7162f2cb-3eb4-4cd9-994b-076df9b7af66",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    function url_get($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL.$url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "Postman-Token: a996ffc2-f728-44a1-b2d2-5d0145dd8a6b",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }

    }

    
    function mobile(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            $mobile = 1;
        } else {
            $mobile = 0;
        }
        return $mobile;
    }

    function cek_session_akses($link,$id){
        $ci = & get_instance();
        /*
    	$session = $ci->db->query("SELECT * FROM modul,users_modul WHERE modul.id_modul=users_modul.id_modul AND users_modul.id_session='$id' AND modul.link='$link'")->num_rows();
    	if ($session == '0' AND $ci->session->userdata('level') != 'admin'){
    		redirect(base_url().'administrator/home');
        }
        */
    }

    function template(){
        $ci = & get_instance();
        /*
        $query = $ci->db->query("SELECT folder FROM templates where aktif='Y'");
        $tmp = $query->row_array();
        if ($query->num_rows()>=1){
            return $tmp['folder'];
        }else{
            return 'errors';
        }
        */
        return "charisma";
    }
    