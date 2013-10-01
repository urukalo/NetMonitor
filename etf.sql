# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jun 14, 2006 at 03:02 PM
# Server version: 3.23.58
# PHP Version: 4.3.4
# Database : `milan`
# --------------------------------------------------------

#
# Table structure for table `etf`
#

CREATE TABLE etf (
  id tinyint(20) NOT NULL auto_increment,
  naziv varchar(255) NOT NULL default '',
  ip varchar(255) NOT NULL default '',
  mac varchar(255) NOT NULL default '',
  x int(255) NOT NULL default '0',
  y int(255) NOT NULL default '0',
  a int(255) NOT NULL default '300',
  b int(255) NOT NULL default '200',
  tip varchar(100) NOT NULL default 'Comp',
  servis varchar(20) NOT NULL default '1/0/0/0/0/0',
  status varchar(20) NOT NULL default '1/0/0/0/0/0',
  PRIMARY KEY  (id),
  UNIQUE KEY naziv (naziv)
) TYPE=MyISAM;

#
# Dumping data for table `etf`
#

INSERT INTO etf VALUES (0, 'Polaris', 'polaris.etf.bg.ac.yu', 'Nema', 200, 80, 200, 80, 'Comp', '0/0/0/0/0/0', '0/0/0/0/0/0');
INSERT INTO etf VALUES (2, 'Google', 'www.google.com', 'Nema', 200, 150, 300, 200, 'Comp', '1/1/0/0/0/0', '1/1/0/0/0/0');
INSERT INTO etf VALUES (1, 'Galeb', 'galeb.etf.bg.ac.yu', 'Nema', 300, 200, 200, 80, 'Comp', '0/0/0/0/0/0', '0/0/0/0/0/0');
INSERT INTO etf VALUES (4, 'OS', 'os.etf.bg.ac.yu', 'Nema', 200, 220, 300, 200, 'Comp', '1/1/0/0/0/0', '0/0/0/0/0/0');
INSERT INTO etf VALUES (5, 'Yahoo', 'www.yahoo.com', 'Nema', 200, 290, 300, 200, 'Comp', '1/1/0/0/0/0', '1/1/0/0/0/0');
INSERT INTO etf VALUES (6, 'Moj Racunar', '192.168.110.201', 'Nema', 400, 80, 300, 200, 'Comp', '1/0/0/0/0/0', '0/0/0/0/0/0');

