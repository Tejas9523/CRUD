<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
		crossorigin="anonymous"></script>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.container {
			background: #fff;
			padding: 20px 30px;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			width: 400px;
		}

		.container h2 {
			margin-bottom: 20px;
			color: #333;
			text-align: center;
		}

		.form-group {
			margin-bottom: 15px;
		}

		.form-group label {
			display: block;
			font-size: 14px;
			color: #555;
			margin-bottom: 5px;
		}

		.form-group input {
			width: 100%;
			padding: 10px;
			font-size: 14px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		.form-group input:focus {
			outline: none;
			border-color: #007BFF;
			box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
		}

		.btn {
			display: inline-block;
			width: 100%;
			padding: 10px;
			background-color: #007BFF;
			color: #fff;
			font-size: 14px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			text-align: center;
		}

		.btn:hover {
			background-color: blue;
			color: yellow;
		}

		.alert {
			padding: 10px;
			margin-bottom: 20px;
			border-radius: 4px;
		}

		.alert-danger {
			background-color: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

		.alert-success {
			background-color: #d4edda;
			color: #155724;
			border: 1px solid #c3e6cb;
		}

		a {
			color: #007BFF;
			text-decoration: none;
		}

		a:hover {
			text-decoration: underline;
		}

		.temp {
			text-align: center;
			margin: 5px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2>Register</h2>
		<?php
		include("connection.php");

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = htmlspecialchars($_POST['name']);
			$email = htmlspecialchars($_POST['email']);
			$user = htmlspecialchars($_POST['username']);
			$pass = htmlspecialchars($_POST['password']);

			if (empty($name) || empty($email) || empty($user) || empty($pass)) {
				echo "<div class='alert alert-danger'>All fields are required. Please fill out all fields.</div>";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo "<div class='alert alert-danger'>Invalid email format.</div>";
			} else {
				// Use prepared statements to prevent SQL injection
				$stmt = $mysqli->prepare("INSERT INTO login(name, email, username, password) VALUES(?, ?, ?, ?)");
				// $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
				$stmt->bind_param("ssss", $name, $email, $user, $pass);

				if ($stmt->execute()) {
					echo "<div class='alert alert-success'>Registration successful. <a href='login.php'>Login here</a>.</div>";
				} else {
					echo "<div class='alert alert-danger'>Error: Could not execute the query.</div>";
				}

				$stmt->close();
			}
		}
		?>
		<form method="post" action="">
			<div class="form-group">
				<label for="name">Full Name</label>
				<input type="text" name="name" id="name" required>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" required>
			</div>
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" required>
			</div>
			<button type="submit" class="btn">Register</button>
		</form>
		<centre>
			<div class="temp">
				Already Registered ? <a href='login.php'>Login</a>
			</div>
		</centre>
	</div>
</body>

</html>