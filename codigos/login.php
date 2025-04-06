<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            // Definir TODAS as variáveis de sessão necessárias
            $_SESSION["usuario_id"] = $usuario['id'];
            $_SESSION["usuario_nome"] = $usuario['nome']; // Esta linha estava faltando
            $_SESSION["usuario_email"] = $email;
            
            header("Location: dashboard.php");
            exit;
        } else {
            // Adicionar mensagem de erro na sessão
            $_SESSION["erro_login"] = "Senha incorreta.";
            header("Location: index.html");
            exit;
        }
    } else {
        $_SESSION["erro_login"] = "Usuário não encontrado.";
        header("Location: index.html");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>