<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Booking Fincas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #7BA841;">
  <div class="container">
    <!-- Logo + Nombre -->
    <a class="navbar-brand d-flex align-items-center" href="?accion=home">
      <img src="/fincas/public/img/logo.png" alt="Logo" width="40" height="40" class="me-3">
      <strong>BOOKING FINCAS</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="?accion=home">Inicio</a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href="?accion=alquiler">Fincas en Alquiler</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?accion=eventos">Fincas por Destino</a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>
