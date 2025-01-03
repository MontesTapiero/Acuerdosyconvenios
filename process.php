<?php
$conexion = new mysqli('localhost', 'root', '', 'sisg');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$ano = $_POST['ano'];
$mes = $_POST['mes'];
$tipo = $_POST['tipo'];
$nombre_acuerdo = $_POST['nombre_acuerdo'];
$entidad = $_POST['entidad'];
$departamento = $_POST['departamento'];
$municipio = $_POST['municipio'];
$representante_legal_entidad = $_POST['representante_legal_entidad'];
$ident_rep_entidad = $_POST['ident_rep_entidad'];
$cargo_ent = $_POST['cargo_ent'];
$representante_legal_snr = $_POST['representante_legal_snr'];
$Ident_rep_snr = $_POST['Ident_rep_snr'];
$cargo_snr = $_POST['cargo_snr'];

$supervisor_contrato = $_POST['supervisor_contrato'];
$ident_supervisor = $_POST['ident_supervisor'];
$cargo_supervisor = $_POST['cargo_supervisor'];

$con_cuantia = $_POST['con_cuantia'];
$aplicativos = $_POST['aplicativos'];
$usuarios_contrasenas = $_POST['usuarios_contrasenas'];
$plazo_ejecucion = $_POST['plazo_ejecucion'];
$estado = $_POST['estado'];
$numero_convenio = $_POST['numero_convenio'];
$fecha_inicio_convenio = $_POST['fecha_inicio_convenio'];

$observ_seguim_respon = $_POST['observ_seguim_respon'];

$sql = "INSERT INTO matriz_contrato (ano, mes, tipo, nombre_acuerdo, entidad, departamento, municipio, representante_legal_entidad, ident_rep_entidad, cargo_ent, representante_legal_snr, 
ident_rep_snr, cargo_snr, supervisor_contrato, ident_supervisor, cargo_supervisor, con_cuantia, aplicativos, usuarios_contrasenas, plazo_ejecucion, estado, numero_convenio, fecha_inicio_convenio, observ_seguim_respon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

$stmt->bind_param('ssssssssssssssssssssssss', $ano, $mes, $tipo, $nombre_acuerdo, $entidad, $departamento, $municipio, $representante_legal_entidad, $ident_rep_entidad, $cargo_ent, $representante_legal_snr, 
$Ident_rep_snr, $cargo_snr, $supervisor_contrato, $ident_supervisor, $cargo_supervisor, $con_cuantia, $aplicativos, $usuarios_contrasenas, $plazo_ejecucion, $estado, $numero_convenio, $fecha_inicio_convenio, $observ_seguim_respon);


if ($stmt->execute()) {
    echo "Datos guardados exitosamente.       <a href='matriz.html'>Ingresar datos de otro Contrato</a>.     <a href='relacion_contratos.php'>Relación</a>";
} else {
    echo "Error al guardar los datos: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>
