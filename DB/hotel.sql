-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10-Nov-2018 às 02:39
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--
CREATE DATABASE IF NOT EXISTS `hotel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hotel`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_cliente`
--

CREATE TABLE `tbl_cliente` (
  `idCliente` int(11) NOT NULL,
  `nome` varchar(45) CHARACTER SET latin1 NOT NULL,
  `cpf` varchar(45) CHARACTER SET latin1 NOT NULL,
  `endereco` varchar(45) CHARACTER SET latin1 NOT NULL,
  `telefone` varchar(45) CHARACTER SET latin1 NOT NULL,
  `email` varchar(45) CHARACTER SET latin1 NOT NULL,
  `senha` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_cliente`
--

INSERT INTO `tbl_cliente` (`idCliente`, `nome`, `cpf`, `endereco`, `telefone`, `email`, `senha`) VALUES
(1, 'Fernanda', '123.123.123-09', 'Rua Oriente', '4444-4444', 'fetpiva@gmail.com', 'fetpiva'),
(2, 'Adriana', '555.555.555-30', 'Rua Sergipe', '7777-7777', 'drip@gmail.com', 'drip'),
(3, 'Augusto', '888.888.888-21', 'Rua Santos', '3333-3333', 'aug@gmail.com', 'aug'),
(4, 'Murilo', '444.444.444.45', 'Rua Boraceia', '9999-9999', 'mu@gmail.com', 'mu'),
(5, 'barbara', '111.111.111-07', 'Rua Sergipe', '5555-5555', 'jessica@gmail.com', 'jessica'),
(6, 'Jessica', '111.111.111-09', 'Rua Oriente', '3333-4444', 'jes@gmail.com', 'jessica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_funcionario`
--

CREATE TABLE `tbl_funcionario` (
  `idFuncionario` int(11) NOT NULL,
  `login` varchar(45) CHARACTER SET latin1 NOT NULL,
  `senha` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_funcionario`
--

INSERT INTO `tbl_funcionario` (`idFuncionario`, `login`, `senha`) VALUES
(1, 'Adriana', 'Adriana'),
(2, 'Fernanda', 'Fernanda'),
(3, 'Sergio', 'Sergio'),
(4, 'Mauro', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_quarto`
--

CREATE TABLE `tbl_quarto` (
  `idQuarto` int(11) NOT NULL,
  `capacidade` int(11) NOT NULL,
  `descricao` varchar(100) CHARACTER SET latin1 NOT NULL,
  `precoDia` float NOT NULL,
  `nomeQuarto` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_quarto`
--

INSERT INTO `tbl_quarto` (`idQuarto`, `capacidade`, `descricao`, `precoDia`, `nomeQuarto`) VALUES
(1, 2, 'classico', 50, 'Classic Room'),
(2, 3, 'chique', 100, 'Ultra Superior Room'),
(3, 1, 'luxuoso', 250, 'Grand Deluxe Room'),
(4, 3, 'simples', 40, 'Basic Room');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_reserva`
--

CREATE TABLE `tbl_reserva` (
  `idReserva` int(11) NOT NULL,
  `idClienteReserva` int(11) NOT NULL,
  `idQuartoReserva` int(11) NOT NULL,
  `precoTotal` float NOT NULL,
  `dataDia` int(11) DEFAULT NULL,
  `dataMes` int(11) DEFAULT NULL,
  `dataAno` int(11) DEFAULT NULL,
  `qntDias` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_reserva`
--

INSERT INTO `tbl_reserva` (`idReserva`, `idClienteReserva`, `idQuartoReserva`, `precoTotal`, `dataDia`, `dataMes`, `dataAno`, `qntDias`) VALUES
(1, 1, 1, 100, 10, 4, 2018, 2),
(2, 2, 1, 1000, 12, 4, 2018, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `tbl_funcionario`
--
ALTER TABLE `tbl_funcionario`
  ADD PRIMARY KEY (`idFuncionario`);

--
-- Indexes for table `tbl_quarto`
--
ALTER TABLE `tbl_quarto`
  ADD PRIMARY KEY (`idQuarto`);

--
-- Indexes for table `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD UNIQUE KEY `idReserva_UNIQUE` (`idReserva`),
  ADD KEY `cliente_idx` (`idClienteReserva`),
  ADD KEY `quarto_idx` (`idQuartoReserva`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_funcionario`
--
ALTER TABLE `tbl_funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_quarto`
--
ALTER TABLE `tbl_quarto`
  MODIFY `idQuarto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`idClienteReserva`) REFERENCES `tbl_cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `quarto` FOREIGN KEY (`idQuartoReserva`) REFERENCES `tbl_quarto` (`idQuarto`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
