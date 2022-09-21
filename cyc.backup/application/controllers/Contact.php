<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends CI_Controller {
	public function index(){
        $data = array();
        
		  $this->template->load(template().'/template',template().'/view_contact',$data);
  }
    
	
	
}
