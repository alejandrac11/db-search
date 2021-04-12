<?php  

$host = "localhost";

$database = "aeropuerto";

$username = "root";

$password = "";

$conection = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$where="";

$nacionalidad = "";

$destino_final = "";

$num_vuelo = "";


if (isset($_REQUEST["nacionalidad"])||isset($_REQUEST["destino_final"])||isset($_REQUEST["num_vuelo"])) {
    
    $filtro = $_REQUEST["filtro"];

    if (isset($_REQUEST["nacionalidad"])) {
	
	    $nacionalidad=$_REQUEST["nacionalidad"];

        if ($nacionalidad != "") {
	    
	        $where="WHERE nacionalidad = '$nacionalidad'";
	    }
    }

    if (isset($_REQUEST["destino_final"])) {
	
	    $destino_final=$_REQUEST["destino_final"];

        if ($destino_final != "") {

        	if ($where == "") {

        		$where="WHERE destino_final='$destino_final'";
        	}

        	else{


        		$where.=" $filtro destino_final='$destino_final'";
        	}
	    
	        
	    }
    }

    if (isset($_REQUEST["num_vuelo"])) {
	
	    $num_vuelo=$_REQUEST["num_vuelo"];

        if ($num_vuelo != "") {

        	if ($where == "") {

        		$where="WHERE num_vuelo='$num_vuelo'";
        	}

        	else{

        		$where.=" $filtro num_vuelo='$num_vuelo'";
        	}
	    
	        
	    }
    }

}

$consulta = $conection->prepare("SELECT nombre, nacionalidad, destino_final, num_vuelo FROM pasajeros INNER JOIN vuelos ON pasajeros.vuelo_id = vuelos.id $where");


$consulta->execute();

$pasajeros = $consulta->fetchAll();



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte Pasajeros</title>
    <style>
    	table, th, td {border: 1px solid black;}
    </style>

</head>
<body>

    <form action="pasajeros.php" method="POST">
    	<label for="">
    		Nacionalidad
    	</label>

    	<select name="nacionalidad" id="">
    		<option value="">
    			Seleccionar Nacionalidad
    	    </option>
    	    <option value="Colombian" <?php if($nacionalidad == "Colombian"){echo "selected";}   ?>>
    	    	Colombian
    	    </option>
    	    <option value="Turkish" <?php if($nacionalidad == "Turkish"){echo "selected";}   ?>>
    	    	Turkish
    	    </option>
          <option value="Mexican" <?php if($nacionalidad == "Mexican"){echo "selected";}   ?>>
            Mexican
          </option>
          <option value="Brazilian" <?php if($nacionalidad == "Brazilian"){echo "selected";}   ?>>
            Brazilian
          </option>
          <option value="Canadian" <?php if($nacionalidad == "Canadian"){echo "selected";}   ?>>
            Canadian
          </option>



    	</select>

        <br>

        <label for="">
    		Destino final del vuelo 
    	</label>

    	<input type="text" name="destino_final" value="<?php echo $destino_final; ?>">
        
        <br>

        <label for="">
    		Numero del vuelo
    	</label>

    	<input type="text" name="num_vuelo" value="<?php echo $num_vuelo; ?>">
         
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
				Nombre del Pasajero 
		    </th> 
				
			<th>
				Nacionalidad del Pasajero
			</th>

			<th>
				Destino final del vuelo
			</th> 
      <th>
        Numero del vuelo
      </th>
	    </thead>

	    <tbody>
	    	
           <?php
            for ($i=0; $i < count($pasajeros); $i++) { 
           ?>
           <tr>
           	<td>
           		
           		<?php 
            		
            		echo $pasajeros[$i]["nombre"];
           		?>


           	</td>
           	<td>
           		<?php 
            		
            		echo $pasajeros[$i]["nacionalidad"];
           		?>
           	</td>
           	<td>
           		<?php 
            		
            		echo $pasajeros[$i]["destino_final"];
           		?>
           	</td>
              <td>
              <?php 
                
                echo $pasajeros[$i]["num_vuelo"];
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