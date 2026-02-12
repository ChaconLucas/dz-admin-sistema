// JavaScript para a Área do Cliente

// Modal de Login
function abrirModalLogin() {
  document.getElementById("modalLogin").style.display = "block";
}

function fecharModalLogin() {
  document.getElementById("modalLogin").style.display = "none";
}

// Event listeners para modal
document.addEventListener("DOMContentLoaded", function () {
  // Fechar modal clicando no X
  const span = document.querySelector(".close");
  if (span) {
    span.onclick = fecharModalLogin;
  }

  // Fechar modal clicando fora
  window.onclick = function (event) {
    const modal = document.getElementById("modalLogin");
    if (event.target === modal) {
      fecharModalLogin();
    }
  };

  // Form de login
  const formLogin = document.getElementById("formLogin");
  if (formLogin) {
    formLogin.addEventListener("submit", function (e) {
      e.preventDefault();

      const email = document.getElementById("email").value;
      const senha = document.getElementById("senha").value;

      if (!email || !senha) {
        alert("Por favor, preencha todos os campos");
        return;
      }

      // Aqui você pode adicionar a lógica de autenticação
      // Por enquanto, apenas uma simulação
      console.log("Tentativa de login:", { email, senha });

      // Simular login bem-sucedido
      alert("Login realizado com sucesso!");
      fecharModalLogin();
    });
  }
});

// Função para adicionar produto ao carrinho
function adicionarAoCarrinho(produtoId, nome, preco) {
  // Verifica se o usuário está logado
  // Por enquanto, apenas simula
  console.log("Produto adicionado ao carrinho:", { produtoId, nome, preco });

  // Animação visual
  const btn = event.target;
  const originalText = btn.textContent;
  btn.textContent = "Adicionado!";
  btn.style.background = "#27ae60";

  setTimeout(() => {
    btn.textContent = originalText;
    btn.style.background = "";
  }, 1500);
}

// Função para buscar produtos
function buscarProdutos() {
  const termoBusca = document.getElementById("busca").value.toLowerCase();
  const produtos = document.querySelectorAll(".produto-card");

  produtos.forEach((produto) => {
    const nome = produto
      .querySelector(".produto-nome")
      .textContent.toLowerCase();
    if (nome.includes(termoBusca)) {
      produto.style.display = "block";
    } else {
      produto.style.display = "none";
    }
  });
}

// Função para filtrar por categoria
function filtrarPorCategoria(categoria) {
  // Implementar lógica de filtro
  console.log("Filtrar por categoria:", categoria);
}

// Animação smooth scroll
function scrollToSection(sectionId) {
  document.getElementById(sectionId).scrollIntoView({
    behavior: "smooth",
  });
}

// Carregar produtos do banco (exemplo)
async function carregarProdutos() {
  try {
    // Aqui você faria uma requisição para buscar os produtos
    // fetch('produtos.php')
    console.log("Carregando produtos...");
  } catch (error) {
    console.error("Erro ao carregar produtos:", error);
  }
}
