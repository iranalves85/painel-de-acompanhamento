-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21-Set-2017 às 08:08
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
  `int` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `what` varchar(255) NOT NULL,
  `because` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL,
  `who` varchar(255) NOT NULL,
  `how` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_approver`
--

CREATE TABLE `pa_approver` (
  `id` int(11) NOT NULL,
  `approver` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_approver`
--

INSERT INTO `pa_approver` (`id`, `approver`) VALUES
(1, 'rh'),
(2, 'gestor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_area`
--

CREATE TABLE `pa_area` (
  `id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_area`
--

INSERT INTO `pa_area` (`id`, `area`) VALUES
(1, 'Marketing'),
(2, 'Financeiro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_company`
--

CREATE TABLE `pa_company` (
  `id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_company`
--

INSERT INTO `pa_company` (`id`, `company`) VALUES
(1, 'Making Pie'),
(2, 'Google');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_deadline`
--

CREATE TABLE `pa_deadline` (
  `id` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `rule_define` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_deadline`
--

INSERT INTO `pa_deadline` (`id`, `plan`, `deadline`, `rule_define`) VALUES
(1, 1, '2017-09-30', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_evidence`
--

CREATE TABLE `pa_evidence` (
  `id` int(11) NOT NULL,
  `activity` int(11) NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_model`
--

CREATE TABLE `pa_model` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `topics` varchar(1000) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_model`
--

INSERT INTO `pa_model` (`id`, `model`, `description`, `topics`, `date_created`) VALUES
(1, 'Novo Modelo', 'Um exemplo de modelo', '[{"id":"1","name":"Ética","description","Uma descrição"}]', '0000-00-00 00:00:00'),
(2, 'Modelo 2', 'Descrição de novo', '', '0000-00-00 00:00:00'),
(3, 'Lizzie Graves', 'run', 's:0:"";', '0000-00-00 00:00:00'),
(4, 'Lizzie Graves', 'run', 'b:0;', '0000-00-00 00:00:00'),
(5, 'weeew', 'ewewewew', 'b:0;', '0000-00-00 00:00:00'),
(6, 'sasaSas', 'dsdsds', 'b:0;', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_plan`
--

CREATE TABLE `pa_plan` (
  `id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `company` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_plan`
--

INSERT INTO `pa_plan` (`id`, `project`, `name`, `description`, `company`, `owner`, `deadline`, `status`, `date_created`) VALUES
(1, 0, 'Aumentar Receita', 'Uma breve descrição sobre o plano', 1, 1, 1, 1, '2017-09-04 09:25:00'),
(2, 0, 'Novo valor', 'Gerar novo valor de atribução', 2, 2, 2, 2, '2017-09-15 01:30:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_project`
--

CREATE TABLE `pa_project` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `approver` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_project`
--

INSERT INTO `pa_project` (`id`, `company`, `model`, `user`, `approver`, `status`, `date_created`) VALUES
(1, 1, 1, 1, 1, 1, '2017-09-01 08:00:00'),
(2, 2, 2, 2, 2, 1, '2017-09-05 10:14:14'),
(3, 2, 2, 1, 1, 0, '0000-00-00 00:00:00'),
(4, 1, 2, 1, 2, 1, '2017-09-11 05:09:29'),
(5, 2, 2, 1, 2, 1, '2017-09-11 00:29:08'),
(6, 1, 2, 1, 1, 1, '2017-09-11 00:29:29'),
(7, 1, 2, 1, 1, 1, '2017-09-11 00:29:37'),
(8, 1, 2, 1, 2, 1, '2017-09-11 00:30:28'),
(9, 1, 1, 1, 2, 1, '2017-09-11 00:34:49'),
(10, 0, 2, 2, 1, 1, '2017-09-12 02:43:48'),
(11, 0, 2, 1, 1, 1, '2017-09-12 02:52:26'),
(12, 0, 2, 1, 1, 1, '2017-09-12 02:53:40'),
(13, 0, 2, 1, 1, 1, '2017-09-12 02:54:19'),
(14, 0, 2, 1, 1, 1, '2017-09-12 02:55:17'),
(15, 0, 2, 1, 1, 1, '2017-09-12 02:56:45'),
(16, 0, 2, 1, 1, 1, '2017-09-12 02:59:31'),
(17, 0, 2, 1, 1, 1, '2017-09-12 03:00:48'),
(18, 0, 2, 1, 2, 1, '2017-09-12 03:06:40'),
(19, 0, 2, 1, 2, 1, '2017-09-12 03:07:39'),
(20, 0, 2, 2, 1, 1, '2017-09-12 03:10:05'),
(21, 0, 2, 2, 1, 1, '2017-09-12 03:10:34'),
(22, 1, 2, 2, 1, 1, '2017-09-12 03:10:41'),
(23, 0, 2, 1, 1, 1, '2017-09-12 03:20:21'),
(24, 0, 2, 1, 1, 1, '2017-09-12 03:20:38'),
(25, 0, 2, 2, 2, 1, '2017-09-13 04:01:40'),
(26, 0, 2, 2, 1, 1, '2017-09-14 00:13:20'),
(27, 0, 2, 2, 1, 1, '2017-09-14 00:16:16'),
(28, 0, 2, 2, 1, 1, '2017-09-14 00:17:47'),
(29, 0, 0, 0, 0, 1, '2017-09-14 00:28:39'),
(30, 0, 2, 1, 1, 1, '2017-09-14 00:38:36'),
(31, 0, 2, 1, 1, 1, '2017-09-14 00:38:51'),
(32, 0, 0, 0, 0, 1, '2017-09-14 23:14:30'),
(33, 0, 0, 0, 0, 1, '2017-09-15 13:13:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_rule`
--

CREATE TABLE `pa_rule` (
  `id` int(11) NOT NULL,
  `rule` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_rule`
--

INSERT INTO `pa_rule` (`id`, `rule`) VALUES
(1, 'verde'),
(2, 'amarelo'),
(3, 'vermelho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_rule_define`
--

CREATE TABLE `pa_rule_define` (
  `id` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `type_rule` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_rule_define`
--

INSERT INTO `pa_rule_define` (`id`, `plan`, `type_rule`, `date`) VALUES
(1, 1, 1, '2017-09-14');

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
(1, 'aberto'),
(2, 'finalizado'),
(3, 'aprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_type_user`
--

CREATE TABLE `pa_type_user` (
  `id` int(11) NOT NULL,
  `type_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_type_user`
--

INSERT INTO `pa_type_user` (`id`, `type_user`) VALUES
(1, 'superuser'),
(2, 'human-resources'),
(3, 'manager');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pa_users`
--

CREATE TABLE `pa_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `area` int(11) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `leader` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `approver` int(11) DEFAULT NULL,
  `type_user` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pa_users`
--

INSERT INTO `pa_users` (`id`, `username`, `email`, `password`, `area`, `company`, `leader`, `approver`, `type_user`, `date_created`) VALUES
(1, 'Iran José Alves', 'superuser@gptw.com', '123456', 1, 1, NULL, 1, 1, '2017-09-01 15:00:00'),
(2, 'Romualdo Alves', 'rh@gptw.com', '123456', 2, 2, NULL, 2, 2, '2017-09-08 16:30:00'),
(3, 'Gestor da Silva', 'gestor@gptw.com', '123456', 1, 1, '1', 2, 3, '2017-09-15 14:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pa_activity`
--
ALTER TABLE `pa_activity`
  ADD PRIMARY KEY (`int`);

--
-- Indexes for table `pa_approver`
--
ALTER TABLE `pa_approver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_area`
--
ALTER TABLE `pa_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_company`
--
ALTER TABLE `pa_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_deadline`
--
ALTER TABLE `pa_deadline`
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
-- Indexes for table `pa_rule`
--
ALTER TABLE `pa_rule`
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
  MODIFY `int` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pa_approver`
--
ALTER TABLE `pa_approver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pa_area`
--
ALTER TABLE `pa_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pa_company`
--
ALTER TABLE `pa_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pa_deadline`
--
ALTER TABLE `pa_deadline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pa_model`
--
ALTER TABLE `pa_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pa_plan`
--
ALTER TABLE `pa_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pa_project`
--
ALTER TABLE `pa_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `pa_rule`
--
ALTER TABLE `pa_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pa_rule_define`
--
ALTER TABLE `pa_rule_define`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
