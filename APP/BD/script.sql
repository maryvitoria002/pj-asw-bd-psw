-- Trabalho Interdisciplinar - Banco de Dados
-- Alunos: Anna Lívia, Álvaro, Ellis, Lorrani, Sabrina e Vinícius
-- Turma: 2AII
-- Título do projeto: MusicWave

DROP DATABASE projeto;
CREATE DATABASE projeto;
USE projeto;

-- ==========================
-- TABELA CLIENTE / USUARIO
-- ==========================
CREATE TABLE ClienteUsuario (
    cpf CHAR(11) PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    rg VARCHAR(15),
    email VARCHAR(45) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    data_cadastro DATE NOT NULL
);
-- select * from ClienteUsuario;

-- ==========================
-- TABELA PRODUTO
-- ==========================
CREATE TABLE Produto (
    idproduto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL,
    imagem VARCHAR(255), -- URL ou caminho da imagem
    marca VARCHAR(45),
    descricao VARCHAR(300) default null
);

-- ==========================
-- TABELA PEDIDO
-- ==========================
CREATE TABLE Pedido (
    idpedido INT AUTO_INCREMENT PRIMARY KEY,
    datapedido DATE NOT NULL,
    dataentrega DATE,
    total DECIMAL(10,2),
    status VARCHAR(45) NOT NULL,
    cliente_cpf CHAR(11) NOT NULL,
    CONSTRAINT fk_pedido_cliente FOREIGN KEY (cliente_cpf) REFERENCES ClienteUsuario(cpf)
);

-- ==========================
-- TABELA PAGAMENTO
-- ==========================
CREATE TABLE Pagamento (
    idpagamento INT AUTO_INCREMENT PRIMARY KEY,
    data_retirada DATE,
    forma_pagamento VARCHAR(15) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    comprovante VARCHAR(255), -- caminho do comprovante
    pedido_idpedido INT NOT NULL,
    cliente_cpf CHAR(11) NOT NULL,
    CONSTRAINT fk_pagamento_pedido FOREIGN KEY (pedido_idpedido) REFERENCES Pedido(idpedido),
    CONSTRAINT fk_pagamento_cliente FOREIGN KEY (cliente_cpf) REFERENCES ClienteUsuario(cpf)
);

-- ==========================
-- TABELA ITEMPEDIDO (Associativa)
-- ==========================
CREATE TABLE ItemPedido (
    produto_idproduto INT NOT NULL,
    pedido_idpedido INT NOT NULL,
    quantidade INT NOT NULL,
    precounitario DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (produto_idproduto, pedido_idpedido),
    CONSTRAINT fk_itempedido_produto FOREIGN KEY (produto_idproduto) REFERENCES Produto(idproduto),
    CONSTRAINT fk_itempedido_pedido FOREIGN KEY (pedido_idpedido) REFERENCES Pedido(idpedido)
);

-- ==========================
-- TABELA CARRINHO
-- ==========================
CREATE TABLE Carrinho (
    idcarrinho INT AUTO_INCREMENT PRIMARY KEY,
    cliente_cpf CHAR(11) NOT NULL,
    CONSTRAINT fk_carrinho_cliente FOREIGN KEY (cliente_cpf) REFERENCES ClienteUsuario(cpf)
);

-- ==========================
-- TABELA CARRINHOITEM (Associativa)
-- ==========================
CREATE TABLE CarrinhoItem (
    produto_idproduto INT NOT NULL,
    carrinho_idcarrinho INT NOT NULL,
    quantidade INT NOT NULL,
    PRIMARY KEY (produto_idproduto, carrinho_idcarrinho),
    CONSTRAINT fk_carrinhoitem_produto FOREIGN KEY (produto_idproduto) REFERENCES Produto(idproduto),
    CONSTRAINT fk_carrinhoitem_carrinho FOREIGN KEY (carrinho_idcarrinho) REFERENCES Carrinho(idcarrinho)
);

-- ==========================
-- INSERÇÕES COMPLETAS
-- ==========================

-- Produtos
INSERT INTO Produto (nome, preco, estoque, marca) VALUES
('Violino Acústico 4/4 Arco Breu Cavalete MDF Estojo Luxo', 899.90, 5, 'Generic'),
('Violino Alan 4/4 AL-1410 Completo', 1299.00, 3, 'Alan'),
('Violino Dominante 9649 3/4 Natural', 749.00, 2, 'Dominante'),
('Violino Tarttan Série 100 Natural 4/4', 560.00, 6, 'Tarttan'),
('Violino Tarttan Série 100 Preto Brilho 4/4', 560.00, 4, 'Tarttan'),
('Violino Eagle VE441 Classic Series 4/4', 1100.00, 2, 'Eagle'),
('Violino Vogga VON144N 4/4', 699.00, 7, 'Vogga'),
('Violino Vivace Strauss 4/4 Fosco', 650.00, 9, 'Vivace'),

('Viola Clássica AL 1310 4/4 Alan', 999.00, 4, 'Alan'),
('Viola Profissional Stradivarius', 4500.00, 1, 'Stradivarius'),
('Viola VA150 4/4 Envernizado Eagle', 1200.00, 3, 'Eagle'),
('Viola Clássica AL 1310 3/4 Envelhecida Alan', 950.00, 2, 'Alan'),
('Viola Antoni Marsale YA320', 850.00, 3, 'Antoni'),
('Viola Antoni Marsale YA400 Stradivari', 1500.00, 1, 'Antoni'),
('Viola Antoni Marsale YA110', 700.00, 5, 'Antoni'),
('Viola Rolim Milor 40cm', 480.00, 6, 'Rolim'),

('Violoncelo AL 1210 4/4 Alan', 3200.00, 2, 'Alan'),
('Violoncelo AL 1210 4/4 Envelhecido Alan', 3500.00, 1, 'Alan'),
('Violoncelo Vogga VOC144N 4/4', 2100.00, 2, 'Vogga'),
('Violoncelo Vivace CMO44 Mozart 4/4', 2300.00, 2, 'Vivace'),
('Violoncelo Dasons CP105H', 1400.00, 4, 'Dasons'),
('Violoncelo Tarttan Série 100 Preto 4/4', 1250.00, 3, 'Tarttan'),
('Violoncelo Dasons CG001L', 1300.00, 3, 'Dasons'),
('Violoncelo Michael VOM40 4/4', 1800.00, 2, 'Michael'),

('Contrabaixo Waldman MB-100 (4 cordas)', 4200.00, 1, 'Waldman'),
('Baixo Yamaha TRBX305 (5 cordas)', 3200.00, 2, 'Yamaha'),
('Baixo Tagima TW65 Woodstock Precision', 1800.00, 4, 'Tagima'),
('Contrabaixo Waldman GJJ-105 BK (5 cordas)', 4500.00, 1, 'Waldman'),
('Baixo Giannini GB205A (5 cordas)', 2100.00, 3, 'Giannini'),
('Baixo Strinberg SAB66 (6 cordas)', 1600.00, 5, 'Strinberg'),
('Baixo Tagima Custom Millenium Top (4 cordas)', 2800.00, 2, 'Tagima'),
('Baixo Fender Squier Affinity Precision PJ Pack', 1500.00, 3, 'Fender'),

('Bandolim Marquês BND-100 Estudante', 450.00, 8, 'Marquês'),
('Bandolim Marquês BND-100 NS', 460.00, 6, 'Marquês'),
('Bandolim Marquês BND-100 NB', 460.00, 4, 'Marquês'),
('Bandolim Marquês BND-100 Natural Sombra', 470.00, 5, 'Marquês'),
('Bandolim Giannini Raiz BS1 NS', 520.00, 3, 'Giannini'),
('Bandolim Rozini Profissional RB22', 1500.00, 2, 'Rozini'),
('Bandolim Giannini Gonçalo Alves', 2200.00, 1, 'Giannini'),
('Bandolim Rozini Hamilton de Holanda', 1800.00, 2, 'Rozini'),

('Ukulele Seven Concert SUK-23 NT Natural', 180.00, 10, 'Seven'),
('Ukulele Seven Concert SUK-23 BK Preto', 180.00, 9, 'Seven'),
('Ukulele Seven Concert SUK-23 PI Rosa', 190.00, 6, 'Seven'),
('Ukulele Seven Concert SUK-23 LB Azul Claro', 190.00, 7, 'Seven'),
('Ukulele Concert Bahardan', 220.00, 5, 'Bahardan'),
('Ukulele ANVAR de Viagem', 160.00, 8, 'ANVAR'),
('Ukulele Malibu 23EP Abacaxi Ébano', 250.00, 4, 'Malibu'),
('Ukulele Concerto Zebra Wood', 300.00, 2, 'Zebra'),

('Viola Giannini Start VS-14 EQ Black', 1400.00, 3, 'Giannini'),
('Viola Caipira Giannini VS14 Cinturada', 1250.00, 4, 'Giannini'),
('Viola Acústica Caipira Giannini VS-14', 1150.00, 4, 'Giannini'),
('Viola Caipira Giannini VS-14 Eletroacústica Natural', 1600.00, 2, 'Giannini'),
('Viola Caipira Rozini RV155 AC Clássica', 900.00, 5, 'Rozini'),
('Viola Caipira Rozini RV151 Ponteio Fosco', 850.00, 6, 'Rozini'),
('Viola Caipira Rozini RV151EG Elétrica', 1100.00, 2, 'Rozini'),
('Viola Caipira Marquês VIL-51', 700.00, 7, 'Marquês'),

('Banjo Strinberg WB50 Natural Bluegrass', 900.00, 4, 'Strinberg'),
('Banjo Rozini RJ14 Estudante Elétrico', 1100.00, 3, 'Rozini'),
('Banjo Strinberg WB50 Americano', 950.00, 2, 'Strinberg'),
('Banjo Strinberg WB50 Luthier', 1300.00, 1, 'Strinberg'),
('Banjo AKLOT 5 Cordas', 850.00, 6, 'AKLOT'),
('Banjo Rozini RJ11 Verde Ativo', 980.00, 3, 'Rozini'),
('Banjo Rozini RJ11 Azul Elétrico', 980.00, 3, 'Rozini'),
('Banjo Marquês Baj-224BKSEL Preto e Dourado', 1400.00, 1, 'Marquês'),

('Violão Michael Elegance VME720', 1200.00, 5, 'Michael'),
('Violão Yamaha CSF-TA Parlor Transacoustic', 4200.00, 2, 'Yamaha'),
('Violão PHX Camerata LCS-501NA', 1500.00, 4, 'PHX'),
('Violão PHX J. White AH-106NS-41 Folk', 1300.00, 3, 'PHX'),
('Violão Tagima Frontier EQ Ambience', 2100.00, 2, 'Tagima'),
('Violão Giannini D12 DLX 12 Cordas', 2600.00, 1, 'Giannini'),
('Violão Strinberg SDB30 Sunburst', 1000.00, 3, 'Strinberg'),
('Violão Rozini RX515.RE2 Studio Flat', 1100.00, 4, 'Rozini'),

('Guitarra Fender Stratocaster Olympic White', 7500.00, 1, 'Fender'),
('Guitarra Gibson Les Paul Tribute Satin Tobacco Burst', 12000.00, 1, 'Gibson'),
('Guitarra Fender Telecaster Butterscotch Blonde', 6800.00, 1, 'Fender'),
('Guitarra Fender Standard Stratocaster Olympic White', 6500.00, 1, 'Fender'),
('Guitarra Elétrica Gibson Modern Collection Les Paul Tribute Cor Satin Tobacco Burst', 12500.00, 1, 'Gibson'),

('Cavaquinho Roos Acústico Preto Fosco', 480.00, 6, 'Roos'),
('Cavaquinho Estudante Roos #054 Natural/Preto', 350.00, 8, 'Roos'),
('Cavaquinho Rozini RC10.EL.F.I Elétrico Fosco', 950.00, 3, 'Rozini'),
('Cavaquinho Toks Eletroacústico Natural', 700.00, 4, 'Toks');

-- Clientes (e-mails corrigidos, sem \n)
INSERT INTO ClienteUsuario (cpf, nome_completo, rg, email, senha, telefone, data_cadastro) VALUES
('00000000001','Ana Maria Silva','MG123456','ana.silva@example.com','senha123','(31)99999-0001','2024-01-15'),
('00000000002','Bruno Almeida','SP987654','bruno.almeida@example.com','senha123','(11)99999-0002','2024-02-10'),
('00000000003','Carla Souza','RJ111222','carla.souza@example.com','senha123','(21)99999-0003','2024-03-05'),
('00000000004','Daniel Costa','BA333444','daniel.costa@example.com','senha123','(71)99999-0004','2024-04-12'),
('00000000005','Eduarda Pereira','PE555666','eduarda.pereira@example.com','senha123','(81)99999-0005','2024-05-03'),
('00000000006','Fabio Rocha','PR777888','fabio.rocha@example.com','senha123','(41)99999-0006','2024-06-18'),
('00000000007','Gabriela Lima','SC222333','gabriela.lima@example.com','senha123','(48)99999-0007','2024-07-21'),
('00000000008','Henrique Martins','RS444555','henrique.martins@example.com','senha123','(51)99999-0008','2024-08-09'),
('00000000009','Isabela Santos','CE666777','isabela.santos@example.com','senha123','(85)99999-0009','2024-09-14'),
('00000000010','João Pedro','AM888999','joao.pedro@example.com','senha123','(92)99999-0010','2024-10-01'),
('00000000011','Karla Nunes','GO101010','karla.nunes@example.com','senha123','(62)99999-0011','2024-11-11'),
('00000000012','Leonardo Dias','MA121212','leonardo.dias@example.com','senha123','(98)99999-0012','2025-01-05'),
('00000000013','Mariana Faria','PA131313','mariana.faria@example.com','senha123','(91)99999-0013','2025-02-20'),
('00000000014','Nicolas Gonçalves','PI141414','nicolas.goncalves@example.com','senha123','(86)99999-0014','2025-03-12'),
('00000000015','Olivia Ramos','AL151515','olivia.ramos@example.com','senha123','(82)99999-0015','2025-04-02'),
('00000000016','Paulo Henrique','PB161616','paulo.henrique@example.com','senha123','(83)99999-0016','2025-04-25'),
('00000000017','Queila Barbosa','RN171717','queila.barbosa@example.com','senha123','(84)99999-0017','2025-05-10'),
('00000000018','Rafael Medeiros','SE181818','rafael.medeiros@example.com','senha123','(79)99999-0018','2025-05-22'),
('00000000019','Sofia Pinto','RR191919','sofia.pinto@example.com','senha123','(95)99999-0019','2025-06-14'),
('00000000020','Tiago Moreira','MT202020','tiago.moreira@example.com','senha123','(65)99999-0020','2025-06-30'),
('00000000021','Úrsula Almeida','TO212121','ursula.almeida@example.com','senha123','(63)99999-0021','2025-07-11'),
('00000000022','Vitor Santana','MS222222','vitor.santana@example.com','senha123','(67)99999-0022','2025-07-29'),
('00000000023','Wanda Ferreira','RO232323','wanda.ferreira@example.com','senha123','(69)99999-0023','2025-08-05'),
('00000000024','Xavier Oliveira','AC242424','xavier.oliveira@example.com','senha123','(68)99999-0024','2025-08-20'),
('00000000025','Yasmin Castro','DF252525','yasmin.castro@example.com','senha123','(61)99999-0025','2025-08-28');

-- Pedidos (totais corrigidos = soma exata dos itens)
INSERT INTO Pedido (datapedido, dataentrega, total, status, cliente_cpf) VALUES
('2025-01-10','2025-01-15',2048.00,'ENTREGUE', '00000000001'),
('2025-01-20','2025-01-27',1259.90,'ENTREGUE', '00000000001'),
('2025-02-05','2025-02-12',3200.00,'ENTREGUE','00000000001'),
('2025-02-18','2025-02-25',16500.00,'CANCELADO','00000000001'),
('2025-03-01','2025-03-08',560.00,'ENTREGUE','00000000001'),
('2025-03-10','2025-03-20',1259.00,'PROCESSANDO','00000000001'),
('2025-03-15',NULL,3200.00,'PROCESSANDO','00000000001'),
('2025-03-25','2025-04-02',1800.00,'ENTREGUE','00000000001'),
('2025-04-05','2025-04-10',1250.00,'ENTREGUE','00000000001'),
('2025-04-18','2025-04-30',11000.00,'ENTREGUE','00000000001'),
('2025-05-02','2025-05-10',3400.00,'ENTREGUE','00000000001'),
('2025-05-15','2025-05-22',9700.00,'ENTREGUE','00000000001'),
('2025-06-01',NULL,14800.00,'PROCESSANDO','00000000001'),
('2025-06-07','2025-06-12',8900.00,'ENTREGUE','00000000001'),
('2025-06-18','2025-06-25',480.00,'ENTREGUE','00000000001'),
('2025-07-01','2025-07-09',520.00,'ENTREGUE','00000000001'),
('2025-07-10','2025-07-18',1100.00,'ENTREGUE','00000000001'),
('2025-07-20',NULL,1500.00,'PROCESSANDO','00000000001'),
('2025-07-25','2025-08-02',5700.00,'ENTREGUE','00000000001'),
('2025-08-01','2025-08-09',2000.00,'ENTREGUE','00000000001'),
('2025-08-07',NULL,1950.00,'PROCESSANDO','00000000001'),
('2025-08-11','2025-08-16',2380.00,'ENTREGUE','00000000001'),
('2025-08-20','2025-08-25',1150.00,'CANCELADO','00000000001'),
('2025-08-24','2025-08-30',350.00,'ENTREGUE','00000000001'),
('2025-09-01',NULL,160.00,'PROCESSANDO','00000000001');

-- Itens dos pedidos (mesmo conjunto fornecido, base para os totais acima)
INSERT INTO ItemPedido (produto_idproduto, pedido_idpedido, quantidade, precounitario) VALUES
(2,1,1,1299.00),
(1,2,1,899.90),
(26,3,1,3200.00),
(10,4,1,4500.00),
(4,5,1,560.00),
(7,6,1,699.00),
(17,7,1,3200.00),
(38,8,1,1500.00),
(22,9,1,1250.00),
(66,10,1,4200.00),
(27,11,1,1800.00),
(26,12,1,3200.00),
(20,13,1,2300.00),
(21,14,1,1400.00),
(78,15,1,480.00),
(37,16,1,520.00),
(55,17,1,1100.00),
(38,18,1,1500.00),
(70,19,1,2600.00),
(33,20,2,450.00),
(58,21,1,1100.00),
(64,22,1,1400.00),
(51,23,1,1150.00),
(79,24,1,350.00),
(46,25,1,160.00),
(3,1,1,749.00),
(41,2,2,180.00),
(5,6,1,560.00),
(48,8,1,300.00),
(30,11,1,1600.00),
(69,19,1,2100.00),
(71,19,1,1000.00),
(72,20,1,1100.00),
(73,14,1,7500.00),
(74,4,1,12000.00),
(75,10,1,6800.00),
(76,12,1,6500.00),
(77,13,1,12500.00),
(61,21,1,850.00),
(62,22,1,980.00);

-- Pagamentos (valores alinhados aos novos totais por pedido)
INSERT INTO Pagamento (data_retirada, forma_pagamento, valor, pedido_idpedido, cliente_cpf) VALUES
('2025-01-15','CARTAO',2048.00,1,'00000000002'),
('2025-01-27','PIX',1259.90,2,'00000000001'),
('2025-02-12','BOLETO',3200.00,3,'00000000012'),
('2025-02-25','CARTAO',16500.00,4,'00000000010'),
('2025-03-08','PIX',560.00,5,'00000000003'),
('2025-03-22','CARTAO',1259.00,6,'00000000006'),
(NULL,'PIX',3200.00,7,'00000000016'),
('2025-04-02','PIX',1800.00,8,'00000000008'),
('2025-04-10','CARTAO',1250.00,9,'00000000009'),
('2025-04-30','PIX',11000.00,10,'00000000011'),
('2025-05-10','CARTAO',3400.00,11,'00000000015'),
('2025-05-22','PIX',9700.00,12,'00000000012'),
(NULL,'BOLETO',14800.00,13,'00000000017'),
('2025-06-12','PIX',8900.00,14,'00000000018'),
('2025-06-25','CARTAO',480.00,15,'00000000005'),
('2025-07-09','PIX',520.00,16,'00000000007'),
('2025-07-18','CARTAO',1100.00,17,'00000000013'),
(NULL,'PIX',1500.00,18,'00000000014'),
('2025-08-02','CARTAO',5700.00,19,'00000000020'),
('2025-08-09','PIX',2000.00,20,'00000000004'),
(NULL,'BOLETO',1950.00,21,'00000000021'),
('2025-08-16','CARTAO',2380.00,22,'00000000022'),
('2025-08-25','PIX',1150.00,23,'00000000023'),
('2025-08-30','PIX',350.00,24,'00000000024'),
(NULL,'PIX',160.00,25,'00000000025');

-- Carrinhos
INSERT INTO Carrinho (cliente_cpf) VALUES
('00000000001'),
('00000000002'),
('00000000003'),
('00000000004'),
('00000000005'),
('00000000006'),
('00000000007'),
('00000000008'),
('00000000009'),
('00000000010'),
('00000000011'),
('00000000012'),
('00000000013'),
('00000000014'),
('00000000015'),
('00000000016'),
('00000000017'),
('00000000018'),
('00000000019'),
('00000000020'),
('00000000021'),
('00000000022'),
('00000000023'),
('00000000024'),
('00000000025');

-- Itens de carrinho
INSERT INTO CarrinhoItem (produto_idproduto, carrinho_idcarrinho, quantidade) VALUES
(2,1,1),
(41,1,1),
(5,2,1),
(33,3,2),
(78,4,1),
(66,5,1),
(69,5,1),
(17,6,1),
(26,6,1),
(37,7,1),
(48,8,1),
(73,9,1),
(74,9,1),
(41,10,2),
(52,11,1),
(70,12,1),
(79,13,1),
(80,14,1),
(81,15,1),
(55,15,1),
(30,16,1),
(31,17,1),
(32,18,1),
(29,19,1),
(28,20,1),
(27,21,1),
(24,22,1),
(23,23,1),
(22,24,1),
(21,25,1);

-- ==========================
-- NOVAS TABELAS SOLICITADAS
-- ==========================

-- TABELA ADMINISTRADOR
CREATE TABLE Administrador (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('admin', 'super_admin') DEFAULT 'admin',
    usuario VARCHAR(50) UNIQUE NOT NULL,
    nome_completo VARCHAR(150) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_login TIMESTAMP NULL
);

-- TABELA AVALIAÇÕES
CREATE TABLE Avaliacao (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    produto_idproduto INT NOT NULL,
    cliente_cpf CHAR(11) NOT NULL,
    nota INT NOT NULL CHECK (nota >= 1 AND nota <= 5),
    comentario TEXT,
    data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aprovado BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_avaliacao_produto FOREIGN KEY (produto_idproduto) REFERENCES Produto(idproduto) ON DELETE CASCADE,
    CONSTRAINT fk_avaliacao_cliente FOREIGN KEY (cliente_cpf) REFERENCES ClienteUsuario(cpf) ON DELETE CASCADE,
    UNIQUE KEY unique_cliente_produto (produto_idproduto, cliente_cpf)
);

-- ==========================
-- INSERIR ADMINISTRADORES PADRÃO
-- ==========================
-- ADMINISTRADOR PADRÃO:
-- Usuário: admin
-- Senha: 123456 (SHA-256: 8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92)
INSERT INTO Administrador (nome, email, senha, usuario, nome_completo) VALUES
('Admin Master', 'admin@musicwave.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin', 'Administrador Master'),
('Gerente Loja', 'gerente@musicwave.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'gerente', 'Gerente da Loja'),
('Moderador', 'moderador@musicwave.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'moderador', 'Moderador do Sistema');


-- ==========================
-- INSERIR AVALIAÇÕES DE EXEMPLO
-- ==========================
INSERT INTO Avaliacao (produto_idproduto, cliente_cpf, nota, comentario, aprovado) VALUES
(1, '00000000001', 5, 'Excelente violino para iniciantes! Som muito bom e o estojo é resistente.', TRUE),
(1, '00000000002', 4, 'Boa qualidade pelo preço. Recomendo para estudantes.', TRUE),
(26, '00000000003', 5, 'Baixo Yamaha fantástico! Captadores excelentes e acabamento perfeito.', TRUE),
(73, '00000000004', 5, 'Fender Strat clássica! Som incrível, não tem erro.', TRUE),
(74, '00000000005', 5, 'Gibson Les Paul é o sonho de qualquer guitarrista. Vale cada centavo!', TRUE),
(33, '00000000006', 4, 'Bandolim muito bom para choro. Som bem definido.', TRUE),
(41, '00000000007', 5, 'Ukulele lindo e com som excelente. Perfeito para iniciantes.', TRUE),
(57, '00000000008', 4, 'Banjo de boa qualidade. Som autêntico para bluegrass.', TRUE),
(66, '00000000009', 5, 'Violão Michael surpreendente! Som de violão muito mais caro.', TRUE),
(9, '00000000010', 5, 'Viola Alan maravilhosa. Timbre aveludado e construção impecável.', TRUE),
(49, '00000000011', 4, 'Viola caipira Giannini excelente. Sistema ativo funciona perfeitamente.', TRUE),
(17, '00000000012', 5, 'Violoncelo Alan de qualidade excepcional. Som profundo e rico.', TRUE),
(78, '00000000013', 4, 'Cavaquinho Roos muito bom para samba. Acabamento bonito.', TRUE),
(2, '00000000014', 5, 'Violino Alan completo e bem acabado. Recomendo!', TRUE),
(27, '00000000015', 4, 'Baixo Tagima com bom custo-benefício. Som vintage autêntico.', TRUE);

-- Fim do script