<?php
namespace Application\Controllers;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require_once 'C:\laragon\www\chatSystem\index.php';
class ChatSocket implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
       
    }

    public function onOpen(ConnectionInterface $conn) {
        $CI = &get_instance();
        $CI->load->model('usermodel');
        $CI->load->model('connectionmodel');
        // Store the new connection to send messages to later

        // ws://localhost:8080/?access_token=12312313
        $uriQuery = $conn->httpRequest->getUri()->getQuery(); //access_token=12312313
        $uriQueryArr = explode('=',$uriQuery); //$uriQueryArr[1]
        // $userModel = new UserModel();
        // $conModel = new ConnectionsModel();

        $user = $CI->usermodel->get_user_by_id($uriQueryArr[1]);
        $conn->user = $user;
       
        $this->clients->attach($conn);

        $CI->connectionmodel->delete_user($user->id);

        $conData = [
                'c_user_id' => $user->id,
                'c_resource_id' => $conn->resourceId,
                'c_name' => $user->first_name
        ];

        $CI->connectionmodel->insert($conData);


        $users = $CI->connectionmodel->all();
        $users = ['users' => $users];

        foreach ($this->clients as $client) {
            $client->send(json_encode($users));
        }


        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $CI = &get_instance();
        $CI->load->model('connectionmodel');
        $CI->load->model('usermodel');
        $this->clients->detach($conn);

        
        $CI->connectionmodel->delete_user($conn->resourceId);
      
        $users = $CI->connectionmodel->all();
        $users = ['users' => $users];

        foreach ($this->clients as $client) {
            $client->send(json_encode($users));
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}