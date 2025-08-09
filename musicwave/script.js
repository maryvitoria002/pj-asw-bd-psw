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




// catálogo dos instrumentos + carrinho + modal de produtos e modal do pix + filtragem por categoria papaizinho
 // Dados dos produtos - ESTES DEVEM ESTAR IDÊNTICOS AOS SEUS PRODUTOS ATUAIS
        const products = [
            // Violinos (8 items)
            { id: 1, category: "violino", title: "Violino Tarttan Série 100 Preto Brilho 4/4", price: 697.00, description: "Este violino Tarttan Série 100, importado da China, é um 4/4 com acabamento preto brilhante. Fabricado com madeira laminada, é ajustado por luthier e vem com estandarte de 4 micro afinadores. Inclui arco, breu e estojo preto.", image: "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png", thumbnails: ["violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png", "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-verso.png", "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-case.png"] },
            { id: 2, category: "violino", title: "Violino Acústico 4/4", price: 299.00, description: "Este violino acústico 4/4 da marca Mix, na cor marrom, possui corpo em MDF tanto na parte superior quanto na traseira. Suas dimensões são 70 x 30 x 70 cm e vem completo com arco, breu, cavalete e um luxuoso estojo.", image: "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png", thumbnails: ["violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png", "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- pessoas.jpg", "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- completo.png"] },
            { id: 3, category: "violino", title: "Violino Alan 4/4 Al-1410 Completo", price: 391.00, description: "O Violino Alan AL-1410 é um modelo 4/4 completo na cor Sunburst. Com tampo em Spruce (revestido), traseira e lateral em Maple, cravelhas, queixeira e estandarte em Boxwood, e escala em Maple. Inclui 4 micro afinadores, filetes entalhados, estojo térmico de luxo e arco de crina sintética de 75 cm. Suas dimensões são 60 x 21 x 4 cm.", image: "violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png", thumbnails: ["violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png", "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- case.png", "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- com case.png"] },
            { id: 4, category: "violino", title: "Violino Dominante 9649 3/4", price: 439.00, description: "Este violino acústico Dominante 9649, tamanho 3/4, apresenta acabamento brilhante na cor natural. Não é para canhotos. O corpo é feito de Spruce e o diapasão de Ébano. Acompanha arco e estojo.", image: "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png", thumbnails: ["violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png", "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- dentro da case.png", "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- detalhes.jpg"] },
            { id: 5, category: "violino", title: "Violino Tarttan Série 100 Natural 4/4 com Case", price: 697.00, description: "O Violino Tarttan Série 100 da marca Xenox é um modelo 4/4 natural, com acabamento em verniz. Possui tampo de Ácer e parte traseira em madeira compensada. Acompanha case.", image: "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png", thumbnails: ["violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png", "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- interior.jpg", "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- parte inferior.png"] },
            { id: 6, category: "violino", title: "Violino Eagle VE441 Classic Series 4/4", price: 1140.00, description: "O Violino Eagle VE441 Classic Series da marca TMZUAMOZ é um modelo 4/4 na cor natural. Possui tampo de Abeto. Suas dimensões são 80 x 30 x 20 cm.", image: "violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png", thumbnails: ["violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png", "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- dentro da case.png", "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- frente e verso.png"] },
            { id: 7, category: "violino", title: "Violino Vogga VON144N 4/4", price: 439.00, description: "O Violino Vogga VON144N é um modelo 4/4 na cor Natural Fosco. Suas dimensões são 80 x 26 x 11 cm e possui tampo em Spruce.", image: "violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png", thumbnails: ["violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png", "violinos/7 VIOLINO VOGGA VON144N 44/violino7- frente.png", "violinos/7 VIOLINO VOGGA VON144N 44/violino7- verso.png"] },
            { id: 8, category: "violino", title: "Violino Vivace Strauss 4/4 Fosco", price: 1799.00, description: "O Violino Vivace Strauss é um modelo 4/4 com acabamento fosco. Possui tampo de Abeto e parte traseira de madeira de bordo. Acompanha case térmico.", image: "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png", thumbnails: ["violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png", "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- frente.png", "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- verso.png"] },

            // Guitarras (8 items)
            { id: 11, category: "guitarra", title: "Guitarra Giannini G102 Elétrica Stratocaster Hh Branco", price: 757.00, description: "Guitarra Elétrica Giannini G102 Stratocaster HH na cor branca, ideal para diversos estilos musicais. Possui ótima tocabilidade e som potente.", image: "guitarras/Guitarra Giannini G102 Elétrica Stratocaster Hh Branco/guitar1-removebg-preview.png", thumbnails: ["guitarras/Guitarra Giannini G102 Elétrica Stratocaster Hh Branco/guitar1-removebg-preview.png", "guitarras/Guitarra Giannini G102 Elétrica Stratocaster Hh Branco/guitar1-body.png", "guitarras/Guitarra Giannini G102 Elétrica Stratocaster Hh Branco/guitar1-headstock.png"] },
            { id: 12, category: "guitarra", title: "Guitarra Les Paul Shelter Nashville", price: 1200.00, description: "Guitarra Les Paul Shelter Nashville, com timbre encorpado e sustain prolongado. Acabamento clássico, ideal para rock e blues.", image: "guitarras/guitar-lespaul.png", thumbnails: ["guitarras/Guitarra Les Paul Shelter Nashville/guitar-lespaul.png"] },
            { id: 13, category: "guitarra", title: "Guitarra Strinberg Stratocaster STP100", price: 980.00, description: "Guitarra Strinberg Stratocaster STP100, versátil para diversos estilos musicais. Corpo em basswood, braço em maple e 3 single-coils.", image: "guitarras/guitar-strinberg.png", thumbnails: ["guitarras/Guitarra Strinberg Stratocaster STP100/guitar-strinberg.png"] },
            { id: 14, category: "guitarra", title: "Guitarra Tagima Memphis MG30", price: 850.00, description: "Guitarra Tagima Memphis MG30, excelente para iniciantes. Corpo em basswood, braço em maple, ponte tremolo e 3 single-coils.", image: "guitarras/guitar-tagima.png", thumbnails: ["guitarras/Guitarra Tagima Memphis MG30/guitar-tagima.png"] },
            { id: 15, category: "guitarra", title: "Guitarra Fender Squier Stratocaster", price: 1500.00, description: "Guitarra Fender Squier Stratocaster, um clássico acessível. Timbre autêntico, conforto e qualidade Fender para todos os guitarristas.", image: "guitarras/guitar-squier.png", thumbnails: ["guitarras/Guitarra Fender Squier Stratocaster/guitar-squier.png"] },
            { id: 16, category: "guitarra", title: "Guitarra Ibanez Gio GRG170DX", price: 1650.00, description: "Guitarra Ibanez Gio GRG170DX, ideal para rock e metal. Design moderno, braço fino e captadores potentes para alto ganho.", image: "guitarras/guitar-ibanez.png", thumbnails: ["guitarras/Guitarra Ibanez Gio GRG170DX/guitar-ibanez.png"] },
            { id: 17, category: "guitarra", title: "Guitarra Epiphone Les Paul Special VE", price: 1100.00, description: "Guitarra Epiphone Les Paul Special VE, visual vintage e som poderoso. Ótima opção para quem busca o clássico timbre Les Paul.", image: "guitarras/Guitarra Epiphone Les Paul Special VE/guitar-epiphone.png", thumbnails: ["guitarras/Guitarra Epiphone Les Paul Special VE/guitar-epiphone.png"] },
            { id: 18, category: "guitarra", title: "Guitarra Washburn X Series X10", price: 900.00, description: "Guitarra Washburn X Series X10, design moderno e versátil. Corpo em basswood, braço em maple, e dois humbuckers para som encorpado.", image: "guitarras/Guitarra Washburn X Series X10/guitar-washburn.png", thumbnails: ["guitarras/Guitarra Washburn X Series X10/guitar-washburn.png"] },

            // Violoncelos (8 items)
            { id: 21, category: "violoncelo", title: "Violoncelo AL 1210 44 Alan Com Capa Arco Breu", price: 1500.00, description: "Este violoncelo Alan AL 1210 4/4, na cor marrom avermelhada, mede 123 x 46 x 14 cm. Possui tampo laminado em Spruce, traseira e laterais em Linden, e acabamento em verniz sintético. Conta com cravelhas em Maple, estandarte em Boxwood, 4 micro afinadores metálicos e filetes entalhados. Acompanha arco de crina sintética de 72 cm, capa e breu.", image: "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png", thumbnails: ["violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png", "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- verso.png", "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- com case.png"] },
            { id: 22, category: "violoncelo", title: "Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu", price: 1836.10, description: "O Violoncelo Envelhecido Alan AL 1210 4/4 E apresenta um acabamento marrom fosco envelhecido. Suas dimensões aproximadas são 133 x 51 x 33 cm, com tampo em Plywood. Acompanha capa, arco e breu.", image: "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png", thumbnails: ["violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png", "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- verso.png", "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- com case.png"] },
            { id: 23, category: "violoncelo", title: "VIOLONCELO VOGGA VOC144N 44", price: 2308.90, description: "O Violoncelo Vogga VOC144N é um modelo 4/4 na cor Natural Fosco. Suas dimensões são 140 x 33 x 52 cm e possui tampo em Abeto.", image: "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png", thumbnails: ["violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png", "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- verso.png", "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- case.png"] },
            { id: 24, category: "violoncelo", title: "Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello", price: 1900.00, description: "O Violoncelo Vivace CMO44 Mozart, tamanho 4/4, na cor natural, possui acabamento brilhante. Com dimensões de 14 x 24 x 68 cm, seu tampo é em Spruce Plywood, corpo em Maple Plywood, espelho e cravelhas em Hardwood, e braço em Maple. O estandarte é de Hardwood. Acompanha BAG, arco de Rosewood com crina animal e breu.", image: "violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png", thumbnails: ["violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png", "violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- cravelhas.png", "violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- parte superior.png"] },
            { id: 25, category: "violoncelo", title: "Violoncelo Cello Dasons Acabamento Brilho", price: 1744.95, description: "O Violoncelo Dasons CP105H está disponível nos tamanhos 3/4 e 4/4, com acabamento brilho. Possui corpo em Plywood, caixa das cravelhas e braço em Hardwood. Inclui arco, resina e afinadores finos, mas não acompanha estojo.", image: "violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png", thumbnails: ["violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png", "violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5- aaaa.png"] },
            { id: 26, category: "violoncelo", title: "Violoncelo Tarttan Série 100 Preto 4/4", price: 2297.00, description: "O Violoncelo Tarttan Série 100 é um modelo 4/4 na cor preta. Possui corpo em Plywood, caixa das cravelhas e braço em Ébano. Inclui estojo, arco e afinadores finos, mas não vem com resina.", image: "violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png", thumbnails: ["violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png"] },
            { id: 27, category: "violoncelo", title: "Violoncelo Rolim Gf-920 4/4", price: 2500.00, description: "O Violoncelo Rolim GF-920 é um modelo 4/4, ideal para estudantes avançados. Possui construção robusta e bom som.", image: "violoncelos/7 Violoncelo Rolim Gf-920 44/violoncelo7.png", thumbnails: ["violoncelos/7 Violoncelo Rolim Gf-920 44/violoncelo7.png"] },
            { id: 28, category: "violoncelo", title: "Violoncelo Eagle CE300 4/4", price: 2800.00, description: "O Violoncelo Eagle CE300 4/4 oferece excelente custo-benefício. Ideal para estudantes e músicos intermediários, com boa sonoridade.", image: "violoncelos/8 Violoncelo Eagle CE300 44/violoncelo8.png", thumbnails: ["violoncelos/8 Violoncelo Eagle CE300 44/violoncelo8.png"] },

            // Adicione mais categorias e produtos conforme necessário
            { id: 31, category: "violao", title: "Violão Acústico Folk Aço", price: 450.00, description: "Violão acústico tipo Folk com cordas de aço, ideal para iniciantes e estudo. Som claro e boa projeção.", image: "instrumentos/violao.png", thumbnails: ["instrumentos/violao.png"] },
            { id: 32, category: "violao", title: "Violão Eletroacústico Nylon", price: 600.00, description: "Violão eletroacústico com cordas de nylon, ótimo para música clássica e MPB. Possui captação para amplificação.", image: "instrumentos/violao_nylon.png", thumbnails: ["instrumentos/violao_nylon.png"] },
            { id: 33, category: "violao", title: "Violão Acústico Clássico", price: 380.00, description: "Violão clássico com cordas de nylon, ideal para estudo de música clássica.", image: "instrumentos/violao_classico.png", thumbnails: ["instrumentos/violao_classico.png"] },
            { id: 34, category: "violao", title: "Violão Di Giorgio Signorina", price: 950.00, description: "Violão Di Giorgio tradicional, som encorpado e ressonante.", image: "instrumentos/violao_digiorgio.png", thumbnails: ["instrumentos/violao_digiorgio.png"] },
            { id: 35, category: "violao", title: "Violão Tagima Dallas Acústico", price: 520.00, description: "Violão Tagima Dallas acústico, ideal para ritmos brasileiros.", image: "instrumentos/violao_tagima.png", thumbnails: ["instrumentos/violao_tagima.png"] },
            { id: 36, category: "violao", title: "Violão Rozini Classico Studio", price: 700.00, description: "Violão Rozini para estudo, excelente sonoridade e acabamento.", image: "instrumentos/violao_rozini.png", thumbnails: ["instrumentos/violao_rozini.png"] },
            { id: 37, category: "violao", title: "Violão Yamaha C40", price: 780.00, description: "Violão clássico Yamaha C40, um dos mais vendidos para iniciantes.", image: "instrumentos/violao_yamaha.png", thumbnails: ["instrumentos/violao_yamaha.png"] },
            { id: 38, category: "violao", title: "Violão Fender CD-60S", price: 850.00, description: "Violão folk Fender CD-60S, som equilibrado e boa tocabilidade.", image: "instrumentos/violao_fender.png", thumbnails: ["instrumentos/violao_fender.png"] },
        ];
let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let currentPage = 1;
        const productsPerPage = 8;
        let currentCategory = 'all'; // Pode ser 'all' ou uma categoria específica
        let currentSearchQuery = ''; // Armazena o termo de busca textual

        // Elementos da busca
        const searchInput = document.getElementById('search-input');
        const searchSuggestions = document.getElementById('search-suggestions');
        const productListDiv = document.getElementById('product-list'); // Renomeado para clareza

        // Sugestões pré-definidas (Categorias + alguns termos chave de produtos)
        // Certifique-se de que 'products' esteja definido e populado antes desta parte do código
        // Exemplo: const products = [ { id: 1, title: 'Violino Acústico', category: 'violino', ... }, ... ];
        const allCategories = [...new Set(products.map(p => p.category))];
        const searchSuggestionsList = [
            ...allCategories,
            "violino acústico",
            "guitarra elétrica",
            "violoncelo envelhecido",
            "violão folk",
            "violão nylon",
            "violino",
            "guitarra",
            "violoncelo",
            "violão"
        ].map(s => s.toLowerCase());

        // --- Funções do Carrinho ---

        // Atualiza a contagem total de itens no ícone do carrinho
        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById("cart-count").textContent = totalItems;
        }

        // Formata o preço para o padrão brasileiro (R$X.XX)
        function formatPrice(price) {
            return `R$${price.toFixed(2).replace('.', ',')}`;
        }

        // Calcula e atualiza o valor total do carrinho e do modal de PIX
        function calculateCartTotal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById("carrinho-total-valor").textContent = formatPrice(total);
            // Atualiza o valor também no modal de PIX, se estiver visível
            if (document.getElementById("pix-total-valor")) {
                document.getElementById("pix-total-valor").textContent = formatPrice(total);
            }
            return total;
        }

        // Salva o estado atual do carrinho no Local Storage do navegador
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        // Renderiza (desenha) todos os itens no carrinho lateral
        function renderCartItems() {
            const carrinhoItemsList = document.getElementById("carrinho-items");
            carrinhoItemsList.innerHTML = ""; // Limpa itens existentes

            if (cart.length === 0) {
                carrinhoItemsList.innerHTML = '<li style="text-align: center; color: #888; padding: 20px;">Seu carrinho está vazio.</li>';
            } else {
                cart.forEach(item => {
                    const listItem = document.createElement("li");
                    listItem.classList.add("carrinho-item");
                    listItem.innerHTML = `
                        <img src="${item.image}" alt="${item.title}">
                        <div class="carrinho-info">
                            <h4>${item.title}</h4>
                            <p>${formatPrice(item.price)}</p>
                            <div class="carrinho-quantidade">
                                <button onclick="updateQuantity(${item.id}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)">+</button>
                                <button style="background-color: #f44336; color: white;"onclick="removeItemFromCart(${item.id})">Remover</button>
                            </div>
                        </div>
                    `;
                    carrinhoItemsList.appendChild(listItem);
                });
            }
            updateCartCount();
            calculateCartTotal();
        }

        // Adiciona um item ao carrinho ou incrementa sua quantidade se já existir
        function addItemToCart(productId, quantity = 1) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ ...product, quantity });
            }
            saveCart();
            renderCartItems(); // Re-renderiza para atualizar a lista no carrinho lateral
            alert(`${product.title} adicionado ao carrinho!`);
        }

        // Adiciona o produto selecionado no modal de detalhes ao carrinho
        function addItemToCartFromModal() {
            // Certifique-se de que 'selectedProduct' está definido globalmente ou que o ID é recuperado corretamente
            // Assume que 'selectedProduct' é a variável global que armazena o produto do modal.
            if (selectedProduct) {
                addItemToCart(selectedProduct.id, 1);
                fecharModalDetalhes();
            }
        }

        // Atualiza a quantidade de um item específico no carrinho
        function updateQuantity(productId, change) {
            const item = cart.find(i => i.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    // Se a quantidade chegar a zero ou menos, remove o item
                    removeItemFromCart(productId);
                } else {
                    saveCart();
                    renderCartItems(); // Re-renderiza para mostrar a nova quantidade e total
                }
            }
        }

        // Remove um item completamente do carrinho
        function removeItemFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            saveCart();
            renderCartItems(); // Re-renderiza para remover o item da lista
        }

        // Limpa todos os itens do carrinho
        function clearCart() {
            if (confirm("Tem certeza que deseja limpar o carrinho?")) {
                cart = [];
                saveCart(); // Salva o carrinho vazio
                renderCartItems(); // Re-renderiza para mostrar o carrinho vazio
                alert("Carrinho limpo!");
            }
        }

        // Abre ou fecha o carrinho lateral
        function toggleCarrinho() {
            const carrinhoLateral = document.getElementById('carrinhoLateral');
            if (carrinhoLateral) {
                carrinhoLateral.classList.toggle('ativo');
                // Se o carrinho estiver ativo, re-renderiza os itens
                if (carrinhoLateral.classList.contains('ativo')) {
                    renderCartItems();
                }
            }
        }
        // --- Funções de Finalização de Compra (PIX) ---
function calculateCartTotal() {
    // Soma o preço de cada item multiplicado pela sua quantidade.
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // Atualiza o valor no carrinho lateral, se o elemento existir.
    const carrinhoTotalElement = document.getElementById("carrinho-total-valor");
    if (carrinhoTotalElement) {
        carrinhoTotalElement.textContent = formatPrice(total);
    }
    
    // Retorna o valor total para ser usado em outras funções.
    // O valor do modal do PIX será atualizado separadamente.
    return total;
}

/**
 * @function finalizarCompraPix
 * Inicia o processo de pagamento via PIX, exibindo o modal com QR Code e valor.
 * Também esvazia o carrinho, simulando a conclusão da compra.
 */
function finalizarCompraPix() {
    // Calcula o valor total do carrinho e armazena na variável 'total'.
    const total = calculateCartTotal();
    if (total === 0) {
        alert("Seu carrinho está vazio. Adicione itens antes de finalizar a compra.");
        return;
    }

    // Atualiza o valor no modal do PIX explicitamente ANTES de limpar o carrinho.
    document.getElementById("pix-total-valor").textContent = formatPrice(total);

    // Usa uma imagem genérica de QR Code, conforme solicitado.
    document.getElementById("pix-qr-code-img").src = "img/qr_code.png"; 
    
    // Exibe o modal adicionando a classe 'ativo'.
    document.getElementById("modalPixPagamento").classList.add("ativo");
    
    // Limpa o carrinho após "finalizar" a compra (simulado).
    clearCart(); 

    // Fecha o carrinho lateral, se a função 'toggleCarrinho' estiver definida.
    if (typeof toggleCarrinho === 'function') {
        toggleCarrinho(); 
    }
}

/**
 * @function fecharModalPix
 * Fecha o modal de pagamento PIX removendo a classe 'ativo'.
 */
function fecharModalPix() {
    document.getElementById("modalPixPagamento").classList.remove("ativo");
}

/**
 * @function getQueryParams
 * Função utilitária para obter os parâmetros da URL.
 * Adicionada conforme seu código de referência.
 */
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || "");
    });
    return params;
}


/**
 * @function getQueryParams
 * Função utilitária para obter os parâmetros da URL.
 * Adicionada conforme seu código de referência.
 */
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || "");
    });
    return params;
}


        // --- Funções de Utilitário e Inicialização ---

        // Pega os parâmetros da URL (usado para filtros de categoria/pesquisa)
        function getQueryParams() {
            const params = {};
            window.location.search.substring(1).split("&").forEach(param => {
                const [key, value] = param.split("=");
                params[decodeURIComponent(key)] = decodeURIComponent(value || "");
            });
            return params;
        }

        // Renderiza os produtos na página principal (filtrados e paginados)
        function renderProducts() {
            productListDiv.innerHTML = ''; // Limpa o conteúdo existente

            let filteredProducts = products;

            if (currentCategory !== 'all') {
                filteredProducts = filteredProducts.filter(p => p.category === currentCategory);
            }

            if (currentSearchQuery) {
                const query = currentSearchQuery.toLowerCase();
                filteredProducts = filteredProducts.filter(p =>
                    p.title.toLowerCase().includes(query) ||
                    p.description.toLowerCase().includes(query)
                );
            }

            const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;
            const paginatedProducts = filteredProducts.slice(start, end);

            if (paginatedProducts.length === 0) {
                productListDiv.innerHTML = '<p style="text-align: center; width: 100%; padding: 50px;">Nenhum produto encontrado para a sua busca ou categoria.</p>';
            } else {
                paginatedProducts.forEach(product => {
                    const productCard = document.createElement("div");
                    productCard.classList.add("instrumento-card");

                    productCard.innerHTML = `
                        <div class="card-image-container">
                            <img src="${product.image}" alt="${product.title}" />
                        </div>
                        <h4>${product.title}</h4>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p>${formatPrice(product.price)}</p>
                        <button class="btn-ver-detalhes" data-product-id="${product.id}">Ver Detalhes</button>
                    `;
                    productListDiv.appendChild(productCard);

                    const viewDetailsButton = productCard.querySelector('.btn-ver-detalhes');
                    if (viewDetailsButton) {
                        viewDetailsButton.addEventListener('click', () => {
                            showProductDetails(parseInt(viewDetailsButton.dataset.productId));
                        });
                    }

                    const cardElementsForDetails = productCard.querySelectorAll('img, h4');
                    cardElementsForDetails.forEach(el => {
                        el.addEventListener('click', () => showProductDetails(product.id));
                    });
                });
            }

            document.getElementById('page-info').textContent = `Página ${paginatedProducts.length > 0 ? currentPage : 0} de ${totalPages}`;
            document.getElementById('prev-page-btn').disabled = currentPage === 1 || paginatedProducts.length === 0;
            document.getElementById('next-page-btn').disabled = currentPage === totalPages || paginatedProducts.length === 0;

            const categoryTitle = document.getElementById('current-category-title');
            if (categoryTitle) {
                if (currentCategory === 'all') {
                    categoryTitle.textContent = currentSearchQuery ? `Resultados para "${currentSearchQuery}"` : 'Instrumentos';
                } else {
                    categoryTitle.textContent = currentCategory.charAt(0).toUpperCase() + currentCategory.slice(1);
                }
            }
        }

        // Filtra os produtos com base na categoria ou busca
        function filterProducts() {
            currentPage = 1;
            renderProducts();
        }

        // Configura o filtro de categorias
        function setupCategoryFilter() {
            const categoryFilter = document.getElementById('category-filter');
            // Certifique-se de que 'products' esteja definido
            const categories = ['all', ...new Set(products.map(p => p.category))];

            if (categoryFilter) {
                categoryFilter.innerHTML = '';

                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category === 'all' ? 'Todas as Categorias' : category.charAt(0).toUpperCase() + category.slice(1);
                    categoryFilter.appendChild(option);
                });

                categoryFilter.value = currentCategory;
                categoryFilter.addEventListener('change', (event) => {
                    currentCategory = event.target.value;
                    currentSearchQuery = '';
                    if (searchInput) searchInput.value = '';
                    hideSuggestions();
                    filterProducts();
                });
            }
        }

        // Configura a paginação
        function setupPagination() {
            document.getElementById('prev-page-btn').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderProducts();
                }
            });

            document.getElementById('next-page-btn').addEventListener('click', () => {
                let productsToCount = products;
                if (currentCategory !== 'all') {
                    productsToCount = productsToCount.filter(p => p.category === currentCategory);
                }
                if (currentSearchQuery) {
                    const query = currentSearchQuery.toLowerCase();
                    productsToCount = productsToCount.filter(p =>
                        p.title.toLowerCase().includes(query) ||
                        p.description.toLowerCase().includes(query)
                    );
                }
                const totalPages = Math.ceil(productsToCount.length / productsPerPage);

                if (currentPage < totalPages) {
                    currentPage++;
                    renderProducts();
                }
            });
        }

        let selectedProduct = null; // Variável para armazenar o produto selecionado para o modal de detalhes

        // Exibe o modal de detalhes do produto
        function showProductDetails(productId) {
            // Certifique-se de que 'products' está definido
            selectedProduct = products.find(p => p.id === productId);
            if (!selectedProduct) return;

            const modal = document.getElementById('modalDetalhesProduto');
            document.getElementById('modal-titulo').textContent = selectedProduct.title;
            document.getElementById('modal-preco').textContent = formatPrice(selectedProduct.price);
            document.getElementById('modal-descricao').textContent = selectedProduct.description;
            document.getElementById('modal-imagem-principal').src = selectedProduct.image;
            modal.dataset.productId = selectedProduct.id; // Armazena o ID no dataset do modal

            const thumbnailsContainer = document.getElementById('modal-thumbnails');
            thumbnailsContainer.innerHTML = '';
            if (selectedProduct.thumbnails && selectedProduct.thumbnails.length > 0) {
                selectedProduct.thumbnails.forEach(thumbnail => {
                    const img = document.createElement('img');
                    img.src = thumbnail;
                    img.alt = selectedProduct.title;
                    img.classList.add('thumbnail-image');
                    img.onclick = () => document.getElementById('modal-imagem-principal').src = thumbnail;
                    thumbnailsContainer.appendChild(img);
                });
            } else {
                // Se não houver miniaturas, usa a imagem principal como miniatura
                const img = document.createElement('img');
                img.src = selectedProduct.image;
                img.alt = selectedProduct.title;
                img.classList.add('thumbnail-image');
                img.onclick = () => document.getElementById('modal-imagem-principal').src = selectedProduct.image;
                thumbnailsContainer.appendChild(img);
            }

            modal.style.display = 'flex'; // Exibe o modal
        }

        // Fecha o modal de detalhes do produto
        function fecharModalDetalhes() {
            document.getElementById('modalDetalhesProduto').style.display = 'none';
            selectedProduct = null; // Limpa o produto selecionado
        }

        // Exibe as sugestões de busca
        function showSuggestions(query) {
            if (!searchInput || !searchSuggestions) return;
            searchSuggestions.innerHTML = '';
            if (!query) {
                hideSuggestions();
                return;
            }

            const lowerQuery = query.toLowerCase();
            const filteredSuggestions = searchSuggestionsList.filter(s => s.includes(lowerQuery));

            if (filteredSuggestions.length > 0) {
                filteredSuggestions.forEach(s => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.textContent = s.charAt(0).toUpperCase() + s.slice(1);
                    suggestionItem.addEventListener('click', () => {
                        searchInput.value = s.charAt(0).toUpperCase() + s.slice(1);
                        applySearchFilter(s);
                        hideSuggestions();
                    });
                    searchSuggestions.appendChild(suggestionItem);
                });
                searchSuggestions.style.display = 'block';
            } else {
                hideSuggestions();
            }
        }

        // Esconde as sugestões de busca
        function hideSuggestions() {
            if (searchSuggestions) searchSuggestions.style.display = 'none';
        }

        // Aplica o filtro de busca ou categoria
        function applySearchFilter(query) {
            const normalizedQuery = query.toLowerCase();
            const isCategory = allCategories.includes(normalizedQuery);

            if (isCategory) {
                currentCategory = normalizedQuery;
                currentSearchQuery = '';
            } else {
                currentCategory = 'all';
                currentSearchQuery = query;
            }
            currentPage = 1;
            setupCategoryFilter(); // Atualiza o seletor de categoria
            renderProducts();
        }

        // Event Listeners para a barra de busca
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                showSuggestions(searchInput.value.trim());
            });

            searchInput.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    applySearchFilter(searchInput.value.trim());
                    hideSuggestions();
                }
            });

            document.addEventListener('click', (event) => {
                if (searchInput && searchSuggestions && !searchInput.contains(event.target) && !searchSuggestions.contains(event.target)) {
                    hideSuggestions();
                }
            });
        }

        // Inicialização quando o DOM estiver completamente carregado
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            calculateCartTotal(); // Calcula o total inicial do carrinho

            const params = getQueryParams();
            if (params.categoria) {
                const categoryFromURL = decodeURIComponent(params.categoria).toLowerCase();
                if (allCategories.includes(categoryFromURL)) {
                    currentCategory = categoryFromURL;
                    if (searchInput) {
                        searchInput.value = categoryFromURL.charAt(0).toUpperCase() + categoryFromURL.slice(1);
                    }
                }
            } else if (params.pesquisa) {
                currentSearchQuery = decodeURIComponent(params.pesquisa);
                if (searchInput) {
                        searchInput.value = currentSearchQuery;
                }
            }

            setupCategoryFilter();
            setupPagination();
            renderProducts();
        });

        // catálogo dos instrumentos + carrinho + modal de produtos e modal do pix + filtragem por categoria papaizinho

