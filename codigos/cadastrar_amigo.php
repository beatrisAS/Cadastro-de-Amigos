<?php
session_start();
include 'conexao.php';

$id_usuario = $_SESSION["usuario_id"];
$nome = $_POST["nome"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$obs = $_POST["observacoes"];

$conn->query("INSERT INTO amigos (nome, email, telefone, observacoes, id_usuario)
              VALUES ('$nome', '$email', '$telefone', '$obs', $id_usuario)");

header("Location: dashboard.php");
?>
