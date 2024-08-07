<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

if(!isset($_SESSION["csrf_token"])) {
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();

    $_SESSION["csrf_token"] = $token;
}

$route = null;


if (isset($_GET['route'])) {
    $route = $_GET['route'];
}

require "services/Routeur.php";

$routeur = new Routeur();

$routeur->handleRequest($route);

