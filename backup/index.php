<?php
    include('includes/db_connect.php');
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
    </head>
    <body>
        <!-- Header Section -->
        <header>
            <div class="container">
                <h1>Our Products</h1>
            </div>
        </header>
        <!-- Main Product Display Section -->
        <main>
            <div class="product-container">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                        <h2 class="product-name"><?php echo $product['name']; ?></h2>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="pages/product.php?id=<?php echo $product['product_id']; ?>" class="view-details">View Details</a>
                        <form method="POST" action="add_to_cart.php">
                            <input type="number" name="quantity" value="1" min="1" class="quantity">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="submit" value="Add to Cart" class="add-to-cart">
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </body>
</html>
