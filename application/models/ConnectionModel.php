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
            return $delete;
        } else {
          echo "error";
        }
    }

    public function delete_resource($resoure_id) {
       
        $delete =  $this->db->where('c_resource_id', $resoure_id)
                  ->delete('connections');
         
         if ($this->db->affected_rows() > 0) {
             return $delete;
         } else {
           echo "error";
         }
     }

    public function insert($connections) {
       
        $this->db->insert('connections', $connections);
    
        if ($this->db->affected_rows() > 0) {
            // Connections inserted successfully
            // ...
        } else {
            // No connections inserted or an error occurred
            // ...
        }
    }
     
   
}