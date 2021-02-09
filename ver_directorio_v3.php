<?php //ver_directorio_v3.php
ini_set("display_errors", 1);
error_reporting(15);

//$ruta = "/Applications/MAMP/htdocs/toolbox/";
//$ruta = "/";
$ruta = "/Applications/MAMP/htdocs/";

$mysqli = new Mysqli("localhost", "root", "root", "espacio_dir");

define("limite_nivel_recursion", 10);

function ver_directorio($cnx, $ruta="", $nivel=0, $id_padre=0){
	print "Ruta: $ruta";

	$dir=null;
	$dir = opendir($ruta);
	if($dir){
		$directorios = array();
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

			//añadimos tiempo
			set_time_limit(10);

			print "<br>$entrada - ";
			if(is_dir($ruta."/".$entrada)){
				//es un directorio
				print "DIR";

				$_ruta = $ruta.$entrada."/";

				$ahora = date("Y-m-d H:i:s");

				//Si es directorio, lo grabo en la tabla directorios
				$sql_dir=<<<fin
					INSERT INTO directorios SET 
					id_padre = '$id_padre',
					directorio = '$entrada',
					ruta = '$_ruta',
					alta = '$ahora',
					dirs = '0',
					fichs = '0'
fin;

				$cnx->query($sql_dir);
				if(!$cnx->error){
					$id = $cnx->insert_id;
				}

				//ahora exploramos esta carpeta recursivamente
				$n = $nivel + 1;
				//if($n > constant("limite_nivel_recursion")){
				if($n > limite_nivel_recursion){
					return(false);
				}
				//ver_directorio($cnx, $_ruta, $n, $id);
				$directorios[] = $entrada;

			}else{
				$ficheros[] = $entrada;
			}
		}//fin while


		//ahora recorremos los ficheros y directorios
		foreach($directorios as $entrada){
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

			//añadimos tiempo
			set_time_limit(10);

			print "<br>$entrada - ";
			if(is_dir($ruta."/".$entrada)){
				//es un directorio
				print "DIR";

				$_ruta = $ruta.$entrada."/";

				$ahora = date("Y-m-d H:i:s");

				//Si es directorio, lo grabo en la tabla directorios
				$sql_dir=<<<fin
					INSERT INTO directorios SET 
					id_padre = '$id_padre',
					directorio = '$entrada',
					ruta = '$_ruta',
					alta = '$ahora',
					dirs = '0',
					fichs = '0'
fin;

				$cnx->query($sql_dir);
				if(!$cnx->error){
					$id = $cnx->insert_id;
				}

				//ahora exploramos esta carpeta recursivamente
				$n = $nivel + 1;
				//if($n > constant("limite_nivel_recursion")){
				if($n > limite_nivel_recursion){
					return(false);
				}
				ver_directorio($cnx, $_ruta, $n, $id);

			}else{
				print "NO DIR";
			}
		}//fin while



	}else{
		print "No se puede abrir el directorio <b>$dir</b>";
	}//fin if else


}//fin funcion ver_directorio

$nivel=0;
$id_padre=0;
ver_directorio($mysqli, $ruta, $nivel, $id_padre);



?>