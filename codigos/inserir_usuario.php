<?php
include("conexao.php");

$nome = "Beatris";
$email = "beatris.antunes2012@gmail.com";
$senha = password_hash("Jully011@", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senha);
$stmt->execute();

echo "Usuário inserido com senha segura.";
?>
