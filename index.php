<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Base Datos Ciudades</title>
        <link href="estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
            require 'config.php'; /* Llama al fichero donde están las variables globales con la conexión definida. 
                                     Se puede incluir también con include. La diferencia es que con require si hay un
                                     error en la carga del fichero y no funcionaría, con include sí o sí seguiría la 
                                     ejecución de la app aunque no cargue el fichero, dando como resultado la no conexión
                                     a la base de datos.*/
            
            $link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD); /* Creación de la conexión haciendo uso de las variables locales del fichero config.php*/
            mysqli_select_db($link, $DB_NAME); /* Abre la base de datos "paises" */
            $link->query("SET NAMES 'utf8'"); /* Para que se muestren las tildes */
            $lista = mysqli_query($link, "SELECT * FROM `ciudades`"); /* Guarda el resultado de la consulta en la variable result. */
            $numfilas = mysqli_num_rows($lista);
            echo "La consulta a devuelto ".$numfilas." filas<br />";
            $filaspagina = 2;
            mysqli_data_seek($lista,0); /* Se posiciona en el primer registro del select almacenado en la variable result. */
            $sigue = TRUE;
            $n = 0;
            while ($sigue) {
                $ciudad= mysqli_fetch_array($lista);  /* Recorre la consulta y guarda en un array */
                if ($ciudad) {
                    echo "id: ".$ciudad ['id']."<br />";
                    echo "Ciudad: ".$ciudad ['ciudad']."<br />";
                    echo "País: ".$ciudad ['pais']."<br />";
                    echo "Habitantes: ".$ciudad ['habitantes']."<br />";
                    echo "Superficie: ".$ciudad ['superficie']."<br />";
                    echo "¿Tiene Metro?: ".$ciudad ['tieneMetro']."<br /><br />";
                    $n++;
                } else {
                    $sigue = FALSE;
                }
                if ($n == $filaspagina) {
                    echo "<hr>";
                    $n = 0;
                }
            }
            mysqli_free_result($lista);
            mysqli_close($link);
        ?>
    </body>
</html>