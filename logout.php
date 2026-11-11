<?php
// Inicia a sessão para ter acesso a ela
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis de sessão na memória
$_SESSION = array();

// Destrói os cookies de sessão no navegador do usuário
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão no servidor
session_destroy();

// Redireciona de volta para a página inicial
header("Location: /nasib/index.php");
exit;
?>