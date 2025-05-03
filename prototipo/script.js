const produtos = [
    { id: 1, nome: "Violino Yamaha", preco: 1500 },
    { id: 2, nome: "Viola Clássica", preco: 1800 },
    { id: 3, nome: "Violoncelo Elétrico", preco: 2300 }
  ];
  
  let carrinho = [];
  let pontos = 0;
  
  function carregarProdutos() {
    const container = document.getElementById('produtos');
    produtos.forEach(prod => {
      const el = document.createElement('div');
      el.classList.add('produto');
      el.innerHTML = `<h3>${prod.nome}</h3>
                      <p>R$ ${prod.preco.toFixed(2)}</p>
                      <button onclick="adicionarCarrinho(${prod.id})">Adicionar</button>`;
      container.appendChild(el);
    });
  }
  
  function adicionarCarrinho(id) {
    const produto = produtos.find(p => p.id === id);
    carrinho.push(produto);
    pontos += Math.floor(produto.preco / 10); // 10% do valor em pontos
    atualizarCarrinho();
  }
  
  function atualizarCarrinho() {
    document.getElementById('cart-count').innerText = carrinho.length;
    const lista = document.getElementById('lista-carrinho');
    const total = carrinho.reduce((acc, item) => acc + item.preco, 0);
    lista.innerHTML = '';
    carrinho.forEach((item, index) => {
      const li = document.createElement('li');
      li.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;
      lista.appendChild(li);
    });
    document.getElementById('total-carrinho').innerText = total.toFixed(2);
    document.getElementById('pontos').innerText = pontos;
  }
  
  function toggleCarrinho() {
    const carrinhoDiv = document.getElementById('carrinho');
    carrinhoDiv.style.display = carrinhoDiv.style.display === 'block' ? 'none' : 'block';
  }
  
  function finalizarCompra() {
    alert(`Compra finalizada com ${carrinho.length} item(ns)!\nTotal: R$ ${carrinho.reduce((acc, i) => acc + i.preco, 0).toFixed(2)}\nPontos acumulados: ${pontos}`);
    carrinho = [];
    atualizarCarrinho();
    toggleCarrinho();
  }
  
  document.addEventListener('DOMContentLoaded', carregarProdutos);
  