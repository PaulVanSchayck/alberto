/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/m0171_create.sql
 */


DROP TABLE IF EXISTS m0171;

CREATE TABLE m0171 (
	gene_agi VARCHAR(13),
	fc_day3 FLOAT,
	fc_day3_q FLOAT,

  splice INT,


 	PRIMARY KEY agi (gene_agi, splice)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'M171-3days_edit_database_FINAL.csv'
  INTO TABLE m0171
  IGNORE 1 LINES;


SHOW WARNINGS;