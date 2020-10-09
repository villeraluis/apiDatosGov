<?php


try {
     $conexionBd= new PDO("mysql:host=127.0.0.1;dbname=apiGov", "root","") ;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
 
?>