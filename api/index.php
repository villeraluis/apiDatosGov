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
 if($_SERVER['REQUEST_METHOD'] == 'GET') {


  if($url == '/api/positivos' ){

    $consulta1 = $conexionBd->prepare("SELECT DISTINCT datos.ciudad_de_ubicaci_n FROM datos ORDER BY datos.ciudad_de_ubicaci_n" );
    $consulta1->execute();
    $consulta1->setFetchMode(PDO::FETCH_ASSOC);    
    $positivosCuidad=array();

    while ( $ciudades=$consulta1->fetch()) {
      $ciudad=$ciudades['ciudad_de_ubicaci_n'];  
      $consulta2 = $conexionBd->prepare("SELECT COUNT(*)FROM datos WHERE datos.ciudad_de_ubicaci_n='$ciudad'" );
      $consulta2->execute();
      $consulta2->setFetchMode(PDO::FETCH_ASSOC);
      $total=$consulta2->fetch()['COUNT(*)'];
      array_push($positivosCuidad, array('Ciudad'=>$ciudad, 'Cantidad'=>$total));
    }
    echo json_encode( $positivosCuidad);
  }

  if($url == '/api/recuperados' ){
    $consulta1 = $conexionBd->prepare("SELECT DISTINCT datos.ciudad_de_ubicaci_n FROM datos ORDER BY datos.ciudad_de_ubicaci_n" );
    $consulta1->execute();
    $consulta1->setFetchMode(PDO::FETCH_ASSOC);    
    $recuperadosCuidad=array();

    while ( $ciudades=$consulta1->fetch()) {
      $ciudad=$ciudades['ciudad_de_ubicaci_n'];  
      $consulta2 = $conexionBd->prepare("SELECT COUNT(*)FROM datos WHERE datos.ciudad_de_ubicaci_n='$ciudad' && datos.atenci_n='Recuperado'" );
      $consulta2->execute();
      $consulta2->setFetchMode(PDO::FETCH_ASSOC);
      $total=$consulta2->fetch()['COUNT(*)'];
      array_push($recuperadosCuidad, array('Ciudad'=>$ciudad, 'Cantidad'=>$total));
    }
    echo json_encode( $recuperadosCuidad);
  
  }


  if($url == '/api/fallecidos' ){
    $consulta1 = $conexionBd->prepare("SELECT DISTINCT datos.ciudad_de_ubicaci_n FROM datos ORDER BY datos.ciudad_de_ubicaci_n" );
    $consulta1->execute();
    $consulta1->setFetchMode(PDO::FETCH_ASSOC);    
    $fallecidosCuidad=array();

    while ( $ciudades=$consulta1->fetch()) {
      $ciudad=$ciudades['ciudad_de_ubicaci_n'];  
      $consulta2 = $conexionBd->prepare("SELECT COUNT(*)FROM datos WHERE datos.ciudad_de_ubicaci_n='$ciudad' && datos.atenci_n='Fallecido'" );
      $consulta2->execute();
      $consulta2->setFetchMode(PDO::FETCH_ASSOC);
      $total=$consulta2->fetch()['COUNT(*)'];
      array_push($fallecidosCuidad, array('Ciudad'=>$ciudad, 'Cantidad'=>$total));
    }
    echo json_encode( $fallecidosCuidad);
  
  }


  if($url == '/api/positivosex' ){
    $consulta1 = $conexionBd->prepare("SELECT DISTINCT datos.sexo FROM datos" );
    $consulta1->execute();
    $consulta1->setFetchMode(PDO::FETCH_ASSOC);    
    $positivoSex=array();

    while ( $sexos=$consulta1->fetch()) {
      $sexo=$sexos['sexo'];  
      $consulta2 = $conexionBd->prepare("SELECT COUNT(*)FROM datos WHERE datos.sexo='$sexo'" );
      $consulta2->execute();
      $consulta2->setFetchMode(PDO::FETCH_ASSOC);
      $total=$consulta2->fetch()['COUNT(*)'];
      array_push($positivoSex, array('sexo'=>$sexo, 'Cantidad'=>$total));
    }
    echo json_encode( $positivoSex);
  
  }
  

  if($url == '/api/edades' ){
    $consulta1 = $conexionBd->prepare("SELECT COUNT(datos.edad)FROM datos" );
    $consulta1->execute();
    $consulta1->setFetchMode(PDO::FETCH_ASSOC); 
    $nPositivos=$consulta1->fetch()['COUNT(datos.edad)'];
    $edades=array();
    $total=0;
    $lInferior=0;
    $lSuperior=10;
    $n=$nPositivos;
   
    while ($total<$nPositivos  ) {
     
      $consulta2 = $conexionBd->prepare("SELECT COUNT(*)FROM datos WHERE datos.edad>=$lInferior && datos.edad<$lSuperior" );
      $consulta2->execute();
      $consulta2->setFetchMode(PDO::FETCH_ASSOC);
      $totalTemp=$consulta2->fetch()['COUNT(*)'];

      array_push($edades, array('edadmin'=>$lInferior,'edadmax'=>$lSuperior-1, 'Cantidad'=>$totalTemp));
      $total=$total+$totalTemp;
      $lInferior= $lInferior+10;
      if($lSuperior>=90){
        $lSuperior=$lSuperior+60;
      }else{
        $lSuperior=$lSuperior+10;
      }
      
     // echo $total .'\n';
      

    }
  
    echo json_encode( $edades);
  
  }

  }
    

 
// trae los datos de la api externa e  inserta los datos en la base de datos con datos recibidos por POST
//if($url == '/tickets' && $_SERVER['REQUEST_METHOD'] == 'POST') {

  if( $url == '/api/getdata') {
   include_once("../php/getdata.php");

  }

  
  
//esta funcion seconecta con la api externa y guarda los datos en la base local


