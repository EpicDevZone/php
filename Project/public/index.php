<?php
//? require_once __DIR__.'/../src/Models/User.php';     

require_once __DIR__ . '/../src/core/Autoloader.php';

use App\Core\Database;
use App\Models\User as U;
use App\Models\Post;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    //! Get the shared database connection for this example page.
    $db =  Database::getInstance();
    $pdo = $db->getConnection();

    //! Load all users from the database.
    $sql_query = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute();

    $result = $stmt->fetchAll();
    // print_r($result);

    // echo "Hello world";
    // $newUserId = U::create("sunilkathyat", "sunilkathayat51@gmail.com", 'e327e3e78e7t');
    // $user1 = new U("suniuuul", "sunilkathauat41@gmail.com", "123421123");

    // $user1->displayUser();


    $pdo = Database::getInstance()->getConnection()->prepare("SELECT * FROM posts");
    

    ?>
</body>

</html>