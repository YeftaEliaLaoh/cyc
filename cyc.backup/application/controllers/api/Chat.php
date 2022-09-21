<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Chat extends REST_Controller
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
        $this->load->model("chat_model");

        date_default_timezone_set('Asia/Jakarta');
    }

    public function updateviewchat_post()
    {
        $code = $this->input->post('cod3');
        $com = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $id =  $this->input->post('id');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {
                        $status = 1;
                        $msg = "success";
                        $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();

                                //$p = $this->feed_model->get_story($user->ID,$id);
                                $p = $this->db->query("SELECT * FROM live_chat_messages WHERE ID = $id AND status = 0")->row();
                                if(!empty($p)) {
                                    $this->db->where("ID", $id)->set("status", 1, FALSE)->update("live_chat_messages");
                                } else {
                                    $status = -1;
                                    $msg = "Already viewed";
                                }
                            } else {
                                $status = -1;
                                $msg = "Invalid user";
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
                'message' => $msg
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

    
    public function list_chat_post()
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
                                
                                //$friends = $this->user_model->get_user_friends($user->ID, $limit,$page)->result();
                                $chat = $this->chat_model->get_livechat_users($user->ID, $limit,$page);
                                if(!empty($chat)) {
                                    foreach($chat as $c) {
                                        $f_timestamp = "";
                                        $format_date = "";
                                        $chatid = $c->chatid;
    
                                        //$ch = $this->chat_model->get_chat_messages($chatid, $limit,$page = 1);
                                        $r = $this->db->query("SELECT u.username, u.first_name, u.last_name,u.avatar, u.online_timestamp, u.ID as friendid,lm.* 
                                        FROM live_chat_users lm LEFT JOIN users u ON u.ID=lm.userid
                                        WHERE lm.chatid = $chatid AND lm.userid != $user->ID ORDER BY lm.ID DESC LIMIT 1")->row();
                                        
                                        if(!empty($r->avatar)) {
                                            $r->avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $r->avatar;
                                        }
                                        if(!empty($r->online_timestamp)) {
                                            $f_timestamp = $this->common->get_time_string_simple($this->common->convert_simple_time($r->online_timestamp));
                                            $format_date = date('d F Y H:i A',  $r->online_timestamp);
                                          
    
                                           
    
                                        }

                                        $tm = date('d F Y H:i A', $c->last_chat_time);
                                        $last_chat = $c->message;
                                      /*  
                                        if(!empty($chatid)) {
                                            $r2 = $this->db->query("SELECT * FROM live_chat_messages WHERE chatid = '$chatid' ORDER BY ID DESC LIMIT 1")->row();
                                            $last_chat = $r2->message;
                                             $tm = date('d F Y H:i A',  $r2->timestamp);
                                        }
                                    */
                                        
                                        if(!empty($r->userid)) {
                                            $data[] = array("ID"=>$r->userid,"username"=>$r->username,"first_name"=>$r->first_name,"last_name"=>$r->last_name,
                                            "online_timestamp"=>$r->online_timestamp,"format_time"=>$f_timestamp,"avatar"=>$r->avatar,"format_date"=>$format_date,"last_chat"=>$last_chat,"last_chat_time"=>$tm);
                                        }
    
                                    }
                                }
                                
                                //$friends = $this->user_model->get_user_friends_chat($user->ID,10)->result();
                                //print_r($this->db->last_query());
                                /*
                                foreach($friends as $r) {
                                    $r->avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $r->avatar;
                                    $f_timestamp = $this->common->get_time_string_simple($this->common->convert_simple_time($r->online_timestamp));
                                    $format_date = date('d F Y H:i A',  $r->online_timestamp);
                                     
                                    $chats = $this->chat_model->get_user_chats($r->friendid);
                                    $chatid = 0;
                                    foreach($chats->result() as $r2) {
                                        $user_count = $this->chat_model->get_user_count($r2->chatid);
                                        if($user_count == 2) {
                                            // Look for friend
                                            $friend = $this->chat_model->get_chat_user($r2->chatid, $r->friendid);
                                            if($friend->num_rows() > 0) {
                                                $chatid = $r2->chatid;
                                                break;
                                            }
                                        }
                                    }
                                    $m = $this->chat_model->get_chat_latest($chatid);

                                    
                                    $tm = "";
                                    $messages = "";
                                    if(!empty($m->message)) {
                                        $messages = $m->message;
                                        $tm = date('d F Y H:i A',  $m->timestamp);
                                    }
                                    
                                    $data[] = array("ID"=>$r->friendid,"username"=>$r->username,"first_name"=>$r->first_name,"last_name"=>$r->last_name,
                                    "online_timestamp"=>$r->online_timestamp,"format_time"=>$f_timestamp,"avatar"=>$r->avatar,"format_date"=>$format_date,"last_chat"=>$messages,"last_chat_time"=>$tm);
                                }
                                */
                
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
                'chat' => $data
            ];
            /*
            
            if($status == 1) {
                
            } else {
                $message = [
                    'status' => $status,
                    'message' => $msg
                ];
            }
            */
            
            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
        else {
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong key'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
    }

    public function detail_chat_post()
    {
        $code = $this->input->post('cod3');
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $id =  $this->input->post('id');
                
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();

                                $friendid = intval($id);
                               //$friendid = intval($userid);
                               /*
                               $friend = $this->user_model->get_user_friend($user->ID, $friendid)->row();
                               if(empty($friend)) {
                                    $status = -1;
                                    $msg = "This user not your friend";
                                } 
                                else {
                                    */
                                    $chats = $this->chat_model->get_user_chats($user->ID);

                                    $chatid = 0;
                                    foreach($chats->result() as $r) {
                                        $user_count = $this->chat_model->get_user_count($r->chatid);
                                        if($user_count == 2) {
                                            // Look for friend
                                            $friend = $this->chat_model->get_chat_user($r->chatid, $friendid);
                                            if($friend->num_rows() > 0) {
                                                $chatid = $r->chatid;
                                                break;
                                            }
                                        }
                                    }

                                    //$chat = $this->chat_model->get_chat_live_message($user->ID,$id)->result();
                                    //$ct = $this->db->query("SELECT * FROM live_chat_messages WHERE userid = $user->ID AND chatid = $friendid")->result();
                                    $limit = $this->input->post("limit");
                                    $page = $this->input->post("page");
                                    if(empty($page)) {
                                        $page = 0;
                                    } else {
                                        $page = $page-1;
                                    }
                    
                                    $page = $page*$limit;
                                    
                                    $messages = $this->chat_model->get_chat_messages($chatid, $limit,$page);
                                    foreach($messages->result() as $r) {
                                        $r->format_date = date('d F Y H:i A',  $r->timestamp);
                                        $r->avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $r->avatar;
                                        $r->format_time = $this->common->get_time_string_simple($this->common->convert_simple_time($r->timestamp));
                                        $r->chatid = $chatid;
                                        if(!empty($r->image_file_name)) {
                                            $r->image_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $r->image_file_name;
                                        } else {
                                            $r->image_file_name = "";
                                        }

                                        if(!empty($r->video_file_name)) {
                                            $r->video_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $r->video_file_name;
                                        } else {
                                            $r->video_file_name = "";
                                        }

                                        if(!empty($r->fromid)) {
                                            $b = $this->feed_model->get_load_detail_story($r->fromid)->row();
                                            if(!empty($b->image_file_name)) {
                                                $b->image_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $b->image_file_name;
                                            } else {
                                                $b->image_file_name = "";
                                            }
                                            if(!empty($b->video_file_name)) {
                                                $b->video_file_name = base_url() . $this->settings->info->upload_path_relative . "/" . $b->video_file_name;
                                            }
                                            $r->story = $b;
                                        } else {
                                            $r->story = array();
                                        }
                                        
                                        
                                        $data[] = $r;
                                    }
                                //} End not friend
                
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
                'chat' => $data
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

    function send_chat_old_post() {
        $code = $this->input->post('cod3');
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $id =  $this->input->post('id');
                $friendid = intval($id);
                $content = $this->common->nohtml($this->input->post('message'));

                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();

                                $fileid = 0;
                                if(isset($_FILES['image_file']['size']) && $_FILES['image_file']['size'] > 0) {
                                    $this->load->library("upload");
                                    // Upload image
                                    $this->upload->initialize(array(
                                    "upload_path" => $this->settings->info->upload_path,
                                    "overwrite" => FALSE,
                                    "max_filename" => 10000,
                                    "encrypt_name" => TRUE,
                                    "remove_spaces" => TRUE,
                                    "allowed_types" => "png|gif|jpeg|jpg|JPG|GIF|PNG",
                                    "max_size" => $this->settings->info->file_size,
                                        )
                                    );

                                    if ( ! $this->upload->do_upload('image_file'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            /*
                                            $this->template->jsonError(lang("error_95") . "<br /><br />" .
                                                $this->upload->display_errors());
                                                */
                                            $status = -1;
                                            $msg = lang("error_95") . "<br /><br />" .
                                            $this->upload->display_errors();
                                    }

                                    $data = $this->upload->data();


                                    $fileid = $this->chat_model->add_image(array(
                                        "file_name" => $data['file_name'],
                                        "file_type" => $data['file_type'],
                                        "extension" => $data['file_ext'],
                                        "file_size" => $data['file_size'], 
                                        "userid" => $user->ID,
                                        "timestamp" => time()
                                        )
                                    );
                                    // Update album count
                                    //$this->image_model->increase_album_count($albumid);
                                }

                                if(empty($message) && empty($fileid)) {
                                    $status = -1;
                                    $msg = lang("error_106");
                                }

                                // Get message
                                $replyid = $this->chat_model->add_chat_message(array(
                                    "chatid" => $chatid,
                                    "userid" => $user->ID,
                                    "message" => $content,
                                    "fileid"=>$fileid,
                                    "timestamp" => time(),
                                    "friendid" => $friendid
                                    )
                                );

                            } // get user
                            else {
                                $status = -2;
                                $msg = "Wrong User";
                            }
                    } // token not null
                    else {
                        $status = -2;
                        $msg = "Empty Token";
                    }

            } // code same
            else {
                $status = -1;
                $msg = "Wrong Code";
            }
            $message = [
                'status' => $status,
                'message' => $msg
            ];
            
            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } // code
        else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Wrong key'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
        }
    }

    public function send_chat_post()
    {
        $code = $this->input->post('cod3');
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                $id =  $this->input->post('id');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {

                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $post = array();
                                $status = 1;
                                $msg = "success";
                                $user = $check->row();

                                $friendid = intval($id);
                                //$friend = $this->user_model->get_user_friend($user->ID, $friendid)->row();
                                
                                //var_dump($friend);
                                
                                //$chatid = $this->input->post("chatid");
                                /*
                                if(empty($friend)) {
                                    $status = -1;
                                    $msg = "This user not your friend";
                                } 
                                else {
                                    */
                                    $chats = $this->chat_model->get_user_chats($user->ID);

                                $chatid = 0;
                                foreach($chats->result() as $r) {
                                    $user_count = $this->chat_model->get_user_count($r->chatid);
                                    if($user_count == 2) {
                                        // Look for friend
                                        $friend = $this->chat_model->get_chat_user($r->chatid, $friendid);
                                        if($friend->num_rows() > 0) {
                                            $chatid = $r->chatid;
                                            break;
                                        }
                                    }
                                }
                                
                                $message = $this->common->nohtml($this->input->post("message"));

                                $fileid = 0;
                                if(isset($_FILES['image_file']['size']) && $_FILES['image_file']['size'] > 0) {
                                    $this->load->library("upload");
                                    // Upload image
                                    $this->upload->initialize(array(
                                    "upload_path" => $this->settings->info->upload_path,
                                    "overwrite" => FALSE,
                                    "max_filename" => 10000,
                                    "encrypt_name" => TRUE,
                                    "remove_spaces" => TRUE,
                                    "allowed_types" => "png|gif|jpeg|jpg|JPG|GIF|PNG",
                                    "max_size" => $this->settings->info->file_size,
                                        )
                                    );

                                    if ( ! $this->upload->do_upload('image_file'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            /*
                                            $this->template->jsonError(lang("error_95") . "<br /><br />" .
                                                $this->upload->display_errors());
                                                */
                                            $status = -1;
                                            $msg = lang("error_95") . "<br /><br />" .
                                            $this->upload->display_errors();
                                    }

                                    $data = $this->upload->data();


                                    $fileid = $this->chat_model->add_image(array(
                                        "file_name" => $data['file_name'],
                                        "file_type" => $data['file_type'],
                                        "extension" => $data['file_ext'],
                                        "file_size" => $data['file_size'], 
                                        "userid" => $user->ID,
                                        "timestamp" => time()
                                        )
                                    );
                                    // Update album count
                                    //$this->image_model->increase_album_count($albumid);
                                }

                                
                                // Video
                                $videoid=0;
                                if(!empty($youtube_url)) {
                                    $matches = array();
                                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $youtube_url, $matches);
                                    if(!isset($matches[0]) || empty($matches[0])) {
                                       // $this->template->jsonError(lang("error_96"));
                                        $status = -1;
                                        $msg = lang("error_96");
                                    }
                                    $youtube_id = $matches[0];
                                    // Add
                                    $videoid = $this->chat_model->add_video(array(
                                        "youtube_id" => $youtube_id,
                                        "userid" => $a->ID,
                                        "timestamp" => time()
                                        )
                                    );
                                } elseif(isset($_FILES['video_file']['size']) && $_FILES['video_file']['size'] > 0) {
                                    $this->load->library("upload");
                                    // Upload image
                                    $this->upload->initialize(array(
                                    "upload_path" => $this->settings->info->upload_path,
                                    "overwrite" => FALSE,
                                    "max_filename" => 300,
                                    "encrypt_name" => TRUE,
                                    "remove_spaces" => TRUE,
                                    "allowed_types" => "avi|mp4|webm|ogv|ogg|3gp|flv|MP4|AVI",
                                    "max_size" => $this->settings->info->file_size,
                                        )
                                    );

                                    if ( ! $this->upload->do_upload('video_file'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $status = -1;
                                            $msg = lang("error_97") . "<br /><br />" .
                                            $this->upload->display_errors() . "<br />" . mime_content_type($_FILES['video_file']['tmp_name']);
                                            /*
                                            $this->template->jsonError(lang("error_97") . "<br /><br />" .
                                                $this->upload->display_errors() . "<br />" . mime_content_type($_FILES['video_file']['tmp_name']));
                                                */
                                    }

                                    $data = $this->upload->data();

                                    $videoid = $this->chat_model->add_video(array(
                                        "file_name" => $data['file_name'],
                                        "file_type" => $data['file_type'],
                                        "extension" => $data['file_ext'],
                                        "file_size" => $data['file_size'],
                                        "userid" => $user->ID,
                                        "timestamp" => time()
                                        )
                                    );
                                }

                                if(empty($message) &&  $fileid == 0 && $videoid == 0) {
                                    $status = -1;
                                    $msg = lang("error_106");
                                }

                                if(!empty($user->ID)) {
                                    if($chatid == 0) {
                                        $title = lang("ctn_643") . " <strong>" . $friendid . "</strong>";
                                        $title2= lang("ctn_643") . " <strong>" . $user->username . "</strong>";
    
                                        // Create Chat
                                        $chatid = $this->chat_model->add_new_chat(array(
                                            "userid" => $user->ID,
                                            "timestamp" => time(),
                                            "posts" => 1
                                            )
                                        );
    
                                        // Get message
                                        $replyid = $this->chat_model->add_chat_message(array(
                                            "chatid" => $chatid,
                                            "userid" => $user->ID,
                                            "friendid" => $id,
                                            "message" => $message,
                                            "fileid"=>$fileid,
                                            "videoid"=>$videoid,
                                            "timestamp" => time()
                                            )
                                        );
    
                                        $this->chat_model->update_chat($chatid, array(
                                            "last_replyid" => $replyid,
                                            "last_reply_timestamp" => time(),
                                            "last_reply_userid" => $user->ID
                                            )
                                        );
    
    
                                        // Add Members
                                        $this->chat_model->add_chat_user(array(
                                            "userid" => $user->ID,
                                            "chatid" => $chatid,
                                            "title" => $title
                                            )
                                        );
    
                                        $this->chat_model->add_chat_user(array(
                                            "userid" => $friendid,
                                            "chatid" => $chatid,
                                            "title" => $title2,
                                            "unread" => 1
                                            )
                                        );

                                        $this->user_model->add_notification(array(
                                            "userid" => $friendid,
                                            "url" => $chatid,
                                            "timestamp" => time(),
                                            "message" => "New Message From $user->first_name",
                                            "status" => 0,
                                            "fromid" => $user->ID,
                                            "username" => $user->username,
                                            "email" => "",
                                            "email_notification" => "",
                                            "type" => 1
                                            )
                                        );
    
                                    } //End First Chat
                                    else {
                                        $chat = $this->chat_model->get_live_chat($chatid);
                                        if($chat->num_rows() == 0) {
                                            $msg = lang("error_88");
                                            $status = -1;
                                           // $this->template->jsonError(lang("error_86"));
                                        }
                                        $chat = $chat->row();

                                        $replyid = $this->chat_model->add_chat_message(array(
                                            "chatid" => $chatid,
                                            "userid" => $user->ID,
                                            "friendid" => $id,
                                            "message" => $message,
                                            "fileid"=>$fileid,
                                            "videoid"=>$videoid,
                                            "timestamp" => time()
                                            )
                                        );

                                        // Update all chat users of unread message
                                        $this->chat_model->update_chat_users($chatid, array(
                                            "unread" => 1
                                            )
                                        );

                                        $this->chat_model->update_chat($chatid, array(
                                            "last_replyid" => $replyid,
                                            "last_reply_timestamp" => time(),
                                            "last_reply_userid" => $user->ID,
                                            "posts" => $chat->posts + 1
                                            )
                                        );

                                        $this->user_model->add_notification(array(
                                            "userid" => $friendid,
                                            "url" => $chatid,
                                            "timestamp" => time(),
                                            "message" => "New Message From $user->first_name",
                                            "status" => 0,
                                            "fromid" => $user->ID,
                                            "username" => $user->username,
                                            "email" => "",
                                            "email_notification" => "",
                                            "type" => 1
                                            )
                                        );
    
                                    }
                                } else {
                                    $status = -1;
                                    $msg = "Message not send";
                                }
                                //} End not friend
                                
                                

                                /*
                                $chats = $this->chat_model->get_user_chats($user->ID);

                                $message = $this->common->nohtml($this->input->post("message"));
                               

                                if(empty($message)) {
                                    $msg = lang("error_88");
                                } else {
                                    $friend = $this->user_model->get_user_friend($user->ID, $friendid);
                                   
                                    if($friend->num_rows() > 0) {
                                        $replyid = $this->chat_model->add_chat_message(array(
                                            "chatid" => $friendid,
                                            "userid" => $user->ID,
                                            "message" => $message,
                                            "timestamp" => time()
                                            )
                                        );
                                    } else {
                                        $status = -1;
                                        $msg = "Invalid friends";
                                    }
                                }
                                */
                               
                                
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
                'message' => $msg
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

    public function get_sos_post() 
	{
        $code = $this->input->post('cod3');
        $list = array();
        if(isset($code)) {
            $post = array();
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
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

                            $lists = $this->chat_model->get_sos($user->ID)->result();
                            foreach($lists as $l) {
                                if(!empty($l->avatar)) {
                                    $l->avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $l->avatar;
                                }

                                $format_date = date('d F Y H:i A',  $l->timestamp);
                                $list[] = array("ID"=>$l->ID,"message"=>$l->reason,"reply"=>$l->reply,"format_date"=>$format_date);
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
                'sos' => $list
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

    public function send_sos_post()
    {
        $code = $this->input->post('cod3');
        $data = array();
        if(isset($code)) {
            if($code == $this->common->keycode()) {
                $token =  $this->input->post('token');
                
                    $warning = '';
                    // pastikan username dan password adalah berupa huruf atau angka.
                    if(!empty($token)) {
                        $message = $this->common->nohtml($this->input->post("message"));

                            $check = $this->user_model->get_user_by_token($token);
                            if($check->num_rows() > 0) {
                                $c = $check->row();

                                $filename = "";
                                if(isset($_FILES['image_file']['size']) && $_FILES['image_file']['size'] > 0) {
                                    $this->load->library("upload");
                                    // Upload image
                                    $this->upload->initialize(array(
                                    "upload_path" => $this->settings->info->upload_path,
                                    "overwrite" => FALSE,
                                    "max_filename" => 10000,
                                    "encrypt_name" => TRUE,
                                    "remove_spaces" => TRUE,
                                    "allowed_types" => "png|gif|jpeg|jpg|JPG|GIF|PNG",
                                    "max_size" => $this->settings->info->file_size,
                                        )
                                    );

                                    if ( ! $this->upload->do_upload('image_file'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            /*
                                            $this->template->jsonError(lang("error_95") . "<br /><br />" .
                                                $this->upload->display_errors());
                                                */
                                            $status = -1;
                                            $msg = lang("error_95") . "<br /><br />" .
                                            $this->upload->display_errors();
                                    }

                                    $data = $this->upload->data();

                                    $filename = $data['file_name'];


                                }

                                if(empty($message) && empty($filename)) {
                                    $status = -1;
                                    $msg = lang("error_106");
                                } else {
                                    $this->user_model->add_report(array(
                                        "userid" => $c->ID,
                                        "timestamp" => time(),
                                        "reason" => $message,
                                        "fromid" =>$c->ID,
                                        "pageid" => 1,
                                        "file_name" => $filename
                                        )
                                    );
    
                                    $this->user_model->add_notification(array(
                                        "userid" => 1,
                                        "url" => "admin/reports",
                                        "timestamp" => time(),
                                        "message" => "SOS from ".$c->username,
                                        "status" => 0,
                                        "fromid" => $c->ID,
                                        "type" => 2
                                        )
                                    );
    
                                    $status = 1;
                                    $msg = "success";
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
                'message' => $msg
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
