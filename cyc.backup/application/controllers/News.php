<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class News extends CI_Controller {
	
    
	public function index(){
        
        $data['title'] = "News";
        $arr = "limit=1&offset=0";
        $url = 'news';
        $gc = url_post($url,$arr);
        if(!empty($gc->data)) {
			$news = $gc->data;
		} else {
			$news = array();
		}
		$data['news'] = $news;
        
		$this->template->load(template().'/template',template().'/view_news',$data);
	}
	
	public function detail($id){
        
		$data['title'] = "Detail News";
		
        $arr = "id_news=$id";
        $url = 'news/news_detail';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }
		
		$data['product'] = $product;
        
		$this->template->load(template().'/template',template().'/view_news_detail',$data);
    }
	
}
