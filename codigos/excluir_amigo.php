<?php
session_start();
include 'conexao.php';
$id = $_GET["id"];
$conn->query("DELETE FROM amigos WHERE id = $id");
header("Location: dashboard.php");
?>