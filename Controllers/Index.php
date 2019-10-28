<?php
class Index {
	public function __construct() {
		if(file_exists('Views/Index.php')) {
			include 'Views/Index.php';
		}
	}
}
?>