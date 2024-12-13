<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        $message = "Item added to cart!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }

        .message {
            font-size: 18px;
            font-weight: bold;
        }

        .home-link {
            color: #fff;
            text-decoration: none;
        }

        .home-btn {
            margin-top: 20px;
            background-color: #FF6F61;
            border: none;
        }

        .home-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
    <body>
        <div class="container text-center">
            <div class="alert alert-info message" role="alert">
                <?php echo isset($message) ? $message : ''; ?>
            </div>

            <a href="index.php" class="btn home-btn">
                <i class="fas fa-home"></i> Go to Home
            </a>
        </div>

        <!-- Bootstrap JS (optional for interactions like tooltips, modals) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
