<?php
require_once('Models/Auth.php');
class Sign {
	private $login;
	private $password;
	
	public function __construct() {
		if(file_exists('Views/Sign.php')) {
			include 'Views/Sign.php';
		}
	}
	public function login() {
		$this->login = $this->encode($_POST['login']);
		$this->password = $this->encode($_POST['password']);
		if(!empty($_POST['password']) && !empty($_POST['login'])) {
			$auth = new Auth();
			$auth->CheckData($this->login, $this->password);
		}
		else {
			echo '<span class="error2">Введённые данные не верны</span>'; 
		}
	}
	public function logout() {
		$auth = new Auth();
		$auth->logout();
	}
	private function encode($value) {
		return htmlspecialchars(trim(strip_tags($value)));
	}
}
?>