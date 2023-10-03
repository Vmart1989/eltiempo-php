<?php 
$titulo = "Previsión semanal AEMET";
include "header.php";
include "conexion.php";
?>

<body>
    <div class="container p-2 w-100">
        <?php
        ?>
        <h3 class="ms-4 mt-1"> <?php echo $xml->nombre; ?> </h3> <!-- nombre de provincia -->
        <small class="text-body-secondary ms-4">Previsión semanal</small>

        <form name="desplegable" id="desplegable" method="post">
            <div class='float-end me-4'>
                <select class="form-select" name="provincia" id="provincia" onchange="submitform()">
                    <option value="03014" selected>Capital de Provincia</option>
                    <option value="02003">Albacete</option>
                    <option value="03014">Alicante</option>
                    <option value="04013">Almería</option>
                    <option value="05019">Ávila</option>
                    <option value="06015">Badajoz</option>
                    <option value="08019">Barcelona</option>
                    <option value="48020">Bilbao</option>
                    <option value="09059">Burgos</option>
                    <option value="10037">Cáceres</option>
                    <option value="11012">Cádiz</option>
                    <option value="12040">Castellón de la Plana</option>
                    <option value="51001">Ceuta</option>
                    <option value="13034">Ciudad Real</option>
                    <option value="14021">Córdoba</option>
                    <option value="16078">Cuenca</option>
                    <option value="17079">Girona</option>
                    <option value="18087">Granada</option>
                    <option value="19130">Guadalajara</option>
                    <option value="21041">Huelva</option>
                    <option value="22125">Huesca</option>
                    <option value="23050">Jaén</option>
                    <option value="15030">A Coruña</option>
                    <option value="35016">Las Palmas de Gran Canaria</option>
                    <option value="24089">León</option>
                    <option value="25120">Lleida</option>
                    <option value="26089">Logroño</option>
                    <option value="27028">Lugo</option>
                    <option value="28079">Madrid</option>
                    <option value="29067">Málaga</option>
                    <option value="52001">Melilla</option>
                    <option value="30030">Murcia</option>
                    <option value="32054">Ourense</option>
                    <option value="33044">Oviedo</option>
                    <option value="34120">Palencia</option>
                    <option value="07040">Palma de Mallorca</option>
                    <option value="36038">Pontevedra</option>
                    <option value="37274">Salamanca</option>
                    <option value="20069">San Sebastián/Donostia</option>
                    <option value="38038">Santa Cruz de Tenerife</option>
                    <option value="39075">Santander</option>
                    <option value="40194">Segovia</option>
                    <option value="41091">Sevilla</option>
                    <option value="42173">Soria</option>
                    <option value="43148">Tarragona</option>
                    <option value="44216">Teruel</option>
                    <option value="45168">Toledo</option>
                    <option value="46250">Valencia</option>
                    <option value="47186">Valladolid</option>
                    <option value="01059">Vitoria</option>
                    <option value="49275">Zamora</option>
                    <option value="50297">Zaragoza</option>
                </select>
            </div>
        </form>

        <div class="container d-flex flex-wrap justify-content-evenly">
            <?php
            
            // recorro los 7 días disponibles en el XML
            for ($i = 0; $i < 7; $i++) {
                $fecha = $elemento->dia[$i]['fecha'];
                $num_dia = date("w", strtotime($fecha)); //devuelve el numero asignado al dia de la semana
                $hoy = date('n-j-Y'); // fecha de hoy en formato 7-6-2023 (sin ceros en dia y mes)
                $cielo = $elemento->dia[$i]->estado_cielo; //<estado_cielo periodo="00-24" descripcion="Cubierto con lluvia">26</estado_cielo>
                if ($cielo == "") { //si no hay datos en periodo 00-24, busco en las siguientes franjas horarias
                    $cielo = $cielo[2]; // franja horaria 12-24
                }
            ?>
                <div class="card m-2 border-white"> <!-- creo la tarjeta que contiene los datos -->
                    <div style="width: 8.3em;" <?php if ($hoy == date("n-j-Y", strtotime($fecha))) { ?> id="link_hoy" class="text-center card-body bg-primary-subtle border border-2 border-primary-subtle"><a  onmouseover="transformToday()" onmouseout="transformToday()" class="text-decoration-none text-dark " href="hoy.php?fecha=<?php echo $fecha ?>&poblacion=<?php echo $codigo_provincia ?>" <?php /* <-- si el dia coincide con hoy lo pinto diferente (borde)*/ } else { ?> class="text-center card-body bg-primary-subtle border border-2 border-white" > <?php } ?>
                    
            <!-- hoy.php?date=". $fecha . "&poblacion=". $fila['titulo'] . "'-->

                    <!-- guardo el nombre del dia segun su codigo date("w", strtotime($fecha))-->
                    <?php switch ($num_dia) { 
                        case 0:
                            $nombre_dia = "Domingo";
                            break;
                        case 1:
                            $nombre_dia = "Lunes";
                            break;
                        case 2:
                            $nombre_dia = "Martes";
                            break;
                        case 3:
                            $nombre_dia = "Miércoles";
                            break;
                        case 4:
                            $nombre_dia = "Jueves";
                            break;
                        case 5:
                            $nombre_dia = "Viernes";
                            break;
                        case 6:
                            $nombre_dia = "Sábado";
                            break;
                        default:
                            $nombre_dia = "";
                    } ?>

                    <!-- DIA Y FECHA -->
                    <h5> <?php echo $nombre_dia; ?> </h5>
                    <h6 class='mb-4'> <?php echo date("j-n-Y", strtotime($fecha)); ?> </h6>
                    <!-- MAXIMA Y MINIMA -->
                    <p><?php echo "<i class='bi bi-thermometer-high'></i>" . $elemento->dia[$i]->temperatura->maxima . "°C"; ?> </p>
                    <p><?php echo "<i class='bi bi-thermometer-low'></i>" . $elemento->dia[$i]->temperatura->minima . "°C"; ?> </p>

                    <?php
                    //ICONOS Y DESCRIPCION SEGUN EL CODIGO DE estado_cielo
                    
                    if ($cielo == 11) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Despejado"><i class="bi bi-sun" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == "") { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Sin datos"><i class="bi bi-question-octagon" style="font-size: 2rem;"></i> </div>
                    <?php  }

                    if ($cielo == 17) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Intervalos nubosos"><i class="bi bi-cloud-sun" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 12) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Principalmente despejado"><i class="bi bi-brightness-low" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 13 || $cielo == 14) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso"><i class="bi bi-clouds" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 15 || $cielo == 16) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso"><i class="bi bi-clouds-fill" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 43 || $cielo == 44) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con lluvia escasa"><i class="bi bi-cloud-drizzle" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 45 || $cielo == 46) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso con lluvia escasa"><i class="bi bi-cloud-drizzle-fill" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 26 || $cielo == 25) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso con lluvia"><i class="bi bi-cloud-rain-fill" style="font-size: 2rem;"></i> </div>
                    <?php }

                    if ($cielo == 23 || $cielo == 24) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con lluvia"><i class="bi bi-cloud-rain" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 71 || $cielo == 72) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con nieve escasa"><i class="bi bi-cloud-snow" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 73 || $cielo == 74) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso con nieve escasa"><i class="bi bi-cloud-snow-fill" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo > 32 && $cielo < 37) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con nieve"><i class="bi bi-snow" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 51 || $cielo == 52) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con tormenta"><i class="bi bi-cloud-lightning" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 53 || $cielo == 54) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso con tormenta"><i class="bi bi-cloud-lightning-fill" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 61 || $cielo == 62) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Nuboso con tormenta y lluvia escasa"><i class="bi bi-cloud-lightning-rain" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 63 || $cielo == 64) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Muy nuboso con tormenta y lluvia escasa"><i class="bi bi-cloud-lightning-rain-fill" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 81) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Niebla"><i class="bi bi-cloud-fog2" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 82) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Bruma"><i class="bi bi-text-center" style="font-size: 2rem;"></i> </div>

                    <?php }

                    if ($cielo == 83) { ?>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Calima"><i class="bi bi-cloud-haze2" style="font-size: 2rem;"></i> </div>


                    <?php  }
                    // PROBABILIDAD DE LLUVIA
                    if ($elemento->dia[$i]->prob_precipitacion > 0) { ?>
                        <div>
                            <p><i class="bi bi-umbrella" style="font-size: 1rem;"> </i><?php echo $elemento->dia[$i]->prob_precipitacion . "%"; ?> </p>
                        </div>

                    <?php  } ?>

                    </a></div>
                    </div>

            <?php   }

            ?>

</div>
        <div> <!-- FUENTE AEMET -->
            <p class="ms-4">
                <?php echo "Fuente: " . $xml->origen->productor; ?>
                <!-- ACTUALIZADO A LAS -->
                <span class="float-end me-4"><?php echo "Última actualización: " . date("g:i a", strtotime($xml->elaborado)) ?></span>
            </p>
        </div>

        <!-- BOOTSTRAP SCRIPT -->                
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

        <!-- ENABLE BS TOOLTIPS (DESCRIPCION DEL TIEMPO EN HOOVER)-->
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>

         <!-- MIS FUNCIONES JS -->  
        <script type="text/javascript">
            //ENVIAR FORMULARIO AL CAMBIAR PROVINCIA
            function submitform() {
                document.desplegable.submit();
            }

            //CAMBIAR ESTILO DE HOY en HOVER
            function transformToday(){
                
                if (document.getElementById("link_hoy").classList.contains("bg-primary-subtle")) {
                    document.getElementById("link_hoy").classList.replace("bg-primary-subtle", "bg-light")
                    document.getElementById("link_hoy").classList.add("shadow")
                    
                } else
                {
                    document.getElementById("link_hoy").classList.replace("bg-light", "bg-primary-subtle",)
                    document.getElementById("link_hoy").classList.remove("shadow")
                }
            }


        </script>



</body>

</html>