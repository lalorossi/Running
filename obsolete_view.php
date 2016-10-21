<?php 

/*

	Acá se dirige cuando se sube el archivo, y muestra las cosas que se necesiten

	Agregar casillas de verificacion para mostrar solo los datos elegidos. Puedo usar
	JS para cambiar el contenido mientras selecciono las casillas

  ATRIBUTOS A MOSTRAR EN GRÁFICO.
  velocidad
  ritmo
  elevacion
  velocidad media (linea fina)

  FUERA DEL GRÁFICO
  velocidad máxima
  velocidad promedio
  ritmo promedio
  (cantidad de paradas)
  tiempo
  distancia

*/

function debug($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
/*
function array_push_assoc($array, $key, $value){
	$array[$key] = $value;
	return $array;
}
*/

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
     $theta = $longitude1 - $longitude2;
     $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
     $distance = acos($distance);
     $distance = rad2deg($distance);
     $distance = $distance * 60 * 1.1515; switch($unit) {
          case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
     }
     return (round($distance,2));
}

$file = $_GET['f'];
$gpx = simplexml_load_file("uploads/$file");


$lats = array();
$longs = array();
$p = 0;
$v = 0;
$l = round( count($gpx->trk->trkseg->trkpt) / 100 ) +1 ;

foreach($gpx->trk->trkseg->trkpt as $point){
	//debug((string) $point["lat"]);

	//if($p % 98 == 0){
    if($v == 0){
      $lat1 = (double) $point['lat'];
      $long1 = (double) $point['lon'];
      $v = 1;
    }
    else{
      $lat2 = (double) $point['lat'];
      $long2 = (double) $point['lon'];
      $v = 1;
      $dis = getDistanceBetweenPointsNew($lat1, $long1, $lat2, $long2);
    }
    /*
    $ad = (double) $point;
    echo $ad;
    */

    $ad = (double) $point->{'ele'};
    array_push($lats, $ad);

 // }
  $p = $p +1;
}

//debug($gpx);
//debug($lats);
 ?>

<!DOCTYPE html>
<html>
 <head>
  <title></title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
 </head>
 <body>
  <div id="grafico" style="height: 350px;"></div>
 </body>
 <script type="text/javascript">
  $(function(){
   new Morris.Line({
    pointSize : 0,
    xLabelAngle : 30,
    element: 'grafico',
    data: [
     <?php foreach ($lats as $k => $v): ?>
     { llave: '<?= $k ?>', valor: <?= $v ?> },
     <?php endforeach ?>
    ],
    xkey: 'llave',
    ykeys: ['valor'],
    labels: ['dis']
   });
  });
 </script>
</html>