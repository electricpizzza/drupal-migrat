<?php
$servername = "https://frmnatation.com";
$username = "frmnatat_userdb";
$password = "acfLIJ[MTTh?";
$dbname = "frmnatat_db";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully <br>";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
