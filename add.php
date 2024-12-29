<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Data</title>
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
            text-align: center;
            font-size: 24px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        Add New Product
    </header>

    <div class="container">
        <?php
        include_once("connection.php");

        if (isset($_POST['Submit'])) {
            $name = $_POST['name'];
            $qty = $_POST['qty'];
            $price = $_POST['price'];
            $loginId = $_SESSION['id'];

            // Checking empty fields
            if (empty($name) || empty($qty) || empty($price)) {

                if (empty($name)) {
                    echo "<div class='error'>Name field is empty.</div>";
                }

                if (empty($qty)) {
                    echo "<div class='error'>Quantity field is empty.</div>";
                }

                if (empty($price)) {
                    echo "<div class='error'>Price field is empty.</div>";
                }

                // Link to the previous page
                echo "<a href='javascript:self.history.back();'>Go Back</a>";
            } else {
                // If all the fields are filled (not empty)

                // Insert data to database
                $result = mysqli_query($mysqli, "INSERT INTO products(name, qty, price, login_id) VALUES('$name','$qty','$price', '$loginId')");

                // Display success message
                echo "<div class='success'>Data added successfully.</div>";
                echo "<a href='view.php'>View Result</a>";
            }
        } else {
        ?>
            <h2>Enter Product Details</h2>
            <form action="" method="post">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter product name">

                <label for="qty">Quantity:</label>
                <input type="text" id="qty" name="qty" placeholder="Enter quantity">

                <label for="price">Price (Rs):</label>
                <input type="text" id="price" name="price" placeholder="Enter price">

                <input type="submit" name="Submit" value="Add Product">
            </form>
        <?php
        }
        ?>
    </div>
</body>

</html>
