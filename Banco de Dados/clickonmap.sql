-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Jul-2015 às 21:43
-- Versão do servidor: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clickonmap`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE IF NOT EXISTS `arquivos` (
  `codArquivo` int(11) NOT NULL AUTO_INCREMENT,
  `desArquivo` text,
  `comentarioArquivo` text,
  `endArquivo` text NOT NULL,
  `codColaboracao` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codArquivo`),
  KEY `codColaboracao` (`codColaboracao`),
  KEY `codUsuario` (`codUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE IF NOT EXISTS `avaliacao` (
  `codColaboracao` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codColaboracao`,`codUsuario`),
  KEY `codUsuario` (`codUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriaevento`
--

CREATE TABLE IF NOT EXISTS `categoriaevento` (
  `codCategoriaEvento` int(11) NOT NULL AUTO_INCREMENT,
  `desCategoriaEvento` varchar(100) NOT NULL,
  PRIMARY KEY (`codCategoriaEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classesdeusuarios`
--

CREATE TABLE IF NOT EXISTS `classesdeusuarios` (
  `codClasse` int(11) NOT NULL AUTO_INCREMENT,
  `nomeClasse` text CHARACTER SET latin1 NOT NULL,
  `desClasse` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`codClasse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `classesdeusuarios`
--

INSERT INTO `classesdeusuarios` (`codClasse`, `nomeClasse`, `desClasse`) VALUES
(1, 'Colaborador Malicioso', 'Menos de 0 pontos'),
(2, 'Colaborador Básico', 'Entre 0 e 99 pontos'),
(3, 'Colaborador Legal', 'Entre 100 e 249 pontos'),
(4, 'Colaborador Master', 'Entre 250 e 449 pontos'),
(5, 'Colaborador Experiente', 'Entre 500 e 799 pontos'),
(6, 'Colaborador Especial', 'Mais de 800 pontos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaboracao`
--

CREATE TABLE IF NOT EXISTS `colaboracao` (
  `codColaboracao` int(11) NOT NULL AUTO_INCREMENT,
  `desTituloAssunto` varchar(100) NOT NULL,
  `desColaboracao` text NOT NULL,
  `datahoraCriacao` datetime NOT NULL COMMENT 'dd/mm/yyyy hh:mm:sss',
  `codCategoriaEvento` int(11) NOT NULL,
  `codTipoEvento` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `dataOcorrencia` date DEFAULT NULL COMMENT 'dd/mm/yyyy',
  `horaOcorrencia` time DEFAULT NULL COMMENT 'hh:mm:ss',
  `numLatitude` float(10,6) NOT NULL,
  `numLongitude` float(10,6) NOT NULL,
  `tipoStatus` char(1) NOT NULL COMMENT '[E]-Em analise; [A]-Aprovada; [R]-Reprovada',
  `desJustificativa` text,
  `zoom` int(11) NOT NULL,
  `ip` text,
  PRIMARY KEY (`codColaboracao`),
  KEY `FK_CodUsuario2` (`codUsuario`),
  KEY `FK_CodCategoriaEvento2` (`codCategoriaEvento`),
  KEY `FK_CodTipoEvento` (`codTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `codComentario` int(11) NOT NULL AUTO_INCREMENT,
  `desComentario` text NOT NULL,
  `datahoraCriacao` datetime NOT NULL,
  `codColaboracao` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codComentario`,`codColaboracao`,`codUsuario`) USING BTREE,
  KEY `FK_CodColaboracao` (`codColaboracao`),
  KEY `FK_CodUsuario` (`codUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes`
--

CREATE TABLE IF NOT EXISTS `configuracoes` (
  `nomeSite` text NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `zoom` int(11) NOT NULL,
  `tipoMapa` text NOT NULL,
  `loginFacebook` tinyint(1) NOT NULL,
  `appIDFacebook` text NOT NULL,
  `appSecretFacebook` text NOT NULL,
  `loginGoogle` tinyint(1) NOT NULL,
  `loginAnonimo` tinyint(1) NOT NULL,
  `emailContato` text NOT NULL,
  `senhaContato` text NOT NULL,
  `linkBase` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `configuracoes`
--

INSERT INTO `configuracoes` (`nomeSite`, `longitude`, `latitude`, `zoom`, `tipoMapa`, `loginFacebook`, `appIDFacebook`, `appSecretFacebook`, `loginGoogle`, `loginAnonimo`, `emailContato`, `senhaContato`, `linkBase`) VALUES
('ClickOnMap       ', -42.880260, -20.747999, 10, 'ROADMAP', 1, '', '', 1, 1, 'email@gmail.com', 'senhaEmail', 'http://localhost/clickonmap');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estatistica`
--

CREATE TABLE IF NOT EXISTS `estatistica` (
  `codColaboracao` int(11) NOT NULL,
  `qtdVisualizacao` int(11) NOT NULL,
  `qtdAvaliacao` int(11) NOT NULL,
  `notaMedia` decimal(10,2) NOT NULL,
  `pesoTotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`codColaboracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicocolaboracoes`
--

CREATE TABLE IF NOT EXISTS `historicocolaboracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codColaboracao` int(11) NOT NULL,
  `desTitulo` varchar(100) NOT NULL,
  `desColaboracao` text NOT NULL,
  `datahoraModificacao` datetime NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_codColaboracao` (`codColaboracao`),
  KEY `FK_codUsuario` (`codUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `codMenu` int(11) NOT NULL AUTO_INCREMENT,
  `nomeItem` text COLLATE utf8_unicode_ci NOT NULL,
  `statusItem` tinyint(1) NOT NULL,
  `enderecoItem` text COLLATE utf8_unicode_ci NOT NULL,
  `ordemItem` int(11) NOT NULL,
  PRIMARY KEY (`codMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`codMenu`, `nomeItem`, `statusItem`, `enderecoItem`, `ordemItem`) VALUES
(1, 'Sobre', 0, 'sobre.php', 1),
(2, 'Colaborar', 0, 'colaborar.php', 2),
(3, 'Filtros', 0, 'filtros.php', 3),
(4, 'Análise', 0, 'analise_dados.php', 4),
(5, 'Metadados', 0, 'metadados.php', 5),
(6, 'Ranking', 0, 'ranking_usuario.php', 6),
(7, 'Histórico', 0, 'dados_historicos.php', 7),
(8, 'Estatísticas', 0, 'estatisticas.php', 8),
(9, 'Contato', 0, 'contato.php', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `multimidia`
--

CREATE TABLE IF NOT EXISTS `multimidia` (
  `codMultimidia` int(11) NOT NULL AUTO_INCREMENT,
  `desTituloImagem` varchar(100) NOT NULL,
  `comentarioImagem` text,
  `endImagem` text NOT NULL,
  `codColaboracao` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codMultimidia`),
  KEY `FK_CodColaboracao2` (`codColaboracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoevento`
--

CREATE TABLE IF NOT EXISTS `tipoevento` (
  `codTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `desTipoEvento` varchar(100) NOT NULL,
  `codCategoriaEvento` int(11) NOT NULL,
  PRIMARY KEY (`codTipoEvento`,`codCategoriaEvento`) USING BTREE,
  KEY `FK_CodCategoriaEvento` (`codCategoriaEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nomPessoa` varchar(100) NOT NULL,
  `endEmail` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `tipoUsuario` char(1) NOT NULL COMMENT '[A]-Administrador; [C]-Colaborador',
  `pontos` decimal(10,2) NOT NULL,
  `faixaEtaria` text NOT NULL,
  `classeUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codUsuario`),
  KEY `FK_codClasse` (`classeUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codUsuario`, `nomPessoa`, `endEmail`, `senha`, `tipoUsuario`, `pontos`, `faixaEtaria`, `classeUsuario`) VALUES
(1, 'Administrador', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 'A', '0.00', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `codVideo` int(11) NOT NULL AUTO_INCREMENT,
  `desTituloVideo` varchar(100) NOT NULL,
  `desUrlVideo` varchar(100) NOT NULL,
  `comentarioVideo` text,
  `codColaboracao` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  PRIMARY KEY (`codVideo`),
  KEY `codColaboracao` (`codColaboracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `arquivos_ibfk_1` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE,
  ADD CONSTRAINT `arquivos_ibfk_2` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`codUsuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`codUsuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `colaboracao`
--
ALTER TABLE `colaboracao`
  ADD CONSTRAINT `FK_CodCategoriaEvento2` FOREIGN KEY (`codCategoriaEvento`) REFERENCES `categoriaevento` (`codCategoriaEvento`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CodTipoEvento` FOREIGN KEY (`codTipoEvento`) REFERENCES `tipoevento` (`codTipoEvento`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CodUsuario2` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`codUsuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `FK_CodColaboracao` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CodUsuario` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`codUsuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `estatistica`
--
ALTER TABLE `estatistica`
  ADD CONSTRAINT `estatistica_ibfk_1` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `historicocolaboracoes`
--
ALTER TABLE `historicocolaboracoes`
  ADD CONSTRAINT `historicocolaboracoes_ibfk_1` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE,
  ADD CONSTRAINT `historicocolaboracoes_ibfk_2` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`codUsuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `multimidia`
--
ALTER TABLE `multimidia`
  ADD CONSTRAINT `FK_CodColaboracao2` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tipoevento`
--
ALTER TABLE `tipoevento`
  ADD CONSTRAINT `FK_CodCategoriaEvento` FOREIGN KEY (`codCategoriaEvento`) REFERENCES `categoriaevento` (`codCategoriaEvento`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`classeUsuario`) REFERENCES `classesdeusuarios` (`codClasse`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`codColaboracao`) REFERENCES `colaboracao` (`codColaboracao`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
