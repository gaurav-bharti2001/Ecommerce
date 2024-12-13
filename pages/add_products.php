<?php
include('../includes/db_connect.php');

$status = $statusMsg = '';
if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $status = 'error';
    if(!empty($_FILES["image"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
         
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
            // Insert image content into database
            $insert = $conn->query("INSERT into products (product_image,name,description,price,stock ) VALUES ('$imgContent','$name','$description','$price','$stock')");
             
            if($insert){
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select an image file to upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Employee Data</title>
    <!-- Link to Bootstrap CSS (CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Submit Employee Data</h1>

    <!-- Display Status Message -->
    <?php if($statusMsg): ?>
        <div class="alert alert-<?php echo $status == 'success' ? 'success' : 'danger'; ?>">
            <?php echo $statusMsg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="name" placeholder="Enter product name" required>
            </div>
            
            <!-- Product Description -->
            <div class="mb-3">
                <label for="productDescription" class="form-label">Product Description</label>
                <textarea class="form-control" id="productDescription" name="description" rows="3" placeholder="Enter product description" required></textarea>
            </div>
            
            <!-- Price -->
            <div class="mb-3">
                <label for="productPrice" class="form-label">Price ($)</label>
                <input type="number" class="form-control" id="productPrice" name="price" min="0.00" max="10000.00" step="0.01" placeholder="Enter product price" required>
            </div>
            
            <!-- Stock -->
            <div class="mb-3">
                <label for="productStock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="productStock" name="stock" min="1" max="1000" placeholder="Enter available stock" required>
            </div>
            
            <!-- Product Image -->
            <div class="mb-3">
                <label for="productImage" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="productImage" name="image" accept="image/*" required>
            </div>
            
            <!-- Release Date -->
            <div class="mb-3">
                <label for="releaseDate" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="releaseDate" name="release_date">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Link to Bootstrap JS (CDN) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
