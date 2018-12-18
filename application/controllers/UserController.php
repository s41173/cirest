<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
        
    }
    
    function response($data, $status = 200){ 
          $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ))
            ->_display();
            exit;  
    }
        
    function search(){
       try{
           $datax = (array)json_decode(file_get_contents('php://input'));  
           $result = $this->User->search($datax['no_pelanggan'],$datax['nama_pelanggan'],$datax['id_pelanggan'],$datax['no_meter']);
           if ($result->num_rows() > 0){ return $this->response($result->result()); }else{
            return $this->response(null,404);
           }    
        }catch(\Exception $e){
            return $this->response(null,403);
        }
        
    }
    
    function register(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $data = [
            'email'    => $datax['email'],
            'password' => password_hash($datax['password'], PASSWORD_DEFAULT),
            'created'  => date('Y-m-d H:i:s')
        ];
        return $this->response($this->User->save($data));
    }
    
    function get_all($limit=100){ return $this->response($this->User->get($limit)->result()); }
    
    function get($param){ 
        
        try{
           if ($this->User->get_by_id($param)){ return $this->response($this->User->get_by_id($param)); }else{
            return $this->response(null,404);
           }    
        }catch(\Exception $e){
            return $this->response(null,403);
        }
        
    }
    
    function times($param=null){
        
        $startTime = date("Y-m-d H:i:s");
        $cenvertedTime = date('Y-m-d H:i:s',strtotime('-7 hour',strtotime($startTime)));

        if (!$param){
           return $this->response(array('gmt7' => $startTime, 'gmt' => lockcode_format($cenvertedTime))); 
        }
    }
    
    function infoair(){ 
        try{
           $datax = (array)json_decode(file_get_contents('php://input'));  
           $result = $this->User->infoair($datax['instalasi']);
           if ($result->num_rows() > 0){ return $this->response($result->result()); }else{
            return $this->response(null,404);
           }    
        }catch(\Exception $e){
            return $this->response(null,403);
        }
    }
    
    function infononair(){ 
        try{
           $datax = (array)json_decode(file_get_contents('php://input'));  
           $result = $this->User->infononair($datax['instalasi']);
           if ($result->num_rows() > 0){ return $this->response($result->result()); }else{
            return $this->response(null,404);
           }    
        }catch(\Exception $e){
            return $this->response(null,403);
        }
    }
	
}
