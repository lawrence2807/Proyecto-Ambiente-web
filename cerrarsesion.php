<?php
session_start();

 
$_SESSION = array();

 
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

 
session_destroy();

// Redirige al usuario a la página de inicio o a donde lo desees
header("Location: IniciarSesion.php");
exit();


/*if (!isset($_SESSION["ID_usuario"])) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: iniciarsesion.php");
    exit(); // Detiene la ejecución del script
}*/


?>