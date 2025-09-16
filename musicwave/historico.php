<?php
require_once '../APP/sessao.php';
requererLogin('historico.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css">
  <title>Histórico de Pedidos</title>
  <style>
    .pedido { border:1px solid #ddd; border-radius:8px; padding:12px; margin:10px 0; background:#fff; }
    .pedido h3 { margin:0 0 8px 0; }
    .pedido small { color:#666; }
    .itens { margin-top:8px; }
    .item { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px dashed #eee; }
    .item:last-child { border-bottom:none; }
  </style>
  <script>
    async function carregarHistorico() {
      const container = document.getElementById('container');
      container.innerHTML = 'Carregando...';
      try {
        const resp = await fetch('../APP/controller/HistoricoController.php');
        const data = await resp.json();
        if (!data.sucesso) throw new Error(data.mensagem || 'Erro');
        if (data.pedidos.length === 0) {
          container.innerHTML = '<p>Você ainda não possui pedidos.</p>';
          return;
        }
        container.innerHTML = data.pedidos.map(p => `
          <div class="pedido">
            <h3>Pedido #${p.idpedido} - ${p.status}</h3>
            <small>Data: ${p.datapedido} ${p.dataentrega ? ' | Entrega: ' + p.dataentrega : ''}</small>
            <div class="itens">
              ${p.itens.map(i => `
                <div class="item">
                  <span>${i.produto} (x${i.quantidade})</span>
                  <span>R$ ${(i.precounitario * i.quantidade).toFixed(2)}</span>
                </div>
              `).join('')}
            </div>
            <p><strong>Total: R$ ${Number(p.total).toFixed(2)}</strong></p>
          </div>
        `).join('');
      } catch (e) {
        container.innerHTML = 'Erro ao carregar histórico: ' + e.message;
      }
    }
    document.addEventListener('DOMContentLoaded', carregarHistorico);
  </script>
</head>
<body>
  <header>
    <div class="logo-img"><img src="img/logomw.png" alt="logo"></div>
    <button class="bubbles"><span class="text"><a href="loja.php">Loja</a></span></button>
  </header>
  <main class="small-container-instrumentos">
    <h2>📦 Histórico de Pedidos</h2>
    <div id="container"></div>
  </main>
</body>
</html>
