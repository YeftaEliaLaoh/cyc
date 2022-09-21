<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller {
	public function index(){
		$data = array();
		
		$cart =  $this->session->userdata('cart');
		if(empty($cart)) {
			$cart = array();
		}

		$data['cart'] = $cart;
		$w = 0;
		$subtotal = 0;
		foreach($cart as $c) {
			$w += $c['weight'];
			$subtotal += $c['harga']*$c['qty'];
		}
		$data['weight'] = $w;
		$data['subtotal'] = $subtotal;
		$data['subtotal_f'] = harga($subtotal);

        $url = 'transaksi/province';
        $gc = url_get($url);
        if(!empty($gc->data)) {
			$provinsi = $gc->data;
		} else {
			$provinsi = array();
		}
		$data['provinsi'] = $provinsi;
        
		$this->template->load(template().'/template',template().'/view_checkout',$data);
  }
    
	
	
}
