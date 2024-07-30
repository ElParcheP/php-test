<?php
$db_host = "bg9aejjbuzhd0npgy9zm-mysql.services.clever-cloud.com";
$db_user = "uualobldg7scrr76";
$db_password = "IjBUKL9nDKq91N9cSoRG";
$db_name = "bg9aejjbuzhd0npgy9zm";
$db_table_name = "users_accounts";

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// Verificar la conexión
if ($db_connection->connect_error) {
    die('No se ha podido conectar a la base de datos: ' . $db_connection->connect_error);
}

$subs_name = $db_connection->real_escape_string($_POST['nombre']);
$subs_last = $db_connection->real_escape_string($_POST['apellido']);
$subs_email = $db_connection->real_escape_string($_POST['email']);

$resultado = $db_connection->query("SELECT * FROM `$db_table_name` WHERE `Email` = '$subs_email'");

if ($resultado->num_rows > 0) {
    header('Location: Fail.html');
    exit();
} else {
    $insert_value = $db_connection->prepare("INSERT INTO `$db_table_name` (`Nombre`, `Apellido`, `Email`) VALUES (?, ?, ?)");
    $insert_value->bind_param('sss', $subs_name, $subs_last, $subs_email);
    
    if ($insert_value->execute()) {
        header('Location: Success.html');
    } else {
        die('Error: ' . $db_connection->error);
    }
    
    $insert_value->close();
}

$db_connection->close();

?>