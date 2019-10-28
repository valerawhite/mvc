<?php 
class bd { 
	public $db; 
	public function __construct() { 
		try { 
			$this->db = new PDO('mysql:host=localhost;charset=utf8;dbname=mvc', 'root'); 
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		}catch(PDOException $e) { 
			echo "Error connect" . ' ' . $e->getMessage();
		exit(); 
		} 
	} 
}
?>