<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frmnatat_db";

// Create connection
try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname",
        $username,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

    // $sql = "SELECT * FROM `file_managed` WHERE `uuid` = '1'  ORDER BY `fid` DESC  LIMIT 1";
    // $result = $conn->prepare($sql);
    // $result->execute();
    // $obj = $result->fetchObject();
    // $fid = $obj->fid;
    // if ($obj != null)
    //     $obj = $obj->fid;

    // var_dump($obj);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
