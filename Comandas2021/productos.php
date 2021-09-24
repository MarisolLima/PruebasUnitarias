<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo']) && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo']))
  {
     // Obtiene los datos del usuario
     $codigo  = $_SESSION['codigo'];
     $usuario = $_SESSION['usuario'];
     $tipo    = $_SESSION['tipo'];    

     // Verifica que el tipo sea control
     if ($tipo != "control")
     {
        // Variables para el error
        $titulo      = "Error Acceso";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso";
     $descripcion = "Intento de Violación de Acceso";
     $enlace      = "index.php";

     // Lanzando Aplicación por Tipo
     header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Comandas</title>

  <!-- // Incluye bootstrap -->
  <?php include "bootstrap.html"; ?>

  <!-- // Incluimos las reglas de estilo de la aplicación--> 
  <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />

</head>
<body>

  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Comandas.Productos</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">
            Usuarios
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mesas.php">
            Mesas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="clases.php">
            Clases
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comentarios.php">
            Comentarios
          </a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="php/salida.php">Salida</a>
        </li>    
      </ul>
    </div>  
  </nav>
  <br>

  <div class="container">
    <table class="table table-striped table-light">
      <caption style="background-color: brown; caption-side: top">
        <a class="nav-link" href="productosABC.php?operacion=Alta">
          Producto Alta
        </a>  
      </caption>
      <thead class="thead-dark">
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php
         // Llamo a Función que obtiene los Productos
        $productos = fnGetDatos($conexion,"productos");         

         // Ciclo para procesar cada registro de usario
        while ($fila = $productos->fetch_assoc()) 
        {
          // Crea el Enlace para Cambio 
          $enlaceCambio  = "productosABC.php?operacion=Cambios";
          $enlaceCambio .= "&codigo=".$fila['codigo'];
          $enlaceCambio .= "&nombre=".$fila['nombre'];
          $enlaceCambio .= "&precio=".$fila['precio'];
          $enlaceCambio .= "&clase=".$fila['clase'];
          // Reemplaza los espacios en blanco
          $enlaceCambio = str_replace(" ", "%20", $enlaceCambio);

          // Crea el Enlace para la Baja
          $enlaceBaja  = "productosABC.php?operacion=Baja";
          $enlaceBaja .= "&codigo=".$fila['codigo'];
          $enlaceBaja .= "&nombre=".$fila['nombre'];
          $enlaceBaja .= "&precio=".$fila['precio'];
          $enlaceBaja .= "&clase=".$fila['clase'];
          // Reemplaza los espacios en blanco
          $enlaceBaja = str_replace(" ", "%20", $enlaceBaja);

          // Crea el Row
          echo "<tr>";

          // Crea las Celdas con los datos
          echo "<td>".$fila['codigo']."</td>";
          echo "<td>".$fila['nombre']."</td>";
          echo "<td>".$fila['precio']."</td>";
          echo "<td>";
          echo "<a href=$enlaceCambio><img src='img/edit.png'></a>";
          echo "<a href=$enlaceBaja><img src='img/del.png'></a>";
          echo "</td>";

            // Cierra el Row
          echo '</tr>';
        }
        ?>    
      </tbody>    
    </table>    
  </div>
  <br><br>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
    <button type="button" class="btn btn-warning">
          <?php 
            echo strtoupper($usuario);      
          ?>
      </button>
      <button type="button" class="btn btn-outline-warning">
          <?php 
            echo strtoupper($tipo);      
          ?> 
      </button>
  </nav>
</body>
</html>