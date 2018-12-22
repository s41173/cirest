<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        $this->url = 'http://192.168.43.174/callcenteradmin/index.php/';
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
    }
    
    private $url;
    
    
    function request($url=null,$param=null,$type=null)
    {   
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $param,
        CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        ),
      ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $err = curl_error($curl);
//        $data = json_decode($response, true); 

        curl_close($curl);
        if (!$type){
            if ($err) { return $err; }else { return $response; }
        }else{
            $result = array();
            $result[0] = $response;
            $result[1] = $info['http_code'];
            return $result;
        }
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
    
    function login(){
        
        try{
           $datax = (array)json_decode(file_get_contents('php://input')); 
           $nilai = '{ "custid":"'.$datax['custid'].'", "device":"'.$datax['device'].'" }';
           $url = $this->url.'api/login';
           $response = $this->request($url, $nilai, 'info');
           $result = (array) json_decode($response[0], true);
           return $this->response($result,$response[1]); 
        }catch(\Exception $e){
            return $this->response(null,403);
        }  
    }
    
    function otentikasi(){
        
        try{
           $datax = (array)json_decode(file_get_contents('php://input')); 
           $nilai = '{ "custid":"'.$datax['custid'].'", "log":"'.$datax['log'].'" }';
           $url = $this->url.'api/otentikasi';
           $response = $this->request($url, $nilai, 'info');
           $result = (array) json_decode($response[0], true);
           return $this->response($result,$response[1]); 
        }catch(\Exception $e){
            return $this->response(null,403);
        }
    }
    
    function get_complain(){
        
        try{
           $datax = (array)json_decode(file_get_contents('php://input')); 
           $nilai = '{ "custid":"'.$datax['custid'].'", "limit":"'.$datax['limit'].'", "start":"'.$datax['start'].'" }';
           $url = $this->url.'complain/get_complain_by_customer_json';
           $response = $this->request($url, $nilai, 'info');
           $result = (array) json_decode($response[0], true);
           return $this->response($result,$response[1]); 
        }catch(\Exception $e){
            return $this->response(null,403);
        }
    }
	
}
