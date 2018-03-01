-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 01 Mars 2018 à 09:28
-- Version du serveur: 5.5.50-0ubuntu0.14.04.1-log
-- Version de PHP: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `web230_main`
--

-- --------------------------------------------------------

--
-- Structure de la table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `guid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `age` smallint(6) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `PERSON` (`lastname`(1),`firstname`(1))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `people`
--

INSERT INTO `people` (`guid`, `lastname`, `firstname`, `age`, `gender`, `category`) VALUES
(1, 'ddfdf', 'dfdfdf', 23, 1, 'dfdfdf');
