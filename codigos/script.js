// Função para confirmar exclusão
function confirmarExclusao(event) {
  if (!confirm('Tem certeza que deseja excluir este amigo?')) {
    event.preventDefault();
  }
}

// Adiciona os event listeners quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
  // Adiciona confirmação para todos os links de exclusão
  const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
  deleteLinks.forEach(link => {
    link.addEventListener('click', confirmarExclusao);
  });
  
  // Mensagens de feedback (pode ser implementado com PHP depois)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('success')) {
    showAlert('Operação realizada com sucesso!', 'success');
  } else if (urlParams.has('error')) {
    showAlert('Ocorreu um erro. Por favor, tente novamente.', 'danger');
  }
});

function showAlert(message, type) {
  const alert = document.createElement('div');
  alert.className = `alert alert-${type}`;
  alert.style.position = 'fixed';
  alert.style.top = '20px';
  alert.style.right = '20px';
  alert.style.zIndex = '1000';
  alert.style.padding = '1rem';
  alert.style.borderRadius = '4px';
  alert.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
  alert.textContent = message;
  
  document.body.appendChild(alert);
  
  setTimeout(() => {
    alert.style.opacity = '0';
    alert.style.transition = 'opacity 0.5s';
    setTimeout(() => alert.remove(), 500);
  }, 3000);
}