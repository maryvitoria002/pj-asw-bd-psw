/* ===== Dados dos produtos ===== */

// Ordem desejada dos instrumentos para as categorias
const INSTRUMENT_ORDER = [
    "violino", "viola", "violoncelo", "violao", "guitarra", "baixo",
    "cavaquinho", "ukulele", "viola_caipira", "banjo", "charango", "bandolim"
];

// Mapeamento de nomes de categorias para exibição
const CATEGORY_NAMES = {
    "todos": "Todos os Instrumentos",
    "violino": "Violinos",
    "viola": "Violas",
    "violoncelo": "Violoncelos",
    "violao": "Violões",
    "guitarra": "Guitarras",
    "baixo": "Baixos",
    "cavaquinho": "Cavaquinhos",
    "ukulele": "Ukuleles",
    "viola_caipira": "Violas Caipiras",
    "banjo": "Banjos",
    "charango": "Charangos",
    "bandolim": "Bandolins",
    "cordas-friccao": "Cordas (Fricção)",
    "cordas-dedilhadas": "Cordas (Dedilhadas)",
    "percussao": "Percussão",
    "sopro": "Sopro",
    "teclas": "Teclas",
    "acessorios": "Acessórios",
    "novidades": "Novidades",
    "promocoes": "Promoções",
    "usados": "Usados",
    "amplificadores": "Amplificadores",
    "pedais": "Pedais",
    "microfones": "Microfones",
    "outros": "Outros"
};

let products = [];
let currentId = 1; // Para garantir IDs únicos para todos os produtos

// Função para adicionar produtos a uma categoria até atingir o limite
function addProductsToCategory(category, count, existingProducts = []) {
    const categoryProducts = existingProducts.filter(p => p.category === category);
    if (categoryProducts.length < count) {
        for (let i = categoryProducts.length; i < count; i++) {
            let titlePrefix = CATEGORY_NAMES[category] ? CATEGORY_NAMES[category].slice(0, -1) : category; // Remove 's' do final se existir
            if (titlePrefix.endsWith("es")) titlePrefix = titlePrefix.slice(0, -2); // Ex: Violões -> Violão

            products.push({
                id: currentId++,
                category: category,
                title: `${titlePrefix} Modelo ${i + 1}`,
                price: `R$${(100 + i * 50).toFixed(2).replace('.', ',')}`, // Preço genérico
                description: `Este é um modelo genérico de ${titlePrefix.toLowerCase()} para demonstração.`,
                image: "placeholder.png", // <--- Você deve alterar isso para as imagens reais!
                thumbnails: ["placeholder.png"] // <--- E aqui para as miniaturas reais!
            });
        }
    }
}

// DADOS INICIAIS PERSONALIZADOS (Violinos, Violas, Violoncelos)
// Você deve adicionar seus outros 9 instrumentos aqui, seguindo o mesmo padrão!

// Dados iniciais de violinos (seus 8 já existentes)
products.push(
    {
        id: currentId++,
        category: "violino",
        title: "Violino Tarttan Série 100 Preto Brilho 4/4",
        price: "R$697,00",
        description: "Este violino Tarttan Série 100, importado da China, é um 4/4 com acabamento preto brilhante. Fabricado com madeira laminada, é ajustado por luthier e vem com estandarte de 4 micro afinadores. Inclui arco, breu e estojo preto.",
        image: "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png",
        thumbnails: [
            "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png",
            "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-verso.png",
            "violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-case.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Acústico 4/4",
        price: "R$299,99",
        description: "Este violino acústico 4/4 da marca Mix, na cor marrom, possui corpo em MDF tanto na parte superior quanto na traseira. Suas dimensões são 70 x 30 x 70 cm e vem completo com arco, breu, cavalete e um luxuoso estojo.",
        image: "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png",
        thumbnails: [
            "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png",
            "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- pessoas.jpg",
            "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- completo.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Alan 4/4 Al-1410 Completo",
        price: "R$391,00",
        description: "O Violino Alan AL-1410 é um modelo 4/4 completo na cor Sunburst. Com tampo em Spruce (revestido), traseira e lateral em Maple, cravelhas, queixeira e estandarte em Boxwood, e escala em Maple. Inclui 4 micro afinadores, filetes entalhados, estojo térmico de luxo e arco de crina sintética de 75 cm. Suas dimensões são 60 x 21 x 4 cm.",
        image: "violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png",
        thumbnails: [
            "violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png",
            "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- case.png",
            "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- com case.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Dominante 9649 3/4",
        price: "R$439,00",
        description: "Este violino acústico Dominante 9649, tamanho 3/4, apresenta acabamento brilhante na cor natural. Não é para canhotos. O corpo é feito de Spruce e o diapasão de Ébano. Acompanha arco e estojo.",
        image: "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png",
        thumbnails: [
            "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png",
            "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- dentro da case.png",
            "violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- detalhes.jpg"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Tarttan Série 100 Natural 4/4 com Case",
        price: "R$697,00",
        description: "O Violino Tarttan Série 100 da marca Xenox é um modelo 4/4 natural, com acabamento em verniz. Possui tampo de Ácer e parte traseira em madeira compensada. Acompanha case.",
        image: "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png",
        thumbnails: [
            "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png",
            "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- interior.jpg",
            "violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- parte inferior.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Eagle VE441 Classic Series 4/4",
        price: "R$1.140,00",
        description: "O Violino Eagle VE441 Classic Series da marca TMZUAMOZ é um modelo 4/4 na cor natural. Possui tampo de Abeto. Suas dimensões são 80 x 30 x 20 cm.",
        image: "violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png",
        thumbnails: [
            "violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png",
            "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- dentro da case.png",
            "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- frente e verso.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Vogga VON144N 4/4",
        price: "R$439,00",
        description: "O Violino Vogga VON144N é um modelo 4/4 na cor Natural Fosco, de origem chinesa. Possui tampo em Spruce. Suas dimensões são 80 x 26 x 11 cm.",
        image: "violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png",
        thumbnails: [
            "violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png",
            "violinos/7 VIOLINO VOGGA VON144N 44/violino7- frente.png",
            "violinos/7 VIOLINO VOGGA VON144N 44/violino7- verso.png"
        ]
    },
    {
        id: currentId++,
        category: "violino",
        title: "Violino Vivace Strauss 4/4 Fosco",
        price: "R$1.799,00",
        description: "O Violino Vivace Strauss é um modelo 4/4 com acabamento fosco. Possui tampo de Abeto e parte traseira de madeira de bordo. Acompanha case térmico.",
        image: "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png",
        thumbnails: [
            "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png",
            "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- frente.png",
            "violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- verso.png"
        ]
    }
);

// Dados iniciais de violas (seus 8 já existentes)
products.push(
    {
        id: currentId++,
        category: "viola",
        title: "Viola De Arco Rolim Milor 40cm Serie Especial ",
        price: "R$2.687,90",
        description: "A Viola de Arco Rolim Milor é um modelo acústico de 40 cm, para destros, com acabamento brilhante e 4 cordas. Inclui como acessórios: arco de crina genuína, breu e estojo.",
        image: "violas/1 Viola De Arco Rolim Milor/viola1- frente e verso.png",
        thumbnails: [
            "violas/1 Viola De Arco Rolim Milor/viola1- frente e verso.png",
            "violas/1 Viola De Arco Rolim Milor/viola1-.png",
            "violas/1 Viola De Arco Rolim Milor/viola1- case.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola Clássica de Arco Alan AL 1310 4/4",
        price: "R$647,00",
        description: "Esta viola clássica de arco Alan, tamanho 4/4, na cor madeira, possui dimensões de 66 x 23 x 4,5 cm. Seu tampo é revestido em Spruce, enquanto a traseira e as laterais são em Maple. Conta com cravelhas, queixeira e estandarte em Boxwood, escala em Maple, e 4 micro afinadores metálicos. Os filetes são entalhados, e o instrumento vem com um luxuoso estojo térmico, arco de crina sintética de 75 cm, breu e cavalete.",
        image: "violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2.png",
        thumbnails: [
            "violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2.png",
            "violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2- completa.png",
            "violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2- case.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola de Arco Profissional Stradivarius",
        price: "R$5.999,00",
        description: "A Viola de Arco Profissional Stradivarius, da marca 'Viola Chinesa Harmonizada', é um modelo acústico para destros.",
        image: "violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- frente e verso.png",
        thumbnails: [
            "violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- frente e verso.png",
            "violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- cavalete.jpg",
            "violas/3 Viola De Arco Profissional STRADIVARIUS/viola3.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola de Arco 4/4 VA150 Envernizado EAGLE",
        price: "R$1.279,00",
        description: "A Viola de Arco Eagle VA150 é um modelo 4/4 com dimensões de 13 x 31 x 86 cm. Possui tampo em Maple e parte traseira em Ébano e Maple, com acabamento envernizado.",
        image: "violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- frente.png",
        thumbnails: [
            "violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- frente.png",
            "violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- verso.png",
            "violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- dentro da case.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola Clássica Envelhecida Alan AL 1310 3/4 E",
        price: "R$660,00",
        description: "A Viola Clássica Envelhecida Alan AL 1310 3/4 E apresenta um acabamento marrom fosco envelhecido. Com dimensões de 88 x 36 x 16 cm, seu tampo é feito de Plywood e as cordas são de aço inoxidável.",
        image: "violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- completa.png",
        thumbnails: [
            "violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- completa.png",
            "violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- verso.png",
            "violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- inclinada.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola Antoni Marsale Série YA320 40,5cm 16",
        price: "R$2.297,00",
        description: "A Viola Antoni Marsale série YA320, de 40,5 cm (16 polegadas), é feita de madeiras maciças (Acero e Abeto) e possui 4 cordas. É ajustada por luthier, vem com estandarte com micro afinador na corda Lá, e acompanha breu, estojo e arco.",
        image: "violas/6 Viola Antoni Marsale série YA320/viola6- frente e verso.png",
        thumbnails: [
            "violas/6 Viola Antoni Marsale série YA320/viola6- frente e verso.png",
            "violas/6 Viola Antoni Marsale série YA320/viola6- voluta e cravelhas.png",
            "violas/6 Viola Antoni Marsale série YA320/viola6- dentro da case.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola Antoni Marsale Série YA400 Stradivari 42 cm 16,5 Gold",
        price: "R$2.997,00",
        description: "A Viola Antoni Marsale série YA400 Stradivari, de 42 cm (16,5 polegadas), é um instrumento indicado para violistas intermediários e avançados. Seu tampo é feito de Abeto, e o fundo e laterais em Acero de excelente seleção com marezzatura média. Os acessórios e o espelho são de Ébano. Acompanha case retangular e um lindo arco octogonal.",
        image: "violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- frente e verso.png",
        thumbnails: [
            "violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- frente e verso.png",
            "violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- case.png",
            "violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- superior.png"
        ]
    },
    {
        id: currentId++,
        category: "viola",
        title: "Viola de Arco Antoni Marsale Série YA110 40,5cm 16",
        price: "R$1.397,00",
        description: "A Viola de Arco Antoni Marsale Série YA110, de 40,5 cm (16 polegadas), na cor laranja-claro, é um modelo acústico Stradivari para destros. Possui 4 cordas e acabamento brilhante.",
        image: "violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- frente e verso.png",
        thumbnails: [
            "violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- frente e verso.png",
            "violas//8 Viola De Arco Antoni Marsale Série Ya110/viola8- voluta e cravelhas.png",
            "violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- case.png"
        ]
    }
);

// Dados iniciais de violoncelos (seus 8 já existentes)
products.push(
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo AL 1210 44 Alan Com Capa Arco Breu",
        price: "R$1.500,00",
        description: "Este violoncelo Alan AL 1210 4/4, na cor marrom avermelhada, mede 123 x 46 x 14 cm. Possui tampo laminado em Spruce, traseira e laterais em Linden, e acabamento em verniz sintético. Conta com cravelhas em Maple, estandarte em Boxwood, 4 micro afinadores metálicos e filetes entalhados. Acompanha arco de crina sintética de 72 cm, capa e breu.",
        image: "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png",
        thumbnails: [
            "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png",
            "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- verso.png",
            "violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- com case.png"
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu",
        price: "R$1.836,10",
        description: "O Violoncelo Envelhecido Alan AL 1210 4/4 E apresenta um acabamento marrom fosco envelhecido. Suas dimensões aproximadas são 133 x 51 x 33 cm, com tampo em Plywood. Acompanha capa, arco e breu.",
        image: "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png",
        thumbnails: [
            "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png",
            "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- verso.png",
            "violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- com case.png"
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "VIOLONCELO VOGGA VOC144N 44",
        price: "R$2.308,90",
        description: "O Violoncelo Vogga VOC144N é um modelo 4/4 na cor Natural Fosco. Suas dimensões são 140 x 33 x 52 cm e possui tampo em Abeto.",
        image: "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png",
        thumbnails: [
            "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png",
            "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- verso.png",
            "violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- case.png"
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello",
        price: "R$1.900,00",
        description: "O Violoncelo Vivace CMO44 Mozart, tamanho 4/4, na cor natural, possui acabamento brilhante. Com dimensões de 14 x 24 x 68 cm, seu tampo é em Spruce Plywood, corpo em Maple Plywood, espelho e cravelhas em Hardwood, e braço em Maple. O estandarte é de Hardwood. Acompanha BAG, arco de Rosewood com crina animal e breu.",
        image: "violoncelos//4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png",
        thumbnails: [
            "violoncelos//4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png",
            "violoncelos//4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- cravelhas.png",
            "violoncelos//4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- parte superior.png"
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo Cello Dasons Acabamento Brilho",
        price: "R$1.744,95",
        description: "O Violoncelo Dasons CP105H está disponível nos tamanhos 3/4 e 4/4, com acabamento brilho. Possui corpo em Plywood, caixa das cravelhas e braço em Hardwood. Inclui arco, resina e afinadores finos, mas não acompanha estojo.",
        image: "violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png",
        thumbnails: [
            "violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png",
            "violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5- aaaa.png",
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo Tarttan Série 100 Preto 4/4",
        price: "R$2.297,00",
        description: "O Violoncelo Tarttan Série 100 é um modelo 4/4 na cor preta. Possui corpo em Plywood, caixa das cravelhas e braço em Ébano. Inclui estojo, arco e afinadores finos, mas não vem com resina.",
        image: "violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png",
        thumbnails: [
            "violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png",
            "violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6- cravelhas.png",
            "violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6- microafinadores.png",
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo Dasons Com Com Arco Capa E Breu",
        price: "R$1.738,45",
        description: "Este Violoncelo Dasons modelo CG001L possui corpo feito de Hardwood. Ele vem completo com arco, capa e breu.",
        image: "violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7.png",
        thumbnails: [
            "violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7.png",
            "violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7- verso.png",
            "violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7- case.png"
        ]
    },
    {
        id: currentId++,
        category: "violoncelo",
        title: "Violoncelo Michael VOM40 4/4 Tradicional",
        price: "R$3.394,70",
        description: "O Violoncelo Michael VOM40 é um modelo 4/4 completo com acabamento tradicional. É ideal para músicos avançados.",
        image: "violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo.png",
        thumbnails: [
            "violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo.png",
            "violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo8- cravelhas.png",
            "violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo8- case.png"
        ]
    }
);

// Adicionando ou completando produtos para cada categoria até 8
// ESTE LOOP IRÁ ADICIONAR PRODUTOS GENÉRICOS (COM "placeholder.png") PARA AS CATEGORIAS QUE NÃO TÊM 8 PRODUTOS DEFINIDOS ACIMA.
// Você deve adicionar os blocos `products.push` acima para cada instrumento que quiser personalizar!
INSTRUMENT_ORDER.forEach(instrument => {
    addProductsToCategory(instrument, 8, products);
});

// Ordenar todos os produtos de acordo com INSTRUMENT_ORDER e depois por ID
products.sort((a, b) => {
    const indexA = INSTRUMENT_ORDER.indexOf(a.category);
    const indexB = INSTRUMENT_ORDER.indexOf(b.category);
    if (indexA !== indexB) {
        return indexA - indexB;
    }
    return a.id - b.id; // Mantém a ordem original dentro da categoria
});


// CARRINHO: Agora armazena objetos { item: produto, quantidade: N }
let carrinho = [];

/* ===== Paginação e renderização (Adaptado para Categorias) ===== */

const productsPerPage = 8;
let currentPage = 1;
let currentCategory = "todos"; // Nova variável para a categoria atual
let filteredProducts = []; // Array para produtos filtrados

const productListEl = document.getElementById("product-list");
const paginationEl = document.getElementById("pagination");
const currentCategoryDisplayEl = document.getElementById("current-category-display");

// Função para filtrar produtos com base na categoria
function filterProductsByCategory(category) {
    if (category === "todos") {
        // Se for "todos", inclui os instrumentos da INSTRUMENT_ORDER e mantém a ordem
        filteredProducts = products.filter(p => INSTRUMENT_ORDER.includes(p.category));
    } else {
        filteredProducts = products.filter(product => product.category === category);
    }
    currentCategory = category;
    currentPage = 1; // Volta para a primeira página ao mudar de categoria
    update();
}

function renderProducts(page) {
    productListEl.innerHTML = "";

    const start = (page - 1) * productsPerPage;
    const end = start + productsPerPage;
    const paginatedProducts = filteredProducts.slice(start, end); // Usa produtos filtrados

    paginatedProducts.forEach(product => {
        const card = document.createElement("div");
        card.className = "instrumento-card";

        card.innerHTML = `
            <div class="card-image-container">
                <img src="${product.image}" alt="${product.title}">
            </div>
            <h4>${product.title}</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>${product.price}</p>
            <button class="ver-detalhes-btn" data-id="${product.id}">Ver detalhes</button>
        `;

        productListEl.appendChild(card);
    });

    setupDetailButtons();
}

function renderPagination() {
    paginationEl.innerHTML = "";

    const pageCount = Math.ceil(filteredProducts.length / productsPerPage); // Baseado em produtos filtrados

    // Botão "Anterior"
    const prevBtn = document.createElement("span");
    prevBtn.textContent = "«";
    prevBtn.className = "prev-btn";
    prevBtn.style.cursor = currentPage === 1 ? "not-allowed" : "pointer";
    prevBtn.style.color = currentPage === 1 ? "#aaa" : "#f7bd6d";
    prevBtn.addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            update();
        }
    });
    paginationEl.appendChild(prevBtn);

    // Exibir botões de página (simplificado, todos)
    for (let i = 1; i <= pageCount; i++) {
        const pageBtn = document.createElement("span");
        pageBtn.textContent = i;
        pageBtn.className = i === currentPage ? "active" : "";
        pageBtn.addEventListener("click", () => {
            if (i !== currentPage) {
                currentPage = i;
                update();
            }
        });
        paginationEl.appendChild(pageBtn);
    }

    // Botão "Próximo"
    const nextBtn = document.createElement("span");
    nextBtn.textContent = "»";
    nextBtn.className = "next-btn";
    nextBtn.style.cursor = currentPage === pageCount ? "not-allowed" : "pointer";
    nextBtn.style.color = currentPage === pageCount ? "#aaa" : "#f7bd6d";
    nextBtn.addEventListener("click", () => {
        if (currentPage < pageCount) {
            currentPage++;
            update();
        }
    });
    paginationEl.appendChild(nextBtn);
}

function update() {
    renderProducts(currentPage);
    renderPagination();
    // Atualiza o texto da categoria sendo exibida
    currentCategoryDisplayEl.textContent = `Mostrando: ${CATEGORY_NAMES[currentCategory] || currentCategory}`;

    // Remove a classe 'active' de todos os botões de categoria e adiciona ao ativo
    document.querySelectorAll('.category-button').forEach(button => {
        button.classList.remove('active');
    });
    const activeButton = document.querySelector(`.category-button[data-category="${currentCategory}"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

/* ===== Modal Detalhes ===== */

const modal = document.getElementById("modal");
const modalClose = document.getElementById("modal-close");
const modalMainImage = document.getElementById("modal-main-image");
const modalThumbnails = document.getElementById("modal-thumbnails");
const modalTitle = document.getElementById("modal-title");
const modalPrice = document.getElementById("modal-price");
const modalDescription = document.getElementById("modal-description");
const quantityInput = document.getElementById("quantity");
const buyBtn = document.getElementById("buy-btn");

let currentModalProduct = null;

// Função para configurar os botões de detalhes após a renderização dos produtos
function setupDetailButtons() {
    const buttons = document.querySelectorAll(".ver-detalhes-btn");
    buttons.forEach(btn => {
        btn.onclick = () => {
            const id = parseInt(btn.getAttribute("data-id"));
            currentModalProduct = products.find(p => p.id === id);
            openModal();
        };
    });
}

function openModal() {
    if (!currentModalProduct) return;

    modalTitle.textContent = currentModalProduct.title;
    modalPrice.textContent = currentModalProduct.price;
    modalDescription.textContent = currentModalProduct.description;
    quantityInput.value = 1; // Reseta a quantidade para 1 no modal

    // Imagem principal
    modalMainImage.src = currentModalProduct.image;
    modalMainImage.alt = currentModalProduct.title;

    // Thumbnails
    modalThumbnails.innerHTML = "";
    currentModalProduct.thumbnails.forEach((thumb, index) => {
        const img = document.createElement("img");
        img.src = thumb;
        img.alt = currentModalProduct.title + " - imagem " + (index + 1);
        if(index === 0) img.classList.add("active"); // Define a primeira thumbnail como ativa

        img.onclick = () => {
            document.querySelectorAll("#modal-thumbnails img").forEach(im => im.classList.remove("active"));
            img.classList.add("active");
            modalMainImage.src = thumb;
        };

        modalThumbnails.appendChild(img);
    });

    modal.classList.add("active");
}

modalClose.onclick = () => {
    modal.classList.remove("active");
};

modal.onclick = (e) => {
    if(e.target === modal){
        modal.classList.remove("active");
    }
};

// BUY BUTTON NO MODAL AGORA ADICIONA AO CARRINHO
buyBtn.onclick = () => {
    const quantity = parseInt(quantityInput.value);
    if (quantity < 1 || isNaN(quantity)) {
        alert("Quantidade inválida. Por favor, insira um número maior que zero.");
        quantityInput.focus();
        return;
    }

    adicionarAoCarrinho(currentModalProduct, quantity);

    modal.classList.remove("active");
};

/* =================================
FUNÇÕES DO CARRINHO DE COMPRAS (MUITO MODIFICADAS)
================================= */
const listaCarrinhoEl = document.getElementById('lista-carrinho');
const totalCarrinhoEl = document.getElementById('total-carrinho');
const cartCountEl = document.getElementById('cart-count');
const cartPaymentMethodSelect = document.getElementById('cart-payment-method');


function toggleCarrinho() {
    document.getElementById('carrinho').classList.toggle('ativo');
    if (document.getElementById('carrinho').classList.contains('ativo')) {
        atualizarCarrinho(); // Garante que o carrinho esteja atualizado ao abrir
    }
}

function adicionarAoCarrinho(produto, quantidade) {
    const itemExistente = carrinho.find(item => item.product.id === produto.id);

    if (itemExistente) {
        itemExistente.quantidade += quantidade;
    } else {
        carrinho.push({ product: produto, quantidade: quantidade });
    }
    atualizarCarrinho();
    alert(`${quantidade}x "${produto.title}" adicionado(s) ao carrinho!`);
}

function removerDoCarrinho(productId) {
    carrinho = carrinho.filter(item => item.product.id !== productId);
    atualizarCarrinho();
}

function aumentarQuantidade(productId) {
    const item = carrinho.find(item => item.product.id === productId);
    if (item) {
        item.quantidade++;
        atualizarCarrinho();
    }
}

function diminuirQuantidade(productId) {
    const item = carrinho.find(item => item.product.id === productId);
    if (item) {
        item.quantidade--;
        if (item.quantidade <= 0) {
            removerDoCarrinho(productId); // Remove se a quantidade for 0 ou menos
        } else {
            atualizarCarrinho();
        }
    }
}

function limparCarrinho() {
    if (confirm("Tem certeza que deseja remover todos os itens do carrinho?")) {
        carrinho = [];
        atualizarCarrinho();
        alert("Carrinho esvaziado!");
    }
}

function atualizarCarrinho() {
    cartCountEl.innerText = carrinho.reduce((total, item) => total + item.quantidade, 0); // Soma todas as quantidades

    if (carrinho.length === 0) {
        listaCarrinhoEl.innerHTML = '<li class="carrinho-vazio">Seu carrinho está vazio.</li>';
        totalCarrinhoEl.innerText = '0,00';
        cartPaymentMethodSelect.value = ""; // Limpa a seleção de pagamento
        return;
    }

    listaCarrinhoEl.innerHTML = ''; // Limpa a lista antes de recriar

    let total = 0;
    carrinho.forEach(itemCarrinho => {
        const produto = itemCarrinho.product;
        const quantidade = itemCarrinho.quantidade;

        // Converte o preço de string "R$1.799,00" para número 1799.00
        const precoNumerico = parseFloat(produto.price.replace('R$', '').replace('.', '').replace(',', '.'));
        total += precoNumerico * quantidade;

        const li = document.createElement('li');
        li.className = 'carrinho-item';
        li.innerHTML = `
            <img src="${produto.image}" alt="${produto.title}">
            <div class="carrinho-item-info">
                <h4>${produto.title}</h4>
                <p>R$ ${precoNumerico.toFixed(2).replace('.', ',')} x ${quantidade}</p>
                <div class="carrinho-item-controls">
                    <button onclick="diminuirQuantidade(${produto.id})">-</button>
                    <span class="quantity-display">${quantidade}</span>
                    <button onclick="aumentarQuantidade(${produto.id})">+</button>
                    <button class="remover-item-btn" onclick="removerDoCarrinho(${produto.id})">Remover</button>
                </div>
            </div>
        `;
        listaCarrinhoEl.appendChild(li);
    });

    totalCarrinhoEl.innerText = total.toFixed(2).replace('.', ',');
}

function finalizarCompra() {
    if (carrinho.length === 0) {
        alert("Seu carrinho está vazio!");
        return;
    }

    const selectedPaymentMethod = cartPaymentMethodSelect.value;
    if (!selectedPaymentMethod) {
        alert("Por favor, selecione a forma de pagamento.");
        cartPaymentMethodSelect.focus();
        return;
    }

    const total = carrinho.reduce((acc, item) => {
        const preco = parseFloat(item.product.price.replace('R$', '').replace('.', '').replace(',', '.'));
        return acc + (preco * item.quantidade);
    }, 0);

    const itensComprados = carrinho.map(item => `${item.quantidade}x ${item.product.title}`).join('\n');

    alert(`Compra finalizada!\n\nItens:\n${itensComprados}\n\nValor total: R$ ${total.toFixed(2).replace('.', ',')}\nForma de Pagamento: ${selectedPaymentMethod.charAt(0).toUpperCase() + selectedPaymentMethod.slice(1)}\n\nObrigado por comprar na MusicWave!`);

    carrinho = []; // Esvazia o carrinho
    atualizarCarrinho(); // Atualiza a exibição
    toggleCarrinho(); // Fecha o painel do carrinho
}

/* ===== Afinador Lateral (Mantido) ===== */
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
    banjo: "Com seu som ressonante e percussivo, o Banjo, frequentemente com 5 cordas e afinação aberta, é a alma do bluegrass e de outros gêneros folcláricos, criando melodias cativantes.",
    charango: "Um instrumento de cordas andino, o Charango, com suas 10 cordas agrupadas em cinco pares, encanta com seu som agudo e vibrante, ideal para melodias folclóricas.",
    bandolim: "Com seu som brilhante e percussivo, o Bandolim, tipicamente com 8 cordas em quatro pares afinados em G-D-A-E, adiciona um toque especial a diversos estilos, do folk ao choro.",
};

const imagens = {
    violino: "instrumentos/violin6.png",
    viola: "instrumentos/viola4.png",
    violoncelo: "instrumentos/celo2.png",
    violao: "instrumentos/violao.png", // Imagem de exemplo para violão
    guitarra: "instrumentos/guitarra1.png",
    baixo: "instrumentos/baixo.png", // Imagem de exemplo para baixo
    cavaquinho: "instrumentos/cavaquinho.png", // Imagem de exemplo para cavaquinho
    ukulele: "instrumentos/ukulele8.png",
    viola_caipira: "instrumentos/viola_caipira.png", // Imagem de exemplo para viola caipira
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

function abrirAfinador() {
    document.getElementById("afinadorLateral").classList.add("ativo");
    localStorage.setItem("afinadorAberto", "true");
}

function fecharAfinador() {
    document.getElementById("afinadorLateral").classList.remove("ativo");
    localStorage.setItem("afinadorAberto", "false");
}

/* ===== Inicialização e Event Listeners ===== */

window.addEventListener("DOMContentLoaded", () => {
    carregarCordas();
    if (localStorage.getItem("afinadorAberto") === "true") abrirAfinador();

    // Adiciona event listeners para os botões de categoria
    document.querySelectorAll(".category-button").forEach(button => {
        button.addEventListener("click", (event) => {
            const category = event.target.dataset.category;
            filterProductsByCategory(category);
        });
    });

    // Adiciona event listeners para os links de categoria no dropdown "Loja"
    // (Se você tiver um dropdown "Loja" no seu HTML que não foi incluído no último HTML completo)
    document.querySelectorAll(".dropdown-content .category-link").forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault(); // Impede o comportamento padrão do link
            const category = event.target.dataset.category;
            filterProductsByCategory(category);
            // Opcional: fechar o dropdown após a seleção
            const dropdown = event.target.closest('.dropdown');
            if (dropdown) {
                dropdown.classList.remove('active');
            }
        });
    });

    // Filtra e renderiza os produtos iniciais (todos)
    filterProductsByCategory("todos");
    atualizarCarrinho(); // Garante que o carrinho esteja vazio/correto na inicialização
});