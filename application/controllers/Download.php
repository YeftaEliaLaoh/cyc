<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends CI_Controller {
	
    
	public function index(){
        
        $data['title'] = "Download - Kategori";
        
        $url = 'category/catalogue';
        $gc = url_get($url);
        if(!empty($gc->data)) {
			$download = $gc->data;
		} else {
			$download = array();
		}
		$data['download'] = $download;
        
		$this->template->load(template().'/template',template().'/view_download',$data);
	}
	
	public function detail($id){
        
		
		
        $url = "master/ecatalogue/$id";
        $gc = url_get($url);

		if(!empty($gc->data)) {
			$download = $gc->data;
			
			foreach($download as $d){
				$kategori = $d->kategori;
			}

			$data['title'] = "Kategori $kategori";
			$data['height'] = '';
		} else {
			$download = array();
			$kategori = "No Data";
			$data['title'] = "$kategori";
			$data['height'] = 'style="height:30em;"';
		}
		
		//var_dump($kategori);

        
		
		$data['download'] = $download;
        
		$this->template->load(template().'/template',template().'/view_download_detail',$data);
		
    }
}
