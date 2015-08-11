<!doctype html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>
<link rel="stylesheet" href="/css/login.css"/>
</head>
<body>
<div class="wrapper">
	<div class="container">
		<h1>Đăng nhập</h1>
		<form action="{{ url('auth/login') }}" method="post">
		    {{ csrf_field() }}
			<input type="email" name="email" placeholder="Email">
			<input type="password" name="password" placeholder="Mật khẩu">
			<button type="submit" id="login-button">Đăng nhập</button>
		</form>
	</div>

	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
</body>
</html>