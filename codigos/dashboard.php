<?php
session_start();
include 'conexao.php';
if (!isset($_SESSION["usuario_id"])) header("Location: index.html");

$id_usuario = $_SESSION["usuario_id"];
$amigos = $conn->query("SELECT * FROM amigos WHERE id_usuario = $id_usuario");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FriendConnect | Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="app-container">
  <header class="app-header">
    <h1>FriendConnect</h1>
    <nav class="navbar">
      <span style="color: white;">Olá, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?></span>
      <a href="logout.php" class="nav-link">Sair</a>
    </nav>
  </header>

  <main class="main-content">
  <div class="card">
    <div class="card-header">Adicionar novo amigo</div>
    <div class="card-body">
        <form action="cadastrar_amigo.php" method="POST">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Nome completo</label>
                    <input class="form-control" name="nome" placeholder="Ex: João Silva" required>
                </div>
                <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <input class="form-control" name="email" placeholder="Ex: joao@exemplo.com" type="email">
                </div>
                <div class="form-group">
                    <label class="form-label">Telefone</label>
                    <input class="form-control" name="telefone" placeholder="Ex: (11) 98765-4321" type="tel">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Observações</label>
                <textarea class="form-control no-resize" name="observacoes" placeholder="Interesses, aniversário, como se conheceram..." rows="3"></textarea>
            </div>
            <div style="text-align: right; margin-top: 1.5rem;">
    <button type="submit" class="btn-add-friend">
        <i class="fas fa-user-plus btn-icon"></i> Adicionar Amigo
    </button>
</div>
        </form>
    </div>
</div>

    <div class="card">
      <div class="card-header">Seus amigos (<?php echo $amigos->num_rows; ?>)</div>
      <div class="card-body">
        <?php if ($amigos->num_rows > 0): ?>
          <div style="overflow-x: auto;">
            <table class="table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Contato</th>
                  <th>Observações</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php while($amigo = $amigos->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($amigo["nome"]) ?></td>
                    <td>
                      <?php if (!empty($amigo["email"])): ?>
                        <div><small>Email:</small> <?= htmlspecialchars($amigo["email"]) ?></div>
                      <?php endif; ?>
                      <?php if (!empty($amigo["telefone"])): ?>
                        <div><small>Tel:</small> <?= htmlspecialchars($amigo["telefone"]) ?></div>
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($amigo["observacoes"]) ?></td>
                    <td>
    <div class="btn-actions-container">
        <a href="editar_amigo.php?id=<?= $amigo["id"] ?>" class="btn-edit">
            <i class="fas fa-pencil-alt"></i> Editar
        </a>
        <a href="excluir_amigo.php?id=<?= $amigo["id"] ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este amigo?')">
            <i class="fas fa-trash"></i> Excluir
        </a>
    </div>
</td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div style="text-align: center; padding: 2rem; color: var(--gray-color);">
            <p>Você ainda não adicionou nenhum amigo.</p>
            <p>Comece adicionando seus amigos usando o formulário acima.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer style="background-color: var(--dark-color); color: white; text-align: center; padding: 1rem;">
    <small>FriendConnect &copy; <?php echo date('Y'); ?> - Todos os direitos reservados</small>
  </footer>
</body>
</html>