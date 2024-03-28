<?php
    $host = 'localhost';
    $dbname = 'db_uastekweb21';
    $username = 'satriya';
    $password = 'infor12345';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
