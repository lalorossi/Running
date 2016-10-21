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
     return ($distance);
}

$file = $_GET['f'];
$xml = simplexml_load_file("uploads/$file");


$elevaciones = array();
$distances = array();
$velocidades = array();
$pointCounter = 0;
$speedCounter = 0;
$dis = 0;
//$pointCant = round( count($xml->trk->trkseg->trkpt) / 100 ) +1 ;

foreach($xml->trk->trkseg->trkpt as $point){

  //Conseguir la velocidad

  if($speedCounter == 0){
    $lat1 = (double) $point['lat'];
    $long1 = (double) $point['lon'];
    $time1 = (string) $point -> {'time'};
    $datetime1 = strtotime($time1);

    $speedCounter = 1;

  }
  else{
    $lat2 = (double) $point['lat'];
    $long2 = (double) $point['lon'];
    $time2 = (string) $point -> {'time'};
    $datetime2 = strtotime($time2);    
    $deltaT = ($datetime2 - $datetime1) / 3660;

    $deltaX = getDistanceBetweenPointsNew($lat1, $long1, $lat2, $long2);

    $dis = $dis + $deltaX;
    array_push($distances, ["$pointCounter", $dis]);

    $speed = $deltaX / $deltaT;
    array_push($velocidades, ["$pointCounter", $speed]);

    $lat1 = $lat2;
    $long1 = $long2;
    $datetime1 = $datetime2;
    $pointCounter = $pointCounter +1;

  }


  // Conseguir las elevaciones
  $elev =  (double) $point->{'ele'};
  array_push($elevaciones, ["$pointCounter", $elev]);

}

//debug($xml);
//debug($elevaciones);
//debug($distances);
//debug($velocidades);

 ?>

 <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(
          [
          ['num', 'elev'],
          <?php foreach($elevaciones as $k => $v): ?>
            ['<?= $v[0] ?>', <?= $v[1]; ?>],
          <?php endforeach ?>
          ]
          );

        var options = {
          title: 'Elevation',
          curveType: 'function',
          lineWidth : 1,
          tooltiptrigger : 'none',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 1800px; height: 500px;"></div>
  </body>
</html>