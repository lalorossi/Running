<?php 


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
$tiempoTotalPausa = 0;

end($velocidades);         // move the internal pointer to the end of the array
$key = key($velocidades);

for ($i=0; $i<$key; $i++){
	$vel = $velocidades[$i][1];
	$time = $velocidades[$i][2];
	if($vel < 5){
		$tiempoPausa = 0;
		$offset = 0;  
		for($x=$i+1; $x<$key; $x++){
			if($velocidades[$x][1] < 5){
				$tiempoPausa = $velocidades[$x][2] - $time;
				$offset += 1;
			}
			else	
				break;
		}
		if(($tiempoPausa*3600)>=2){
			$offset += 1;
			array_splice($velocidades, $i, $x-$i);
			$key -= $offset;
			$i-=1;
		}
	}
	$tiempoConPausa = $tiempoConPausa - $tiempoPausa;
	$tiempoTotalPausa += $tiempoPausa;
	$time -= $tiempoTotalPausa;
	//debug($time);
	$tiempoPausa = 0;
	if ($i>0){
		$distanciaDesdeInicio = $velocidades[$i][0];
		ritmos2($medioKm, $unKm, $dosKm, $cincoKm);
	} 
	//Hay que ajustar los cambios para que también modifiquen la distancia (Velocidades[$i][0])
	//Y aplicar las pausas a los array de elevaciones y distancias
}


//Calculo de ritmos de vueltas finales incompletas
ultimoRitmo($tiempoConPausa, $distanciaDesdeInicio, 0.5, $tiempoInicial05, $medioKm);
ultimoRitmo($tiempoConPausa, $distanciaDesdeInicio, 1, $tiempoInicial1, $unKm);
ultimoRitmo($tiempoConPausa, $distanciaDesdeInicio, 2, $tiempoInicial2, $dosKm);
ultimoRitmo($tiempoConPausa, $distanciaDesdeInicio, 5, $tiempoInicial5, $cincoKm);



?>