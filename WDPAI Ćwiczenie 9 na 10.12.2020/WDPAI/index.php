<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/'); /*POZBYWAM SIE SLESZA I OTWARZAM SCIEZKE ODWOLUJAC SIE DO FUNKCJI SERWERA */
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController'); /*jeżeli nie mamy podanej zadnej ścieżki to odtwarzamy metode defaultcontroller*/
Router::get('projects', 'DefaultController'); /*scieżka do naszej apliakcji dzieki niej otwieram ścieżkeproject z klasy defaultcontroller*/
Router::post('login', 'SecurityController');
Router::post('addProject', 'ProjectController');
Router::run($path); /*$path - argument*/

