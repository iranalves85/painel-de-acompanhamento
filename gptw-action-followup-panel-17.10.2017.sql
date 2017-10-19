-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17-Out-2017 às 05:17
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gptw-action-followup-panel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_activity`
--

CREATE TABLE `pa_activity` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `what` varchar(255) NOT NULL,
  `because` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `who` varchar(255) NOT NULL,
  `how` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `moment` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_activity`
--

INSERT INTO `pa_activity` (`id`, `project`, `plan`, `name`, `description`, `what`, `because`, `place`, `who`, `how`, `cost`, `moment`, `status`, `date_created`) VALUES
(15, 120, 65, 'Ella Briggs', 'midkimul', 'pi', 'zaewo', 'rajpu', '35', '35', 'kaf', '2017-10-11', 2, '2017-10-09 03:10:10'),
(16, 120, 67, 'a', 'b', 'c', 'd', 'e', '36', '36', 'R$ 450,00', '2017-10-12', 1, '2017-10-09 03:21:33'),
(17, 120, 65, 'Norman Todd', 'ugova', 'nimsajzo', 'mo', 'di', '37', '37', 'ove', '2017-10-24', 2, '2017-10-09 03:27:49'),
(18, 120, 72, 'Dustin Scott', 'huwaf', 'jemju', 'guwvi', 'iku', '40', '40', 'urcum', '2017-10-31', 1, '2017-10-16 21:21:05'),
(19, 120, 73, 'Carolyn Mack', 'eci', 'su', 'ogasi', 'gi', '40', '40', 'udro', '2017-10-31', 1, '2017-10-17 00:14:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_company`
--

CREATE TABLE `pa_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_company`
--

INSERT INTO `pa_company` (`id`, `name`) VALUES
(1, 'Making Pie'),
(2, 'Google'),
(66, 'Titanium'),
(69, 'HSM do Brasil'),
(70, 'Casas Bahia'),
(71, 'Cachorro Grande'),
(72, 'Microsoft'),
(73, 'Pr Consulting');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_emails`
--

CREATE TABLE `pa_emails` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `type` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_emails`
--

INSERT INTO `pa_emails` (`id`, `project`, `message`, `type`) VALUES
(9, 120, 'Email de cobrança', 'charge'),
(10, 120, 'E-mail de boas vindas', 'welcome');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_evidence`
--

CREATE TABLE `pa_evidence` (
  `id` int(11) NOT NULL,
  `activity` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_evidence`
--

INSERT INTO `pa_evidence` (`id`, `activity`, `topic`, `action`, `date_created`) VALUES
(35, 14, 'a:2:{s:11:"description";s:23:"agilidade é importante";s:4:"name";s:9:"Agilidade";}', 'pumel', '2017-10-09 03:09:46'),
(36, 15, 'a:2:{s:11:"description";s:20:"ética é importante";s:4:"name";s:6:"Ética";}', 'le', '2017-10-09 03:10:10'),
(37, 16, 'a:2:{s:11:"description";s:20:"ética é importante";s:4:"name";s:6:"Ética";}', 'Melhorar tratamento', '2017-10-09 03:21:33'),
(38, 16, 'a:2:{s:11:"description";s:25:"compromisso é importante";s:4:"name";s:11:"Compromisso";}', 'Assumi compromisso com funcionários', '2017-10-09 03:21:33'),
(39, 16, 'a:2:{s:11:"description";s:23:"agilidade é importante";s:4:"name";s:9:"Agilidade";}', 'Entregas mais ágeis', '2017-10-09 03:21:33'),
(40, 17, 'a:2:{s:11:"description";s:20:"ética é importante";s:4:"name";s:6:"Ética";}', 'mutajme', '2017-10-09 03:27:49'),
(41, 17, 'a:2:{s:11:"description";s:25:"compromisso é importante";s:4:"name";s:11:"Compromisso";}', 'sdsdsddasdd', '2017-10-09 03:27:49'),
(42, 17, 'a:2:{s:11:"description";s:23:"agilidade é importante";s:4:"name";s:9:"Agilidade";}', 'dsadadsadasdad', '2017-10-09 03:27:49'),
(43, 18, 'a:2:{s:11:"description";s:20:"ética é importante";s:4:"name";s:6:"Ética";}', 'kekuwgok', '2017-10-16 21:21:05'),
(44, 19, 'a:2:{s:11:"description";s:25:"compromisso é importante";s:4:"name";s:11:"Compromisso";}', 'pinu', '2017-10-17 00:14:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_model`
--

CREATE TABLE `pa_model` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) NOT NULL,
  `topics` varchar(1000) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_model`
--

INSERT INTO `pa_model` (`id`, `name`, `description`, `topics`, `date_created`) VALUES
(64, 'Modelo X', 'Um modelo todo especial', 'a:3:{i:0;a:2:{s:4:"name";s:6:"Ética";s:11:"description";s:20:"ética é importante";}i:1;a:2:{s:4:"name";s:11:"Compromisso";s:11:"description";s:25:"compromisso é importante";}i:2;a:2:{s:4:"name";s:9:"Agilidade";s:11:"description";s:23:"agilidade é importante";}}', '2017-10-09 02:52:23'),
(66, 'XBrent Barnes', 'gegecip', 'a:1:{i:0;a:2:{s:4:"name";s:10:"Clara Carr";s:11:"description";s:5:"figfo";}}', '2017-10-09 04:25:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_plan`
--

CREATE TABLE `pa_plan` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `goal` varchar(255) NOT NULL,
  `company` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_plan`
--

INSERT INTO `pa_plan` (`id`, `project`, `name`, `description`, `cost`, `goal`, `company`, `owner`, `deadline`, `status`, `date_created`) VALUES
(65, 120, 'Eva Abbott', 'sidow', 'lefibzes', 'Nova meta', 0, 35, '2017-10-12', 1, '2017-10-09 03:01:12'),
(67, 120, 'Meu plano 1', 'descrição do plano', 'R$ 250,00', 'Aumentar profissionalização', 0, 36, '2017-10-10', 1, '2017-10-09 03:19:52'),
(68, 120, 'Kate Ingram', 'pokup', 'anu', 'modilne', 0, 37, '2017-11-30', 1, '2017-10-09 03:29:07'),
(70, 120, 'Shane Lloyd', 'tibuge', 'cic', 'duabo', 0, 35, '2017-10-14', 1, '2017-10-09 04:49:59'),
(71, 120, 'Teste de Plano em atraso', 'teste de plano', 'R$ 1.000,00', 'Atingir meta', 0, 37, '2017-10-10', 3, '2017-10-09 05:48:43'),
(72, 120, 'Phoebe Lewis', 'ipewajrac', 'genotbet', 'goh', 0, 40, '2017-10-21', 3, '2017-10-16 14:59:26'),
(73, 120, 'Nell Thompson', 'ubmo', 'riziba', 'up', 0, 40, '2017-10-18', 1, '2017-10-16 23:23:50'),
(76, 120, 'Tyler Barber', 'lo', 'zibet', 'gam', 0, 40, '2017-10-19', 3, '2017-10-17 00:39:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_project`
--

CREATE TABLE `pa_project` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `responsible` varchar(255) NOT NULL,
  `approver` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_project`
--

INSERT INTO `pa_project` (`id`, `company`, `model`, `responsible`, `approver`, `status`, `date_created`) VALUES
(120, 1, 64, 'a:1:{i:0;s:2:"38";}', 35, 1, '2017-10-09 02:54:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_rule_define`
--

CREATE TABLE `pa_rule_define` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `rules` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_rule_define`
--

INSERT INTO `pa_rule_define` (`id`, `project`, `rules`) VALUES
(114, 120, 'a:2:{s:6:"danger";a:3:{s:11:"conditional";s:1:"0";s:3:"qtd";s:1:"2";s:5:"types";a:3:{s:2:"id";s:1:"2";s:13:"identificador";s:1:"d";s:4:"name";s:4:"Dias";}}s:7:"warning";a:3:{s:11:"conditional";s:1:"0";s:3:"qtd";s:1:"4";s:5:"types";a:3:{s:2:"id";s:1:"2";s:13:"identificador";s:1:"d";s:4:"name";s:4:"Dias";}}}'),
(115, 122, 'a:2:{s:6:"danger";a:3:{s:11:"conditional";s:1:"1";s:3:"qtd";s:1:"1";s:5:"types";a:3:{s:2:"id";s:1:"2";s:13:"identificador";s:1:"d";s:4:"name";s:4:"Dias";}}s:7:"warning";a:3:{s:11:"conditional";s:1:"0";s:3:"qtd";s:2:"10";s:5:"types";a:3:{s:2:"id";s:1:"2";s:13:"identificador";s:1:"d";s:4:"name";s:4:"Dias";}}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_status`
--

CREATE TABLE `pa_status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_status`
--

INSERT INTO `pa_status` (`id`, `status`) VALUES
(1, 'Em Aberto'),
(2, 'Finalizado'),
(3, 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_type_user`
--

CREATE TABLE `pa_type_user` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_type_user`
--

INSERT INTO `pa_type_user` (`id`, `type`) VALUES
(1, 'superuser'),
(2, 'human-resources'),
(3, 'manager');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_users`
--

CREATE TABLE `pa_users` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `leader` varchar(1000) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `type_user` int(1) NOT NULL DEFAULT '3',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_users`
--

INSERT INTO `pa_users` (`id`, `project`, `company`, `username`, `email`, `password`, `area`, `leader`, `type_user`, `date_created`) VALUES
(1, 0, 0, 'Iran Alves', 'superuser@gptw.com', '$2y$10$AmFl4xd0Q7MNwe5DB9nageAm2RR0QbedQrr2o3LWuD9uUqv1d/fQm', 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', 1, '2017-09-01 15:00:00'),
(35, 120, 1, 'user', 'user@gmail.com', '$2y$10$.d9uveOGxjXGvvn5mQeR7.mA2oDwrEaGBrEX0VvuaqdaSbHKF9e52', 'a:1:{i:0;s:20:"Área de Aprovação";}', 'a:1:{i:0;s:0:"";}', 0, '2017-10-09 02:54:23'),
(36, 120, 1, 'user3', 'user3@gmail.com', '$2y$10$yk5pWe6Po4VT2NG0kVEYJeT5FFkaWuYhjfdt3rMA1Z/T11tb5esXC', 'a:1:{i:0;s:10:"Operação";}', 'a:1:{i:0;s:0:"";}', 0, '2017-10-09 02:54:24'),
(37, 120, 1, 'user2', 'user2@gmail.com', '$2y$10$hyr.HH8LhWn73j9z./9Le.OiY.C.8x7fLSpwy7d7cH.IYtfr0JQh6', 'a:1:{i:0;s:10:"Operação";}', 'a:1:{i:0;s:17:"reginal@gmail.com";}', 0, '2017-10-09 03:16:14'),
(38, 120, 1, 'user6', 'user6@gmail.com', '$2y$10$c90fHmexnrCwjonk6rTxFO3nPgcXiXEie1b0vSEno9gtPYrWEid5S', 'a:1:{i:0;s:16:"Recursos Humanos";}', 'a:1:{i:0;s:15:"user7@gmail.com";}', 0, '2017-10-09 03:35:08'),
(39, 122, 1, 'user7', 'user7@gmail.com', '$2y$10$WU4EBkAYXItavyEEjBOChODkerENSCmqDwt./sIrD5XyY/EkZkIam', 'a:1:{i:0;s:7:"Diretor";}', 'a:1:{i:0;s:0:"";}', 0, '2017-10-09 03:35:08'),
(40, 120, 1, 'reginaldo', 'reginal@gmail.com', '$2y$10$xaAyA6W4Dl2mCJ2omcx1xOjVzSy3WwetyXUXeqh6DPKSWeNqTOc9O', 'a:1:{i:0;s:16:"Recursos Humanos";}', 'a:1:{i:0;s:14:"user@gmail.com";}', 0, '2017-10-09 07:26:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pa_activity`
--
ALTER TABLE `pa_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_company`
--
ALTER TABLE `pa_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_emails`
--
ALTER TABLE `pa_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_evidence`
--
ALTER TABLE `pa_evidence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_model`
--
ALTER TABLE `pa_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_plan`
--
ALTER TABLE `pa_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_project`
--
ALTER TABLE `pa_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_rule_define`
--
ALTER TABLE `pa_rule_define`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_status`
--
ALTER TABLE `pa_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_type_user`
--
ALTER TABLE `pa_type_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_users`
--
ALTER TABLE `pa_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pa_activity`
--
ALTER TABLE `pa_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pa_company`
--
ALTER TABLE `pa_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `pa_emails`
--
ALTER TABLE `pa_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pa_evidence`
--
ALTER TABLE `pa_evidence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `pa_model`
--
ALTER TABLE `pa_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `pa_plan`
--
ALTER TABLE `pa_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `pa_project`
--
ALTER TABLE `pa_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT for table `pa_rule_define`
--
ALTER TABLE `pa_rule_define`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `pa_status`
--
ALTER TABLE `pa_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pa_type_user`
--
ALTER TABLE `pa_type_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pa_users`
--
ALTER TABLE `pa_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
