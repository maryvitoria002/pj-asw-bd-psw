// botão do dark mode

const switchEl = document.getElementById("darkModeSwitch");

if (localStorage.getItem("darkMode") === "true") {
  document.body.classList.add("dark-mode");
  switchEl.checked = true;
}

switchEl.addEventListener("change", function () {
  document.body.classList.toggle("dark-mode", this.checked);
  localStorage.setItem("darkMode", this.checked);
});

// botão do dark mode

// botão de inserir o cep

const cepTexto = document.getElementById("cep-texto");

  // Mostra o CEP salvo (caso exista)
  window.addEventListener("DOMContentLoaded", () => {
    const cepSalvo = localStorage.getItem("cepSalvo");
    if (cepSalvo) {
      cepTexto.textContent = "CEP: " + cepSalvo;
    }
  });

  function pedirCep() {
    const cepAtual = localStorage.getItem("cepSalvo") || "";
    const novoCep = prompt(
      "Digite seu CEP:\n\n(Para remover, deixe vazio ou digite 'remover')",
      cepAtual
    );

    if (novoCep === null) return; // cancelou

    if (novoCep.trim() === "" || novoCep.toLowerCase() === "remover" || novoCep.toLowerCase() === "excluir") {
      localStorage.removeItem("cepSalvo");
      cepTexto.textContent = "Informe seu CEP";
      alert("CEP removido.");
      return;
    }  

    const cepFormatado = novoCep.replace(/\D/g, ""); // remove tudo que não for número

    if (/^[0-9]{8}$/.test(cepFormatado)) {
      const cepFinal = cepFormatado.replace(/(\d{5})(\d{3})/, "$1-$2"); // Formata para 12345-678
      localStorage.setItem("cepSalvo", cepFinal);
      cepTexto.textContent = "CEP: " + cepFinal;
    } else {
      alert("CEP inválido. Digite no formato 12345678 ou 12345-678.");
    }
  }

// botão de inserir o cep



// slideshow paizão

const slides = document.querySelectorAll(".slide");
  const dots = document.querySelectorAll(".dot");
  const wrapper = document.querySelector(".slideshow-wrapper");

  const bgColors = [
  "#f0e3dc",
  "#ffd7c1",
  "linear-gradient(to right, #374253, #1b2d4a)",
  "#fa98b1",
  "linear-gradient(to right, #e4a777, #f1eae2)"
];


  let index = 0;
  let intervalId;

  function showSlide(i) {
    slides[index].classList.remove("active");
    dots[index].classList.remove("active");
    index = i;
    slides[index].classList.add("active");
    dots[index].classList.add("active");
  wrapper.style.background = bgColors[index];

  }

  function nextSlide() {
    showSlide((index + 1) % slides.length);
  }

  function startAutoSlide() {
    intervalId = setInterval(nextSlide, 3000);
  }

  function resetAutoSlide() {
    clearInterval(intervalId);
    startAutoSlide();
  }

  dots.forEach(dot => {
    dot.addEventListener("click", () => {
      showSlide(parseInt(dot.dataset.index));
      resetAutoSlide();
    });
  });

  startAutoSlide();

// slideshow paizão





// seção do afinador lateral bb

const afinacoes = {
    violino: [
      { nome: "E - 1ª Corda", freq: 659.25 },
      { nome: "A - 2ª Corda", freq: 440 },
      { nome: "D - 3ª Corda", freq: 293.66 },
      { nome: "G - 4ª Corda", freq: 196 },
    ],
    viola: [
      { nome: "A - 1ª Corda", freq: 880 },
      { nome: "D - 2ª Corda", freq: 587.33 },
      { nome: "G - 3ª Corda", freq: 392 },
      { nome: "C - 4ª Corda", freq: 261.63 },
    ],
    violoncelo: [
      { nome: "A - 1ª Corda", freq: 220 },
      { nome: "D - 2ª Corda", freq: 146.83 },
      { nome: "G - 3ª Corda", freq: 98 },
      { nome: "C - 4ª Corda", freq: 65.41 },
    ],
    violao: [
      { nome: "E - 6ª Corda", freq: 82.41 },
      { nome: "A - 5ª Corda", freq: 110.00 },
      { nome: "D - 4ª Corda", freq: 146.83 },
      { nome: "G - 3ª Corda", freq: 196.00 },
      { nome: "B - 2ª Corda", freq: 246.94 },
      { nome: "E - 1ª Corda", freq: 329.63 },
    ],
    guitarra: [
      { nome: "E - 6ª Corda", freq: 82.41 },
      { nome: "A - 5ª Corda", freq: 110.00 },
      { nome: "D - 4ª Corda", freq: 146.83 },
      { nome: "G - 3ª Corda", freq: 196.00 },
      { nome: "B - 2ª Corda", freq: 246.94 },
      { nome: "E - 1ª Corda", freq: 329.63 },
    ],
    baixo: [
      { nome: "E - 4ª Corda", freq: 41.20 },
      { nome: "A - 3ª Corda", freq: 55.00 },
      { nome: "D - 2ª Corda", freq: 73.42 },
      { nome: "G - 1ª Corda", freq: 98.00 },
    ],
     cavaquinho: [
      { nome: "G - 4ª Corda", freq: 392 },
      { nome: "D - 3ª Corda", freq: 293.66 },
      { nome: "B - 2ª Corda", freq: 246.94 },
      { nome: "D - 1ª Corda", freq: 196 },
    ],
    ukulele: [
      { nome: "G - 4ª Corda", freq: 392 },
      { nome: "C - 3ª Corda", freq: 261.63 },
      { nome: "E - 2ª Corda", freq: 329.63 },
      { nome: "A - 1ª Corda", freq: 440 },
    ],
    viola_caipira: [
      { nome: "E - 1ª Corda", freq: 329.63 },
      { nome: "B - 2ª Corda", freq: 246.94 },
      { nome: "G# - 3ª Corda", freq: 415.30 },
      { nome: "E - 4ª Corda", freq: 329.63 },
      { nome: "B - 5ª Corda", freq: 246.94 },
    ],
    banjo: [
      { nome: "D - 4ª Corda", freq: 293.66 },
      { nome: "B - 3ª Corda", freq: 246.94 },
      { nome: "G - 2ª Corda", freq: 196 },
      { nome: "D - 1ª Corda", freq: 146.83 },
      { nome: "G - 5ª Corda", freq: 392 },
    ],
    charango: [
      { nome: "G - 5ª Corda", freq: 196 },
      { nome: "C - 4ª Corda", freq: 261.63 },
      { nome: "E - 3ª Corda", freq: 329.63 },
      { nome: "A - 2ª Corda", freq: 440 },
      { nome: "E - 1ª Corda", freq: 659.25 },
    ],
    bandolim: [
      { nome: "E - 1ª Corda", freq: 659.25 },
      { nome: "A - 2ª Corda", freq: 440 },
      { nome: "D - 3ª Corda", freq: 293.66 },
      { nome: "G - 4ª Corda", freq: 196 },
    ],
  };


  const descricoes = {
    violino: "Conhecido por sua expressividade e agilidade, o Violino, com suas 4 cordas afinadas em G-D-A-E, é um instrumento de cordas que pode evocar desde as mais delicadas melodias até passagens virtuosísticas.",
    viola: "Com um timbre mais grave e encorpado que o violino, a Viola de Arco, possuindo 4 cordas afinadas uma quinta abaixo do violino (C-G-D-A), atua como uma ponte harmônica, adicionando profundidade e calor.",
    violoncelo: "Dona de uma sonoridade rica e ressonante, que se assemelha à voz humana, o Violoncelo, com suas 4 cordas afinadas em C-G-D-A (uma oitava abaixo da viola), é capaz de tocar linhas melódicas e harmonias profundas com grande emoção.",
     violao: "Essencial em diversos gêneros musicais, o Violão, geralmente com 6 cordas afinadas em E-A-D-G-B-E, é um instrumento versátil que oferece sonoridades ricas e acolhedoras.",
    guitarra: " Seja elétrica ou acústica, a Guitarra, com suas 6 cordas (ou mais) e afinação padrão em E-A-D-G-B-E, é um ícone da música moderna, capaz de produzir desde riffs poderosos a melodias suaves.",
    baixo: "Com suas 4 a 6 cordas e timbre profundo, o Baixo, tipicamente afinado em E-A-D-G, é a espinha dorsal de qualquer banda, fornecendo a base rítmica e harmônica.",
    cavaquinho: "Essencial no samba e no choro, o Cavaquinho, com suas 4 cordas e afinação padrão em D-G-B-D, é um instrumento pequeno, mas com um som vibrante e ágil.",
    ukulele: "Pequeno e alegre, o Ukulele, geralmente com 4 cordas afinadas em G-C-E-A, é perfeito para quem busca um som descontraído e fácil de aprender, ideal para canções leves.",
    viola_caipira: "Parte da alma musical brasileira, a Viola Caipira se destaca por suas 10 cordas em cinco pares e seu timbre único, que evoca a tradição e a emoção do campo.",
    banjo: "Com seu som ressonante e percussivo, o Banjo, frequentemente com 5 cordas e afinação aberta, é a alma do bluegrass e de outros gêneros folclóricos, criando melodias cativantes.",
    charango: "Um instrumento de cordas andino, o Charango, com suas 10 cordas agrupadas em cinco pares, encanta com seu som agudo e vibrante, ideal para melodias folclóricas.",
    bandolim: "Com seu som brilhante e percussivo, o Bandolim, tipicamente com 8 cordas em quatro pares afinados em G-D-A-E, adiciona um toque especial a diversos estilos, do folk ao choro.",
  };


  const imagens = {
    violino: "instrumentos/violin6.png",
    viola: "instrumentos/viola4.png",
    violoncelo: "instrumentos/celo2.png",
    violao: "",
    guitarra: "instrumentos/guitarra1.png",
    baixo: "",
    cavaquinho: "",
    ukulele: "instrumentos/ukulele8.png",
    viola_caipira: "",
    banjo: "instrumentos/banjo5.png",
    charango: "instrumentos/charango7.png",
    bandolim: "instrumentos/bandolim3.png"
  };


  function playNote(freq, el = null) {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    const ctx = new AudioContext();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();


    osc.type = "sine";
    osc.frequency.value = freq;


    gain.gain.setValueAtTime(0.2, ctx.currentTime);
    osc.connect(gain);
    gain.connect(ctx.destination);


    osc.start();
    osc.stop(ctx.currentTime + 2);


    if (el) {
      el.classList.add("vibrar");
      setTimeout(() => el.classList.remove("vibrar"), 300);
    }
  }


  function carregarCordas() {
    const tipo = document.getElementById("instrumento").value;
    const cordas = afinacoes[tipo];
    const container = document.getElementById("cordas");
    container.innerHTML = "";
    cordas.forEach(corda => {
      const btn = document.createElement("button");
      btn.textContent = corda.nome;
      btn.onclick = () => playNote(corda.freq, btn);
      container.appendChild(btn);
    });
    document.getElementById("descricao").textContent = descricoes[tipo] || "";
    const img = document.getElementById("imgInstrumento");
    img.src = imagens[tipo] || "";
    img.style.display = imagens[tipo] ? "block" : "none";
  }


  function tocarTodasCordas() {
    const tipo = document.getElementById("instrumento").value;
    const cordas = afinacoes[tipo];
    cordas.forEach((corda, i) => {
      setTimeout(() => playNote(corda.freq), i * 1000);
    });
  }


  function abrirAfinador() {
    document.getElementById("afinadorLateral").classList.add("ativo");
    localStorage.setItem("afinadorAberto", "true");
  }


  function fecharAfinador() {
    document.getElementById("afinadorLateral").classList.remove("ativo");
    localStorage.setItem("afinadorAberto", "false");
  }


  window.addEventListener("DOMContentLoaded", () => {
    carregarCordas();
    if (localStorage.getItem("afinadorAberto") === "true") abrirAfinador();
  })

// seção do afinador lateral bb




// scriptzinho do formulário de login (mas que iremos remover posteriormente)

 const fotoInput = document.getElementById('foto-perfil');
  const avatarPreview = document.getElementById('preview-avatar');
  const removerBtn = document.getElementById('remover-foto');
  const form = document.getElementById('cadastro-form');
  const logoutBtn = document.getElementById('logout');
  const nomeInput = document.getElementById('nome');
  const emailInput = document.getElementById('email');
  const senhaInput = document.getElementById('senha');
  const cepInput = document.getElementById('cep');

  // Carregar dados do localStorage
  window.onload = () => {
    const dados = JSON.parse(localStorage.getItem('usuario'));
    if (dados) {
      nomeInput.value = dados.nome;
      emailInput.value = dados.email;
      senhaInput.value = dados.senha;
      cepInput.value = dados.cep;
      if (dados.foto) {
        avatarPreview.src = dados.foto;
        removerBtn.style.display = 'inline-block';
      }
      logoutBtn.style.display = 'inline-block';
    }
  }

  // Preview de imagem
  fotoInput.addEventListener('change', () => {
    const file = fotoInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        avatarPreview.src = e.target.result;
        removerBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    }
  });

  // Remover imagem
  removerBtn.addEventListener('click', () => {
    avatarPreview.src = 'https://via.placeholder.com/100';
    fotoInput.value = '';
    removerBtn.style.display = 'none';
  });

  // Envio do formulário
  form.addEventListener('submit', e => {
    e.preventDefault();
    const foto = avatarPreview.src;
    const usuario = {
      nome: nomeInput.value,
      email: emailInput.value,
      senha: senhaInput.value,
      cep: cepInput.value,
      foto: foto
    };
    localStorage.setItem('usuario', JSON.stringify(usuario));
    alert("Cadastro salvo localmente!");
    logoutBtn.style.display = 'inline-block';
  });

  // Logout
  logoutBtn.addEventListener('click', () => {
    localStorage.removeItem('usuario');
    form.reset();
    avatarPreview.src = 'https://via.placeholder.com/100';
    removerBtn.style.display = 'none';
    logoutBtn.style.display = 'none';
  });


// scriptzinho do formulário de login (mas que iremos remover posteriormente)

