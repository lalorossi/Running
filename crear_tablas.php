<?php 

include_once("funcionesCalculos.php");


//ESTO SE PUEDE MANDAR AL ARCHIVO FUNCIONES
//Toma los datos que se quieren mostrar desde el get
/*
$grafico = array();

if(!isset($_GET['g'])){
  $grafico = 'velocidades';
}
else{
  $graf = $_GET['g'];
  $v = 0;
  $e = 0;
  $d = 0;

  for($i=0; $i<strlen($graf); $i++){
    if($graf[$i] != ','){
      switch ($graf[$i]) {
        case 'e':
          if($e == 0){
            array_push($grafico, 'elevaciones');
            $e = 1;            
          }
          break;

        case 'v':
          if($v == 0){
            array_push($grafico, 'velocidades');
            $v = 1;            
          }
          break;

        case 'd':
          if($d == 0){
            array_push($grafico, 'distances');
            $d = 1;            
          }
          break;
        
        default:
          array_push($grafico, 'elevaciones');
          break;
      }
    }
  }
}
*/

$file = $_GET['f'];
$xml = simplexml_load_file("uploads/$file");

//Arrays con las tablas del grafico
$elevaciones = array();
$distancias = array();
$velocidades = array();

$primerIteracion = 0;
$distanciaDesdeInicio = 0;      //Distancia desde el inicio
$elevacionTotal = 0;            //Elevacion actual  MODIFICAR PARA QUE SOLO TOME LAS SUBIDAS
$velMax = 0;

//Arrays de [ritmos, velocidades] segun distancia de vuelta  
$medioKm = array();             
$unKm = array();
$dosKm = array();
$cincoKm = array();
/*
//Para buscar las distancias que coincidan con la distancia de vuelta
$vuelta05 = 0.5;                
$vuelta1 = 1;

//Para sacar el delta T de la vuelta
$tiempoInicial05 = 0;           
$tiempoInicial1 = 0;
$tiempoInicial2 = 0;
$tiempoInicial5 = 0;
*/
$tiempoConPausa = 0;                       //Suma de los deltaT (sirve para calcular tiempos con pausas)


foreach($xml->trk->trkseg->trkpt as $in=>$punto){

  if($primerIteracion == 0){

    //Coordenadas del primer punto para sacar la distancia
    $lat1 = (double) $punto['lat'];
    $long1 = (double) $punto['lon'];
    $hora1 = (string) $punto -> {'time'};     //2016-08-19T22:10:11Z  HORA DEL PRIMER PUNTO 
    $datetime1 = strtotime($hora1);           //1471644605            SEGUNDOS DESDE 1/1/1970 00:00:00                 
    $horaInicio = $datetime1;                 //HORA DE INICIO
    $tiempoTranscurrido = 0;
    $fechaActividad = date_create("$hora1");
    $fechaActividad = date_format($fechaActividad, "Y/m/d");

    $primerIteracion = 1;

  }
  else{

    //Coordenadas del 2do punto para la distancia
    $lat2 = (double) $punto['lat'];
    $long2 = (double) $punto['lon'];
    $hora2 = (string) $punto -> {'time'};                   //2016-08-19T22:10:11Z  HORA DEL PUNTO ACTUAL
    $deltaX = getDistanceBetweenPointsNew($lat1, $long1, $lat2, $long2);
    $horaFin = strtotime($hora2);                           //1471644611            SEGUNDOS DESDE 1/1/1970 00:00:00
    $deltaT = ($horaFin - $datetime1);                      //6                     SEGUNDOS DESDE EL PUNTO ANTERIOR   
    $tiempoTranscurrido = ($horaFin - $horaInicio) / 3600;  //0.0016666666666667    HORAS DESDE EL INICIO

    //Uso el punto actual como siguiente primer punto
    $lat1 = $lat2;              
    $long1 = $long2;  
    $datetime1 = $horaFin;  


    $distanciaDesdeInicio = $distanciaDesdeInicio + $deltaX;
    $velocidad = $deltaX / ($deltaT/3600);

    //$tiempoConPausa = $tiempoConPausa + $deltaT;


    //Calculo de ritmos por vueltas
    //SI METO LAS PAUSAS A ESTE FOREACH, ESTO TIENE QUE SALIR 
    //ritmos($medioKm, $unKm, $dosKm, $cincoKm);


    //Array de distancias en funcion del tiempo transcurrido 
    // LO VOY A TERMINAR SACANDO. SIRVE PARA CHEQUEOS
    array_push($distancias, [($tiempoTranscurrido*60), $distanciaDesdeInicio]);

    //Array de velocidades en funcion del tiempo transcurrido
    array_push($velocidades, [$distanciaDesdeInicio, $velocidad, $tiempoTranscurrido]);
    if($velocidad>$velMax) $velMax = $velocidad;

  }

  //Array de elevaciones, en función de la distancia o el tiempo
  $elevacion =  (double) $punto->{'ele'};
  array_push($elevaciones, [$distanciaDesdeInicio, $elevacion, $tiempoTranscurrido]);

  //LEER COMO SE CALCULA
  $elevacionTotal += $elevacion;


}


/*
PARA SABER COMO FUNCIONA EL SPLICE

$peso= array ("cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez");
array_splice($peso, 3, 5); 
debug($peso);
*/

include_once "filtrosFOR.php";
/*
//Calculo de ritmos de vueltas finales incompletas
ultimoRitmo($tiempoTranscurrido, $distanciaDesdeInicio, 0.5, $tiempoInicial05, $medioKm);
ultimoRitmo($tiempoTranscurrido, $distanciaDesdeInicio, 1, $tiempoInicial1, $unKm);
ultimoRitmo($tiempoTranscurrido, $distanciaDesdeInicio, 2, $tiempoInicial2, $dosKm);
ultimoRitmo($tiempoTranscurrido, $distanciaDesdeInicio, 5, $tiempoInicial5, $cincoKm);
*/

//Sacar la velocidad media en Km/h
$velocidadMedia = $distanciaDesdeInicio / $tiempoTranscurrido;

//Sacar el ritmo en min/Km
$ritmo = (($tiempoTranscurrido*60)/$distanciaDesdeInicio);
$ritmo = formatoMin($ritmo, true);

//Tiempos con pausas ($tiempoConPausa) o sin
$tiempoTranscurrido = formatoMin($tiempoTranscurrido*60);
$tiempoConPausa = formatoMin($tiempoConPausa*60);

//Cantidad de cuadriculas en el grafico
$cantGrid = calculoGrids($distanciaDesdeInicio);

//include_once  'filtros.php';
//debug($xml);
//debug($elevaciones);
//debug($distancias);
//debug($velocidades);
//debug($grafico);
debug($medioKm);
//debug($unKm);
//debug($dosKm);
//debug($cincoKm);



include_once 'draw.php';  
?>

<html>
<body>
<h1>Día de la actividad</h1>
<br><?= $fechaActividad ?></br>
<h1>Tiempo total</h1>
<br><?= $tiempoTranscurrido ?></br>
<h1>Tiempo en movimiento</h1>
<br><?= $tiempoConPausa ?></br>
<h1>Distancia</h1>
<br><?= $distanciaDesdeInicio; ?></br>
<h1>Velocidad media</h1>
<br><?= $velocidadMedia; ?></br>
<h1>Velocidad máxima</h1>
<br><?= $velMax; ?></br>
<h1>Subida total</h1>
<br><?= $elevacionTotal; ?></br>
<h1>Ritmo</h1>
<br><?= $ritmo ?></br>
</body>
</html>
