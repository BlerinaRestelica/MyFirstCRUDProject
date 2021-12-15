<?php

require_once "functions.php";
//the db connection
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
//if the connection doesnt work we throw an exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$description = '';
$price = '';
$product = [
    'image' => ''
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //we do this if the object is empty in db, on this case make a insert in the db
    //we do this only if the request method is post
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image'] ?? null;
    $imagePath = '';
    //this creates a images folder to store the images
    if (!is_dir('images')) {
        mkdir('images');
    }
    // this specifies where we want to move the uploaded file ne rastin ton eshte tmp_name
    if ($image && $image['tmp_name']) {
        $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
        mkdir(dirname($imagePath));
       
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    if (!$title) {
        $errors[] = 'Product title is required';
    }

    if (!$price) {
        $errors[] = 'Product price is required';
    }

    if (empty($errors)) {
        //to make an insert in the db 
        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();
        //this redirects the user to the inex page when they click submit
        header('Location: index.php');
    }

}


?>

<?php include_once 'views/partials/header.php'?>
<p>
    <a href="index.php" class="btn btn-secondary">Back to products</a>
</p>
<h1>Create new Product</h1>

<?php include_once "views/products/form.php"?>

</body>
</html>