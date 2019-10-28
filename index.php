<?php
class Route {
	public static $simple_page;
	
	public static function GetUrl() {
		self::$simple_page = false;
		if(!empty($_GET['url'])) {
			$url = $_GET['url'];
			$url = trim($url, '/');
			if(file_exists('Views/'.$url)) { self::$simple_page = true; header('Location: /mvc/Views/'.$url);}//если это простой html-файл сразу переходим на него
			else if(file_exists($url)) { self::$simple_page = true;}
			@$ct = [explode('/', $url)[0],explode('/', $url)[1]];
			list($controller, $param) = $ct;
			$controller = explode('.', $controller)[0];
			
			spl_autoload_register(function ($controller) {
				@$path = include 'Controllers/' . $controller . '.php';
				if(!$path && !self::$simple_page) {//проверяем, что контроллер существует и что, введённый url не является простой страницей
					throw new Exception(header('Location: /mvc/404.php '));
				}
			});
			try {
				$obj = new $controller();
				if(!empty($param)) {
					$obj->$param();
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		else {
			//Подгружаем наш контроллер
			spl_autoload_register(function ($controller) {
				@$path = include 'Controllers/' . $controller . '.php';
			});
			$obj = new Index();
		}
	}
}

Route::GetUrl();
?>