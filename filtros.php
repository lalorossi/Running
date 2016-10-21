<?php 

/*

  Luego de filtrar, mostrar estos datos

  NORMALES
  Fecha y hora          -LISTO
  tiempo                -LISTO
  distancia             -LISTO
  velocidad promedio    -LISTO
  ritmo promedio        -LISTO
  Velocidad máxima		  -LISTO

  AVANZADAS
  Ascenso/descenso total
  Vuelta rápida/lenta (elección de vuelta)
  Lista de vueltas con:
  				Ritmo
  				Velocidad
  				Elevación 
  Tiempo en movimiento/total	
  (cantidad de paradas)
*/

//Pausa: menos de 2 km/h por 10 seg corriendo
//Pausa: menos de 5 km7h por 30 seg en bici


//velodidades = array(distancia, velocidad, tiempoEnHoras)

/*
$peso= array ("cero", "uno", "dos", "tres", "cuatro");
array_splice($peso, 1,2); 
debug($peso);
*/

$pausa = false;


foreach ($velocidades as $index=>$value) {
  $vel = $value[1];
  $time = $value[2];
  //echo $index . "--" . $vel;
  if($vel < 5){
    if($pausa == true){
      $tiempoPausa = $time - $inicioPausa;
    }else{
      $inicioPausa = $time;
      $pausa = true;
      $indexInicio = $index;
      $tiempoPausa = 0;
    }
    //echo "---------------------". $tiempoPausa*3600;
  }
  else{
    if ($pausa == true && ($tiempoPausa*3600) >= 2) {
      //echo "-------------------------- PAUSADO -------------";
      $tiempoConPausa = $tiempoConPausa - ($tiempoPausa*3600);
      $tiempoPausa = 0;
      $offset = $index - $indexInicio;
      array_splice($velocidades, $indexInicio, $offset);
      debug($indexInicio);
      debug($offset);
      //echo $indexInicio . "-----";
      //echo $offset; 
    }
  $pausa = false;
  }
  //echo "<br>";
}



?>