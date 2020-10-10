<?php
 include ("conexion.php");

 $ndatos=30000;   
 $consultaDel = $conexionBd->prepare("TRUNCATE TABLE datos");
 $consultaDel -> execute();

 $headers = array(
   'Accept: application/json',
   'Content-type: application/json',
   "X-App-Token: " . 'SRCTIinLUBDwFfewx64V6JFJb'
   );
   
   $cliente =
   curl_init(
   "https://www.datos.gov.co/resource/gt2j-8ykr.json?departamento=C%C3%B3rdoba&\$limit=$ndatos");
   curl_setopt($cliente, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);

   $response = curl_exec($cliente);


   
   //print_r(($response));

   $datospaciente = json_decode($response, true);

   foreach ($datospaciente as $paciente) {

    
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

      
   //

       $consulta = $conexionBd->prepare("INSERT INTO 
      datos ( id_de_caso,fecha_de_notificaci_n,c_digo_divipola,
     ciudad_de_ubicaci_n,departamento,atenci_n,edad,sexo,tipo,estado,pa_s_de_procedencia,
     fis,fecha_de_muerte,fecha_diagnostico,fecha_recuperado,fecha_reporte_web,tipo_recuperaci_n,
     codigo_departamento,codigo_pais,pertenencia_etnica,nombre_grupo_etnico,ubicaci_n_recuperado)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");  
       $consulta->bindParam(1, $paciente['id_de_caso'], PDO::PARAM_STR);
       $consulta->bindParam(2, $paciente['fecha_de_notificaci_n'], PDO::PARAM_STR);
       $consulta->bindParam(3, $paciente['c_digo_divipola'], PDO::PARAM_STR);
       $consulta->bindParam(4, $paciente['ciudad_de_ubicaci_n'], PDO::PARAM_STR);
       $consulta->bindParam(5, $paciente['departamento'], PDO::PARAM_STR);
       $consulta->bindParam(6, $paciente['atenci_n'], PDO::PARAM_STR);
       $consulta->bindParam(7, $paciente['edad'], PDO::PARAM_STR);
       $consulta->bindParam(8, $paciente['sexo'], PDO::PARAM_STR);
       $consulta->bindParam(9, $paciente['tipo'], PDO::PARAM_STR);
       $consulta->bindParam(10, $paciente['estado'], PDO::PARAM_STR);
       $consulta->bindParam(11, $paciente['pa_s_de_procedencia'], PDO::PARAM_STR);
       $consulta->bindParam(12, $paciente['fis'], PDO::PARAM_STR);
       $consulta->bindParam(13, $paciente['fecha_de_muerte'], PDO::PARAM_STR);
       $consulta->bindParam(14, $paciente['fecha_diagnostico'], PDO::PARAM_STR);
       $consulta->bindParam(15, $paciente['fecha_recuperado'], PDO::PARAM_STR);
       $consulta->bindParam(16, $paciente['fecha_reporte_web'], PDO::PARAM_STR);
       $consulta->bindParam(17, $paciente['tipo_recuperaci_n'], PDO::PARAM_STR);
       $consulta->bindParam(18, $paciente['codigo_departamento'], PDO::PARAM_STR);
       $consulta->bindParam(19, $paciente['codigo_pais'], PDO::PARAM_STR);
       $consulta->bindParam(20, $paciente['pertenencia_etnica'], PDO::PARAM_STR);
       $consulta->bindParam(21, $paciente['nombre_grupo_etnico'], PDO::PARAM_STR);
       $consulta->bindParam(22, $paciente['ubicaci_n_recuperado'], PDO::PARAM_STR);
     

       $consulta -> execute();
   



    }

?>