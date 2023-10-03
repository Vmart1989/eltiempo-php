<?php
$titulo = "Detalles HOY";
include "header.php";
include "conexion.php";


$codigo_provincia = $_GET['poblacion'];
$xml = simplexml_load_file("https://www.aemet.es/xml/municipios/localidad_$codigo_provincia.xml");
foreach ($xml as $elemento) {
}; //recorrer xml
$hoy = $_GET['fecha'];
$num_dia = date("w", strtotime($_GET['fecha']));
$nombre_dia = nombreDia($num_dia);
$cielo = $elemento->dia->estado_cielo;
$icono_cielo = iconoCielo($cielo);

$time = date('H:i:s', time());
$hour = date('H', time());

//ajusto el icono segun la hora actual:
    if ($hour <= 6) {
        $cielo = $cielo[3];
    }
    if ($hour > 6 && $hour <= 12) {
        $cielo = $cielo[4];
    }

    if ($hour > 12 && $hour <= 18) {
        $cielo = $cielo[5];
    }

    if ($hour > 18 && $hour <= 23) {
        $cielo = $cielo[6];
    }

// FUNCIONES
function nombreDia($num_dia)
{ //devuelve el nombre del dia basado en el numero que devuelve la funcion date("w", strtotime)
    $num_dia = date("w", strtotime($_GET['fecha']));
    switch ($num_dia) {
        case 0:
            $resultado = "Domingo";
            break;
        case 1:
            $resultado = "Lunes";
            break;
        case 2:
            $resultado = "Martes";
            break;
        case 3:
            $resultado = "Miércoles";
            break;
        case 4:
            $resultado = "Jueves";
            break;
        case 5:
            $resultado = "Viernes";
            break;
        case 6:
            $resultado = "Sábado";
            break;
        default:
            $resultado = "";
    }
    return $resultado;
}

function iconoCielo($cielo)
{//devuelve el icono del tiempo segun el codigo que trae el XML
    switch ($cielo) {
        case "":
            $cielo = $cielo[2];
            
        case 11:
            $icono = "bi bi-sun";
            break;
        case 12:
            $icono = "bi bi-brightness-low";
            break;
        case 13:
        case 14:
            $icono = "bi bi-clouds";
            break;
        case 17:
            $icono = "bi bi-cloud-sun";
            break;
        case 15:
        case 16:
            $icono = "bi bi-clouds-fill";
            break;
        case 23:
        case 24:
            $icono = "bi bi-cloud-rain";
            break;
        case 25:
        case 26:
            $icono = "bi bi-cloud-rain-fill";
            break;
        case 32:
        case 37:
            $icono = "bi bi-snow";
            break;
        case 43:
        case 44:
            $icono = "bi bi-cloud-drizzle";
            break;
        case 45:
        case 46:
            $icono = "bi bi-cloud-drizzle-fill";
            break;
        case 51:
        case 52:
            $icono = "bi bi-cloud-lightning";
            break;
        case 53:
        case 54:
            $icono = "bi bi-cloud-lightning-fill";
            break;
        case 61:
        case 62:
            $icono = "bi bi-cloud-lightning-rain";
            break;
        case 63:
        case 64:
            $icono = "bi bi-cloud-lightning-rain-fill";
            break;
        case 71:
        case 72:
            $icono = "bi bi-cloud-snow";
            break;
        case 73:
        case 74:
            $icono = "bi bi-cloud-snow-fill";
            break;
        case 81:
            $icono = "bi bi-cloud-fog2";
            break;
        case 82:
            $icono = "bi bi-text-center";
            break;
        case 83:
            $icono = "bi bi-cloud-haze2";
            break;



        default:
            $icono = "bi bi-sun";
            break;
    }
    return $icono;
}


?>

<div class="container w-75  m-auto mt-2 ">
    <div class="card-body    mt-4">
        <h3 class="ms-2"><?php echo $xml->nombre; ?><span class="float-end me-4"><i class="<?php echo $icono_cielo ?>" style="font-size: 6rem;"></i></span></h3>
        <p class="ms-2"><?php echo $nombre_dia . " " . date('n-j-Y') ?></p>
        <a class="ms-2 p-2  border border-primary-subtle text-black text-decoration-none" href="index.php">Volver</a>
    </div>

    <div id="contenedor_detalles" class="container d-flex flex-wrap justify-content-between mt-4">



        <div class="m-2 p-3   bg-primary-subtle text-wrap " style="width: 12em;">
            <h5><i class="bi bi-cloud-sun" style="font-size: 2rem;"> </i>Estado del cielo</h5>
            <p class="">00-06h: <?php echo !empty($elemento->dia->estado_cielo[3]['descripcion']) ? $elemento->dia->estado_cielo[3]['descripcion'] : "No disponible" ?></p>
            <p>06-12h: <?php echo $elemento->dia->estado_cielo[4]['descripcion'] ?></p>
            <p>12-18h: <?php echo $elemento->dia->estado_cielo[5]['descripcion'] ?></p>
            <p>18-24h: <?php echo $elemento->dia->estado_cielo[6]['descripcion'] ?></p>

          

        </div>

        <div class="m-2 p-3   bg-primary-subtle text-wrap" style="width: 12em;">
            <h5><i class="bi bi-umbrella" style="font-size: 2rem;"> </i>Precipitación</h5>
            <p>00-06h: <?php echo !empty($elemento->dia->prob_precipitacion[3]) ? $elemento->dia->prob_precipitacion[3]: 0 ?>%</p>
            <p>06-12h: <?php echo $elemento->dia->prob_precipitacion[4] ?>%</p>
            <p>12-18h: <?php echo $elemento->dia->prob_precipitacion[5] ?>%</p>
            <p>18-24h: <?php echo $elemento->dia->prob_precipitacion[6] ?>%</p>

        </div>
        <div class="m-2 p-3   bg-primary-subtle text-wrap" style="width: 12em;">
            <h5><i class="bi bi-thermometer-half" style="font-size: 2rem;"> </i>Temperatura</h5>
            <p><?php echo "<i class='bi bi-thermometer-high'></i>" . $elemento->dia->temperatura->maxima . "°C"; ?> </p>
            <p><?php echo "<i class='bi bi-thermometer-low'></i>" . $elemento->dia->temperatura->minima . "°C"; ?> </p>
            <p>06h: <?php echo $elemento->dia->temperatura->dato[0] ?>°C</p>
            <p>12h: <?php echo $elemento->dia->temperatura->dato[1] ?>°C</p>
            <p>18h: <?php echo $elemento->dia->temperatura->dato[2] ?>°C</p>
            <p>24h: <?php echo $elemento->dia->temperatura->dato[3] ?>°C</p>

        </div>


        <div class="m-2 p-3   bg-primary-subtle text-wrap" style="width: 12em;">
            <h5><i class="bi bi-moisture" style="font-size: 2rem;"> </i>Humedad relativa</h5>
            <p>Máxima: <?php echo $elemento->dia->humedad_relativa->maxima . "%"; ?> </p>
            <p>Mínima: <?php echo $elemento->dia->humedad_relativa->minima . "%"; ?> </p>
            <p>06h: <?php echo $elemento->dia->humedad_relativa->dato[0] ?>%</p>
            <p>12h: <?php echo $elemento->dia->humedad_relativa->dato[1] ?>%</p>
            <p>18h: <?php echo $elemento->dia->humedad_relativa->dato[2] ?>%</p>
            <p>24h: <?php echo $elemento->dia->humedad_relativa->dato[3] ?>%</p>

        </div>



    </div>

</div>

</div>