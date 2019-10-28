<!DOCTYPE html>
<html>
<head lang="ru">
	<title>Авторизация</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="/mvc/Vendors/styles/bootstrap.min.css">
	<link rel="stylesheet" href="/mvc/Vendors/styles/jquery.fancybox.min.css">
	<link rel="stylesheet" href="/mvc/Vendors/styles/main.css">
	<script src="/mvc/Vendors/scripts/jquery-3.4.1.min.js"></script>
	<script src="/mvc/Vendors/scripts/bootstrap.min.js"></script>
	<style>
		body {
			background: #423c3c;
		}
	</style>
</head>
<body>
	<div class="main">
			<div class="col-sm-2 col-md-3 wrap_form">
				<form method="POST" action="/mvc/Sign/login/">
					<span>Авторизация Пользователя</span>
					<div class="wrap_err">
						
					</div>
					<input type="text" class="col-md-9" placeholder="Логин" id="login" name="login"><br>
					<input type="password" class="col-md-9" placeholder="Пароль" id="password" name="password"><br>
					<input type="submit" id="submit" class="col-md-9" value="Войти">
				</form>
			</div>
	</div>
	<script>
		$("document").ready(function() {
			$(".wrap_err").append($(".error2"));
			$(".error2").css("display", "block");
		});
	</script>
</body>
</html>