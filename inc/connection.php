<?php
try {
    $db_connect = new PDO("sqlite:".__DIR__."/journal.db");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $e->getMessage()."<br>";
    die();
}
?>