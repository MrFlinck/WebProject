

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `ramal` int(11) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `area` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);


ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);
COMMIT;




create table `professor`(
  `id`int primary key,
  `nome`varchar(99),
  `email`varchar(99),
  `area`varchar (99),
  `imagem` varchar(99)); 
  
create table `funcionario`(
  `id`int primary key not null AUTO_INCREMENT, 
  `nome`varchar(99),
  `salario`varchar(99),
  `depto`varchar(99),
  `imagem` varchar(99));

create table `area`(
  `id` int primary key not null AUTO_INCREMENT, 
  `area` varchar(99)
);
create table `cursos`(
  `id`int primary key not null AUTO_INCREMENT,
  `nome`varchar(99),
  `duracao`varchar(99),
  `imagem` varchar(99),
  `id_area` int, 
   FOREIGN key (`id_area`) references `area` (`id`)
  );

create table `admin`(
  `id`int primary key not null AUTO_INCREMENT,
  `nome`varchar(99),
  `email`varchar(99),
  `idade` varchar(99)
  ); 
  create table `docente`(
  `id`int primary key not null AUTO_INCREMENT,
  `nome`varchar(99),
  `email`varchar(99),
  `formacao` varchar(99)
  ); 