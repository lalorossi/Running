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

$nuevaVel = 0;

/*
$peso= array ("cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez");
debug($peso);
foreach($peso as $k=>$v){
  if($k==3){
  	echo "a";
   	array_splice($peso, $k, 5);
   }
  debug($v);
}
debug ($peso);
*/
//EL foreach sigue recorriendo en los elementos que se "borraron". Ver ejemplo de arriba

debug($velocidades);

foreach ($velocidades as $index=>$value) {
	if($nuevaVel != 0){
		if($index == $nuevaVel)
			$nuevaVel = 0;
		else
			continue;
	}

	$vel = $value[1];
	$time = $value[2];
	
	debug($index);
	if($vel < 5){
		echo "---";
		$tiempoPausa = 0;
		$offset = 0;  
		foreach ($velocidades as $k => $v) {
			if ($k <= $index) continue;
			//debug($v);
			if($v[1] < 5){
				debug("$k,".($tiempoPausa*3600)."");	
				$tiempoPausa = $v[2] - $time;
				$offset += 1;
			}
			else	
				break;
		}
		if(($tiempoPausa*3600)>=2){
			debug("pauso");
			array_splice($velocidades, $index, $offset);
			$nuevaVel = $index + $offset;
		}
		//Podría hacer un continue hasata $index+$offset
	}
	$tiempoConPausa = $tiempoConPausa - $tiempoPausa;
	//if ($index >0) ritmos2($medioKm, $unKm, $dosKm, $cincoKm);
}
debug ($velocidades);



/*
//$peso = array(4, 4, 5, 2, 1, 2, 3, 4, 5);
debug($peso);
echo "---";
$nn = 0;

foreach ($peso as $index => $value) {
	if($nn != 0){
		if($index == $nn)
			$nn = 0;
		else
			continue;
	}
	debug ($value);
	if($index == 2){
		array_splice($peso, $index, 3);
		$nn = $index + 3;
	}

}
*/

 ?>