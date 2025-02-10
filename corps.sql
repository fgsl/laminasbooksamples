-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 10-Fev-2025 às 15:20
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `corps`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `lanterna`
--

CREATE TABLE `lanterna` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `codigo_setor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `lanterna`
--

INSERT INTO `lanterna` (`codigo`, `nome`, `codigo_setor`) VALUES
(1, 'Rot Lop Fan', 911),
(2, 'Sinestro', 1417),
(3, 'Mogo', 2261),
(4, 'Hal Jordan', 2814);

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

CREATE TABLE `setor` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`codigo`, `nome`) VALUES
(911, 'Profundezas Obsidianas'),
(1417, 'Korugar'),
(2261, 'Mogo'),
(2814, 'Terra'),
(3182, 'Daxam');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `lanterna`
--
ALTER TABLE `lanterna`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `lanterna`
--
ALTER TABLE `lanterna`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
