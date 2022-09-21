<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utama extends CI_Controller {
	public function index(){
		$b = url_get('category/banner');
		
		
		
		if(!empty($b->data)) {
			$banner = $b->data;
		} else {
			$banner = array();
		}
		$data['banner'] = $banner;

		$c = url_get('category/product_crazy');
		
		if(!empty($c->data)) {
			$crazy = $c->data;
		} else {
			$crazy = array();
		}
		
		$data['crazy'] = $crazy;

		$p = url_get('category/new_product');
		//$new = $p->data;
		
		
		if(!empty($p->data)) {
			$new = $p->data;
		} else {
			$new = array();
		}
		$data['new'] = $new;

		$gc = url_get('category?type=1');
		if(!empty($gc->data)) {
			$category = $gc->data;
		} else {
			$category = array();
		}
		
		
		$data['category'] = $category;
	
		$this->template->load(template().'/template',template().'/view_home',$data);
	}

	public function category() {

		$gc = url_get('category?type=1');
		if(!empty($gc->data)) {
			$category = $gc->data;
		} else {
			$category = array();
		}
		
		
		$data['category'] = $category;


		$this->template->load(template().'/template',template().'/view_category',$data);

	}

	public function profile() {
		$id = $this->session->id;

		$gc = url_get("member/index/id/$id");
		if(!empty($gc->data)) {
			$profile = $gc->data;
		} else {
			$profile = array();
		}
		
		$data['profile'] = $profile;


		$this->template->load(template().'/template',template().'/view_profile',$data);

	}

	public function reqwhole() {
		$id = $this->session->id;

		$gc = url_get("member/index/id/$id");
		if(!empty($gc->data)) {
			$profile = $gc->data;
		} else {
			$profile = array();
		}

		$data['profile'] = $profile;


		$this->template->load(template().'/template',template().'/view_reqwhole',$data);

	}

	public function chat() {
		$id = $this->session->id;

		$arr = "id_member=$id";
        $url = 'member/list_chat_detail';
        $gc = url_post($url,$arr);
        if(!empty($gc->data)) {
			$chat = $gc->data;
		} else {
			$chat = array();
		}
		$data['chat'] = $chat;


		$this->template->load(template().'/template',template().'/view_chat',$data);

	}

	public function category_detail($id) {

		$arr = "id_kategori=$id";
        $url = 'category';
        $gc = url_post($url,$arr);
        if(!empty($gc->data)) {
			$cate = $gc->data;
		} else {
			$cate = array();
		}
		$data['category'] = $cate;


		$this->template->load(template().'/template',template().'/view_category_detail',$data);

	}

	public function subcategory_detail($id) {
		$arr = "id_subcategory=$id&type=2";
        $url = 'category/product_subcategory';
        $gc = url_post($url,$arr);
        if(!empty($gc->data)) {
			$cate = $gc->data;
		} else {
			$cate = array();
		}
		$data['product'] = $cate;


		$this->template->load(template().'/template',template().'/view_subcategory_detail',$data);

	}

	public function subcategory() {

		$gc = url_get('category?type=2');
		if(!empty($gc->data)) {
			$scategory = $gc->data;
		} else {
			$scategory = array();
		}
		
		$data['subcategory'] = $scategory;


		$this->template->load(template().'/template',template().'/view_subcategory',$data);

	}
	
	
}
