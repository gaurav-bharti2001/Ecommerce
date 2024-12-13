<?php

    session_start();
    include('includes/db_connect.php');
    
    // Fetch cart item count for the logged-in user
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $cart_count = 0;

    if ($user_id) {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = '$user_id'";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $cart_count = $row['total_quantity'];
        }
    }
    
    // Fetch all products
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Our Products</title>
        <link rel="stylesheet" href="css/styles.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        <!-- Header Section -->
        <header>
            <div class="container">
                <h1>Our Products</h1>
                <?php if ($user_id): ?>
                    <a href="cart.php" class="cart-link">
                       <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    </a>
                    <a href="pages/logout.php" class="cart-link logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>                    
                <?php else: ?>
                    <a href="pages/login.php" class="cart-link">
                        <i class="fas fa-user"></i>
                    </a>
                <?php endif; ?>
            </div>
        </header>
        <!-- Main Product Display Section -->
        <main>
            <div class="product-container">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['product_image']); ?>" class="product-image" />
                        <h2 class="product-name"><?php echo $product['name']; ?></h2>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="pages/product.php?id=<?php echo $product['product_id']; ?>" class="view-details">View Details</a>
                        <form method="POST" action="add_to_cart.php">
                            <input type="number" name="quantity" value="1" min="1" class="  quantity">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="submit" value="Add to Cart" class="add-to-cart">
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>            
        </main>
    </body>
</html>
