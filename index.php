<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<title>Homepage</title>
	<link href="style.css" rel="stylesheet" type="text/css">
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
			margin: 0;
			padding: 0;
			background-color: #f4f4f9;
		}

		#header {
			background-color: #007BFF;
			color: white;
			text-align: center;
			width: 100%;
			padding: 20px 0;
			font-size: 24px;
			font-weight: bold;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		#footer {
			background-color: #333;
			color: #fff;
			text-align: center;
			padding: 10px 0;
			position: fixed;
			bottom: 0;
			width: 100%;
		}

		#footer a {
			color: #4CAF50;
			text-decoration: none;
		}

		#footer a:hover {
			text-decoration: underline;
		}

		.container {
			max-width: 800px;
			margin: 50px auto;
			background: #fff;
			padding: 40px 30px;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.container h1 {
			text-align: center;
			color: #333;
		}

		.welcome {
			text-align: center;
			font-size: 18px;
			margin-bottom: 20px;
			color: #555;
		}

		.links {
			text-align: center;
			margin-top: 20px;
		}

		.links a {
			margin: 0 10px;
			text-decoration: none;
			color: #007BFF;
			font-weight: bold;
			padding: 10px 20px;
			border: 2px solid #007BFF;
			border-radius: 4px;
			transition: all 0.3s ease-in-out;
		}

		.links a:hover {
			background-color: #007BFF;
			color: white;
		}

		.error {
			text-align: center;
			color: #d9534f;
			font-weight: bold;
			margin-bottom: 20px;
		}

		.button-group {
			text-align: center;
			margin-top: 20px;
		}

		.button-group a {
			margin: 5px;
			text-decoration: none;
			color: white;
			background-color: #007BFF;
			padding: 10px 15px;
			border-radius: 4px;
			transition: all 0.3s ease-in-out;
		}

		.button-group a:hover {
			background-color: #0056b3;
		}
	</style>
</head>

<body>
	<div id="header">
		---  Welcome to My Page  ---
	</div>

	<div class="container">
		<?php
		if (isset($_SESSION['valid'])) {
			include("connection.php");
			$result = mysqli_query($mysqli, "SELECT * FROM login");
			?>
			<div class="welcome">
				Welcome, <strong><?php echo $_SESSION['name'] ?></strong>! <a href='logout.php'>Logout</a>
			</div>
			<div class="button-group">
				<a href='view.php'>View and Add Products</a>
			</div>
			<?php
		} else {
			?>
			<div class="error">
				You must be logged in to view this page.
			</div>
			<div class="button-group">
				<a href='login.php'>Login</a>
				<a href='register.php'>Register</a>
			</div>
			<?php
		}
		?>
	</div>
</body>

</html>