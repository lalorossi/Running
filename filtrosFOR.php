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
$nuevaVel = 0;




/*
echo "___________";

$peso2= array ("cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez");
end($peso2);         // move the internal pointer to the end of the array
$key = key($peso2);

for ($i=0; $i <= $key; $i++) { 
	if($i == 3){
		echo "a";
		array_splice($peso2, $i, 3);
		$key -= 3;
	}
	debug($peso2[$i]);
}
debug($peso2);
*/

//debug($velocidades);

end($velocidades);         // move the internal pointer to the end of the array
$key = key($velocidades);



for ($a=0; $a<$key; $a++){
	echo "$a ---" . $velocidades[$a][1] . " --- ". ($velocidades[$a][2]*3600)."<br>";
}


for ($i=0; $i<$key; $i++){
	$vel = $velocidades[$i][1];
	$time = $velocidades[$i][2];
	echo("$i --- $vel");
	if($vel < 5){
		echo " ------ MENOR";
		$tiempoPausa = 0;
		$offset = 0;  
		for($x=$i+1; $x<$key; $x++){
			if($velocidades[$x][1] < 5){
				echo "<br>".$velocidades[$x][1]." ----- DOBLE <br>";
				$tiempoPausa = $velocidades[$x][2] - $time;
				$offset += 1;
			}
			else	
				break;
		}
		echo "<br>";
		if(($tiempoPausa*3600)>=2){
			$offset += 1;
			array_splice($velocidades, $i, $x-$i);
			$key -= $offset;
			debug("borro ".($x-$i));
			$i-=1;
			debug($i);
		}
		//Podría hacer un continue hasata $index+$offset
	}
	echo "<br>";
	$tiempoConPausa = $tiempoConPausa - $tiempoPausa;
	$tiempoPausa = 0;
	//if ($index >0) ritmos2($medioKm, $unKm, $dosKm, $cincoKm);
}


for ($a=0; $a<$key; $a++){
	echo "$a ---" . $velocidades[$a][1] . "<br>";
}


debug($tiempoConPausa);

?>