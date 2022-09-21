<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Outlet extends CI_Controller {
	
    
	public function index(){
        
        $data['title'] = "Outlet";
        
        $url = 'master/outlet';
        $gc = url_get($url);
        if(!empty($gc->data)) {
			$outlet = $gc->data;
		} else {
			$outlet = array();
		}
		$data['outlet'] = $outlet;
        
		$this->template->load(template().'/template',template().'/view_outlet',$data);
	}
	
	public function factory(){
        
		
		
        $url = "master/pabrik";
        $gc = url_get($url);

		if(!empty($gc->data)) {
			$pabrik = $gc->data;
		} else {
			$pabrik = array();
        }
        $data['title'] = "Factory";
		
		$data['factory'] = $pabrik;
        
		$this->template->load(template().'/template',template().'/view_factory',$data);
    }
}
