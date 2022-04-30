--
-- Structure de la table `network_vision`
--
CREATE TABLE IF NOT EXISTS `network_vision` (
  `id` int(11) NOT NULL,
  `si_id` int(11) NOT NULL,
  `mes_prevu` int(10) DEFAULT NULL,
  `ann_prevu` int(11) NOT NULL,
  `entre` varchar(30) NOT NULL,
  `cpe` date DEFAULT NULL,
  `circuit` varchar(5) NOT NULL,
  `location` varchar(10) NOT NULL,
  `mes` date DEFAULT NULL,
  `outils` varchar(15) NOT NULL,
  `ticket` varchar(15) NOT NULL,
  `contact` text CHARACTER SET utf8 NOT NULL,
  `appel` text CHARACTER SET utf8 NOT NULL,
  `site` varchar(10) NOT NULL,
  `tiroir` varchar(255) NOT NULL,
  `tube` varchar(10) NOT NULL,
  `fibre` varchar(10) NOT NULL,
  `etat` varchar(30) NOT NULL,
  `commentaire_natira` text NOT NULL,
  `date_natira` date DEFAULT NULL,
  `annuler` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;


--
-- Structure de la table `network_resiliation`
--

CREATE TABLE `network_resiliation` (
  `id_resil` int(11) NOT NULL AUTO_INCREMENT,
  `si_id` int(11) NOT NULL,
  `sn` varchar(30) NOT NULL,
  `pe` varchar(5) NOT NULL,
  `depro` varchar(5) DEFAULT 'NOK',
  `rt` varchar(5) NOT NULL,
  `relance` varchar(10) NOT NULL,
  `cpe` varchar(5) DEFAULT 'NOK',
  `ticket` varchar(20) NOT NULL,
  PRIMARY KEY (`id_resil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Structure de la table `odroid`
--

CREATE TABLE `odroid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fsn` varchar(30) NOT NULL,
  `sim` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table `network_fon`
--
CREATE TABLE IF NOT EXISTS `network_fon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `si_id` int(11) NOT NULL,
  `mes_prevu` int(10) DEFAULT NULL,
  `ann_prevu` int(11) NOT NULL,
  `mes` date DEFAULT NULL,
  `contact` text CHARACTER SET utf8 NOT NULL,
  `appel` text CHARACTER SET utf8 NOT NULL,
  `annuler` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
