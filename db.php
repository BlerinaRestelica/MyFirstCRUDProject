<?php
//connecting the database 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
// if the connection doesnt work we use this to throw an exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>