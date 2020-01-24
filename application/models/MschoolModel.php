<?php
defined('BASEPATH') OR exit('No direct script access allowed');
     
class MschoolModel extends CI_Model {
     
    function __construct(){
    	parent::__construct();
    }

    function getAllSchools(){
        $query = $this->db->query('SELECT * FROM info');
        return $query->result();
    }

    function getOneById($id){
        $sql = 'SELECT * FROM info WHERE id = ?';
        $query = $this->db->query($sql, array($id));

        return $query->row();
    }

    function getByLetter($letter){
        $sql = 'SELECT * FROM info WHERE name LIKE ?';
        $query = $this->db->query($sql, array($letter . '%'));

        return $query->result();
    }

    public function getSchoolsByList($ids){
        $sql = 'SELECT * FROM info WHERE id IN ?';
        
        $query = $this->db->query($sql, array($ids));

        return $query->result();
    }
    
    function insertCookiesConsent($ip, $date){
        $sql = 'INSERT INTO cookies_consent (ip_address, consent_date) VALUES (?, ?)';

        $query = $this->db->query($sql, array($ip, $date));

        return ($this->db->affected_rows() > 0);
    }

    function getBlockedEmail($email){
        $sql = 'SELECT * FROM blocked_email WHERE email = ?';

        $query = $this->db->query($sql, array($email));

        return ($this->db->affected_rows() > 0);
    }

    function insertConsent($email, $date){
        $sql = 'INSERT INTO consent (email, consent_date) VALUES (?, ?)';

        $query = $this->db->query($sql, array($email, $date));

        return ($this->db->affected_rows() > 0);
    }

}