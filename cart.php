<?php
    session_start();
    include('includes/db_connect.php');

    // Ensure the user is logged in
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = '$user_id'";
    $result = $conn->query($sql);

    $total_price = 0;
    
    if (isset($_GET['remove'])) {
        $remove_id = $_GET['remove'];
        $remove_sql = "DELETE FROM cart WHERE user_id = '$user_id' AND cart_id = '$remove_id'";
        if ($conn->query($remove_sql) === TRUE) {
            header("Location: cart.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a href="index.php" class="navbar-brand">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Cart</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($cart_item = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($cart_item['product_image']); ?>" class="card-img-top" alt="<?php echo $cart_item['name']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $cart_item['name']; ?></h5>
                                <p class="card-text">Price: $<?php echo $cart_item['price']; ?></p>
                                <p class="card-text">Quantity: <?php echo $cart_item['quantity']; ?></p>
                                <p class="card-text font-weight-bold">Total: $<?php echo $cart_item['price'] * $cart_item['quantity']; ?></p>

                                <!-- Remove Button -->
                                <a href="cart.php?remove=<?php echo $cart_item['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </div>
                        </div>
                    </div>
                    <?php $total_price += $cart_item['price'] * $cart_item['quantity']; ?>
                <?php endwhile; ?>
            </div>

            <div class="text-center mt-4">
                <h3>Total Price: $<?php echo $total_price; ?></h3>
                <a href="pages/checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
            </div>

        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional for interactions like tooltips, modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
