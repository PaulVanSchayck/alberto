/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/intact_create.sql
 */

DROP TABLE IF EXISTS intact ;

CREATE TABLE intact  (
	gene_agi VARCHAR(13),
	suspensor_eg_1 FLOAT,
	suspensor_eg_2 FLOAT,
	suspensor_eg_3 FLOAT,
	suspensor_eg_4 FLOAT,
	suspensor_eg FLOAT,
	suspensor_eg_sd FLOAT,
  suspensor_eg_rsd FLOAT,
	vascular_eg_2 FLOAT,
	vascular_eg_3 FLOAT,
	vascular_eg_4 FLOAT,
	vascular_eg FLOAT,
	vascular_eg_sd FLOAT,
  vascular_eg_rsd FLOAT,
	embryo_eg_2 FLOAT,
	embryo_eg_3 FLOAT,
	embryo_eg_4 FLOAT,
	embryo_eg FLOAT,
	embryo_eg_sd FLOAT,
  embryo_eg_rsd FLOAT,
	vascular_lg_1 FLOAT,
	vascular_lg_2 FLOAT,
	vascular_lg_3 FLOAT,
	vascular_lg FLOAT,
	vascular_lg_sd FLOAT,
  vascular_lg_rsd FLOAT,
	embryo_lg_1 FLOAT,
	embryo_lg_2 FLOAT,
	embryo_lg_4 FLOAT,
	embryo_lg FLOAT,
	embryo_lg_sd FLOAT,
  embryo_lg_rsd FLOAT,
	qc_hs_1 FLOAT,
	qc_hs_2 FLOAT,
	qc_hs_3 FLOAT,
	qc_hs_4 FLOAT,
	qc_hs FLOAT,
	qc_hs_sd FLOAT,
  qc_hs_rsd FLOAT,
	fc_vascular_eg_embryo_eg FLOAT,
	fc_vascular_eg_embryo_eg_q FLOAT,
	fc_vascular_eg_vascular_lg FLOAT,
	fc_vascular_eg_vascular_lg_q FLOAT,
	fc_vascular_eg_suspensor_eg FLOAT,
	fc_vascular_eg_suspensor_eg_q FLOAT,
	fc_vascular_eg_embryo_lg FLOAT,
	fc_vascular_eg_embryo_lg_q FLOAT,
	fc_vascular_eg_qc_hs FLOAT,
	fc_vascular_eg_qc_hs_q FLOAT,
	fc_embryo_eg_vascular_eg FLOAT,
	fc_embryo_eg_vascular_eg_q FLOAT,
	fc_embryo_eg_vascular_lg FLOAT,
	fc_embryo_eg_vascular_lg_q FLOAT,
	fc_embryo_eg_suspensor_eg FLOAT,
	fc_embryo_eg_suspensor_eg_q FLOAT,
	fc_embryo_eg_embryo_lg FLOAT,
	fc_embryo_eg_embryo_lg_q FLOAT,
	fc_embryo_eg_qc_hs FLOAT,
	fc_embryo_eg_qc_hs_q FLOAT,
	fc_vascular_lg_vascular_eg FLOAT,
	fc_vascular_lg_vascular_eg_q FLOAT,
	fc_vascular_lg_embryo_eg FLOAT,
	fc_vascular_lg_embryo_eg_q FLOAT,
	fc_vascular_lg_suspensor_eg FLOAT,
	fc_vascular_lg_suspensor_eg_q FLOAT,
	fc_vascular_lg_embryo_lg FLOAT,
	fc_vascular_lg_embryo_lg_q FLOAT,
	fc_vascular_lg_qc_hs FLOAT,
	fc_vascular_lg_qc_hs_q FLOAT,
	fc_suspensor_eg_vascular_eg FLOAT,
	fc_suspensor_eg_vascular_eg_q FLOAT,
	fc_suspensor_eg_embryo_eg FLOAT,
	fc_suspensor_eg_embryo_eg_q FLOAT,
	fc_suspensor_eg_vascular_lg FLOAT,
	fc_suspensor_eg_vascular_lg_q FLOAT,
	fc_suspensor_eg_embryo_lg FLOAT,
	fc_suspensor_eg_embryo_lg_q FLOAT,
	fc_suspensor_eg_qc_hs FLOAT,
	fc_suspensor_eg_qc_hs_q FLOAT,
	fc_embryo_lg_vascular_eg FLOAT,
	fc_embryo_lg_vascular_eg_q FLOAT,
	fc_embryo_lg_embryo_eg FLOAT,
	fc_embryo_lg_embryo_eg_q FLOAT,
	fc_embryo_lg_vascular_lg FLOAT,
	fc_embryo_lg_vascular_lg_q FLOAT,
	fc_embryo_lg_suspensor_eg FLOAT,
	fc_embryo_lg_suspensor_eg_q FLOAT,
	fc_embryo_lg_qc_hs FLOAT,
	fc_embryo_lg_qc_hs_q FLOAT,
	fc_qc_hs_vascular_eg FLOAT,
	fc_qc_hs_vascular_eg_q FLOAT,
	fc_qc_hs_embryo_eg FLOAT,
	fc_qc_hs_embryo_eg_q FLOAT,
	fc_qc_hs_vascular_lg FLOAT,
	fc_qc_hs_vascular_lg_q FLOAT,
	fc_qc_hs_suspensor_eg FLOAT,
	fc_qc_hs_suspensor_eg_q FLOAT,
	fc_qc_hs_embryo_lg FLOAT,
 	PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'A325_all_2014_CustomCDF_2014_11_04_headers_no_MC.csv'
  INTO TABLE intact
  IGNORE 2 LINES;

SHOW WARNINGS;