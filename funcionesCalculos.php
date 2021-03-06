<?php 


function debug($data){
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}

function array_push_assoc($array, $key, $value){
  $array[$key] = $value;
  return $array;
}

//Devuelve desitancia entre dos coordenadas
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
  $theta = $longitude1 - $longitude2;
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
  $distance = acos($distance);
  $distance = rad2deg($distance);
  $distance = $distance * 60 * 1.1515; 
  switch($unit) {
    case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
  }
  return ($distance);
}

//Devuelve un string en el formato hh:mm:ss
//Si no hay horas - mm:ss
//Si son menos de 10 min - 0m::ss
function formatoMin($numEnMinutos, $sacarCerosHora=false){
  $mins = (int) $numEnMinutos;
  $hs = (int) ($mins / 60);
  $segs = $numEnMinutos - $mins;
  $segs = (int) ($segs * 60);

  $ret = "";
  if($hs>=1){
    $ret .= "0$hs:";
    $mins = $mins - ($hs * 60);
  }else{
    if($sacarCerosHora==false){
      $ret .= "00:";
    }
  }
  if($mins<10){
    $ret .= "0$mins:";
  }
  else{
    $ret .= "$mins:";
  }
  if($segs<10){
    $ret .= "0$segs";
  }
  else{
    $ret .= "$segs";
  }
  return $ret;
}

function arrayHora($hora2, $tiempoTranscurrido, &$tiempo){

  // NO ANDA //
	//Array con la hora del punto [hh, mm, ss] - $tiempo
  //String con el tiempo transcurrido "hh:mm:ss" - $aaa

  $data = 0;
  $aaa = ""; 

  for($i=0; $i<3; $i++){

    if($data == 0){
      array_push($tiempo, substr($hora2, -9, 2));
      $data++;
      $aaa .= formatoMin($tiempoTranscurrido/60) . ':';
    }
    elseif($data == 1){
      array_push($tiempo, substr($hora2, -6, 2));
      $data++;
      $aaa .= formatoMin($tiempoTranscurrido/60) . ':';
    }
    elseif($data == 2){
      array_push($tiempo, substr($hora2, -3, 2));
      $data=0;
      $aaa .= formatoMin($tiempoTranscurrido/60);
    }
  }
  echo $aaa . "<br>";
  return $aaa;
}

function calculoGrids($distanciaDesdeInicio){
	if($distanciaDesdeInicio <=12)
	  if($distanciaDesdeInicio <=5)
	    $cantGrid = intval($distanciaDesdeInicio/0.5);
	  else
	    $cantGrid = intval($distanciaDesdeInicio);
	else
	  if($distanciaDesdeInicio >=29)
	    if($distanciaDesdeInicio >= 70)
	      $cantGrid = intval($distanciaDesdeInicio/10);
	    else
	      $cantGrid = intval($distanciaDesdeInicio/5);
	  else
	      $cantGrid = intval($distanciaDesdeInicio/2);

	return $cantGrid;
}
/*
Divisiones de cuadricula
(0, 5]km -> cada 0.5 km
[6, 12]km -> cada 1 km
[13, 28]km -> cada 2 km
[29, 69]km -> cada 5 km
[70, ..)km -> cada 10 km
*/

function ritmos(&$medioKm, &$unKm, &$dosKm, &$cincoKm){
  global $distanciaDesdeInicio;
  global $tiempoTranscurrido;
  global $vuelta05;
  global $tiempoInicial05;
  global $vuelta1;
  global $tiempoInicial1;
  global $tiempoInicial2;
  global $tiempoInicial5;

  if($distanciaDesdeInicio >= $vuelta05){
    $deltaT05 = $tiempoTranscurrido-$tiempoInicial05;
    $velocidad05 = 0.5/$deltaT05;
    $ritmo05 = (($deltaT05*60)/0.5);
    $ritmo05 = formatoMin($ritmo05, true);
    array_push($medioKm, [$ritmo05, $velocidad05]);

    if($vuelta05 == $vuelta1){
      $deltaT1 = $tiempoTranscurrido - $tiempoInicial1;
      $velocidad1 = 1/$deltaT1;
      $ritmo1 = ($deltaT1*60);
      $ritmo1 = formatoMin($ritmo1, true);
      array_push($unKm, [$ritmo1, $velocidad1]);

      if($vuelta1%2 == 0){
        $deltaT2 = $tiempoTranscurrido - $tiempoInicial2;
        $velocidad2 = 2/$deltaT2;
        $ritmo2 = (($deltaT2*60)/2);
        $ritmo2 = formatoMin($ritmo2, true);
        array_push($dosKm, [$ritmo2, $velocidad2]);

        $tiempoInicial2 = $tiempoTranscurrido;
      }

      if($vuelta1%5 == 0){
        $deltaT5 = $tiempoTranscurrido - $tiempoInicial5;
        $velocidad5 = 5/$deltaT5;
        $ritmo5 = (($deltaT5*60)/5);
        $ritmo5 = formatoMin($ritmo5, true);
        array_push($cincoKm, [$ritmo5, $velocidad5]);

        $tiempoInicial5 = $tiempoTranscurrido;
      }

      $vuelta1 += 1;
      $tiempoInicial1 = $tiempoTranscurrido;
    }
    $vuelta05 += 0.5;
    $tiempoInicial05 = $tiempoTranscurrido;

  }
}

function ritmos2(&$medioKm, &$unKm, &$dosKm, &$cincoKm){
  global $dist;
  global $time;
  global $vuelta05;
  global $tiempoInicial05;
  global $vuelta1;
  global $tiempoInicial1;
  global $tiempoInicial2;
  global $tiempoInicial5;

  global $max05;
  global $max1;
  global $max2;
  global $max5;

  global $min05;
  global $min1;
  global $min2;
  global $min5;

  $rap05 = false;

  if($dist >= $vuelta05){
    $deltaT05 = $time-$tiempoInicial05;
    $velocidad05 = 0.5/$deltaT05;

    if($velocidad05 > $max05 )  $max05 = $velocidad05;
    if($velocidad05 < $min05 )  $min05 = $velocidad05;

    $ritmo05 = (($deltaT05*60)/0.5);
    $ritmo05 = formatoMin($ritmo05, true);
    array_push($medioKm, [$ritmo05, $velocidad05, formatoMin($deltaT05*60), $vuelta05]);

    if($vuelta05 == $vuelta1){
      $deltaT1 = $time - $tiempoInicial1;
      $velocidad1 = 1/$deltaT1;

      if($velocidad1 > $max1 )  $max1 = $velocidad1;
      if($velocidad1 < $min1 )  $min1 = $velocidad1;

      $ritmo1 = ($deltaT1*60);
      $ritmo1 = formatoMin($ritmo1, true);
      array_push($unKm, [$ritmo1, $velocidad1, formatoMin($deltaT1*60), $vuelta1]);

      if($vuelta1%2 == 0){
        $deltaT2 = $time - $tiempoInicial2;
        $velocidad2 = 2/$deltaT2;

        if($velocidad2 > $max2 )  $max2 = $velocidad2;
        if($velocidad2 < $min2 )  $min2 = $velocidad2;

        $ritmo2 = (($deltaT2*60)/2);
        $ritmo2 = formatoMin($ritmo2, true);
        array_push($dosKm, [$ritmo2, $velocidad2, formatoMin($deltaT2*60), $vuelta1]);

        $tiempoInicial2 = $time;
      }

      if($vuelta1%5 == 0){
        $deltaT5 = $time - $tiempoInicial5;
        $velocidad5 = 5/$deltaT5;

        if($velocidad5 > $max5 )  $max5 = $velocidad5;
        if($velocidad5 < $min5 )  $min5 = $velocidad5;

        $ritmo5 = (($deltaT5*60)/5);
        $ritmo5 = formatoMin($ritmo5, true);
        array_push($cincoKm, [$ritmo5, $velocidad5, formatoMin($deltaT5*60), $vuelta1]);

        $tiempoInicial5 = $time;
      }

      $vuelta1 += 1;
      $tiempoInicial1 = $time;
    }
    $vuelta05 += 0.5;
    $tiempoInicial05 = $time;

  }
}

//Sacar los últimos ritmos de vuelta
function ultimoRitmo($tiempoTranscurrido, $distanciaDesdeInicio, $distVuelta, $ultimoTiempo, &$array){
  
  global $max05;
  global $max1;
  global $max2;
  global $max5;

  global $min05;
  global $min1;
  global $min2;
  global $min5;

  $deltaT = $tiempoTranscurrido-$ultimoTiempo;
  $distVuelta2 = $distVuelta;
  $distVuelta = $distanciaDesdeInicio - ((int) ($distanciaDesdeInicio/$distVuelta))*$distVuelta;
  $velocidad = $distVuelta/$deltaT;

  switch ($distVuelta2) {
    case 0.5:
      if ($velocidad > $max05) $max05 = $velocidad;
      if ($velocidad < $min05) $min05 = $velocidad;
      break;
    case 1:
      if ($velocidad > $max1) $max1 = $velocidad;
      if ($velocidad < $min1) $min1 = $velocidad;
      break;
    case 2:
      if ($velocidad > $max2) $max2 = $velocidad;
      if ($velocidad < $min2) $min2 = $velocidad;
      break;
    case 5:
      if ($velocidad > $max5) $max5 = $velocidad;
      if ($velocidad < $min5) $min5 = $velocidad;
      break;
  
    }

  $ritmo = (($deltaT*60)/$distVuelta);
  $ritmo = formatoMin($ritmo, true);
  array_push($array, [$ritmo, $velocidad, formatoMin($deltaT*60), $distanciaDesdeInicio]);
}

 ?>