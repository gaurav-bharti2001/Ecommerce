<?php

    session_start();
    include('includes/db_connect.php');
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = '$user_id'";
    $result = $conn->query($sql);
    $total_price = 0;

?>

<h1>Your Cart</h1>
<?php while ($cart_item = $result->fetch_assoc()): ?>
    <div>
        <img src="assets/images/<?php echo $cart_item['image']; ?>" alt="<?php echo $cart_item['name']; ?>" width="200px" height="200px">
        <h2><?php echo $cart_item['name']; ?></h2>
        <p>Quantity: <?php echo $cart_item['quantity']; ?></p>
        <p>Price: $<?php echo $cart_item['price']; ?></p>
        <p>Total: $<?php echo $cart_item['price'] * $cart_item['quantity']; ?></p>
    </div>
    <?php $total_price += $cart_item['price'] * $cart_item['quantity']; ?>
<?php endwhile; ?>

<p>Total Price: $<?php echo $total_price; ?></p>