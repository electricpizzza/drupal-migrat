<?php
include_once('connection.php');
include_once('functions.php');

try {
    // addActu($conn);
    addGalleries($conn);
    // addRecM($conn);
    // addAgenda($conn);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
