<?php
$db_host = "bqdx9f4zjgvi2vjhdppn-mysql.services.clever-cloud.com";
$db_user = "uxcfmdtu9pfuaycp";
$db_password = "LD6MD8Pyq5HFMV2FSHVI";
$db_name = "bqdx9f4zjgvi2vjhdppn";
$db_table_name = "users_accounts";

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// Verificar la conexión
if ($db_connection->connect_error) {
    die('No se ha podido conectar a la base de datos: ' . $db_connection->connect_error);
}

// Obtiene los datos de forma segura
$subs_name = $db_connection->real_escape_string($_POST['nombre']);
$subs_last = $db_connection->real_escape_string($_POST['apellido']);
$subs_email = $db_connection->real_escape_string($_POST['email']);

// Consulta
$resultado = $db_connection->query("SELECT * FROM `$db_table_name` WHERE `email` = '$subs_email'");

// Si obtiene almenos una coincidencia
if ($resultado->num_rows > 0) {
    header('Location: Fail.html');
    exit();
} else { // Si no
    // Consulta para insertar
    $insert_value = $db_connection->prepare("INSERT INTO `$db_table_name` (`username`, `last_name`, `email`) VALUES (?, ?, ?)");
    // Pasa los datos del formulario como parametros de la consulta
    $insert_value->bind_param('sss', $subs_name, $subs_last, $subs_email);
    
    // Si lo ejecuta correctamente
    if ($insert_value->execute()) {
        header('Location: Success.html');
    } else {
        // manda error
        die('Error: ' . $db_connection->error);
    }
    
    $insert_value->close();
}

$db_connection->close();

?>
