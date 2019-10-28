<?php
session_start();
require_once('bd.php');
class Model extends bd {
	public $cur_page;
	public $num_pages;
	public $sort;
	
	public function NewTask($name, $email, $text) {
		$status = 1;
		$data = $this->db->prepare('INSERT INTO tasks (username, email, text_task, status) VALUES(:fieldName, :fieldEmail, :fieldTask, :fieldStatus)');
		$data->bindParam(':fieldName', $name);
		$data->bindParam(':fieldEmail', $email);
		$data->bindParam(':fieldTask', $text);
		$data->bindParam(':fieldStatus', $status);
		if($data->execute()) {
			echo 'done';
		}
	}
	public function View($data, $page) {
		$query = $this->GenerateQuery($data, $page);
		$result = $this->db->prepare($query);
		$result->execute();
		while($info = $result->fetch(PDO::FETCH_ASSOC)) {?>
			<div class="row">
				<div class="col-sm-3 col-md-2 task">
					<?php echo $info['username'];?>
				</div>
				<div class="col-sm-3 task col-md-4">
					<?php echo $info['email'];?>
				</div>
				<div class="col-sm-3 col-md-4 task">
					<?php echo $info['text_task'];?>
				</div>
				<div class="col-sm-3 task col-md-2">
					<?php 
						switch ($info['status']) {
							case 1:
								echo "Выполняется";
							break;
							case 2:
								echo "Выполнено/Редактировано администратором";
							break;
						}
					if((isset($_SESSION['id']) && !empty($_SESSION['id'])) || (!empty($_COOKIE['id']))) {?>
						<a href="#edit<?php echo $info['id_task']?>" class="open">
							<img src="Vendors/images/pen.png">
						</a>
						<div id="edit<?php echo $info['id_task']?>" data-id="<?php echo $info['id_task']?>" style="display: none;" class="edit_form">
							<textarea class="col-sm-12 textarea_edit" ><?php echo $info['text_task']?></textarea><br>
							<input type="text" class="col-sm-12 status-edit" value="<?php echo $info['status']?>"><br>
							<button class="col-sm-12 edit_button">Редактировать</button>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		<?php
		}
		echo $this->GeneratePagination($data, $this->sort);
		
	}
	public function GenerateQuery($data, $page) {
		$query = 'SELECT * FROM tasks ';
		$page = explode(':', $page)[1];
			list($data, $this->sort) = [explode(':', $data)[0], explode(':', $data)[1]];
			$this->cur_page = $page;
			$results_per_page = 3;
			$skip = (($this->cur_page - 1) * $results_per_page);
			
			$query = $query . " ORDER BY $data $this->sort";
			
			$result = $this->db->prepare($query);
			$result->execute();
			$total = $result->rowCount();
			$this->num_pages = ceil($total / $results_per_page);
			$query = $query . " LIMIT $skip, $results_per_page";
			return $query;
	}
	
	public function GeneratePagination($data, $sort) {
		if($this->cur_page != 1 && $this->num_pages > 1) {
			$cur_page_f = $this->cur_page-1;
			echo '<a class="page" href="page:' .$cur_page_f .'&' .$data.':' .$sort .'" onClick="loadMore(event, this)">' . $cur_page_f. '</a>';
		}
		if($this->cur_page < $this->num_pages) {
			$cur_page_cur = $this->cur_page;
			echo $cur_page_cur;
		}
		if($this->cur_page <= $this->num_pages && $this->cur_page != $this->num_pages) {
			$this->cur_page += 1;
			echo '<a class="page" href="page:' .$this->cur_page .'&' .$data.':' .$sort .'" onClick="loadMore(event, this)">' . $this->cur_page. '</a>';
		}
	}
	public function EditTask($IdTask, $edit_text, $status) {
		if((isset($_SESSION['id']) && !empty($_SESSION['id'])) || (!empty($_COOKIE['id']))) {
			$data = $this->db->prepare('UPDATE tasks SET text_task = :fieldText, status = :fieldStatus WHERE id_task = :fieldIdTask ');
			$data->bindParam(':fieldIdTask', $IdTask);
			$data->bindParam(':fieldText', $edit_text);
			$data->bindParam(':fieldStatus', $status);
			if($data->execute()) {
				echo 'done';
			}
		}
		else {
				echo 'redirect';
			}
	}
}

?>