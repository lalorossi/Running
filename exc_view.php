<html>
<head>
	<style>
		table {
		    font-family: arial, sans-serif;
		    border-collapse: collapse;
		}

		td, th {
		    border: 1px solid #dddddd;
		    text-align: left;
		    padding: 8px;
		}

		tr:nth-child(even) {
		    background-color: #dddddd;
		}
	</style>

<script>

var currentView = 'datos';
function changeView(newView) {
    document.getElementById(currentView).style.display='none';
    document.getElementById(newView).style.display = '';
    currentView = newView;
    //alert(current_ID);
  }
</script>

<script type="text/javascript">
var vueltaActual = "0.5"; 
function cambioVuelta(){

	var selector = document.getElementById("distVuelta");
	var nuevaVuelta = selector.options[selector.selectedIndex].value;
	nuevaVuelta = nuevaVuelta.toString();
    //alert(nuevaVuelta);
    document.getElementById(vueltaActual).style.display='none';
	document.getElementById(nuevaVuelta).style.display = '';
	vueltaActual = nuevaVuelta;
}
</script>

</head>
<body>
	<br></br>
	<button type="button" onclick=changeView('datos')>Estadisticas</button>
	<button type="button" onclick=changeView('ritmo')>Ritmos</button>
	<div id="datos">
		<h3>Día de la actividad</h3>
		<?= $fechaActividad ?>
		<br></br>
		<h3>Tiempo total</h3>
		<?= $tiempoTranscurrido ?>
		<br></br>
		<h3>Tiempo en movimiento</h3>
		<?= $tiempoConPausa ?>
		<br></br>
		<h3>Distancia</h3>
		<?= $distanciaDesdeInicio; ?>
		<br></br>
		<h3>Distancia Con Pausa</h3>
		<?= $distConPausa; ?>
		<br></br>
		<h3>Velocidad media</h3>
		<?= $velocidadMedia; ?>
		<br></br>
		<h3>Velocidad media con Pausa</h3>
		<?= $velocidadMediaConPausa; ?>
		<br></br>
		<h3>Velocidad máxima</h3>
		<?= $velMax; ?>
		<br></br>
		<h3>Subida total</h3>
		<?= $elevacionTotal; ?>
		<br></br>
		<h3>Ritmo</h3>
		<?= $ritmo ?>
		<br></br>
		<h3>Ritmo con pausas</h3>
		<?= $ritmoConPausa ?>
		<br></br>
	</div>


	<div id="ritmo" style="display:none ">
		<br></br>

		Distancia de vuelta: 
		<select name="vuelta" id="distVuelta" onchange="cambioVuelta()">
		   <option value="0.5">0.5 KM</option> 
		   <option value="1">1 KM</option> 
		   <option value="2">2KM</option>
		   <option value="5">5 KM</option> 
		</select>
		<br></br>

		<table id="0.5">
		  <tr>
		    <th>Vuelta n°</th>
		    <th>Velocidad de vuelta</th>
		    <th>Ritmo de Vuelta</th>
		    <th>Duración de vuelta</th>
		    <th>Distancia</th>
		  </tr>
			  <?php foreach ($medioKm as $key => $value) {
				if($value[1] >= $max05){
				?>
			  	<tr style="background-color:#4db8ff">
				<?php
				}
				else{
				?>
			  	<tr>
				<?php
				}
				?>
			  	<td><?= $key+1; ?>
			  	<td><?= round($value[1], 2); ?>
			  	<td><?= $value[0]; ?>
			  	<td><?= $value[2]; ?>
			  	<td><?= round($value[3], 2); ?>
			  </tr>
			  <?php  }	?>
		</table>

		<table id="1" style="display:none">
		  <tr>
		    <th>Vuelta n°</th>
		    <th>Velocidad de vuelta</th>
		    <th>Ritmo de Vuelta</th>
		    <th>Duración de vuelta</th>
		    <th>Distancia</th>
		  </tr>
			  <?php foreach ($unKm as $key => $value) {
				if($value[1] >= $max1){
				?>
			  	<tr style="background-color:#4db8ff">
				<?php
				}
				else{
				?>
			  	<tr>
				<?php
				}
				?>
			  	<td><?= $key+1; ?>
			  	<td><?= round($value[1], 2); ?>
			  	<td><?= $value[0]; ?>
			  	<td><?= $value[2]; ?>
			  	<td><?= round($value[3], 2); ?>
			  </tr>
			  <?php  }	?>
		</table>

		<table id="2" style="display:none">
		  <tr>
		    <th>Vuelta n°</th>
		    <th>Velocidad de vuelta</th>
		    <th>Ritmo de Vuelta</th>
		    <th>Duración de vuelta</th>
		    <th>Distancia</th>
		  </tr>
			  <?php foreach ($dosKm as $key => $value) {
				if($value[1] >= $max2){
				?>
			  	<tr style="background-color:#4db8ff">
				<?php
				}
				else{
				?>
			  	<tr>
				<?php
				}
				?>
			  	<td><?= $key+1; ?>
			  	<td><?= round($value[1], 2); ?>
			  	<td><?= $value[0]; ?>
			  	<td><?= $value[2]; ?>
			  	<td><?= round($value[3], 2); ?>
			  </tr>
			  <?php  }	?>
		</table>

		<table id="5" style="display:none">
		  <tr>
		    <th>Vuelta n°</th>
		    <th>Velocidad de vuelta</th>
		    <th>Ritmo de Vuelta</th>
		    <th>Duración de vuelta</th>
		    <th>Distancia</th>
		  </tr>
			  <?php foreach ($cincoKm as $key => $value) {
				if($value[1] >= $max5){
				?>
			  	<tr style="background-color:#4db8ff">
				<?php
				}
				else{
				?>
			  	<tr>
				<?php
				}
				?>
			  	<td><?= $key+1; ?>
			  	<td><?= round($value[1], 2); ?>
			  	<td><?= $value[0]; ?>
			  	<td><?= $value[2]; ?>
			  	<td><?= round($value[3], 2); ?>
			  </tr>
			  <?php  }	?>
		</table>

		
	</div>

</body>
</html>
