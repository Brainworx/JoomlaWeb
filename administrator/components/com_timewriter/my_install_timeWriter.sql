CREATE TABLE IF NOT EXISTS `f9ko_oc_company` (
  `id` int(11) NOT NULL auto_increment,
  `company_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `vat_reg_no` varchar(25) default NULL,
  `company_no` varchar(25) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_company`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_project`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_project` (
  `id` int(11) NOT NULL auto_increment,
  `project_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_project`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_project_user`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_project_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `project_id` int(11) NOT NULL default '0',
  `is_project_mgr` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_project_user`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_timesheets`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_timesheets` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_hours` float NOT NULL,
  `start_time` varchar(15) NOT NULL,
  `end_time` varchar(15) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) default NULL,
  `description` varchar(255) default NULL,
  `published` tinyint(1) NOT NULL,
  `is_billable` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_timesheets`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_user_mileage`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_user_mileage` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `vehicle_id` int(11) NOT NULL default '0',
  `start_location` varchar(255) NOT NULL,
  `end_location` varchar(255) NOT NULL,
  `start_odometer` int(11) NOT NULL default '0',
  `end_odometer` int(11) NOT NULL default '0',
  `date` date NOT NULL,
  `parking` float NOT NULL,
  `company_id` int(11) NOT NULL default '0',
  `is_billable` tinyint(1) NOT NULL default '0',
  `notes` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_user_mileage`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_user_prefs`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_user_prefs` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `is_timesheet_user` tinyint(1) NOT NULL default '0',
  `is_timesheet_admin` tinyint(1) NOT NULL default '0',
  `project_id` int(11) NOT NULL default '0',
  `vehicle_id` int(11) NOT NULL default '0',
  `is_billable` tinyint(1) NOT NULL default '0',
  `mileage_is_billable` tinyint(1) NOT NULL default '0',
  `start_location` varchar(255) NOT NULL,
  `end_location` varchar(255) NOT NULL,
  `parking` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).


--
-- Gegevens worden uitgevoerd voor tabel `#__oc_user_prefs`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `#__oc_user_vehicles`
--

CREATE TABLE IF NOT EXISTS `f9ko_oc_user_vehicles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `vehicle_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(20) NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL gaf een lege resultaat set terug (0 rijen).