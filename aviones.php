<?php  

$host = "localhost";

$database = "aeropuerto";

$username = "root";

$password = "";

$conection = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$where="";

$tipo_avion = "";

$aerolinea = "";

$destino = "";


if (isset($_REQUEST["tipo_avion"])||isset($_REQUEST["aerolinea"])||isset($_REQUEST["destino"])) {
    
    $filtro = $_REQUEST["filtro"];
    

    if (isset($_REQUEST["tipo_avion"])) {
	
	    $tipo_avion=$_REQUEST["tipo_avion"];

        if ($tipo_avion != "") {
	    
	        $where="WHERE tipo_avion LIKE '%$tipo_avion%'";
	    }
    }

    if (isset($_REQUEST["aerolinea"])) {
	
	    $aerolinea=$_REQUEST["aerolinea"];

        if ($aerolinea != "") {

        	if ($where == "") {

        		$where="WHERE aerolinea='$aerolinea'";
        	}

        	else{

        		$where.=" $filtro aerolinea='$aerolinea'";
        	}
	    
	        
	    }
    }

    if (isset($_REQUEST["destino"])) {
	
	    $destino=$_REQUEST["destino"];

        if ($destino != "") {

        	if ($where == "") {

        		$where="WHERE destino='$destino'";
        	}

        	else{

        		$where.=" $filtro destino='$destino'";
        	}
	    
	        
	    }
    }

}

$consulta = $conection->prepare("SELECT tipo_avion, aerolinea, destino FROM aviones $where");


$consulta->execute();

$aviones = $consulta->fetchAll();



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte Aviones</title>
    <style>
    	table, th, td {border: 1px solid black;}
    </style>

</head>
<body>

    <form action="aviones.php" method="POST">
    	<label for="">
    		Tipo Avión
    	</label>

    	<select name="tipo_avion" id="">
    		<option value="">
    			Seleccionar tipo de avión
    	    </option>
    	    <option value="Boeing" <?php if($tipo_avion == "Boeing"){echo "selected";}   ?>>
    	    	Boeing
    	    </option>
    	    <option value="Airbus" <?php if($tipo_avion == "Airbus"){echo "selected";}   ?>>
    	    	Airbus
    	    </option>
    	</select>

        <br>

        <label for="">
    		Aerolinea Que Opera
    	</label>

    	<input type="text" name="aerolinea" value="<?php echo $aerolinea; ?>">
        
        <br>

        <label for="">
    		Destino
    	</label>

    	<input type="text" name="destino" value="<?php echo $destino; ?>">
         
        <br>

    	<button type="submit" name="filtro" value="AND">
    		Filtrar Todo
    	</button>

    	<button type="submit" name="filtro" value="OR">
    		Filtrar Cualquiera
    	</button>


    </form>

	<table>
		<thead> 
			<th>
				Tipo de Avión 
		    </th> 
				
			<th>
				Aerolinea que Opera
			</th>

			<th>
				Destino del Vuelo
			</th> 
	    </thead>

	    <tbody>
	    	
           <?php
            for ($i=0; $i < count($aviones); $i++) { 
           ?>
           <tr>
           	<td>
           		
           		<?php 
            		
            		echo $aviones[$i]["tipo_avion"];
           		?>


           	</td>
           	<td>
           		<?php 
            		
            		echo $aviones[$i]["aerolinea"];
           		?>
           	</td>
           	<td>
           		<?php 
            		
            		echo $aviones[$i]["destino"];
           		?>
           	</td>
           		
           </tr>
           <?php 
              
              }
            ?>

	    </tbody>
 



	</table>
		
</body>
</html>