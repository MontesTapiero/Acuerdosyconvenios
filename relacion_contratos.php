<?php
include('db.php'); 
include('includes/header3.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Relación Proyectos</title>
  <!-- <link rel="stylesheet" href="/sisgprod/css/styles.css"> -->
    <link rel="icon" href="logo.jpg" type="image/x-icon">

    <!-- Incluye Bootstrap y jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
   
    <!-- Campo de entrada para el filtro -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar en la tabla...">

<?php
// Ejecutar la consulta SQL
$sql = "SELECT a.*, b.nombre_departamento, c.nombre_municipio, DATE_ADD(a.fecha_inicio_convenio, INTERVAL a.plazo_ejecucion YEAR) AS fecha_finalizacion, 
DATEDIFF(DATE_ADD(a.fecha_inicio_convenio, INTERVAL a.plazo_ejecucion YEAR), CURRENT_DATE) AS 'para_vencer'
FROM matriz_contrato a INNER JOIN departamento b ON a.departamento = b.id_departamento INNER JOIN municipio  c ON c.id_municipio=a.municipio ORDER BY a.fecha_registro DESC ";

$resultado = $conn->query($sql);

echo "<table border='1' id='myTable' class='table table-bordered table-striped'>";  // añade id
echo   "<tr>
            <th>AÑO</th>
            <th>MES</th>
            <th>TIPO</th>
            <th>NOMBRE ACUERDO</th>
            <th>ENTIDAD</th>
            <th>DEPARTAMENTO</th>
            <th>MUNICIPIO</th>
            <th>REP ENTID</th>
            <th>CEDULA REP ENT</th>
            <th>CARGO ENTIDAD</th>
            <th>REP SNR</th>
            <th>CEDULA SNR</th>
            <th>CARGO SNR</th>
            <th>SUPERVISOR</th>
            <th>CEDULA SUPERVISOR</th>
            <th>CARGO SUPERVISOR</th>
            <th>CUANTIA</th>
            <th>APLICATIVOS</th>
            <th>USUARIOS</th>
            <th>PLAZO EJECUCION EN AÑOS</th>
            <th>ESTADO</th>
            <th>NUMERO CONVENIO</th>
            <th>FECHA INICIO CONVENIO</th>
            <th>FECHA FIN</th>
            <th>DIAS RESTANTES</th>
            <th>OBSERVACIONES</th>
            <th>NOVEDADES</th>
            <th>DOCUMENTOS</th>
            <th>ACCIONES</th>
        </tr>";

while($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila['ano'] . "</td>";
    echo "<td>" . $fila['mes'] . "</td>";
    echo "<td>" . $fila['tipo'] . "</td>";
    echo "<td>" . $fila['nombre_acuerdo'] . "</td>";
    echo "<td>" . $fila['entidad'] . "</td>";  
    echo "<td>" . strtoupper(htmlspecialchars($fila['nombre_departamento'], ENT_QUOTES, 'UTF-8')) . "</td>";
    echo "<td>" . strtoupper(htmlspecialchars($fila['nombre_municipio'], ENT_QUOTES, 'UTF-8')) . "</td>";
    echo "<td>" . strtoupper(htmlspecialchars($fila['representante_legal_entidad'], ENT_QUOTES, 'UTF-8')) . "</td>";
    echo "<td>" . $fila['ident_rep_entidad'] . "</td>";
    echo "<td>" . $fila['cargo_ent'] . "</td>";
    echo "<td>" . strtoupper(htmlspecialchars($fila['representante_legal_snr'], ENT_QUOTES, 'UTF-8')) . "</td>";
    echo "<td>" . $fila['ident_rep_snr'] . "</td>";
    echo "<td>" . $fila['cargo_snr'] . "</td>";

    echo "<td>" . $fila['supervisor_contrato'] . "</td>";
    echo "<td>" . $fila['ident_supervisor'] . "</td>";
    echo "<td>" . $fila['cargo_supervisor'] . "</td>";
    
    echo "<td>" . $fila['con_cuantia'] . "</td>";
    echo "<td>" . $fila['aplicativos'] . "</td>";
    
    
    echo "<td>
    <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#usuarios_contrasenasModal{$fila['id_matriz']}'>
        <i class='fas fa-users'></i>
    </button>
  </td>";

    echo "<td>" . $fila['plazo_ejecucion'] . "</td>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>" . $fila['numero_convenio'] . "</td>";
    echo "<td>" . $fila['fecha_inicio_convenio'] . "</td>";
    echo "<td>" . $fila['fecha_finalizacion'] . "</td>";
    echo "<td>" . $fila['para_vencer'] . "</td>";
    echo "<td>" . $fila['observ_seguim_respon'] . "</td>";
    
    // Botones modales novedades y documentos
    echo "<td>
            <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#novedadesModal{$fila['id_matriz']}'>
                <i class='fas fa-eye'></i>
            </button>
          </td>";

    echo "<td>
            <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#documentosModal{$fila['id_matriz']}'>
                <i class='fas fa-folder-open'></i>
            </button>
          </td>";  

    echo "<td>
    <a href='edit_matriz.php?id_matriz=".$fila['id_matriz']."'>Editar</a>
    <a href='edit_matriz_novedad.php?id_matriz=".$fila['id_matriz']."'>Novedades</a>
    <a href='delete_matriz.php?id_matriz=".$fila['id_matriz']."'
       onclick=\"return confirm('¿Estás seguro de que deseas eliminar este registro?');\">
       Borrar
    </a>            
  </td>";

     // Modal para Usuarios
     echo "<div class='modal fade' id='usuarios_contrasenasModal{$fila['id_matriz']}' tabindex='-1' aria-labelledby='usuarios_contrasenasModalLabel{$fila['id_matriz']}' aria-hidden='true'>
     <div class='modal-dialog'>
         <div class='modal-content'>
             <div class='modal-header'>
                 <h5 class='modal-title' id='usuarios_contrasenasModalLabel{$fila['id_matriz']}'>Usuarios para el Acuerdo " . htmlspecialchars($fila['nombre_acuerdo']) . "</h5>
                 <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
             </div>
             <div class='modal-body'>
                 " . nl2br(htmlspecialchars($fila['usuarios_contrasenas'])) . "
             </div>
             <div class='modal-footer'>
                 <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
             </div>
         </div>
     </div>
     </div>";


    // Modal para Novedades
    echo "<div class='modal fade' id='novedadesModal{$fila['id_matriz']}' tabindex='-1' aria-labelledby='novedadesModalLabel{$fila['id_matriz']}' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='novedadesModalLabel{$fila['id_matriz']}'>Novedades para el Acuerdo " . htmlspecialchars($fila['nombre_acuerdo']) . "</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                " . nl2br(htmlspecialchars($fila['novedades'])) . "
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
            </div>
        </div>
    </div>
    </div>";

     // Modal para Documentos
     echo "<div class='modal fade' id='documentosModal{$fila['id_matriz']}' tabindex='-1' aria-labelledby='documentosModalLabel{$fila['id_matriz']}' aria-hidden='true'>
     <div class='modal-dialog'>
         <div class='modal-content'>
             <div class='modal-header'>
                 <h5 class='modal-title' id='documentosModalLabel{$fila['id_matriz']}'>Documentos para el Acuerdo " . htmlspecialchars($fila['nombre_acuerdo']) . "</h5>
                 <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
             </div>
             <div class='modal-body'>";

 // Mostrar los documentos en el modal
 $documentos = explode(',', $fila['documentos']);
 foreach($documentos as $doc) {
     echo "<a href='upload/$doc' target='_blank'>$doc</a><br>";
 }

 echo "</div>
             <div class='modal-footer'>
                 <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
             </div>
         </div>
     </div>
 </div>";
}

echo "</table><br><br>";
?>

</div>

<!-- Código JavaScript para la funcionalidad de búsqueda -->
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>



</body>
</html>
