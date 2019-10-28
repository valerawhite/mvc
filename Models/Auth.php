<?php
session_start();
require_once('bd.php');
	class Auth extends bd {
		public function CheckData($login, $password) {
			$data = $this->db->prepare('SELECT * FROM users WHERE login = :fieldLogin && password = :fieldPassword');
			$data->execute(array(':fieldLogin' => $login, ':fieldPassword' => md5($password)));
			if($data->rowCount() != 0) {
				$info = $data->fetch(PDO::FETCH_ASSOC);
				$_SESSION['id'] = $info['id_user'];
				setcookie('id', $info['id_user'], time() + (60 * 60 * 24 * 30));
				header('Location: /mvc/');
			}
			else {
				echo '<span class="error2">Введённые данные не верны</span>';
			}
		}
		public function logout() {
			if (isset($_SESSION['id'])) {
				var_dump($_SESSION['id']);
				$_SESSION = array();
				session_destroy();
			}
			setcookie('id', '', time() - 3600);
		}
	}

?>