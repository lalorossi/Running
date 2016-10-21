<?php 
//Este tiene pausas "mirando a futuro"


end($velocidades);         // move the internal pointer to the end of the array
$key = key($velocidades);

//Para buscar las distancias que coincidan con la distancia de vuelta
$vuelta05 = 0.5;                
$vuelta1 = 1;

//Para sacar el delta T de la vuelta
$tiempoInicial05 = 0;           
$tiempoInicial1 = 0;
$tiempoInicial2 = 0;
$tiempoInicial5 = 0;

$tiempoConPausa = $tiempoTranscurrido;

/*
$peso= array ("cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez");
foreach($peso as $k=>$v){
  if($k==3){
  	echo "a";
   	array_splice($peso, 3, 5);
   }
  debug($v);
}
debug($peso);
*/

//EL foreach sigue recorriendo en los elementos que se "borraron". Ver ejemplo de arriba

foreach ($velocidades as $index=>$value) {
	$vel = $value[1];
	$time = $value[2];
	
	if($nuevaVel != 0){
		if($index == $nuevaVel)
			$nuevaVel = 0;
		else
			continue;
	}
	if($vel < 5){
		$tiempoPausa = 0;
		$offset = 0;
		debug($value);
		foreach ($velocidades as $k => $v) {
			if ($k < $index) continue;
			//debug($v);
			if($v[1] < 5){
				$tiempoPausa = $v[2] - $time;
				$offset += 1;
			}
			else	break;
		}
		if(($tiempoPausa*3600)>=2){
			array_splice($velocidades, $index, $offset);
			$nuevaVel = $index + $offset;
		}
		//Podría hacer un continue hasata $index+$offset
	}
	$tiempoConPausa = $tiempoConPausa - $tiempoPausa;
	//if ($index >0) ritmos2($medioKm, $unKm, $dosKm, $cincoKm);
}


 ?>