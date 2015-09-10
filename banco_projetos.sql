-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Set-2015 às 09:41
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `banco_projetos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_projetos`
--

CREATE TABLE IF NOT EXISTS `tbl_projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_coordenador` int(11) DEFAULT NULL,
  `id_desenvolvedor` int(11) DEFAULT NULL,
  `arquivo` varchar(255) NOT NULL COMMENT 'Arquivo',
  `nome_demandante` varchar(255) NOT NULL,
  `instituicao_demandante` varchar(255) NOT NULL,
  `email_demandante` varchar(255) NOT NULL,
  `resumo` text NOT NULL,
  `pdf` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `tbl_projetos`
--

INSERT INTO `tbl_projetos` (`id`, `id_usuario`, `nome`, `data_inicio`, `status`, `id_coordenador`, `id_desenvolvedor`, `arquivo`, `nome_demandante`, `instituicao_demandante`, `email_demandante`, `resumo`, `pdf`) VALUES
(3, 3, 'teste ric', '2014-11-27', 'nao_atribuido', NULL, 4, '', 'paulo', 'ifps campi', 'ricard@agenciadelucca.com.br', 'teste', ''),
(4, 3, 'Computador para todos', '2014-11-27', 'desenvolvimento', NULL, 3, '', 'Andre Fernando Pereira da Silva', 'IFPS Maceió', 'andre.fernando@edu.uniso.br', 'Quamve faucibus aliquet mauris iumsed justonul tiam. Enimsus tur mus nisimor loremnul natis adipis mauris at. Tristi mauris sellus sfusce iquam sedlorem. Laoreet rutrum volutp sent sodalesm tesque uamnam egetal edonec.\r\n\r\nSapien sque nonmorbi sed portad justo urnaut vestibu dui atein. Orci suspendi primis ecenas ent tique. Miin eduis nean sse mi magnaqu malesu uis esent metusves. Sceler quamnunc quisut elementu dapibusc odioin quis liberofu. Ndisse quamal estnulla risusvi vitaef maurisve aliquam mussed inproin.\r\n\r\nLigula proin molesti auris dictum miproin. Maurisma nequen tcras nuncnunc que leosed orcivest lacus sque teger pulvina uscras esent aenean liquam luctus ut risque laciniai pellent.', ''),
(5, 6, 'Água quente e vapor', '2014-11-27', 'concluido', NULL, 4, '', 'Instituto Campinas', 'IFPS Maceió', 'alencar@uol.com.br', 'Enimdon vallis gravida aenean orcivest orciut enas consequa. Interdum orciduis euismodd ullamco modnam cras. Loremn rproin sed nislsed aliquam sollic anunc. Nequenu viverr gravida eclass lectus leosed nam liquam.\r\n\r\nSociis mi nulla sellus nulla senectus. Telluss tetiam antenull imperdie posuered potent placerat metusd sellus. Quiscras faucib mipraese vestib nascetur uscras duis nequenu elitpr aesent.\r\n\r\nLitora uis adipis orcisusp ullam laoreet sce sfusce aliquete. Maecenas nullam aesent teger eratquis nulla nas malesu oin. Hendre consequa convall magnapro bibend nullam. Uam convalli risusvi parturi euismod ibulum ut nibhnul. Liberom potenti sodalesm varius iquam in iam tsed sodales adipisci metuscra abitur ulum ultricie.', ''),
(6, 4, 'Projeto com Arquivo de teste', '2014-12-11', 'implantado', NULL, 3, '1ca104af5d56bed.pdf', 'teste', 'teste 2', 'teste@teste.com', 'projeto de teste', ''),
(7, 3, 'Teste com novo projeto', '2014-12-11', 'desenvolvimento', NULL, 3, 'f4443a5715e51a0.pdf', 'IFSP Campinas', 'IFSP Campinas 2', 'ricardo@agenciadelucca.com.br', 'Ulum proin sapienna tortor orci mi amet ullamcor enim. Egestas eratquis pornam ridicul sapien integer itor diampr. Sse massacra portado netus vallis mauris quamnunc sque nibhphas. Metussed mnulla ulum mattis pretiu ornare necmae oin platea adipisci.\r\n\r\nTesque nean risusm blandi dignis dictum felisut lacus quispr. Et ultrices sfusce molesti suspendi cras bus. Lacusp nuncnunc vulput laoreetc noninte malesu setiam nunc. Vivamus aenean pellent arcu lobortis lacusaen llus vitaef.\r\n\r\nRissed orbi posuered amus commodo nislin dapibusc gravida class liberofu. Tristiq turpisf magna ligulam viverr lum. Vamus nulla ger liberoa auris nulla tortor dis teger accumsan imperd roin tempusp eratphas eunulla eleifen.', ''),
(8, 4, 'Pedidos', '1989-02-15', 'desenvolvimento', NULL, 4, '2140e3a711566e1.pdf', 'Ricardo Fiorani', 'IFSPQ', 'ricardo.fiorani@gmail.com', 'teste', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_config`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL COMMENT 'invisible',
  `endereco` longtext NOT NULL COMMENT 'Endereço',
  `email_contato` varchar(255) NOT NULL COMMENT 'E-mail para contato.',
  `email_admin` varchar(255) NOT NULL COMMENT 'E-mail do Admin',
  `telefone` varchar(255) NOT NULL COMMENT 'Telefone',
  `url_facebook` varchar(255) NOT NULL COMMENT 'URL (Facebook)',
  `url_pinterest` varchar(255) NOT NULL COMMENT 'URL (Pinterest)',
  `url_instagram` varchar(255) NOT NULL COMMENT 'URL (Instagram)',
  `url_linkedin` varchar(255) NOT NULL COMMENT 'URL (Linkedin)',
  `email_pagseguro` varchar(255) NOT NULL COMMENT 'E-mail (Pagseguro)',
  `token_pagseguro` varchar(255) NOT NULL COMMENT 'Token (Pagseguro)',
  `script_analytics` varchar(255) NOT NULL COMMENT 'Id do Google Analytics (ex : UA-99999999-1)',
  `data_ins` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'invisible',
  `ordem` int(11) NOT NULL COMMENT 'invisible',
  `ativo` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'invisible',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tbl_sys_config`
--

INSERT INTO `tbl_sys_config` (`id`, `nome`, `endereco`, `email_contato`, `email_admin`, `telefone`, `url_facebook`, `url_pinterest`, `url_instagram`, `url_linkedin`, `email_pagseguro`, `token_pagseguro`, `script_analytics`, `data_ins`, `ordem`, `ativo`) VALUES
(1, 'Configurações', 'Rua Atílio Giaretta, n° 40<br>\r\n        Bairro: Adelmo Corradine<br>\r\n        Itatiba/SP<br>\r\n        Cep: 13257-584', 'contato@queroumadoula.com.br', 'contato@queroumadoula.com.br', '(11) 4534.2423', '', '', '', '', 'financeiro@mulheresempoderadas.com.br', 'C39399483A73401D9B589BB8354A3BDA', '', '2012-04-20 17:38:51', 0, 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_log_ips`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_log_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL DEFAULT '0' COMMENT 'Usuário',
  `data` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data',
  `hora` time NOT NULL DEFAULT '00:00:00' COMMENT 'Hora',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `logou` enum('Não','Sim') NOT NULL DEFAULT 'Não',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Extraindo dados da tabela `tbl_sys_log_ips`
--

INSERT INTO `tbl_sys_log_ips` (`id`, `usuario`, `data`, `hora`, `ip`, `logou`) VALUES
(6, 1, '0000-00-00', '16:03:00', '127.0.0.1', ''),
(7, 1, '0000-00-00', '16:03:00', '127.0.0.1', ''),
(8, 1, '0000-00-00', '16:03:00', '127.0.0.1', 'Sim'),
(9, 1, '0000-00-00', '17:11:00', '179.156.211.5', 'Sim'),
(10, 1, '0000-00-00', '18:32:00', '179.159.209.86', 'Sim'),
(11, 1, '0000-00-00', '17:40:00', '179.159.209.86', 'Sim'),
(12, 1, '0000-00-00', '09:58:00', '179.156.211.5', 'Sim'),
(13, 1, '0000-00-00', '16:15:00', '127.0.0.1', 'Sim'),
(14, 1, '0000-00-00', '11:20:00', '127.0.0.1', 'Sim'),
(15, 1, '0000-00-00', '11:20:00', '127.0.0.1', 'Sim'),
(16, 1, '0000-00-00', '16:35:00', '127.0.0.1', 'Sim'),
(17, 1, '0000-00-00', '21:17:00', '127.0.0.1', 'Sim'),
(18, 1, '0000-00-00', '10:19:00', '179.159.101.19', 'Sim'),
(19, 1, '0000-00-00', '11:06:00', '127.0.0.1', 'Sim'),
(20, 1, '0000-00-00', '09:31:00', '127.0.0.1', 'Sim'),
(21, 1, '0000-00-00', '21:23:00', '177.194.72.19', 'Sim'),
(22, 1, '0000-00-00', '21:33:00', '179.156.210.113', 'Sim'),
(23, 1, '0000-00-00', '21:41:00', '177.194.72.19', 'Sim'),
(24, 1, '0000-00-00', '22:04:00', '177.194.72.19', 'Sim'),
(25, 1, '0000-00-00', '19:50:00', '200.144.113.130', 'Sim'),
(26, 1, '0000-00-00', '18:34:00', '189.61.237.160', 'Sim'),
(27, 1, '0000-00-00', '18:38:00', '179.156.210.113', 'Sim'),
(28, 1, '0000-00-00', '09:53:00', '177.194.72.19', 'Sim'),
(29, 1, '0000-00-00', '09:57:00', '177.194.72.19', 'Sim'),
(30, 1, '0000-00-00', '10:09:00', '177.194.72.19', 'Sim'),
(31, 1, '0000-00-00', '13:10:00', '127.0.0.1', 'Sim'),
(32, 1, '0000-00-00', '09:14:00', '177.194.72.19', 'Sim'),
(33, 1, '0000-00-00', '16:38:00', '179.159.110.215', 'Sim'),
(34, 1, '0000-00-00', '16:55:00', '179.159.110.215', 'Sim'),
(35, 1, '0000-00-00', '17:14:00', '127.0.0.1', 'Sim'),
(36, 1, '0000-00-00', '20:25:00', '177.194.72.19', 'Sim'),
(37, 1, '0000-00-00', '15:56:00', '179.159.110.215', 'Sim'),
(38, 1, '0000-00-00', '18:17:00', '179.159.110.215', ''),
(39, 1, '0000-00-00', '18:18:00', '179.159.110.215', 'Sim'),
(40, 1, '0000-00-00', '18:22:00', '179.156.210.113', 'Sim'),
(41, 1, '0000-00-00', '18:27:00', '179.159.110.215', 'Sim'),
(42, 1, '0000-00-00', '18:55:00', '179.159.110.215', 'Sim'),
(43, 1, '0000-00-00', '18:58:00', '179.159.110.215', 'Sim'),
(44, 1, '0000-00-00', '10:17:00', '179.159.110.215', 'Sim'),
(45, 1, '0000-00-00', '10:24:00', '179.159.110.215', 'Sim'),
(46, 1, '0000-00-00', '10:25:00', '179.159.110.215', 'Sim'),
(47, 1, '0000-00-00', '14:08:00', '179.156.210.113', 'Sim'),
(48, 1, '0000-00-00', '14:35:00', '179.159.110.215', 'Sim'),
(49, 1, '0000-00-00', '16:35:00', '179.159.110.215', 'Sim'),
(50, 1, '0000-00-00', '18:14:00', '179.159.110.215', 'Sim'),
(51, 1, '0000-00-00', '18:57:00', '179.159.110.215', 'Sim'),
(52, 1, '0000-00-00', '20:02:00', '200.144.112.8', 'Sim'),
(53, 1, '0000-00-00', '14:01:00', '179.156.210.113', 'Sim'),
(54, 1, '0000-00-00', '14:45:00', '127.0.0.1', 'Sim'),
(55, 1, '0000-00-00', '13:39:00', '179.159.110.215', 'Sim'),
(56, 2, '0000-00-00', '13:53:00', '179.159.110.215', 'Sim'),
(57, 2, '0000-00-00', '13:56:00', '201.55.38.76', 'Sim'),
(58, 1, '0000-00-00', '14:35:00', '179.156.209.186', 'Sim'),
(59, 1, '0000-00-00', '14:40:00', '179.159.110.215', 'Sim'),
(60, 1, '0000-00-00', '14:58:00', '179.159.110.215', 'Sim'),
(61, 1, '0000-00-00', '19:34:00', '200.144.112.8', 'Sim'),
(62, 2, '0000-00-00', '13:51:00', '201.55.38.76', 'Sim'),
(63, 1, '0000-00-00', '14:37:00', '179.159.110.215', 'Sim'),
(64, 1, '0000-00-00', '14:50:00', '179.156.209.186', 'Sim'),
(65, 2, '0000-00-00', '19:42:00', '177.194.72.19', 'Sim'),
(66, 1, '0000-00-00', '20:01:00', '179.156.209.186', 'Sim'),
(67, 2, '0000-00-00', '20:08:00', '187.64.250.238', 'Sim'),
(68, 1, '0000-00-00', '20:36:00', '200.144.112.8', 'Sim'),
(69, 1, '0000-00-00', '22:41:00', '177.194.72.19', 'Sim'),
(70, 1, '0000-00-00', '22:54:00', '177.194.72.19', ''),
(71, 1, '0000-00-00', '22:54:00', '177.194.72.19', 'Sim'),
(72, 1, '0000-00-00', '23:07:00', '66.249.88.152', 'Sim'),
(73, 2, '0000-00-00', '08:32:00', '201.82.58.31', 'Sim'),
(74, 1, '0000-00-00', '10:43:00', '179.156.209.186', 'Sim'),
(75, 1, '0000-00-00', '13:38:00', '179.156.209.186', 'Sim'),
(76, 1, '0000-00-00', '13:49:00', '179.159.110.215', 'Sim'),
(77, 2, '0000-00-00', '14:04:00', '201.55.38.76', 'Sim'),
(78, 2, '0000-00-00', '15:59:00', '201.55.38.76', 'Sim'),
(79, 1, '0000-00-00', '16:15:00', '179.159.110.215', 'Sim'),
(80, 1, '0000-00-00', '17:34:00', '179.159.110.215', 'Sim'),
(81, 2, '0000-00-00', '18:39:00', '177.194.72.19', 'Sim'),
(82, 1, '0000-00-00', '19:52:00', '179.159.110.215', 'Sim'),
(83, 2, '0000-00-00', '20:47:00', '177.194.72.19', 'Sim'),
(84, 2, '0000-00-00', '20:49:00', '187.64.250.238', ''),
(85, 2, '0000-00-00', '20:49:00', '187.64.250.238', ''),
(86, 2, '0000-00-00', '20:50:00', '187.64.250.238', 'Sim'),
(87, 1, '0000-00-00', '21:06:00', '179.159.110.215', 'Sim'),
(88, 2, '0000-00-00', '08:28:00', '201.55.38.76', 'Sim'),
(89, 2, '0000-00-00', '08:33:00', '187.64.250.238', 'Sim'),
(90, 1, '0000-00-00', '08:43:00', '179.159.110.215', 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL COMMENT 'Nome',
  `pagina` varchar(255) NOT NULL COMMENT 'Página',
  `class` varchar(255) NOT NULL COMMENT 'Classe (CSS)',
  `parent` mediumint(9) NOT NULL COMMENT 'Parent',
  `ordem` int(11) NOT NULL COMMENT 'invisible',
  `ativo` enum('Sim','Não') NOT NULL COMMENT 'Menu disponível',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `tbl_sys_menu`
--

INSERT INTO `tbl_sys_menu` (`id`, `nome`, `pagina`, `class`, `parent`, `ordem`, `ativo`) VALUES
(1, 'Parent Vazio', '', '', 0, 10, 'Sim'),
(19, 'Projetos', 'page_projetos.php', 'li_padrao', 1, 1, 'Sim'),
(20, 'Usuarios', 'page_usuarios.php', 'li_padrao', 1, 0, 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_newsletter`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tbl_sys_newsletter`
--

INSERT INTO `tbl_sys_newsletter` (`id`, `nome`, `email`) VALUES
(5, 'Ricardo Fiorani', 'ricardo.fiorani@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_seo`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL COMMENT 'url (ex: /novo-detalhes/1/all-new-cerato/) Sempre iniciado com barra "/"',
  `seo_title` varchar(255) NOT NULL COMMENT 'invisible',
  `seo_keywords` varchar(255) NOT NULL COMMENT 'Meta Tag - SEO : Keywords',
  `seo_description` varchar(255) NOT NULL COMMENT 'Meta Tag - SEO : Description',
  `ordem` int(11) NOT NULL COMMENT 'invisible',
  `ativo` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'invisible',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tbl_sys_seo`
--

INSERT INTO `tbl_sys_seo` (`id`, `nome`, `seo_title`, `seo_keywords`, `seo_description`, `ordem`, `ativo`) VALUES
(1, 'Meta Tags Padrão', '', 'Keywords do site', 'Description do Site', 0, 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_textos_gerais`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_textos_gerais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL COMMENT 'invisible',
  `nome` varchar(255) NOT NULL COMMENT 'Nome',
  `descricao` longtext NOT NULL COMMENT 'Descrição',
  `ordem` int(11) NOT NULL COMMENT 'invisible',
  `ativo` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Visível no site ?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sys_usuarios`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordem` int(11) NOT NULL DEFAULT '0' COMMENT 'invisible',
  `ativo` enum('Não','Sim','') DEFAULT NULL COMMENT 'Ativo',
  `login` varchar(255) NOT NULL DEFAULT '' COMMENT 'Login',
  `senha` varchar(50) DEFAULT NULL COMMENT 'Senha',
  `nome` varchar(255) NOT NULL DEFAULT '' COMMENT 'Nome',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Email',
  `cadastrado` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data do Cadastro',
  `datas` mediumtext NOT NULL COMMENT 'Datas de Acessos',
  `ips` mediumtext NOT NULL COMMENT 'IPs de Acessos',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tbl_sys_usuarios`
--

INSERT INTO `tbl_sys_usuarios` (`id`, `ordem`, `ativo`, `login`, `senha`, `nome`, `email`, `cadastrado`, `datas`, `ips`) VALUES
(1, 1, 'Sim', 'ricardos', 'fc25f57bf41c84b0e820185c740a5150', 'Admin Master', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_usuarios`
--

CREATE TABLE IF NOT EXISTS `tbl_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nome`, `email`, `senha`, `cpf`, `cidade`, `uf`, `endereco`, `numero`, `complemento`) VALUES
(3, 'Ricardo Bernardo', 'ricardo@umbernardo.com.br', 'c7641b881dbdbfe9c3c00acb7500b5f4', '29119091869', 'Sorocaba', 'sp', 'Av. General Carneiro', '1122', '34'),
(4, 'Ricardo Fiorani', 'ricardo.fiorani@gmail.com', 'cea70f58e6cbbb10d3b0a4b04bdf810e', '380.667.418-39', '', '', '', '', ''),
(5, '', '', 'e99086a68a53dd4238af39d47ad6c278', '', '', '', '', '', ''),
(6, 'Alencar', 'ricardo@agenciadelucca.com.br', '46600b0de3fe91edfc8bb1ef9c5c5ccf', '2999999999999', 'Campinas', 'SP', 'Rua teste', '234', 'e34'),
(7, 'leonardo rocco', 'leeo.rocco@gmail.com', '7031efaadbae8895ecc44094d1736316', '402.216.078-03', 'Salto', 'sp', 'Roque Lazzazera', '1212', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
