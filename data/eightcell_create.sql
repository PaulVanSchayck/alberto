/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/eightcell_create.sql
 */

DROP TABLE IF EXISTS eightcell ;

CREATE TABLE eightcell  (
	gene_agi VARCHAR(13),
	bdl_1 FLOAT,
  bdl_2 FLOAT,
  bdl_4 FLOAT,

  wt_1 FLOAT,
  wt_2 FLOAT,
  wt_3 FLOAT,

  bdl FLOAT,
  bdl_sd FLOAT,
  bdl_rsd FLOAT,

  wt FLOAT,
  wt_sd FLOAT,
  wt_rsd FLOAT,

  fc_bdl_wt FLOAT,
  fc_bdl_wt_q FLOAT,

 	PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'A402_RMA_CustomCDF_2014_12_16_edit.csv'
  INTO TABLE eightcell
  IGNORE 1 LINES;

SHOW WARNINGS;