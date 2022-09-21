<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Listproduct extends CI_Controller {
	
    
	public function crazy(){
        
		$data['title'] = "Crazy Sale";
		
		$gc = url_get('category/product_crazy');
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
		}
		
		
		$data['product'] = $product;
        
		$this->template->load(template().'/template',template().'/view_list_product',$data);
	}
	
	public function all(){
        
		$data['title'] = "List Product";
		
		$gc = url_get('category/new_product');
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
		}
		
		
		$data['product'] = $product;
        
		$this->template->load(template().'/template',template().'/view_list_product',$data);
    }
	
	public function detail($id){
        
		$data['title'] = "Product Detail";
		
		$arr = "id_product=$id";
        $url = 'category/product_detail';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }
		
		$data['product'] = $product;

		$arr = "id_product=$id";
        $url = 'category/product_variant';
        $gc2 = url_post($url,$arr);
		if(!empty($gc2->data)) {
			$varian = $gc2->data;
		} else {
			$varian = array();
        }
		
		$data['varian'] = $varian;
		
		//$this->session->unset_userdata("cart");
        
		$this->template->load(template().'/template',template().'/view_product_detail',$data);
	}
	
	public function search(){
		$keyword = $this->input->post("keyword");
        
		$data['title'] = "Product Search $keyword";
		
		$arr = "type_product=&keyword=$keyword&type=";
        $url = 'category/all_product';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }
		
		$data['product'] = $product;
        
		$this->template->load(template().'/template',template().'/view_list_product',$data);
    }
	
}
