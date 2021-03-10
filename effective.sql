-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 10/03/2021 às 04h29min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `effective`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

CREATE TABLE IF NOT EXISTS `atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordem` varchar(50) DEFAULT NULL,
  `descricao` varchar(54) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `realizada` tinyint(1) DEFAULT NULL,
  `finalizada` tinyint(1) DEFAULT NULL,
  `aviso` varchar(50) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_limite` date DEFAULT NULL,
  `fk_setor` int(11) DEFAULT NULL,
  `fk_usuario` int(11) DEFAULT NULL,
  `fk_importancia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ordem` (`ordem`),
  KEY `FK_Atividade_2` (`fk_setor`),
  KEY `FK_Atividade_3` (`fk_usuario`),
  KEY `FK_Atividade_4` (`fk_importancia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2980 ;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id`, `ordem`, `descricao`, `quantidade`, `realizada`, `finalizada`, `aviso`, `data_inicio`, `data_limite`, `fk_setor`, `fk_usuario`, `fk_importancia`) VALUES
(2979, '123456		\r\n		', 'Primeira Ordem		\r\n		', 0, 0, 0, 'ATRASADO!		\r\n		', '2021-03-09', '2021-03-10', 2, 13, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `importancia`
--

CREATE TABLE IF NOT EXISTS `importancia` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `importancia`
--

INSERT INTO `importancia` (`id`, `nome`) VALUES
(0, 'max'),
(1, 'max-med'),
(2, 'max-min'),
(3, 'med');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

CREATE TABLE IF NOT EXISTS `setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `setor_alias` varchar(50) DEFAULT NULL,
  `centrocusto` int(11) NOT NULL,
  `centrocusto2` int(11) NOT NULL,
  `style` varchar(50) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL,
  `habilita` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`id`, `nome`, `setor_alias`, `centrocusto`, `centrocusto2`, `style`, `cor`, `tempo`, `habilita`) VALUES
(1, 'setor 1', 'SETOR 1', 0, 0, NULL, '123', 10000, 0),
(2, 'producao', 'PRODUÃ‡ÃƒO', 20010, 0, NULL, '555344', 10000, 1),
(3, 'assistencia', 'ASSISTÃŠNCIA TÃ‰CNICA', 0, 0, NULL, '555344', 10000, 1),
(4, 'marcenaria', 'MARCENARIA', 20006, 0, NULL, '555344', 10000, 0),
(5, 'pedidos', 'PEDIDOS PENDENTES', 0, 0, NULL, NULL, NULL, 0),
(6, 'prod. mont. placas', 'MONTAGEM PLACAS', 20008, 20009, NULL, NULL, NULL, 0),
(7, 'permutas', 'CONSERTO DE PERMUTAS', 0, 0, NULL, NULL, NULL, 0),
(8, 'aniversarios', 'FELIZ  ANIVERSÃRIO ', 0, 0, NULL, NULL, NULL, 0),
(9, 'almoxerifado', 'ALMOXERIFADO', 0, 0, NULL, NULL, NULL, 0),
(10, 'indicadores', 'INDICADORES', 0, 0, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `usuario_alias` varchar(50) DEFAULT NULL,
  `nivel_usuario` int(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `data_ultimo_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_cadastro` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  `ativado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `usuario_alias`, `nivel_usuario`, `data_nascimento`, `senha`, `data_ultimo_login`, `data_cadastro`, `email`, `ativado`) VALUES
(13, 'pedidos', 'Geral Pedidos', 2, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2021-03-10 02:10:58', '0000-00-00 00:00:00', '', 1),
(16, 'admin', 'admin', 1, '1986-05-01', 'e10adc3949ba59abbe56e057f20f883e', '2021-03-10 03:04:24', '0000-00-00 00:00:00', '', 1),
(17, 'usuario', 'padrao', 2, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2021-03-10 02:10:58', '0000-00-00 00:00:00', '', 1);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `FK_Atividade_2` FOREIGN KEY (`fk_setor`) REFERENCES `setor` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_Atividade_3` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Atividade_4` FOREIGN KEY (`fk_importancia`) REFERENCES `importancia` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
