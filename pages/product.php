<?php
include('../includes/db_connect.php');
$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id='$product_id'";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
    <body>
       <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="../index.php" class="navbar-brand">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['product_image']); ?>" class="img-fluid rounded-start" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title"><?php echo $product['name']; ?></h1>
                            <p class="card-text">Description: <?php echo $product['description']; ?></p>
                            <p class="card-text text-success fw-bold">Price: $<?php echo $product['price']; ?></p>
                            <form method="POST" action="../add_to_cart.php" class="d-flex align-items-center">
                                <div class="me-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
