/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/q0990_create.sql
 */

/*
Combined two datasets:

SELECT * FROM `q0990` LEFT JOIN `q0990_6` ON `q0990`.`gene_agi` = `q0990_6`.`gene_agi` AND `q0990`.`splice` = `q0990_6`.`splice`
UNION
SELECT * FROM `q0990` RIGHT JOIN `q0990_6` ON `q0990`.`gene_agi` = `q0990_6`.`gene_agi` AND `q0990`.`splice` = `q0990_6`.`splice`
 */


DROP TABLE IF EXISTS q0990;

CREATE TABLE q0990 (
	gene_agi VARCHAR(13),
	fc_day3 FLOAT,
	fc_day3_q FLOAT,
  fc_day6 FLOAT,
  fc_day6_q FLOAT,

  splice INT,


 	PRIMARY KEY agi (gene_agi, splice)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'Q0990_edit_combined_FINAL.csv'
  INTO TABLE q0990
  IGNORE 1 LINES;




SHOW WARNINGS;