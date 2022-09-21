<?php

class User_Model extends CI_Model 
{

	public function getUser($email, $pass) 
	{
		return $this->db->select("ID")
		->where("email", $email)->where("password", $pass)->get("users");
	}

	public function get_user_by_id($userid) 
	{
		return $this->db->where("ID", $userid)->get("users");
	}

	public function get_user_by_token($token) 
	{
		$select = "users.`ID`, users.`username`, users.`email`, 
				users.first_name, 
				users.personal_club,
				users.last_name, users.`online_timestamp`, users.avatar,
				users.email_notification, users.aboutme, users.points,
				users.premium_time, users.active, users.activate_code,
				users.profile_comments, users.address_1, users.address_2,
				users.city, users.state, users.zipcode, users.country,
				users.noti_count, users.profile_header, users.location_from,
				users.location_live, users.friends, users.pages, users.tag_user,
				users.profile_view, users.posts_view, users.post_profile,
				users.allow_friends, users.allow_pages, users.chat_option,
				users.relationship_status, users.relationship_userid,
				users.user_role, user_roles.name as ur_name,
				user_roles.admin, user_roles.admin_settings, 
				user_roles.admin_members, user_roles.admin_payment,
				user_roles.banned, user_roles.live_chat, user_roles.page_creator,
				user_roles.page_admin, user_roles.post_admin,
				user_roles.ID as user_role_id";
				
		return $this->db->select($select)->where("token", $token)
		->join("user_roles", "user_roles.ID = users.user_role", "left outer")
		->get("users");
	}

	public function get_user_by_email($email) 
	{
		$select = "users.`ID`, users.`username`, users.`email`, 
				users.first_name, 
				users.last_name, users.`online_timestamp`, users.avatar,
				users.email_notification, users.aboutme, users.points,
				users.premium_time, users.active, users.activate_code,
				users.profile_comments, users.address_1, users.address_2,
				users.city, users.state, users.zipcode, users.country,
				users.noti_count, users.profile_header, users.location_from,
				users.location_live, users.friends, users.pages, users.tag_user,
				users.profile_view, users.posts_view, users.post_profile,
				users.allow_friends, users.allow_pages, users.chat_option,
				users.relationship_status, users.relationship_userid,
				users.user_role, user_roles.name as ur_name,
				user_roles.admin, user_roles.admin_settings, 
				user_roles.admin_members, user_roles.admin_payment,
				user_roles.banned, user_roles.live_chat, user_roles.page_creator,
				user_roles.page_admin, user_roles.post_admin,
				user_roles.ID as user_role_id";
				
		return $this->db->select($select)->where("email", $email)
		->join("user_roles", "user_roles.ID = users.user_role", "left outer")
		->get("users");
	}

	public function get_user_by_username($username) 
	{
		return $this->db->where("username", $username)->get("users");
	}
	

	public function delete_user($id) 
	{
		$this->db->where("ID", $id)->delete("users");
	}

	public function get_new_members($limit) 
	{
		return $this->db->select("email, username, joined, oauth_provider, 
			avatar")
		->order_by("ID", "DESC")->limit($limit)->get("users");
	}

	public function get_registered_users_date($month, $year) 
	{
		$s= $this->db->where("joined_date", $month . "-" . $year)->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_oauth_count($provider) 
	{
		$s= $this->db->where("oauth_provider", $provider)->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_total_members_count() 
	{
		$s= $this->db->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_active_today_count() 
	{
		$s= $this->db->where("online_timestamp >", time() - 3600*24)->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_new_today_count() 
	{
		$s= $this->db->where("joined >", time() - 3600*24)->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_online_count() 
	{
		$s= $this->db->where("online_timestamp >", time() - 60*15)->select("COUNT(*) as num")->get("users");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_members($datatable) 
	{
		$datatable->db_order();

		$datatable->db_search(array(
			"users.username",
			"users.first_name",
			"users.last_name",
			"user_roles.name"
			)
		);

		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, users.online_timestamp, users.avatar,
			user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit($datatable->length, $datatable->start)
		->get("users");
	}

	public function get_members_admin($datatable) 
	{
		$datatable->db_order();

		$datatable->db_search(array(
			"users.username",
			"users.first_name",
			"users.last_name",
			"user_roles.name",
			"users.email"
			)
		);

		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, users.online_timestamp, users.avatar,
			user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit($datatable->length, $datatable->start)
		->get("users");
	}

	public function get_members_by_search($search) 
	{
		return $this->db->select("users.username, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit(20)
		->like("users.username", $search)
		->get("users");
	}

	public function search_by_username($search) 
	{
		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit(20)
		->like("users.username", $search)
		->get("users");
	}

	public function search_by_email($search) 
	{
		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit(20)
		->like("users.email", $search)
		->get("users");
	}

	public function search_by_first_name($search) 
	{
		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit(20)
		->like("users.first_name", $search)
		->get("users");
	}

	public function search_by_last_name($search) 
	{
		return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
		->join("user_roles", "user_roles.ID = users.user_role", 
				 	"left outer")
		->limit(20)
		->like("users.last_name", $search)
		->get("users");
	}

	function get_avatar($userid) {
		$q = $this->db->query("SELECT u.avatar FROM users u WHERE u.ID = $userid")->row();
		$file_name = $q->avatar;

		return base_url() . $this->settings->info->upload_path_relative . "/" . $file_name;
	}

	public function get_notifications_like($userid,$limit,$page) 
    {
		return $this->db->query("SELECT `users`.`ID` as `userid`, `users`.`username`, `users`.`avatar`, `user_notifications`.`timestamp`,
		`user_notifications`.`message`, `user_notifications`.`url`, `user_notifications`.`ID`,
		`user_notifications`.`fromid`, `user_notifications`.`status`
		FROM `user_notifications`
		JOIN `users` ON `users`.`ID` = `user_notifications`.`userid`
		WHERE `user_notifications`.`userid` = $userid AND `user_notifications`.message LIKE '%liked%' AND 
		`user_notifications`.`fromid` != $userid
		ORDER BY `user_notifications`.`ID` DESC
		LIMIT $page,$limit");
    }

	public function get_notifications($userid,$limit,$page) 
    {
    	/*return $this->db
    		->where("user_notifications.userid", $userid)
    		->select("users.ID as userid, users.username, users.avatar,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, user_notifications.fromid,
    			user_notifications.status")
    		->join("users", "users.ID = user_notifications.userid")
    		->limit($limit,$page)
    		->order_By("user_notifications.ID", "DESC")
    		->get("user_notifications");
				
				select users.ID as userid, users.username, users.avatar,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, user_notifications.fromid,
    			user_notifications.status from user_notifications 
					join users on users.ID = user_notifications.userid where user_notifications.userid = 33 and message LIKE '%has liked your post!%' GROUP BY url

				select users.ID as userid, users.username, users.avatar,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, user_notifications.fromid,
    			user_notifications.status from user_notifications 
					join users on users.ID = user_notifications.userid where user_notifications.userid = 33  
				
				*/
				$querynotif = "SELECT
							n.*
					FROM
							(
							SELECT
									users.ID AS userid,
									users.username,
									users.avatar,
									user_notifications.timestamp,
									user_notifications.message,
									user_notifications.url,
									user_notifications.ID,
									user_notifications.fromid,
									user_notifications.status
							FROM
									user_notifications
							JOIN users ON users.ID = user_notifications.userid
							WHERE
									user_notifications.userid = $userid AND message NOT LIKE '%has liked your post!%'
							UNION
					SELECT
							users.ID AS userid,
							users.username,
							users.avatar,
							user_notifications.timestamp,
							user_notifications.message,
							user_notifications.url,
							user_notifications.ID,
							user_notifications.fromid,
							user_notifications.status
					FROM
							user_notifications
					JOIN users ON users.ID = user_notifications.userid
					WHERE
							user_notifications.userid = $userid AND message LIKE '%has liked your post!%'
					GROUP BY
							url
					) AS n ORDER BY n.ID DESC LIMIT $page,$limit";
				return $this->db->query($querynotif);
    }

    public function get_notifications_unread($userid) 
    {
    	return $this->db
    		->where("user_notifications.userid", $userid)
    		->select("users.ID as userid, users.username, users.avatar,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, 
    			user_notifications.status")
    		->join("users", "users.ID = user_notifications.fromid")
    		->limit(5)
    		->where("user_notifications.status", 0)
    		->order_By("user_notifications.ID", "DESC")
    		->get("user_notifications");
    }

    public function get_notification($id, $userid) 
    {
    	return $this->db
    		->where("user_notifications.userid", $userid)
    		->where("user_notifications.ID", $id)
    		->select("users.ID as userid, users.username, users.avatar,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, 
    			user_notifications.status")
    		->join("users", "users.ID = user_notifications.fromid")
    		->order_By("user_notifications.ID", "DESC")
    		->get("user_notifications");
    }

    public function get_notifications_all($userid, $datatable) 
    {
    	$datatable->db_order();

		$datatable->db_search(array(
			"users.username",
			"user_notifications.message",
			)
		);

    	return $this->db
    		->where("user_notifications.userid", $userid)
    		->select("users.ID as userid, users.username, users.avatar,
    			users.online_timestamp,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, 
    			user_notifications.status")
    		->join("users", "users.ID = user_notifications.fromid")
    		->limit($datatable->length, $datatable->start)
    		->order_By("user_notifications.ID", "DESC")
    		->get("user_notifications");
    }

    public function get_notifications_all_fp($userid, $page, $max=10) 
    {
    	return $this->db
    		->where("user_notifications.userid", $userid)
    		->select("users.ID as userid, users.username, users.avatar,
    			users.online_timestamp,
    			user_notifications.timestamp, user_notifications.message,
    			user_notifications.url, user_notifications.ID, 
    			user_notifications.status")
    		->join("users", "users.ID = user_notifications.fromid")
    		->limit($max, $page)
    		->order_By("user_notifications.ID", "DESC")
    		->get("user_notifications");
    }

    public function get_notifications_all_total($userid) 
    {
    	$s = $this->db
    		->where("user_notifications.userid", $userid)
    		->select("COUNT(*) as num")
    		->get("user_notifications");
    	$r = $s->row();
    	if(isset($r->num)) return $r->num;
    	return 0;
    }

    public function add_notification($data) 
    {
    	if(isset($data['email']) && isset($data['email_notification']) 
    		&& $data['email_notification']) {
	    	// Send Email
	    	$subject = $this->settings->info->site_name . " Notification!";
	    	if(isset($data['username'])) {
				$body = lang("ctn_665"). " " . $data['username'] . ",";
			} else {
				$body = lang("ctn_666");
			}
			$body .="
			<br /><br />" .lang("ctn_667"). " <a href='".
				site_url()."'>" . site_url() . "</a><br /><br />
			".lang("ctn_668") . "
			<br /><br />
			".lang("ctn_669")."<br />
			" . $this->settings->info->site_name;
			$this->common->send_email($subject, $body, $data['email']);
		}

		$this->send_notif($data);
		unset($data['email']);
		unset($data['email_notification']);
		unset($data['username']);
    	$this->db->insert("user_notifications", $data);
	}
	
	public function send_notif($data) {
		$this->load->model("feed_model");
		$userid = $data["userid"];
		$message = $data["message"];
		$url = $data["url"];
		$fromid = $data["fromid"];
		$timestamp = $data["timestamp"];
		$username = $data["username"];
		$type = $data["type"];
		/*
		$api_key = 'AAAAwZQ6naE:APA91bEkBTtufmsne31llNP-bp-IYUwJNwoQlGgf-KZ_x6yXGoUsx_tw5dKHGACgMorPHSvTd_n--a9scER42_fWAmLXdj9vXR9x4P6z5kvYh2IcQRQSEuoSOR6L5-xJc9Pn3tgVCB6m';
		define( 'API_ACCESS_KEY', $api_key);
		*/

		if(!empty($userid)) {
			$d = $this->db->query("SELECT * FROM users WHERE ID = $userid")->row();
			$token1 = $d->device_id;

			$img_post = $this->feed_model->get_img_post($url,$fromid);
			$im = "";
			if(!empty($img_post)) {
				$im = base_url() . $this->settings->info->upload_path_relative . "/" . $img_post;
			}
			$confirm = 0;
			$title = "Christian Youth Connect";
			if($url == "user_settings/friend_requests") {
				$confirm = $d->posts_view;
//				$title = "CYC Friend Request";
			} else {
//				$title = "CYC Notification";
			}

			$image_post = $im;
			$avatar = base_url() . $this->settings->info->upload_path_relative . "/" . $d->avatar;
			$format_date = date('d F Y H:i A',  $timestamp);
			$confirm = $confirm;

			$body = array(
				'registration_ids' => array($token1), // apabila lebih dari 1 deviceid tapi content sama yg dikirim tinggal dibuat array
				'notification' => array('body' => $message, 'title' => $title,'image'=>$image_post),
				'data' => array("userid"=>$userid,"username"=>$username,"avatar"=>$avatar,"image_post"=>$image_post,"fromid"=>$fromid,"url"=>$url,"format_date"=>$format_date)
			);

			//echo json_encode($body);
		
			$headers = array
					(
						'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
					);
			#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
			$result = curl_exec($ch );
			//echo $result;
			curl_close( $ch );

		}

	}

    public function update_notification($id, $data) 
    {
    	$this->db->where("ID", $id)->update("user_notifications", $data);
    }

    public function update_user_notifications($userid, $data) 
    {
    	$this->db->where("userid", $userid)
    		->update("user_notifications", $data);
    }

    public function increment_field($userid, $field, $amount) 
    {
    	$this->db->where("ID", $userid)
    		->set($field, $field . '+' . $amount, FALSE)->update("users");
    }

    public function decrement_field($userid, $field, $amount) 
    {
    	$this->db->where("ID", $userid)
    		->set($field, $field . '-' . $amount, FALSE)->update("users");
    }

	public function update_user($userid, $data) {
		$this->db->where("ID", $userid)->update("users", $data);
	}

	public function check_block_ip() 
	{
		$s = $this->db->where("IP", $_SERVER['REMOTE_ADDR'])->get("ip_block");
		if($s->num_rows() == 0) return false;
		return true;
	}

	public function get_user_groups($userid) 
	{
		return $this->db->where("user_group_users.userid", $userid)
			->select("user_groups.name,user_groups.ID as groupid,
				user_group_users.userid")
			->join("user_groups", "user_groups.ID = user_group_users.groupid")
			->get("user_group_users");
	}

	public function check_user_in_group($userid, $groupid) 
	{
		$s = $this->db->where("userid", $userid)->where("groupid", $groupid)
			->get("user_group_users");
		if($s->num_rows() == 0) return 0;
		return 1;
	}

	public function get_default_groups() 
	{
		return $this->db->where("default", 1)->get("user_groups");
	}

	public function add_user_to_group($userid, $groupid) 
	{
		$this->db->insert("user_group_users", array(
			"userid" => $userid, 
			"groupid" => $groupid
			)
		);
	}

	public function add_points($userid, $points) 
	{
        $this->db->where("ID", $userid)
        	->set("points", "points+$points", FALSE)->update("users");
    }

    public function get_verify_user($code, $username) 
    {
    	return $this->db
    		->where("activate_code", $code)
    		->where("username", $username)
    		->get("users");
    }

    public function get_user_event($request) 
    {
    	return $this->db->where("IP", $_SERVER['REMOTE_ADDR'])
    		->where("event", $request)
    		->order_by("ID", "DESC")
    		->get("user_events");
    }

    public function add_user_event($data) 
    {
    	$this->db->insert("user_events", $data);
    }

    public function get_custom_fields($data) 
	{
		if(isset($data['register'])) {
			$this->db->where("register", 1);
		}
		return $this->db->get("custom_fields");
	}

	public function add_custom_field($data) 
	{
		$this->db->insert("user_custom_fields", $data);
	}

	public function get_custom_fields_answers($data, $userid) 
	{
		if(isset($data['edit'])) {
			$this->db->where("custom_fields.edit", 1);
		}
		return $this->db
			->select("custom_fields.ID, custom_fields.name, custom_fields.type,
				custom_fields.required, custom_fields.help_text,
				custom_fields.options,
				user_custom_fields.value")
			->join("user_custom_fields", "user_custom_fields.fieldid = custom_fields.ID
			 AND user_custom_fields.userid = " . $userid, "LEFT OUTER")
			->get("custom_fields");

	}

	public function get_user_cf($fieldid, $userid)
	{
		return $this->db
			->where("fieldid", $fieldid)
			->where("userid", $userid)
			->get("user_custom_fields");
	}

	public function update_custom_field($fieldid, $userid, $value) 
	{
		$this->db->where("fieldid", $fieldid)
			->where("userid", $userid)
			->update("user_custom_fields", array("value" => $value));
	}

	public function get_payment_logs($userid, $datatable) 
	{
		$datatable->db_order();

		$datatable->db_search(array(
			"users.username",
			"payment_logs.email"
			)
		);
		return $this->db
			->where("payment_logs.userid", $userid)
			->select("users.ID as userid, users.username, users.email,
			users.avatar, users.online_timestamp,
			payment_logs.email, payment_logs.amount, payment_logs.timestamp, 
			payment_logs.ID, payment_logs.processor")
			->join("users", "users.ID = payment_logs.userid")
			->limit($datatable->length, $datatable->start)
			->get("payment_logs");
	}

	public function get_total_payment_logs_count($userid) 
	{
		$s= $this->db
			->where("userid", $userid)
			->select("COUNT(*) as num")->get("payment_logs");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_profile_comments($userid, $page) 
	{
		return $this->db
			->where("profile_comments.profileid", $userid)
			->select("profile_comments.ID, profile_comments.comment,
				profile_comments.userid, profile_comments.timestamp,
				profile_comments.profileid, profile_comments.userid,
				users.username, users.avatar, users.online_timestamp")
			->join("users", "users.ID = profile_comments.userid")
			->limit(5, $page)
			->order_by("profile_comments.ID", "DESC")
			->get("profile_comments");
	}

	public function add_profile_comment($data) 
	{
		$this->db->insert("profile_comments", $data);
	}

	public function get_profile_comment($id) 
	{
		return $this->db->where("ID", $id)->get("profile_comments");
	}

	public function delete_profile_comment($id) 
	{
		$this->db->where("ID", $id)->delete("profile_comments");
	}

	public function get_total_profile_comments($userid) 
	{
		$s = $this->db
			->where("profile_comments.profileid", $userid)
			->select("COUNT(*) as num")
			->get("profile_comments");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function increase_profile_views($userid) 
	{
		$this->db->where("ID", $userid)->set("profile_views", "profile_views+1", FALSE)->update("users");
	}

	public function add_user_data($data) 
	{
		$this->db->insert("user_data", $data);
	}

	public function update_user_data($id, $data) 
	{
		$this->db->where("ID", $id)->update("user_data", $data);
	}

	public function get_user_data($userid) 
	{
		return $this->db->where("userid", $userid)->get("user_data");
	}

	public function get_user_role($roleid) 
    {
    	return $this->db->where("ID", $roleid)->get("user_roles");
    }

	public function get_users_with_permissions($permissions) 
	{

		foreach($permissions as $p) {
			$this->db->or_where("user_roles." . $p, 1);
		}

		return $this->db
			->select("users.ID as userid, users.username, users.email, users.first_name,
				users.last_name, users.online_timestamp")
			->join("user_roles", "user_roles.ID = users.user_role")
			->get("users");
	}

	public function get_all_user_groups() 
	{
		return $this->db->get("user_groups");
	}

	public function get_user_group($id) 
	{
		return $this->db->where("ID", $id)->get("user_groups");
	}

	public function get_user_friends_id($userid,$id) {
		return $this->db->query("SELECT * FROM user_friends WHERE userid = $userid AND friendid = $id");
	}

	public function get_user_friends($userid, $limit,$page = 0) 
	{
		return $this->db
			->select("users.username, users.first_name, users.last_name,
				users.avatar, users.online_timestamp, users.ID as friendid")
			->where("user_friends.userid", $userid)
			->join("users", "users.ID = user_friends.friendid")
			->order_by("users.online_timestamp", "DESC")
			->limit($limit,$page)
			->get("user_friends");
	}

	public function get_user_friends_story($userid,$friendall, $limit,$page) 
	{
		/*
		return $this->db
		->query("SELECT `users`.`username`, `users`.`first_name`, `users`.`last_name`, `users`.`avatar`, `users`.`online_timestamp`, `users`.`ID` as `friendid`,b2.ID,b2.story_id,b2.count_story
		FROM `user_friends`
		JOIN `users` ON `users`.`ID` = `user_friends`.`friendid`
		LEFT JOIN
		(
			SELECT rh.ID,MIN(rh.`timestamp`) as waktu,rh.userid,GROUP_CONCAT(rh.ID) as story_id,COUNT(rh.ID) as count_story
			FROM feed_item rh WHERE rh.type = 2 AND rh.userid IN ($friendall)
			AND rh.`timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)
		) b2 ON users.ID = b2.userid
		WHERE `user_friends`.`userid` = $userid AND b2.ID IS NOT NULL
		ORDER BY `users`.`online_timestamp` DESC
		 LIMIT $limit");
		 */
		
		return $this->db->query("SELECT u.*, u.`ID` as `friendid`,b2.ID,b2.story_id,b2.count_story
		FROM users u LEFT JOIN (SELECT rh.ID,MIN(rh.`timestamp`) as waktu,rh.userid,GROUP_CONCAT(rh.ID) as story_id,COUNT(rh.ID) as count_story
					FROM feed_item rh WHERE rh.type = 2 AND rh.userid IN ($friendall)
					AND rh.`timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)) b2 ON u.ID=b2.userid
					WHERE b2.ID IS NOT NULL
				ORDER BY u.`online_timestamp` DESC
				 LIMIT 100");
				 
		// if($friendall != "") {
		// 	$friendall = " AND rh.userid IN ($friendall) ";
		// }
		// $query = "SELECT u.*, u.`ID` as `friendid`,b2.ID,b2.story_id,b2.count_story
		// FROM users u LEFT JOIN (SELECT rh.ID,MIN(rh.`timestamp`) as waktu,rh.userid,GROUP_CONCAT(rh.ID) as story_id,COUNT(rh.ID) as count_story
		// 			FROM feed_item rh WHERE rh.type = 2 $friendall
        //             AND rh.timestamp >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))  GROUP BY rh.userid) b2 ON u.ID=b2.userid
		// 			WHERE b2.ID IS NOT NULL
		// 		ORDER BY u.`online_timestamp` DESC
		// 		 LIMIT 100";
		
		// return $this->db->query($query);
	}

	public function get_friend_story($id) 
	{
		$value = $this->db
		->query("SELECT `u`.`username`, `u`.`first_name`, `u`.`last_name`, `u`.`avatar`,
		`u`.`online_timestamp`,rh.*
		FROM `users` u LEFT JOIN feed_item rh ON rh.userid=u.ID
		WHERE rh.`ID` = $id");
		// $value = array();
		// var_dump($dry)
		// foreach($dry as $d) {
		// 	$img = "";
		// 	if(!empty($d->imageid)) {
				
		// 		$m = $this->feed_model->get_feed_images($d->imageid)->row();
		// 		$img = $m->file_name;
				
		// 	}
		// 	$d->full_image = $img;
		// 	$value = $d;
		// }

		return $value;
	}

	public function get_user_story($userid) 
	{
		return $this->db
		->query("SELECT `users`.`username`, `users`.`first_name`, `users`.`last_name`, `users`.`avatar`,
		`users`.`online_timestamp`, `users`.`ID` as userid,b2.ID
		FROM `users` LEFT JOIN
		(
		SELECT rh.ID,MIN(rh.`timestamp`) as waktu,rh.userid
		FROM feed_item rh WHERE rh.type = 2 AND rh.`timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY) AND rh.userid = $userid
		) b2 ON users.ID = b2.userid
		WHERE `users`.`ID` = $userid AND b2.ID IS NOT NULL
		ORDER BY `users`.`online_timestamp` DESC");
	}

	public function get_user_friends_chat($userid, $limit) 
	{
		return $this->db
			->query("SELECT `users`.`username`, `users`.`first_name`, `users`.`last_name`, `users`.`avatar`, `users`.`online_timestamp`, `users`.`ID` as `friendid`,
			(SELECT lc.chatid FROM live_chat_users lc WHERE lc.userid=`users`.`ID`) as chatid
			FROM `user_friends`
			JOIN `users` ON `users`.`ID` = `user_friends`.`friendid`
			WHERE `user_friends`.`userid` = $userid
			ORDER BY `users`.`online_timestamp` DESC
			 LIMIT $limit");
	}

	public function get_usernames($username) 
    {
    	return $this->db->like("username", $username)->limit(10)->get("users");
    }

    public function get_user_by_name($query) 
    {
    	return $this->db->like("first_name", $query)->or_like("last_name", $query)->limit(10)->get("users");
	}
	
	public function get_user_by_name_friends($userid,$query,$limit=10,$page = 0,$type = 1) 
    {
		/*
		return $this->db->like("first_name", $query)->limit($limit,$page)->get("users");
		*/
		if(!empty($query)) {
			//$wh = "u.first_name REGEXP '$query'";
			$wh = " u.first_name LIKE '$query%' OR u.username LIKE '$query%'";
			// $wh = " u.first_name LIKE '%$query%' OR u.last_name LIKE '%$query%' OR u.username LIKE '%$query%'";
		} else {
			$wh = "u.first_name LIKE '%%'";
		}
		if($type == 1) { // All List
		/*
			$qry = "SELECT u.*,(SELECT COUNT(*) FROM user_friends uf WHERE uf.userid = $userid AND uf.friendid=u.ID ) as teman FROM users u WHERE $wh
			AND u.ID != $userid LIMIT $page,$limit";
			return $this->db->query($qry);
			*/
			$qry = "SELECT u.* FROM users u WHERE $wh
			AND u.ID != $userid ORDER BY u.username LIMIT $page,$limit";
			return $this->db->query($qry);
		} 
		if($type == 2) { // Friend List
			return $this->db
			->select("users.username, users.first_name, users.last_name,
				users.avatar, users.online_timestamp, users.ID as friendid")
			->where("user_friends.userid", $userid)
			->like("users.first_name", $query)
			->join("users", "users.ID = user_friends.friendid")
			->order_by("users.online_timestamp", "DESC")
			->limit($limit,$page)
			->get("user_friends");
		}

		if($type == 3) { // Friend Request
			return $this->db
    		->select("user_friend_requests.ID as friendid, user_friend_requests.timestamp,
    			users.ID as userid, users.avatar, users.first_name, users.last_name,
    			users.online_timestamp, users.username")
    		->join("users", "users.ID = user_friend_requests.userid")
			->where("user_friend_requests.friendid", $userid)
			->like("users.first_name", $query)
			->limit($limit,$page)
    		->get("user_friend_requests");
		}
		
    }

    public function get_names($name) 
    {
    	return $this->db->like("first_name", $name)->or_like("last_name", $name)->limit(10)->get("users");
    }

    public function get_friend_names($name, $userid) 
    {
    	return $this->db
    		->where("user_friends.userid", $userid)
    		->group_start()
    		->like("users.first_name", $name)
    		->or_like("users.last_name", $name)
    		->group_end()
    		->select("users.ID, users.username, users.first_name, users.last_name,
    			users.email, users.online_timestamp, users.avatar")
    		->join("users", "users.ID = user_friends.friendid")
    		->limit(10)
    		->get("user_friends");
    } 

    public function get_user_friend($userid, $friendid) 
    {
    	return $this->db
    		->where("userid", $userid)
    		->where("friendid", $friendid)
    		->get("user_friends");
    }

    public function check_friend_request($userid, $friendid) 
    {
    	return $this->db
    		->where("userid", $userid)
    		->where("friendid", $friendid)
    		->get("user_friend_requests");
	}
	
	public function check_tanggap_teman($userid, $friendid) 
    {
    	return $this->db
    		->where("userid", $friendid)
    		->where("friendid", $userid)
    		->get("user_friend_requests");
    }

    public function add_friend_request($data) 
    {
    	$this->db->insert("user_friend_requests", $data);
    }

    public function get_friend_requests($userid) 
    {
    	return $this->db
    		->select("user_friend_requests.ID, user_friend_requests.timestamp,user_friend_requests.status,
    			users.ID as userid, users.avatar, users.first_name, users.last_name,
    			users.online_timestamp, users.username")
    		->join("users", "users.ID = user_friend_requests.userid")
    		->where("user_friend_requests.friendid", $userid)
    		->get("user_friend_requests");
	}
	
	public function get_subscribers($userid) 
    {
    	return $this->db
    		->select("user_subscribers.ID, user_subscribers.timestamp,
    			users.ID as userid, users.avatar, users.first_name, users.last_name,
    			users.online_timestamp, users.username")
    		->join("users", "users.ID = user_subscribers.friendid")
    		->where("user_subscribers.friendid", $userid)
    		->get("user_subscribers");
    }

    public function get_friend_request($id, $userid) 
    {
    	return $this->db->where("user_friend_requests.ID", $id)
    		->where("user_friend_requests.friendid", $userid)
    		->select("user_friend_requests.ID, users.ID as userid, users.first_name,
    			users.last_name, users.avatar, users.online_timestamp,
    			users.email, users.email_notification, users.username")
    		->join("users", "users.ID = user_friend_requests.userid")
    		->get("user_friend_requests");
    }

    public function delete_friend_request($id) 
    {
    	$this->db->where("ID", $id)->delete("user_friend_requests");
    }

    public function add_friend($data) 
    {
    	$this->db->insert("user_friends", $data);
    }

    public function get_user_friends_sample($userid) 
    {
    	return $this->db->where("user_friends.userid", $userid)
    		->select("users.username, users.first_name, users.last_name, users.avatar,
    			users.online_timestamp, users.ID as userid,
    			user_friends.ID")
    		->join("users", "users.ID = user_friends.friendid")
    		->limit(6)
    		->get("user_friends");
	}
	/*
	function get_total_following($userid) {
		$s = $this->db
    		->where("user_friend_requests.userid", $userid)
    		->select("COUNT(*) as num")->get("user_friend_requests");
    	$r = $s->row();
    	if(isset($r->num)) return $r->num;
		return 0;
		
	}
	
	function get_total_follower($userid) {
		$s = $this->db
    		->where("user_friend_requests.friendid", $userid)
    		->select("COUNT(*) as num")->get("user_friend_requests");
    	$r = $s->row();
    	if(isset($r->num)) return $r->num;
		return 0;
		
	}
	*/

	public function get_following($userid,$friendid) 
	{
		$a = $this->db->query("SELECT A.friendid as friendid,A.`status`,b.username, b.first_name, b.last_name,
		b.avatar, b.online_timestamp FROM (
	SELECT friendid,`status` FROM user_friend_requests WHERE userid = $userid AND friendid = $friendid
	UNION
	SELECT friendid,0 as status FROM user_friends WHERE userid = $userid AND friendid = $friendid
	) A LEFT JOIN users b ON b.ID=A.friendid");
		$c = $a->row();
		if(!empty($c)) {
			$a = 1;
		} else {
			$a = 0;
		}
		return $a;
	}

	public function get_list_following($userid,$limit = 1000,$page = 0) 
	{
		$a = $this->db->query("SELECT A.friendid as friendid,A.`status`,b.username, b.first_name, b.last_name,
		b.avatar, b.online_timestamp FROM (
	SELECT friendid,`status` FROM user_friend_requests WHERE userid = $userid
	UNION
	SELECT friendid,0 as status FROM user_friends WHERE userid = $userid
	) A LEFT JOIN users b ON b.ID=A.friendid");
		return $a;
	}
	
	public function get_list_follower($userid, $limit,$page = 0) 
	{
		$a = $this->db->query("SELECT A.userid as friendid,A.`status`,b.username, b.first_name, b.last_name,
		b.avatar, b.online_timestamp FROM (
	SELECT userid,`status` FROM user_friend_requests WHERE friendid = $userid
	UNION
	SELECT userid,0 as status FROM user_friends WHERE friendid = $userid
	) A LEFT JOIN users b ON b.ID=A.userid");
		return $a;
	}

	function get_total_following($userid) {
		$a = $this->db->query("SELECT COUNT(A.friendid) as total FROM (
			SELECT friendid FROM user_friend_requests WHERE userid = $userid
			UNION
			SELECT friendid FROM user_friends WHERE userid = $userid
			) A")->row();
		if(!empty($a->total)) {
			$val = $a->total;
		} else {
			$val = 0;
		}
		return $val;
	}

	
	function get_total_follower($userid) {
		$a = $this->db->query("SELECT COUNT(A.userid) as total FROM (
			SELECT userid FROM user_friend_requests WHERE friendid = $userid
			UNION
			SELECT userid FROM user_friends WHERE friendid = $userid
			) A")->row();
		if(!empty($a->total)) {
			$val = $a->total;
		} else {
			$val = 0;
		}
		return $val;
		
	}

/*
	function get_list_following($userid) {
		$s = $this->db
    		->where("user_friend_requests.userid", $userid)
    		->select("*")->get("user_friend_requests");
		$r = $s->result();
		
		return $r;
		
	}

	public function get_list_following($userid,$limit = 1000,$page = 0) 
	{
		return $this->db
			->select("users.username, users.first_name, users.last_name,
				users.avatar, users.online_timestamp, users.ID as friendid,user_friend_requests.status")
			->where("user_friend_requests.userid", $userid)
			->join("users", "users.ID = user_friend_requests.friendid")
			->order_by("users.online_timestamp", "DESC")
			->limit($limit,$page)
			->get("user_friend_requests");
	}
	
	public function get_list_follower($userid, $limit,$page = 0) 
	{
		return $this->db
			->select("users.username, users.first_name, users.last_name,
				users.avatar, users.online_timestamp, users.ID as friendid,user_friend_requests.status")
			->where("user_friend_requests.friendid", $userid)
			->join("users", "users.ID = user_friend_requests.userid")
			->order_by("users.online_timestamp", "DESC")
			->limit($limit,$page)
			->get("user_friend_requests");
	}

	function get_list_follower($userid) {
		$s = $this->db
    		->where("user_friend_requests.friendid", $userid)
    		->select("*")->get("user_friend_requests");
		$r = $s->result();
		
		return $r;
		
	}
*/
    public function get_total_friends_count($userid) 
    {
    	$s = $this->db
    		->where("user_friends.userid", $userid)
    		->select("COUNT(*) as num")->get("user_friends");
    	$r = $s->row();
    	if(isset($r->num)) return $r->num;
    	return 0;
    }

    public function get_user_friends_dt($userid, $datatable) 
    {
    	$datatable->db_order();

		$datatable->db_search(array(
			"users.username",
			"users.first_name",
			"users.last_name"
			),
			true // Cache query
		);
		$this->db
			->where("user_friends.userid", $userid)
			->select("users.ID as userid, users.username, users.email,
			users.avatar, users.online_timestamp,
			users.first_name, users.last_name,
			user_friends.timestamp, user_friends.ID")
			->join("users", "users.ID = user_friends.friendid");
		return $datatable->get("user_friends");
	}

    public function get_user_friend_id($id, $userid) 
    {
    	return $this->db->where("ID", $id)->where("userid", $userid)->get("user_friends");
    }

    public function delete_friend($userid, $friendid) 
    {
    	$this->db->where("userid", $userid)->where("friendid", $friendid)->delete("user_friends");
    	$this->db->where("userid", $friendid)->where("friendid", $userid)->delete("user_friends");
	}

	public function check_following($userid,$friendid) 
    {
    	return $this->db->where("userid", $userid)->where("friendid", $friendid)->get("user_friend_requests")->row();
    }
	
	public function unfollow_friend_following($id,$friendid) 
    {
		$this->db->where("userid", $id)->where("friendid", $friendid)->delete("user_friend_requests");
		$this->db->where("userid", $id)->where("friendid", $friendid)->delete("user_friends");
    }

    public function add_report($data) 
    {
    	$this->db->insert("reports", $data);
    }

    public function add_relationship_request($data) 
    {
    	$this->db->insert("relationship_requests", $data);
    }

    public function get_relationship_request($userid) 
    {
    	return $this->db
    		->where("relationship_requests.friendid", $userid)
    		->select("relationship_requests.ID, users.first_name,
    		users.last_name, users.username")
    		->join("users", "users.ID = relationship_requests.userid")
    		->get("relationship_requests");
    }

    public function get_relationship_request_invites($userid) 
    {
    	return $this->db
    		->where("relationship_requests.userid", $userid)
    		->select("relationship_requests.ID, relationship_requests.relationship_status,
    			users.first_name,
    		users.last_name, users.username")
    		->join("users", "users.ID = relationship_requests.friendid")
    		->get("relationship_requests");
    }

    public function get_relationship_request_id($id) 
    {
    	return $this->db->where("ID", $id)->get("relationship_requests");
    }

    public function delete_relationship_request($id) 
    {
    	$this->db->where("ID", $id)->delete("relationship_requests");
    }

    public function check_relationship_request($userid, $friendid) 
    {
    	return $this->db->where("userid", $userid)->where("friendid", $friendid)->get("relationship_requests");
    }

    public function delete_relationship_request_from_user($userid) 
    {
    	$this->db->where("userid", $userid)->delete("relationship_requests");
    }

    public function get_newest_users($userid) 
    {
    	return $this->db->where("ID !=", $userid)->limit(5)->order_by("ID", "DESC")->get("users");
    }

    public function increase_posts($userid) 
    {
    	$this->db->where("ID", $userid)->set("post_count", "post_count+1", FALSE)->update("users");
	}
	
	public function update_friend_request($id,$stat) 
    {
    	$this->db->where("ID", $id)->set("status", $stat)->update("user_friend_requests");
    }

    public function decrease_posts($userid) 
    {
    	$this->db->where("ID", $userid)->set("post_count", "post_count-1", FALSE)->update("users");
	}
	
	public function get_profile($userid) 
    {
		return $this->db->query("SELECT u.*,p.`name` as province_name, c.`name` as city_name, s.`name` as subdistrict_name,(SELECT COUNT(f.ID) as total FROM feed_item f WHERE f.userid = $userid AND f.type = 2) as total_story FROM users u LEFT JOIN provinces p ON p.id=u.province 
		LEFT JOIN city c ON c.id=u.city
		LEFT JOIN subdistrict s ON s.id=u.subdistrict
		WHERE u.ID = $userid");
	}
	
	public function delete_user_feed_like($id) 
	{
		$this->db->where("userid", $id)->delete("feed_likes");
	}

	public function delete_user_feed_item($id) 
	{
		$this->db->where("userid", $id)->delete("feed_item");
	}

	public function delete_user_subscriber($id) 
	{
		$this->db->where("userid", $id)->delete("user_subscribers");
	}

	public function delete_chat($id) 
	{
		$this->db->where("userid", $id)->delete("live_chat_users");
	}

	public function delete_user_comment($id) 
	{
		$this->db->where("userid", $id)->delete("feed_item_comments");
	}

	public function delete_user_friendreq($id) 
	{
		$this->db->where("userid", $id)->delete("user_friend_requests");
	}

	public function delete_user_friend($id) 
	{
		$this->db->where("userid", $id)->delete("user_friends");
	}

	public function delete_user_friend_id($id) 
	{
		$this->db->where("ID", $id)->delete("user_friends");
	}

	public function in_active_user_by_username($username, $data)
	{
		$this->db->where("username", $username)->update("users", $data);
	}


}

?>