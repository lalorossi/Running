<?php 

/*

PARA SUBIR UN ARCHIVO AUTOMATICAMENTE, SOLO APRETA EL BOTON DE SUBMIT
CUANDO CAMBIA EL INPUT DE ARCHIVO

*/


  //Vaciar arrays usados
  unset($xml);
  unset($elevaciones);
  unset($distancias);
  unset($velocidades);


 ?>
<html>
<head>
<title></title>

<script type="text/javascript">

var op = 1;

function checkFile(){
	var fileName = document.getElementById("fileToUpload").value;
	var l = fileName.length-3;
	
	if(document.getElementById("subir").checked == true){

		var ext = fileName.substring(l, l+3)
		if(ext != 'gpx'){
			op = 1;
			document.getElementById("fileToUpload").style="background-color:red";
			//document.getElementById("fileToUpload").style="opacity:0.5";
			//setTimeout(changeColor, 1000);
			var fade = setInterval(changeOpacity, 10);
			if(op <= 0){
				clearTimeout(fade);
			}

			window.alert("Solo se permiten archivos del tipo GPX ");
			return false;
		}else{
			document.getElementById("fileToUpload").style="background-color:blue";
			return true;
		}

	}

}

function changeColor(){
	document.getElementById("fileToUpload").style="background-color:transparent";
}

function changeOpacity(){
	document.getElementById("fileToUpload").style='background-color:rgba(255,0,0, '+op+')';
		op = op - (0.01);
	if(op <= 0){
		op=0;
	}
}

function cambio(actual){
	var boton = document.getElementsByName("fileToUpload");
	if(actual=="elegir"){
		boton[1].checked=true;
	}if(actual=="subir"){
		for(x = 1; x < boton.length; x++){
			boton[x].checked = false;
		}
	}if(actual=="arch"){
		document.getElementById('elegir').checked = true;
		document.getElementById('subir').checked = false;
	}
}

</script>

</head>

<body>

	<form action="upload.php" onsubmit="return checkFile();" id="form" method="post" enctype="multipart/form-data">

		<input type="radio" name="metodo" value="subir" id="subir" onclick="cambio('subir')" checked> 
	    Seleccione el archivo GPX 	<br><br />
	    <input type="file" name="fileToUpload" id="fileToUpload" onchange="document.getElementById('botonSubmit').click();">
	    <br></br>
	    
  		<input type="radio" name="metodo" value="elgir" id="elegir" onclick="cambio('elegir')">
		O elija un archivo ya subido
	    <ul>
			<?php 
				$directorio = opendir("uploads/");
				while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
				{
				    if (!is_dir($archivo) and substr($archivo, -3, 3)=="gpx")//verificamos si es o no un directorio
				    {
				    	?>
				    	<input type="radio" name="fileToUpload" id="nombre_archivo" value =<?=$archivo;?> onclick="cambio('arch')">
				    	<?php
				        echo $archivo . "<br />";
				    }
				}
			?>
		</ul>

	    <input type="submit" id="botonSubmit" value="Upload File" name="submit">

	</form>
</body>
</html>

