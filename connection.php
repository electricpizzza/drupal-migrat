<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drupal-test";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT `fid` FROM `file_usage` ORDER BY `fid` DESC LIMIT 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $fid = $result->fetchColumn();
    var_dump($fid);


    echo "Connected successfully <br>";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
