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
			debug($i);
		}
		//Podría hacer un continue hasata $index+$offset
	}
	$tiempoConPausa = $tiempoConPausa - $tiempoPausa;
	$tiempoPausa = 0;
	//if ($index >0) ritmos2($medioKm, $unKm, $dosKm, $cincoKm);
}


?>