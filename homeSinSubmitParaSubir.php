<?php 
/*

ESTE SOLO TOMA EL SUBMIT SI SE USA UN ARCHIVO YA SUBIDO
SI SE QUIERE SUBIR UNO NUEVO, NO HACE FALTA APRETAR EL LBOTÓN

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

</script>

</head>

<body>

	<form action="upload.php" onsubmit="return checkFile();" id="form" method="post" enctype="multipart/form-data">

	    Seleccione el archivo GPX 	<br><br />
	    <input type="file" name="fileToUpload" id="fileToUpload" onchange="javascript:this.form.submit();">
	    <br></br>
	</form>
	
	<form action="upload.php" id="form" method="post" enctype="multipart/form-data">
		O elija un archivo ya subido
	    <ul>
		<?php 
			$directorio = opendir("uploads/");
			while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
			{
			    if (!is_dir($archivo) and substr($archivo, -3, 3)=="gpx")//verificamos si es o no un directorio
			    {
			    	?>
			    	<input type="radio" name="fileToUpload" id="nombre_archivo" value =<?=$archivo;?> checked>
			    	<?php
			        echo $archivo . "<br />";
			    }
			}
		?>
		</ul>

	    <input type="submit" value="Upload File" name="submit">
	</form>

</body>
</html>

