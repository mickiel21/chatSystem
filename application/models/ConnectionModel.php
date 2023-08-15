<?php 
 
class ConnectionModel extends CI_Model{ 
    function __construct() { 
        // Set table name 
        $this->table = 'connections'; 
    } 
    public function all() {
        return $this->db->get('connections')->result();
    }

    public function delete_user($user_id) {
       
       $delete =  $this->db->where('c_user_id', $user_id)
                 ->delete('connections');
        
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
          return false;
        }
    }

    public function delete_resource($resource) {
       
        $this->db->where('c_resource_id', $resource)
        ->delete('connections');
        
        if ($this->db->affected_rows() > 0) {
            return true; // Indicates successful deletion
        } else {
            return false; // Indicates deletion error
        }
    }

    public function insert($connections) {
       
        $this->db->insert('connections', $connections);
    
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
           return false;
        }
    }
     
   
}