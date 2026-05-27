<?php
include('config/database.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido. Use el formulario.");
}

$f_name  = $_POST['fname']  ?? '';
$l_name  = $_POST['lname']  ?? '';
$e_mail  = $_POST['email']  ?? '';
$m_phone = $_POST['mphone'] ?? '';
$p_asswd  = $_POST['passwd'] ?? '';

//$enc_pass = password_hash($p_sswd, PASSWORD_BCRYPT);
     $enc_pass = md5($p_asswd);


$check_email = "SELECT email FROM users WHERE email = '$e_mail'";
$res_email = pg_query($local_conn, $check_email);

if (pg_num_rows($res_email) > 0) {
    echo "Error: El correo electrónico '$e_mail' ya está registrado. Por favor, use uno diferente.";
    exit();
}

$check_phone = "SELECT mobile_phone FROM users WHERE mobile_phone = '$m_phone'";
$res_phone = pg_query($local_conn, $check_phone);

if (pg_num_rows($res_phone) > 0) {
    echo "Error: El número de celular '$m_phone' ya está registrado en nuestro sistema.";
    exit();
}

$sql = "INSERT INTO users(firstname, lastname, email, mobile_phone, password)
        VALUES('$f_name','$l_name','$e_mail','$m_phone','$enc_pass')";

$res_local = pg_query($local_conn, $sql);
if ($res_local) {
    $res_supa = pg_query($supa_conn, $sql);
    if ($res_supa) {
        echo "<script>alert('Listo. Usuario registrado')</script>";
        header('refresh:0;url=login.php');
    } else {
        echo "Error: Se guardó en local pero no en la nube.";
    }
} else {
    echo "Error: No se pudo guardar ni en local.";
}
?>