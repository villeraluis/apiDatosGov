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



// 1. READ   


// listar todos los casos
// 2. LIST   GET /casos

//
 if($url == '/api/casos' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $consulta = $conexionBd->prepare("SELECT * FROM datos");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_ASSOC);
    
    header("HTTP/1.1 200 OK");
    echo json_encode( $consulta->fetchAll()  );
   
  exit();}
    

// 3. CREATE  
// trae los datos de la api externa e  inserta los datos en la base de datos con datos recibidos por POST
//if($url == '/tickets' && $_SERVER['REQUEST_METHOD'] == 'POST') {

  if( $url == '/api/insert' && $_SERVER['REQUEST_METHOD'] == 'POST') {
           
    obtenciondatos();
      
}



    
   


 

   


 
//esta funcion permite realizar varios metodos de busquedas

    if(preg_match("/pacientes\/([1-9][0-9]{0,15})/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS'){ 
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
  
//esta funcion seconecta con la api externa y guarda los datos en la base local
  function obtenciondatos(){
   
    $headers = array(
      'Accept: application/json',
      'Content-type: application/json',
      "X-App-Token: " . 'SRCTIinLUBDwFfewx64V6JFJb'
      );
      
      $cliente =
      curl_init(
      "https://www.datos.gov.co/resource/gt2j-8ykr.json?departamento=C%C3%B3rdoba&\$limit=100");
      curl_setopt($cliente, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($cliente);


      
      print_r("Total de Registros obtenidos: ".($response));

      $datospaciente = json_decode($response, true);

      foreach ($datospaciente as $paciente) {

       // print_r($paciente);
         if(!array_key_exists('fis', $paciente)){
          $paciente['fis']= null;
         }
         if(!array_key_exists('fecha_de_muerte', $paciente)){
          $paciente['fecha_de_muerte']= null;
         }
         if(!array_key_exists('pa_s_de_procedencia', $paciente)){
          $paciente['pa_s_de_procedencia']= null;
         }
         if(!array_key_exists('codigo_pais', $paciente)){
          $paciente['codigo_pais']= null;
         }
         if(!array_key_exists('pertenencia_etnica', $paciente)){
          $paciente['pertenencia_etnica']=null;
         }
         if(!array_key_exists('nombre_grupo_etnico', $paciente)){
          $paciente['nombre_grupo_etnico']= null;
         }
         if(!array_key_exists('fecha_recuperado', $paciente)){
          $paciente['fecha_recuperado']= null;
         }
         if(!array_key_exists('tipo_recuperaci_n', $paciente)){
          $paciente['tipo_recuperaci_n']= null;
         }

      //TRUNCATE TABLE datos

         $query = $conexionBd->prepare("INSERT INTO 
         datos ( id_de_caso,fecha_de_notificaci_n,c_digo_divipola,
        ciudad_de_ubicaci_n,departamento,atenci_n,edad,sexo,tipo,estado,pa_s_de_procedencia,
        fis,fecha_de_muerte,fecha_diagnostico,fecha_recuperado,fecha_reporte_web,tipo_recuperaci_n,
        codigo_departamento,codigo_pais,pertenencia_etnica,nombre_grupo_etnico,ubicaci_n_recuperado)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");  
         $query->bindParam(1, $paciente['id_de_caso'], PDO::PARAM_STR);
         $query->bindParam(2, $paciente['fecha_de_notificaci_n'], PDO::PARAM_STR);
         $query->bindParam(3, $paciente['c_digo_divipola'], PDO::PARAM_STR);
         $query->bindParam(4, $paciente['ciudad_de_ubicaci_n'], PDO::PARAM_STR);
         $query->bindParam(5, $paciente['departamento'], PDO::PARAM_STR);
         $query->bindParam(6, $paciente['atenci_n'], PDO::PARAM_STR);
         $query->bindParam(7, $paciente['edad'], PDO::PARAM_STR);
         $query->bindParam(8, $paciente['sexo'], PDO::PARAM_STR);
         $query->bindParam(9, $paciente['tipo'], PDO::PARAM_STR);
         $query->bindParam(10, $paciente['estado'], PDO::PARAM_STR);
         $query->bindParam(11, $paciente['pa_s_de_procedencia'], PDO::PARAM_STR);
         $query->bindParam(12, $paciente['fis'], PDO::PARAM_STR);
         $query->bindParam(13, $paciente['fecha_de_muerte'], PDO::PARAM_STR);
         $query->bindParam(14, $paciente['fecha_diagnostico'], PDO::PARAM_STR);
         $query->bindParam(15, $paciente['fecha_recuperado'], PDO::PARAM_STR);
         $query->bindParam(16, $paciente['fecha_reporte_web'], PDO::PARAM_STR);
         $query->bindParam(17, $paciente['tipo_recuperaci_n'], PDO::PARAM_STR);
         $query->bindParam(18, $paciente['codigo_departamento'], PDO::PARAM_STR);
         $query->bindParam(19, $paciente['codigo_pais'], PDO::PARAM_STR);
         $query->bindParam(20, $paciente['pertenencia_etnica'], PDO::PARAM_STR);
         $query->bindParam(21, $paciente['nombre_grupo_etnico'], PDO::PARAM_STR);
         $query->bindParam(22, $paciente['ubicaci_n_recuperado'], PDO::PARAM_STR);
        

         $query -> execute();


                
    }
      
  }

