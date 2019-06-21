--
-- Gegevens voor inkomsten
--
CREATE TABLE IF NOT EXISTS `f9ko_iv_income` (
  `id` int(11) NOT NULL auto_increment,
  `iv_id` varchar(20) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `period_start` date,
  `period_end` date,
  `description` text NOT NULL,
  `amount` float NOT NULL default '0',
  `tax` float NOT NULL default '0',
  `total_amount` float NOT NULL default '0',
  `currency` varchar(10) NOT NULL default 'EUR',
  `book_date` date,
  `ogm` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`company_id`) REFERENCES `f9ko_oc_company`(`id`) ON DELETE RESTRICT,
  UNIQUE (`iv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `f9ko_iv_income_fpline` (
  `id` int(11) NOT NULL auto_increment,
  `invoice_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `quantity` float NOT NULL default '0',
  `total_amount` float NOT NULL default '0',
  `amount_unit` float NOT NULL default '0',
  `unit` varchar(20) NOT NULL default 'day',
  `currency` varchar(10) NOT NULL default 'EUR',
  PRIMARY KEY  (`id`,`invoice_id`),
  FOREIGN KEY (`invoice_id`) REFERENCES `f9ko_iv_income`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens voor uitgaven
--

CREATE TABLE IF NOT EXISTS `f9ko_iv_supplier` (
  `id` int(11) NOT NULL auto_increment,
  `supplier_name` varchar(255) NOT NULL,
  `company_id` int(11) default '0',
  `description` text NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `vat_reg_no` varchar(25) default NULL,
  `company_no` varchar(25) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`company_id`) REFERENCES `f9ko_oc_company`(`id`) ON DELETE RESTRICT
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `f9ko_iv_expense` (
  `id` int(11) NOT NULL auto_increment,
  `supplier_id` int(11) NOT NULL,
  `expensetype_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `amount` float NOT NULL default '0',
  `tax` float NOT NULL default '0',
  `total_amount` float NOT NULL default '0',
  `currency` varchar(10) NOT NULL default 'EUR',
  `book_date` date,
  `invoice_received` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`supplier_id`) REFERENCES `f9ko_iv_supplier`(`id`) ON DELETE RESTRICT  
  FOREIGN KEY (`expensetype_id`) REFERENCES `f9ko_iv_expensetype`(`id`) ON DELETE RESTRICT
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `f9ko_iv_expensetype` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL,
  `perc_deductable` float NOT NULL default '0',
  `perc_deductalbe_tax` float NOT NULL default '0',
  `start_date` date NOT NULL,
  `end_date` date,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `f9ko_iv_invest` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(274) NOT NULL,
  `amount` float NOT NULL default '0',
  `book_date` date NOT NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
--
-- Gegevens voor tax and vat
--
CREATE TABLE IF NOT EXISTS `f9ko_iv_tax` (
  `id` int(11) NOT NULL auto_increment,
  `taxtype_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `amount` float NOT NULL default '0',
  `currency` varchar(10) NOT NULL default 'EUR',
  `book_date` date,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`taxtype_id`) REFERENCES `f9ko_iv_taxtype`(`id`) ON DELETE RESTRICT
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `f9ko_iv_taxtype` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `f9ko_iv_staff` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `passport_id` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text NOT NULL,
  `address` varchar(750) NOT NULL default 'no address data',
  `telephone` varchar(20) NOT NULL,
  `jobtitle` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
  FOREIGN KEY (`user_id`) REFERENCES `f9ko_users`(`id`) ON DELETE RESTRICT
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `f9ko_iv_salary` (
  `id` int(11) NOT NULL auto_increment,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `amount` float NOT NULL default '0',
  `currency` varchar(10) NOT NULL default 'EUR',
  `book_date` date,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`staff_id`) REFERENCES `f9ko_iv_staff`(`id`) ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
