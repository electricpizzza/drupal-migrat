<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drupal-test";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    var_dump($conn);
    echo "Connected successfully <br>";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
