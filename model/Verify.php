<?php
 class Verify {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // // Inserting data to verification
    // public function insertVerify($data) {
    //     $this->db->query('INSERT INTO verification (user_id, link_code) VALUES(:userID, :linkCode)');

    //     // Bind values
    //     $this->db->bind(':userID'  , $data['userID']);
    //     $this->db->bind(':linkCode', $data['linkCode']);
  
    //     // Execute
    //     if($this->db->execute()) {
    //       return true;
    //     } else {
    //       return false;
    //     }
    // }

    // // Select a (link code) col 
    // public function selectLinkCode($linkCode) {
    //     $this->db->query("SELECT link_code, created_at AS 'verifyDate' 
    //                     FROM verification
    //                     WHERE link_code = :linkCode");

    //     // Bind value
    //     $this->db->bind(':linkCode', $linkCode);
  
    //     $verifyRow = $this->db->single();
  
    //     // Check row
    //     if($this->db->rowCount() > 0) {
    //       return $verifyRow;
    //     } else {
    //       return false;
    //     }
    //   }

    // // Update the (status) col 
    // public function updateVerifyStatus($data) {
    //     $this->db->query('UPDATE verification SET status = :status
    //                      WHERE user_id = :userID');

    //     // Bind values
    //     $this->db->bind(':userID', $data['userID']);
    //     // $this->db->bind(':linkCode', $data['linkCode']);
    //     $this->db->bind(':status', $data['status']);

    //     // Execute
    //     if($this->db->execute()){
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}