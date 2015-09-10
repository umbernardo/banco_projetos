-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2015 at 08:46 PM
-- Server version: 5.5.42-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `umbernar_db_projetos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projetos`
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
-- Dumping data for table `tbl_projetos`
--

INSERT INTO `tbl_projetos` (`id`, `id_usuario`, `nome`, `data_inicio`, `status`, `id_coordenador`, `id_desenvolvedor`, `arquivo`, `nome_demandante`, `instituicao_demandante`, `email_demandante`, `resumo`, `pdf`) VALUES
(4, 3, 'Computador para todos', '2014-11-27', 'desenvolvimento', NULL, 3, '', 'Andre Fernando Pereira da Silva', 'IFPS Maceió', 'andre.fernando@edu.uniso.br', 'Quamve faucibus aliquet mauris iumsed justonul tiam. Enimsus tur mus nisimor loremnul natis adipis mauris at. Tristi mauris sellus sfusce iquam sedlorem. Laoreet rutrum volutp sent sodalesm tesque uamnam egetal edonec.\r\n\r\nSapien sque nonmorbi sed portad justo urnaut vestibu dui atein. Orci suspendi primis ecenas ent tique. Miin eduis nean sse mi magnaqu malesu uis esent metusves. Sceler quamnunc quisut elementu dapibusc odioin quis liberofu. Ndisse quamal estnulla risusvi vitaef maurisve aliquam mussed inproin.\r\n\r\nLigula proin molesti auris dictum miproin. Maurisma nequen tcras nuncnunc que leosed orcivest lacus sque teger pulvina uscras esent aenean liquam luctus ut risque laciniai pellent.', ''),
(7, 3, 'Teste com novo projeto', '2014-12-11', 'desenvolvimento', NULL, 3, 'f4443a5715e51a0.pdf', 'IFSP Campinas', 'IFSP Campinas 2', 'ricardo@agenciadelucca.com.br', 'Ulum proin sapienna tortor orci mi amet ullamcor enim. Egestas eratquis pornam ridicul sapien integer itor diampr. Sse massacra portado netus vallis mauris quamnunc sque nibhphas. Metussed mnulla ulum mattis pretiu ornare necmae oin platea adipisci.\r\n\r\nTesque nean risusm blandi dignis dictum felisut lacus quispr. Et ultrices sfusce molesti suspendi cras bus. Lacusp nuncnunc vulput laoreetc noninte malesu setiam nunc. Vivamus aenean pellent arcu lobortis lacusaen llus vitaef.\r\n\r\nRissed orbi posuered amus commodo nislin dapibusc gravida class liberofu. Tristiq turpisf magna ligulam viverr lum. Vamus nulla ger liberoa auris nulla tortor dis teger accumsan imperd roin tempusp eratphas eunulla eleifen.', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_config`
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
-- Dumping data for table `tbl_sys_config`
--

INSERT INTO `tbl_sys_config` (`id`, `nome`, `endereco`, `email_contato`, `email_admin`, `telefone`, `url_facebook`, `url_pinterest`, `url_instagram`, `url_linkedin`, `email_pagseguro`, `token_pagseguro`, `script_analytics`, `data_ins`, `ordem`, `ativo`) VALUES
(1, 'Configurações', 'Rua Atílio Giaretta, n° 40<br>\r\n        Bairro: Adelmo Corradine<br>\r\n        Itatiba/SP<br>\r\n        Cep: 13257-584', 'contato@queroumadoula.com.br', 'contato@queroumadoula.com.br', '(11) 4534.2423', '', '', '', '', 'financeiro@mulheresempoderadas.com.br', 'C39399483A73401D9B589BB8354A3BDA', '', '2012-04-20 17:38:51', 0, 'Sim');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_log_ips`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_log_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL DEFAULT '0' COMMENT 'Usuário',
  `data` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data',
  `hora` time NOT NULL DEFAULT '00:00:00' COMMENT 'Hora',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `logou` enum('Não','Sim') NOT NULL DEFAULT 'Não',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_menu`
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
-- Dumping data for table `tbl_sys_menu`
--

INSERT INTO `tbl_sys_menu` (`id`, `nome`, `pagina`, `class`, `parent`, `ordem`, `ativo`) VALUES
(1, 'Parent Vazio', '', '', 0, 10, 'Sim'),
(19, 'Projetos', 'page_projetos.php', 'li_padrao', 1, 1, 'Sim'),
(20, 'Usuarios', 'page_usuarios.php', 'li_padrao', 1, 0, 'Sim');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_newsletter`
--

CREATE TABLE IF NOT EXISTS `tbl_sys_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_sys_newsletter`
--

INSERT INTO `tbl_sys_newsletter` (`id`, `nome`, `email`) VALUES
(5, 'Ricardo Fiorani', 'ricardo.fiorani@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_seo`
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
-- Dumping data for table `tbl_sys_seo`
--

INSERT INTO `tbl_sys_seo` (`id`, `nome`, `seo_title`, `seo_keywords`, `seo_description`, `ordem`, `ativo`) VALUES
(1, 'Meta Tags Padrão', '', 'Keywords do site', 'Description do Site', 0, 'Sim');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_textos_gerais`
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
-- Table structure for table `tbl_sys_usuarios`
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
-- Dumping data for table `tbl_sys_usuarios`
--

INSERT INTO `tbl_sys_usuarios` (`id`, `ordem`, `ativo`, `login`, `senha`, `nome`, `email`, `cadastrado`, `datas`, `ips`) VALUES
(1, 1, 'Sim', 'ricardos', 'fc25f57bf41c84b0e820185c740a5150', 'Admin Master', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuarios`
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
-- Dumping data for table `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nome`, `email`, `senha`, `cpf`, `cidade`, `uf`, `endereco`, `numero`, `complemento`) VALUES
(3, 'Ricardo Bernardo', 'ricardo@umbernardo.com.br', 'c7641b881dbdbfe9c3c00acb7500b5f4', '29119091869', 'Sorocaba', 'sp', 'Av. General Carneiro', '1122', '34'),
(6, 'Alencar', 'ricardo@agenciadelucca.com.br', '46600b0de3fe91edfc8bb1ef9c5c5ccf', '2999999999999', 'Campinas', 'SP', 'Rua teste', '234', 'e34'),
(7, 'leonardo rocco', 'leeo.rocco@gmail.com', '7031efaadbae8895ecc44094d1736316', '402.216.078-03', 'Salto', 'sp', 'Roque Lazzazera', '1212', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
