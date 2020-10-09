<?php


try {
     $conexionBd= new PDO("mysql:host=127.0.0.1;dbname=ticket", "root","") ;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
 
?>