<?php //ver_directorio_v1.php
ini_set("display_errors", 1);
error_reporting(15);

$ruta = "/Applications/MAMP/htdocs/toolbox/";

function ver_directorio($ruta=""){
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
		}//fin while
	}else{
		print "No se puede abrir el directorio <b>$dir</b>";
	}//fin if else


}//fin funcion ver_directorio

ver_directorio($ruta);

?>