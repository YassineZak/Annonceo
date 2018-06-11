<?php
// Initialiser la sesssion
session_start();

// Vider la session
$_SESSION = array();

// Supprimer le cookie PHPSESSID
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, on détruit la session.
session_destroy();

// Redirige vers la page de connexion
header("Location: index.php");
exit;
?>
