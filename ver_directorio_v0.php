<?php //ver_directorio.php
ini_set("display_errors", 1);
error_reporting(15);

$ruta = "/Applications/MAMP/htdocs/toolbox/";
print "Ruta: $ruta";


$dir=null;
$dir = opendir($ruta);
if($dir){
	while($entrada = readdir($dir)){
		//nos saltamos los . y ..
		if($entrada == "."){
			//print ".";
			continue;
		}
		if($entrada == ".."){
			//print "..";
			continue;
		}
		if($entrada == ".DS_Store"){
			//print "..";
			continue;
		}


		print "<br>$entrada - ";
		if(is_dir($ruta.$entrada)){
			//es un directorio
			print "DIR";
		}else{
			print "NO DIR";
		}
	}
}else{
	print "No se puede abrir el directorio <b>$dir</b>";
}





?>