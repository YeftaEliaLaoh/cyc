<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class History extends CI_Controller {
	public function index(){
        redirect(base_url("history/waiting"));
    }

    public function waiting(){
        $data = array();
        $id = $this->session->id;
		
		$arr = "id_member=$id&status=1";
        $url = 'transaksi/transaksi_history';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }

        $data['product'] = $product;
        
        $data['link'] = $this->uri->segment(1)."/".$this->uri->segment(2);
      
		
        
		$this->template->load(template().'/template',template().'/view_history',$data);
    }

    public function approve(){
        $data = array();

        $id = $this->session->id;
		
		$arr = "id_member=$id&status=2";
        $url = 'transaksi/transaksi_history';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }

        $data['product'] = $product;
        
        $data['link'] = $this->uri->segment(1)."/".$this->uri->segment(2);
		
        
		$this->template->load(template().'/template',template().'/view_history',$data);
    }

    public function reject(){
        $data = array();

        $id = $this->session->id;
		
		$arr = "id_member=$id&status=3";
        $url = 'transaksi/transaksi_history';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }

        $data['product'] = $product;
        
        $data['link'] = $this->uri->segment(1)."/".$this->uri->segment(2);
		
        
		$this->template->load(template().'/template',template().'/view_history',$data);
    }
    
    public function dikirim(){
        $data = array();

        $id = $this->session->id;
		
		$arr = "id_member=$id&status=4";
        $url = 'transaksi/transaksi_history';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }

        $data['product'] = $product;
        
        $data['link'] = $this->uri->segment(1)."/".$this->uri->segment(2);
		
        
		$this->template->load(template().'/template',template().'/view_history',$data);
    }

    public function detail(){
        $data = array();

        $id = $this->session->id;

        $id_trans = $this->uri->segment(3);
		
		$arr = "id_transaksi=$id_trans";
        $url = 'transaksi/transaksi_detail';
        $gc = url_post($url,$arr);
		if(!empty($gc->data)) {
			$product = $gc->data;
		} else {
			$product = array();
        }

        $data['product'] = $product;
        
        $data['link'] = $this->uri->segment(1)."/".$this->uri->segment(2);
		
        
		$this->template->load(template().'/template',template().'/view_history_detail',$data);
    }
	
	
}
