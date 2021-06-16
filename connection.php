<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drupal-test";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

    $sql = "SELECT * FROM `file_managed` WHERE `uuid` = 'aa4f518d-f422-4963-866c-67527d6ea49e'  ORDER BY `fid` DESC  LIMIT 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $obj = $result->fetchObject();
    if ($obj != null)
        $obj = $obj->fid;

    var_dump($obj);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
