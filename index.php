<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = null;


if (isset($_GET['route'])) {
    $route = $_GET['route'];
}

require "services/Routeur.php";

$routeur = new Routeur();

$routeur->handleRequest($route);

