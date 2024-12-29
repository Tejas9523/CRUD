<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// Including the database connection file
include_once("connection.php");

// Fetching data in descending order (latest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM products WHERE login_id=" . $_SESSION['id'] . " ORDER BY id DESC");

// Arrays to store product names, quantities, and prices for the chart
$productNames = [];
$productQuantities = [];
$productPrices = [];

while ($res = mysqli_fetch_array($result)) {
	$productNames[] = $res['name'];
	$productQuantities[] = $res['qty'];
	$productPrices[] = $res['price'];
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Product List</title>
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

	<!-- Include Chart.js library -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f9f9f9;
			color: #333;
		}

		header {
			background-color: #343a40;
			color: white;
			padding: 15px 20px;
			font-size: 24px;
		}

		nav {
			float: right;
			text-align: center;
		}

		nav a {
			color: white;
			font-size: 16px;
			padding: 10px 15px;
			background-color: rgb(39, 140, 249);
			border-radius: 4px;
			transition: background-color 0.3s ease-in-out;
		}

		nav a:hover {
			text-decoration: none;
			background-color: #0056b3;
			color: white;
		}

		.container {
			max-width: 1000px;
			margin: 30px auto;
			padding: 20px;
			background: white;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
		}

		table thead {
			background-color: #007BFF;
			color: white;
		}

		table th,
		table td {
			padding: 12px 15px;
			text-align: center;
			border: 1px solid #ddd;
		}

		table tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		table tbody tr:hover {
			background-color: #e9ecef;
		}

		.btn {
			padding: 8px 12px;
			background-color: #007BFF;
			color: white;
			text-decoration: none;
			border-radius: 4px;
			transition: background-color 0.3s ease-in-out;
		}

		.btn:hover {
			background-color: yellowgreen;
		}

		.chart-container {
			width: 80%;
			margin: 40px auto;
			text-align: center;
		}
	</style>
</head>

<body>
	<header>
		Product Management System
		<nav>
			<a href="index.php">Home</a>
			<a href="add.html">Add</a>
			<a href="logout.php">Logout</a>
		</nav>
	</header>

	<div class="container">
		<h2>Product List</h2>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Quantity</th>
					<th>Price (Rs)</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				mysqli_data_seek($result, 0); // Reset the result pointer
				while ($res = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<td>" . $res['name'] . "</td>";
					echo "<td>" . $res['qty'] . "</td>";
					echo "<td>" . $res['price'] . "</td>";
					echo "<td><a class='btn' href=\"edit.php?id=$res[id]\">Edit</a>&nbsp<a class='btn' href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>

	<!-- Chart.js visualization -->
	<div class="chart-container">
		<h3>Product Quantity & Price Visualization</h3>
		<canvas id="productChart"></canvas>
	</div>

	<script>
		// Get data from PHP and pass it to JavaScript variables
		var productNames = <?php echo json_encode($productNames); ?>;
		var productQuantities = <?php echo json_encode($productQuantities); ?>;
		var productPrices = <?php echo json_encode($productPrices); ?>;

		// Chart.js setup
		var ctx = document.getElementById('productChart').getContext('2d');
		var productChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: productNames, // X-axis labels
				datasets: [
					{
						label: 'Product Quantity',
						data: productQuantities, // Y-axis data for quantity
						backgroundColor: 'rgba(39, 140, 249, 0.6)',
						borderColor: 'rgba(39, 140, 249, 1)',
						borderWidth: 1,
						barPercentage: 0.4,
					},
					{
						label: 'Product Price (Rs)',
						data: productPrices, // Y-axis data for price
						backgroundColor: 'rgba(255, 165, 0, 0.6)', // Orange color for price bars
						borderColor: 'rgba(255, 165, 0, 1)',
						borderWidth: 1,
						barPercentage: 0.4,
					}
				]
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
					},
					tooltip: {
						enabled: true
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							stepSize: 5
						}
					}
				}
			}
		});
	</script>
</body>

</html>
