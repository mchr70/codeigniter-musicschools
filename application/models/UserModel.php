<?php
defined('BASEPATH') OR exit('No direct script access allowed');
     
class UserModel extends CI_Model {
     
    function __construct(){
    	parent::__construct();
    }
     
    public function getAllUsers(){
    	$query = $this->db->get('user');
    	return $query->result(); 
	}
	
	public function getUser($id){
		$query = $this->db->get_where('user',array('id'=>$id));
		return $query->row_array();
	}

    public function insert($user){
		$this->db->insert('user', $user);
		return $this->db->insert_id(); 
	}

	public function activate($id){
		$sql = 'UPDATE user SET active = 1 WHERE id = ?';
		$query = $this->db->query($sql, array($id));

		return ($this->db->affected_rows() > 0);
	}

	public function getUserByEmailAndPass($email, $password){
		$sql = 'SELECT * FROM user WHERE user.email = ? AND user.password = ? AND user.active = 1';
		$query = $this->db->query($sql, array($email, $password));

		return $query->row();
	}

	public function getUserByEmail($email){
		$sql = 'SELECT * FROM user WHERE user.email = ?';
		$query = $this->db->query($sql, array($email));

		return $query->row();
	}

	public function setCode($code, $id){
		//First set code to blank
		$sql = 'UPDATE user SET code = "" WHERE id = ?';
		$query =$this->db->query($sql, array($id));

		$sql = 'UPDATE user SET code = ? WHERE id = ?';
		$query = $this->db->query($sql, array($code, $id));

		return ($this->db->affected_rows() > 0);
	}

	public function setPassword($password, $id){
		//First set password to blank
		$sql = 'UPDATE user SET password = "" WHERE id = ?';
		$query =$this->db->query($sql, array($id));

		$sql = 'UPDATE user SET password = ? WHERE id = ?';
		$query = $this->db->query($sql, array($password, $id));

		return ($this->db->affected_rows() > 0);
	}

	public function delToken($userId){
		$sql = 'DELETE FROM token WHERE user_id = ?';
		$query = $this->db->query($sql, array($userId));

		return ($this->db->affected_rows() > 0);
	}

	public function delUser($id){
		$sql = 'DELETE FROM user WHERE id = ?';
		$query = $this->db->query($sql, array($id));

		return ($this->db->affected_rows() > 0);
	}

	public function insertToken($token, $id, $date){
		$sql = 'INSERT INTO token (token_key, user_id, exp_time)
				VALUES (?, ?, ?)';
		
		$query = $this->db->query($sql, array($token, $id, $date));

		return $this->db->insert_id(); 
	}

	public function getTokenByKey($tokenKey){
		$sql = 'SELECT * FROM token WHERE token_key = ?';
		$query = $this->db->query($sql, array($tokenKey));

		return $query->row();
	}

	public function deleteToken($id){
		$sql = 'DELETE FROM token WHERE id =?';
		$query = $this->db->query($sql, array($id));

		return ($this->db->affected_rows() > 0);
	}

	public function setUserLatAndLon($lat, $lon, $address, $id){
		$sql = 'UPDATE user SET latitude = ?, longitude = ?, address = ? WHERE id = ?';

		$query = $this->db->query($sql, array($lat, $lon, $address, $id));

		return ($this->db->affected_rows() > 0);
	}

	public function getSchoolsByUser($id){
		$sql = 'SELECT * FROM user_school WHERE user_id = ?';

		$query = $this->db->query($sql, array($id));

		return $query->result();
	}

	public function getOneUserSchool($userId, $schoolId){
		$sql = 'SELECT * FROM user_school WHERE user_id = ? AND school_id = ?';

		$query = $this->db->query($sql, array($userId, $schoolId));

		return ($this->db->affected_rows() > 0);
	}

	public function insertUserSchool($userId, $schoolId){
		$sql = 'INSERT INTO user_school (user_id, school_id) VALUES (?, ?)';

		$query = $this->db->query($sql, array($userId, $schoolId));

		return ($this->db->affected_rows() > 0);
	}

	public function delUserSchool($userId, $schoolId){
		$sql = 'DELETE FROM user_school WHERE user_id = ? AND school_id = ?';

		$query = $this->db->query($sql, array($userId, $schoolId));

		return ($this->db->affected_rows() > 0);
	}
     
}