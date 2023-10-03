<?php
//al cargar la pagina, la provincia por defecto es Alicante(03014)
$codigo_provincia = isset($_POST['provincia']) ? $_POST['provincia'] : "03014";

//cargo archivo XML de AEMET
$xml = simplexml_load_file("https://www.aemet.es/xml/municipios/localidad_$codigo_provincia.xml");
// recorro cada elemento del XML y lo guardo en $elemento
            foreach ($xml as $elemento) {
            };

?>