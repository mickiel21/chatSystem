<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat extends CI_Controller {

    function __construct() { 
        parent::__construct(); 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    } 
    public function index() {
        if($this->isUserLoggedIn){
            $this->load->view('chat_view');
        }else{
            redirect('user/login'); 
        }
        
    }
}

