
DROP TABLE IF EXISTS gene;

CREATE TABLE `gene` (
  `agi` varchar(13) NOT NULL,
  `gene` varchar(255) NOT NULL,
  `annotation` text NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`agi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOAD DATA LOCAL INFILE 'cleaned'
  INTO TABLE gene
  FIELDS TERMINATED BY '|'
  IGNORE 1 LINES;

SHOW WARNINGS;