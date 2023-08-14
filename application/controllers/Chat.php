<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat extends CI_Controller {
    public function index() {
        $this->load->view('chat_view');
    }
}

