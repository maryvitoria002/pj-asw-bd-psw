const palavras = ["viola", "guitarra", "instrumentista", "musicwave", "harmonia"];
let palavra = "";
let palavraExibida = [];
let letrasErradas = [];
let tentativas = 6;

const partesBoneco = [
  ".cabeca",
  ".tronco",
  ".braco-esq",
  ".braco-dir",
  ".perna-esq",
  ".perna-dir"
];

function escolherPalavra() {
  palavra = palavras[Math.floor(Math.random() * palavras.length)];
  palavraExibida = Array(palavra.length).fill("_");
  letrasErradas = [];
  tentativas = 6;
  esconderBoneco();
  atualizarTela();
}

function atualizarTela() {
  document.getElementById("wordDisplay").textContent = palavraExibida.join(" ");
  document.getElementById("wrongLetters").textContent = letrasErradas.join(", ");
  document.getElementById("attempts").textContent = tentativas;
  mostrarBoneco();
}

function guessLetter() {
  const input = document.getElementById("letterInput");
  const letra = input.value.toLowerCase();

  // Limpa mensagem antiga
  document.getElementById("message").textContent = "";

  if (!letra || letra.length !== 1 || !letra.match(/[a-záéíóúãõç]/i)) {
    document.getElementById("message").textContent = "Digite uma letra válida.";
    return;
  }

  if (palavraExibida.includes(letra) || letrasErradas.includes(letra)) {
    document.getElementById("message").textContent = "Você já tentou essa letra.";
    return;
  }

  if (palavra.includes(letra)) {
    for (let i = 0; i < palavra.length; i++) {
      if (palavra[i] === letra) {
        palavraExibida[i] = letra;
      }
    }
  } else {
    letrasErradas.push(letra);
    tentativas--;
  }

  input.value = "";
  atualizarTela();
  verificarFimDeJogo();
}

function verificarFimDeJogo() {
  const messageElement = document.getElementById("message");

  if (!palavraExibida.includes("_")) {
    messageElement.textContent = "Parabéns! Você venceu! 🎉";
    desativarJogo();
  } else if (tentativas === 0) {
    messageElement.textContent = `Fim de jogo! A palavra era "${palavra}". 😞`;
    desativarJogo();
  }
}

function desativarJogo() {
  document.getElementById("letterInput").disabled = true;
}

function restartGame() {
  document.getElementById("letterInput").disabled = false;
  document.getElementById("letterInput").value = "";
  document.getElementById("message").textContent = "";
  escolherPalavra();
}

function mostrarBoneco() {
  const erros = 6 - tentativas;
  for (let i = 0; i < partesBoneco.length; i++) {
    const parte = document.querySelector(partesBoneco[i]);
    parte.style.display = i < erros ? "block" : "none";
  }
}

function esconderBoneco() {
  partesBoneco.forEach(seletor => {
    document.querySelector(seletor).style.display = "none";
  });
}

escolherPalavra();
