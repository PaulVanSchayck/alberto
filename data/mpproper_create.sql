/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/mpproper_create.sql
 */

DROP TABLE IF EXISTS mpproper;

CREATE TABLE mpproper  (
  c1 FLOAT,
  c2 FLOAT,
  c3 FLOAT,
  c4 FLOAT,
  e1 FLOAT,
  e2 FLOAT,
  e3 FLOAT,
  e4 FLOAT,
  fc1 FLOAT,
  fc2 FLOAT,
  fc3 FLOAT,
  fc4 FLOAT,
	gene_agi VARCHAR(13),

 	PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'Q0990_3days.csv'
  INTO TABLE mpproper
  IGNORE 1 LINES;

SHOW WARNINGS;