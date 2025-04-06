<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION["usuario_id"]) || !isset($_SESSION["usuario_nome"])) {
    header("Location: index.html");
    exit;
}

$id = $_GET["id"];
$amigo = $conn->query("SELECT * FROM amigos WHERE id = $id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $obs = $_POST["observacoes"];

    $stmt = $conn->prepare("UPDATE amigos SET nome=?, email=?, telefone=?, observacoes=? WHERE id=?");
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $obs, $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $_SESSION["mensagem_sucesso"] = "Amigo atualizado com sucesso!";
    } else {
        $_SESSION["mensagem_erro"] = "Nenhuma alteração foi feita.";
    }
    
    $stmt->close();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Amigo | FriendConnect</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="app-container">
  <header class="app-header">
    <h1>FriendConnect</h1>
    <nav class="navbar">
      <span style="color: white;">Olá, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?></span>
      <a href="dashboard.php" class="nav-link"><i class="fas fa-arrow-left"></i> Voltar</a>
      <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </nav>
  </header>

  <main class="edit-container">
  <div class="edit-card">
    <div class="edit-card-header">
        <i class="fas fa-user-edit"></i> Editar Amigo
    </div>
    <div class="edit-card-body">
        <form method="POST">
            <div class="form-group">
                <label class="form-label">Nome completo</label>
                <input name="nome" class="form-control" value="<?= htmlspecialchars($amigo['nome']) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($amigo['email']) ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Telefone</label>
                <input name="telefone" class="form-control" value="<?= htmlspecialchars($amigo['telefone']) ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Observações</label>
                <textarea name="observacoes" class="form-control no-resize" rows="4"><?= htmlspecialchars($amigo['observacoes']) ?></textarea>
            </div>
            
            <div class="edit-actions">
                <a href="dashboard.php" class="btn btn-edit">
                    <i class="fas fa-times btn-icon"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-add-friend">
                    <i class="fas fa-save btn-icon"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
  </main>

  <script>
    // Adiciona máscara para telefone
    document.querySelector('input[name="telefone"]')?.addEventListener('input', function(e) {
      var value = e.target.value.replace(/\D/g, '');
      if (value.length > 0) {
        value = '(' + value;
        if (value.length > 3) value = value.substring(0, 3) + ') ' + value.substring(3);
        if (value.length > 10) value = value.substring(0, 10) + '-' + value.substring(10);
        if (value.length > 15) value = value.substring(0, 15);
      }
      e.target.value = value;
    });
  </script>
</body>
</html>