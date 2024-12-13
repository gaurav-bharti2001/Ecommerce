<?php
include('../includes/db_connect.php');

// Array of sample products to add
$products = [
    [
        'name' => 'Laptop',
        'description' => 'A high-performance laptop with 16GB RAM, 512GB SSD, and Intel Core i7 processor.',
        'price' => 999.99,
        'stock' => 50,
        'image' => 'laptop.jpg'
    ],
    [
        'name' => 'Smartphone',
        'description' => 'Latest smartphone with a 6.5-inch screen, 128GB storage, and dual-camera setup.',
        'price' => 499.99,
        'stock' => 100,
        'image' => 'smartphone.jpg'
    ],
    [
        'name' => 'Wireless Headphones',
        'description' => 'Noise-cancelling wireless headphones with 30-hour battery life.',
        'price' => 129.99,
        'stock' => 75,
        'image' => 'headphones.jpg'
    ],
    [
        'name' => 'Smartwatch',
        'description' => 'Fitness tracking smartwatch with heart rate monitor and GPS.',
        'price' => 199.99,
        'stock' => 150,
        'image' => 'smartwatch.jpg'
    ],
    [
        'name' => 'Gaming Console',
        'description' => 'Next-gen gaming console with 4K resolution and 1TB storage.',
        'price' => 499.99,
        'stock' => 30,
        'image' => 'console.jpg'
    ]
];

// Insert each product into the database
foreach ($products as $product) {
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $stock = $product['stock'];
    $image = $product['image'];

    // Check if the product already exists
    $checkSql = "SELECT product_id FROM products WHERE name = '$name'";
    $result = $conn->query($checkSql);


     if ($result === false) {
        // Log the error and stop execution for debugging
        echo "Error in SQL: " . $conn->error . "<br>";
        continue; // Skip to the next product
    }

    if ($result->num_rows > 0) {
        echo "Product '$name' already exists. Skipping.<br>";
    } else {
        // Insert the product
        $sql = "INSERT INTO products (name, description, price, stock, image) 
                VALUES ('$name', '$description', '$price', '$stock', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "Product '$name' added successfully!<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

$conn->close();
?>
