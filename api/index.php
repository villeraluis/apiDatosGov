<?php

include_once("../php/conexion.php");



// Mostrarmos los errores en pantalla
// Se deben desactivar en modo producción. Deben estar activos en tiempo de desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);



// Definimos el tipo de contenido que retornara la petición
// Formato JSON
header("Content-Type:application/json");


//se define la conexion a la base de datos en la variable conexionBd

// Obenemos el URI  /tickets
$url = $_SERVER['REQUEST_URI'];



// 1. READ   GET /tickets/
//    Se hace uso de expresiones regulares con preg_match() para buscar el patron /tickets/x
//    Donde la x sea cualquier valor numérico mayor o igual a 1 y hasta 15 cifras
//    Se valida que el método HTTP sea GET
//

  if(preg_match("/tickets\/([1-9][0-9]{0,15})/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){ 
   

    
    

      $id = $matches[1];
    $sentencia = $conexionBd->prepare("SELECT id FROM tickets WHERE id = ? LIMIT 1;");
    $sentencia->execute([$id]);
    $numeroDeFilas = $sentencia->rowCount();

    if ($numeroDeFilas == 1) {
      $consulta = $conexionBd->prepare("SELECT tickets.id,tickets.nombres,
      tickets.id_dependencia,dependencia.nombre_dependencia,tickets.id_tipo,tipo.nombre_tipo,tickets.apellidos,
      tickets.email,tickets.asunto, tickets.descripcion,tickets.fecha 
      FROM tickets,dependencia,tipo 
      WHERE tickets.id_tipo=tipo.id_tipo && tickets.id_dependencia=dependencia.id_dependencia && tickets.id=$id");
      $consulta->bindValue(':id', $id);
      $consulta->execute();
      $validacion=$consulta->fetch(PDO::FETCH_ASSOC);
      
      echo json_encode($validacion);
        //header("HTTP/1.1 200 OK");
      
    }else {
      $resp=array("success" =>"el ticket  $id no se encuentra" );
      echo json_encode($resp);
  }
      
  
  exit();
   
}


// listar todos los tikets
// 2. LIST   GET /tikets

//
 if($url == '/api/tickets' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $consulta = $conexionBd->prepare("SELECT tickets.id,tickets.nombres, dependencia.nombre_dependencia,tipo.nombre_tipo,tickets.apellidos, tickets.email,tickets.asunto, tickets.descripcion,tickets.fecha FROM tickets,dependencia,tipo
    WHERE tickets.id_tipo=tipo.id_tipo && tickets.id_dependencia=dependencia.id_dependencia ORDER BY id");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_ASSOC);
    
    header("HTTP/1.1 200 OK");
    echo json_encode( $consulta->fetchAll()  );
   
  exit();}
    

// 3. CREATE  POST /tickets
//   crea un nuevo tickets en la base de datos con datos recibidos por POST
//if($url == '/tickets' && $_SERVER['REQUEST_METHOD'] == 'POST') {

  if( $url == '/api/tickets' && $_SERVER['REQUEST_METHOD'] == 'POST') {
           
     if ($_POST['nombres']!="") {
   // la variable input toma los valores que trae $_POST
    
   $input = $_POST;
 
    $consulta = "INSERT INTO tickets ( nombres,apellidos, email, asunto,descripcion,id_tipo,id_dependencia,fecha)
          VALUES(:nombres, :apellidos, :email, :asunto , :descripcion,:id_tipo,:id_dependencia, :fecha)";
    $sentencia = $conexionBd->prepare($consulta); 
    enlazarValores($sentencia, $input);
    $sentencia->execute();
    $postId = $conexionBd->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      
	 }  

    
     } 
  else {
    $resp=array("success" =>"el usuario   ya esta registrado" );
          echo json_encode($resp);
          //header("HTTP/1.1 200 OK");
}



    
   }


 // borrar un tickets por id .DELETE
 if (preg_match("/tickets\/([1-9][0-9]{0,15})/", $url, $matches) && $_SERVER['REQUEST_METHOD'] ==  'DELETE')
  {

    
      //estas lineas consultan si al menos una tiene la id que se intenta registrar valida que un estu
      //diante esta registrad
    //print_r ($matches[1]);
    $id = $matches[1];
    $sentencia = $conexionBd->prepare("SELECT id FROM tickets WHERE id = ? LIMIT 1;");
    $sentencia->execute([$id]);
    $numeroDeFilas = $sentencia->rowCount();

    if ($numeroDeFilas == 1) { 
     $sentencia = $conexionBd->prepare("DELETE FROM tickets where id=:id");
     $sentencia->bindValue(':id', $id);
     $sentencia->execute();
    
     $resp=array("success" =>"el ticket  $id se elimino satisfactoriamente" );

     echo json_encode($resp);
     header("HTTP/1.1 200 OK");
     
    }

    }

   


    // modificar un tickets UPDATE con el metodo PATH

    if (preg_match("/tickets\/([1-9][0-9]{0,15})/", $url, $matches) && $_SERVER['REQUEST_METHOD'] ==  'PATCH')
    {
     
        $id = $matches[1];
        $sentencia = $conexionBd->prepare("SELECT id FROM tickets WHERE id = ? LIMIT 1;");
        $sentencia->execute([$id]);
        $numeroDeFilas = $sentencia->rowCount();
        
        if ($numeroDeFilas == 1) { 
           if(empty($_GET)){
            echo "no hay variables para cambiar escribalas en la url";
            
           }else{    
            $input = $_GET;
            $fields = obtenerParams($input);
            $consulta = " UPDATE tickets SET $fields WHERE id ='$id' ";
            $sentencia = $conexionBd->prepare($consulta);
            enlazarValores($sentencia, $input);
            $sentencia->execute();
            $consulta = $conexionBd->prepare("SELECT * FROM tikets where id=:id");
            $consulta->bindValue(':id', $id);
            $consulta->execute();      
            echo json_encode(  $consulta->fetch(PDO::FETCH_ASSOC)  );      
            header("HTTP/1.1 200 OK"); 
                  
             }
            }else {
                $resp=array("success" =>"el usuario  $id no se encuentra" );
                echo json_encode($resp);
                }

        
    }
 
//esta funcion permite realizar varios metodos de busquedas

    if(preg_match("/tickets\/([1-9][0-9]{0,15})/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS'){ 
      $input = $_GET["dato"];
      $id = $matches[1];

      
      if ($input==1){
        $consulta = $conexionBd->prepare("SELECT tickets.id,tickets.nombres,
        tickets.id_dependencia,dependencia.nombre_dependencia,tickets.id_tipo,tipo.nombre_tipo,tickets.apellidos,
        tickets.email,tickets.asunto, tickets.descripcion,tickets.fecha 
        FROM tickets,dependencia,tipo 
        WHERE tickets.id_tipo=tipo.id_tipo && tickets.id_dependencia=dependencia.id_dependencia && tickets.id=$id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
      
        echo json_encode( $consulta->fetchAll());
      }
      if ($input==2){
        $consulta = $conexionBd->prepare("SELECT tickets.id,tickets.nombres,
        tickets.id_dependencia,dependencia.nombre_dependencia,tickets.id_tipo,tipo.nombre_tipo,tickets.apellidos,
        tickets.email,tickets.asunto, tickets.descripcion,tickets.fecha 
        FROM tickets,dependencia,tipo 
        WHERE tickets.id_tipo=tipo.id_tipo && tickets.id_dependencia=dependencia.id_dependencia && tickets.id_dependencia=$id");
        $consulta->bindValue(':id_dependencia', $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
      
        echo json_encode( $consulta->fetchAll());
        
      }
      if ($input==3){
        $consulta = $conexionBd->prepare("SELECT tickets.id,tickets.nombres,
        tickets.id_dependencia,dependencia.nombre_dependencia,tickets.id_tipo,tipo.nombre_tipo,tickets.apellidos,
        tickets.email,tickets.asunto, tickets.descripcion,tickets.fecha 
        FROM tickets,dependencia,tipo 
        WHERE tickets.id_tipo=tipo.id_tipo && tickets.id_dependencia=dependencia.id_dependencia && tickets.id_tipo=$id");
        $consulta->bindValue(':id_tipo', $id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
      
        echo json_encode( $consulta->fetchAll());
        
      }
      
      
      
  
      
  
  exit();

   
}


  
//Obtener parametros para actualizar una fila en la base de datos.
function obtenerParams($input)
{
   $filterParams = [];
   foreach($input as $param => $value)
   {
           $filterParams[] = "$param=:$param";
   }
   return implode(", ", $filterParams);
   }


 //Asociar todos los parametros a un sql para armar una forma de escritura automatica para pasar los valores a la base de datos.
   function enlazarValores($sentencia, $params)
 {
       foreach($params as $param => $value)
   {
               $sentencia->bindValue(':'.$param, $value);
       }
       return $sentencia;
  }

