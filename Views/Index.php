<?php session_start();?>
<!DOCTYPE html>
<html>
<head lang="ru">
	<title>Задачник</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="Vendors/styles/bootstrap.min.css">
	<link rel="stylesheet" href="Vendors/styles/jquery.fancybox.min.css">
	<link rel="stylesheet" href="Vendors/styles/main.css">
	<script src="Vendors/scripts/jquery-3.4.1.min.js"></script>
	<script src="Vendors/scripts/bootstrap.min.js"></script>
	<script src="Vendors/scripts/jquery.fancybox.min.js"></script>
</head>
<body>
	<header>
		<div class="container-fluid">
			<div class="row justify-content-end">
				<?php 
					if((isset($_SESSION['id']) && !empty($_SESSION['id'])) || (!empty($_COOKIE['id']))) {
						echo '<a id="sign" href="/mvc/Sign/logout/" class="col-sm-2">Выйти</a>';
					}
					else {
						echo '<a id="sign" href="/mvc/Sign/" class="col-sm-2">Войти</a>';
					}
				 ?>
			</div>
		</div>
	</header>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-2 title">
					Имя пользователя<img data-code="username:desc" class="Down" src="Vendors/images/down.png">
				</div>
				<div class="col-sm-3 col-md-4 title">
					E-mail<img data-code="email:desc" class="Down" src="Vendors/images/down.png">
				</div>
				<div class="col-sm-3 col-md-4 title">
					Текст Задачи
				</div>
				<div class="col-sm-3 col-md-2 title">
					Статус<img data-code="status:desc" class="Down" src="Vendors/images/down.png">
				</div>
			</div>
			<div class="replace">
				<?php
					$ss = new Task();
					echo $ss->View();
				?>
			</div>
			<div class="row button_task">
				<a href="#popup" class="col-sm-2" id="create_task">Создать задачу</a>
			</div>
			<div id="popup" style="display: none;">
				<form class="formTask">
					<div class="col-sm-12 success_create_task"></div>
					<input type="text" class="col-sm-12" id="name" placeholder="Введите ваше имя"><br>
					<input type="text" class="col-sm-12"  id="email" placeholder="Введите email"><br>
					<textarea placeholder="Введите текст задачи" id="text" class="col-sm-12"></textarea>
					<input type="button" value="Создать задачу" id="sendDataTask" class="button_create_task col-sm-12">
				</form>
			</div>
		</div>
	</div>
	<script>
		$("document").ready(function() {
			$("#create_task").fancybox(
				{
					"hideOnContentClick" :false,
					"overlayShow" : true,
					"overlayOpacity" : 0.8,
				});
			$(".open").fancybox(
				{
					"hideOnContentClick" :false,
					"overlayShow" : true,
					"overlayOpacity" : 0.8,
				});
			$("#sendDataTask").on("click", function() {
				let name = $("#name").val(),
					email = $("#email").val(),
					text = $("#text").val(),
					regex_email = /.+@.+\..+/i;
					
				if(name !== '' && email !== '' && text !== '') {
					if(regex_email.test(email)) {
						$.ajax({
							data: {name: name, email: email, text: text},
							url: 'Task/Data/',
							success: function(data){
								if(data == 'done') {
									$('.formTask')[0].reset();
									if($('.success_create_task').hasClass('error')) {
										$('.success_create_task').removeClass('error');
									}
									$(".success_create_task").html('<span>Задача успешно создана!</span>');
								}
								else {
									$(".success_create_task").addClass('error');
									$(".success_create_task").html('<span>Произошла ошибка!</span>');
								}
							}
						});
					}
					else {
						$(".success_create_task").html('<span>Некорректный email!</span>');
					}
				}
				else {
					$(".success_create_task").addClass('error');
					$(".success_create_task").html('<span>Пожалуйста, заполните все данные!</span>');
				}
			});
			$(".edit_button").on("click", function() { 
				let parent = $(this).parent(),
					id = $(parent).data('id');
					status = $(parent).find('.status-edit').val();
					text = $(parent).find('.textarea_edit').val();
				if(status !== "" || text !== "") {
					$.ajax({
						data: {id: id, edit_text: text, status: status},
						url: 'Task/Edit/',
						success: function(data){
							if(data == 'done') {
								location.reload();
							}
							else if(data == 'redirect') {
								document.location.href = '/mvc/sign/';
							}
						}
					});
				}
			});
			$(".Down").on("click", function() {
				let down = $(this),
					code = $(down).attr('data-code'),
					sort = code.split(':');
				if(code.length !== '') {
					$.ajax({
						data: {code: code, page: 'page:1'},
						url: 'Task/View/',
						success: function(data){
							if(sort[1] == 'desc') {
								$(down).attr('src', 'Vendors/images/up2.png');
								$(down).attr('data-code', sort[0] + ':asc');
								$(".replace").html(data);
							}
							else {
								$(down).attr('src', 'Vendors/images/down.png');
								$(down).attr('data-code', sort[0] +':desc');
								$(".replace").html(data);
							}
						}
					});
				}
			});
		});
			function loadMore(e, elem) {
				e.preventDefault();
				let href = $(elem).attr('href');
				let spl = href.split('&'),
					code = spl[1].split(':');
					code = code[0];
				$.ajax({
						data: {code: spl[1], page: spl[0]},
						url: 'Task/View/',
						success: function(data){
							$(".replace").html(data);
						}
				}); 
			}
	</script>
</body>
</html>