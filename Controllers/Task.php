<?php
require_once('Models/Model.php');
class Task {
	private $name;
	private $email;
	private $text;
	private $page;
	private $edit_text;
	private $status;
	private $id;
	
	public function Data() {
		//Принимаем входные данные
		if(!empty($_REQUEST['name']) && !empty($_REQUEST['email'] && !empty($_REQUEST['text']))) {
			$this->name = $this->encode($_REQUEST['name']);
			$this->email = $this->encode($_REQUEST['email']);
			$this->text = $this->encode($_REQUEST['text']);
			$newTask = new Model();
			$newTask->NewTask($this->name, $this->email, $this->text);
		}
	}
	public function View() {
		if(!empty($_REQUEST['page'])) {
			$this->page = $this->encode($_REQUEST['page']);
		}
		else {
			$this->page = 'page:1';
		}
		
		$return = new Model();
		
		if(!empty($_REQUEST['code'])) {
			$this->title = $this->encode($_REQUEST['code']);
			$return->View($this->title, $this->page);
		}
		else {
			$return->View('username:asc', $this->page);
		}
	}
	public function Edit() {
		if(!empty($_REQUEST['id']) && intval($_REQUEST['id'])) {
			$this->id = $this->encode($_REQUEST['id']);
			if(!empty($_REQUEST['edit_text'])) {
				$this->edit_text = $this->encode($_REQUEST['edit_text']);
			}
			else {
				$this->edit_text = "";
			}
			if(!empty($_REQUEST['status'])) {
				$this->edit_status = $this->encode($_REQUEST['status']);
			}
			else {
				$this->edit_status = 1;
			}
			$edit = new Model();
			$edit->EditTask($this->id, $this->edit_text, $this->edit_status);
		}
	}
	private function encode($value) {
		return htmlspecialchars(trim(strip_tags($value)));
	}
}
?>