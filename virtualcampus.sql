-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2017 alle 14:16
-- Versione del server: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `virtualcampus`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
`id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `courses`
--

INSERT INTO `courses` (`id`, `nome`, `descrizione`) VALUES
(1, 'Sistemi e tecnologie web', 'STW '),
(2, 'Matematica 1', 'MAT1'),
(3, 'Matematica 2', 'MAT2'),
(4, 'Matematica 3', 'MAT3'),
(5, 'Reti logiche', 'RLO');

-- --------------------------------------------------------

--
-- Struttura della tabella `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
`id` int(11) NOT NULL,
  `idMittente` int(11) NOT NULL,
  `idDestinatario` int(11) NOT NULL,
  `oggetto` varchar(64) NOT NULL,
  `testo` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `letto` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `emails`
--

INSERT INTO `emails` (`id`, `idMittente`, `idDestinatario`, `oggetto`, `testo`, `data`, `letto`) VALUES
(1, 1, 4, 'Ciao', 'Email di prova', '2017-02-01 10:22:12', 1),
(3, 4, 1, 'Re: Ciao', 'RISPOSTA\r\n\r\nEmail di prova', '2017-02-03 10:57:04', 1),
(4, 1, 4, 'Aggiornamento stato esame Matematica 2', '22/30', '2017-02-22 09:05:32', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `exams`
--

CREATE TABLE IF NOT EXISTS `exams` (
`id` int(11) NOT NULL,
  `idCorso` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `loc` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `exams`
--

INSERT INTO `exams` (`id`, `idCorso`, `data`, `loc`) VALUES
(1, 3, '2016-10-11 10:00:00', 'Milano'),
(2, 4, '2016-10-19 11:00:00', 'Roma'),
(3, 5, '2016-10-20 12:00:00', 'Regona'),
(4, 3, '2016-10-31 15:00:00', 'Rieti'),
(5, 4, '2017-02-23 10:00:00', 'Cremona');

-- --------------------------------------------------------

--
-- Struttura della tabella `results`
--

CREATE TABLE IF NOT EXISTS `results` (
`id` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idEsame` int(11) NOT NULL,
  `stato` text NOT NULL,
  `corretto` tinyint(1) NOT NULL,
  `verbalizzato` tinyint(1) NOT NULL,
  `accettato` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dump dei dati per la tabella `results`
--

INSERT INTO `results` (`id`, `idUtente`, `idEsame`, `stato`, `corretto`, `verbalizzato`, `accettato`) VALUES
(1, 4, 3, '25/30', 1, 1, 0),
(20, 4, 1, '22/30', 1, 0, 1),
(21, 4, 2, '24/30', 1, 1, 0),
(22, 4, 4, '30 e lode', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `nome` text NOT NULL,
  `cognome` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `nome`, `cognome`, `username`, `password`, `isAdmin`) VALUES
(1, 'Amministratore', 'Amministratore', 'admin', 'admin', 1),
(4, 'Samuele', 'Bacchetta', 'samuele', 'samuele', 0),
(5, 'Davide', 'Bacchetta', 'davide', 'davide', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `usersdetail`
--

CREATE TABLE IF NOT EXISTS `usersdetail` (
`id` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idCorso` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `usersdetail`
--

INSERT INTO `usersdetail` (`id`, `idUtente`, `idCorso`) VALUES
(1, 4, 3),
(2, 4, 4),
(3, 4, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
 ADD PRIMARY KEY (`id`), ADD KEY `idMittente` (`idMittente`), ADD KEY `idDestinatario` (`idDestinatario`), ADD KEY `idMittente_2` (`idMittente`,`idDestinatario`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
 ADD PRIMARY KEY (`id`), ADD KEY `corso` (`idCorso`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
 ADD PRIMARY KEY (`id`), ADD KEY `idUtente` (`idUtente`), ADD KEY `idEsame` (`idEsame`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usersdetail`
--
ALTER TABLE `usersdetail`
 ADD PRIMARY KEY (`id`), ADD KEY `idUtente` (`idUtente`), ADD KEY `idCorso` (`idCorso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usersdetail`
--
ALTER TABLE `usersdetail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
