<?php
session_start();
include('../includes/db_connect.php');

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = '$user_id'";
$result = $conn->query($sql);
$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Checkout</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <div class="col-md-6">
                    <h4>Order Summary</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($cart_item = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $cart_item['name']; ?></td>
                                    <td>$<?php echo $cart_item['price']; ?></td>
                                    <td><?php echo $cart_item['quantity']; ?></td>
                                    <td>$<?php echo $cart_item['price'] * $cart_item['quantity']; ?></td>
                                </tr>
                                <?php $total_price += $cart_item['price'] * $cart_item['quantity']; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <h4>Total Price: $<?php echo $total_price; ?></h4>
                </div>

                <div class="col-md-6">
                    <h4>Shipping Information</h4>
                    <form action="checkout.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>

                        <div class="mb-3">
                            <label for="zipcode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Your cart is empty. Please add items to your cart before proceeding.</p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
