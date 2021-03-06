/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/intact_create.sql
 */

DROP TABLE IF EXISTS intact ;

CREATE TABLE intact  (
	gene_agi VARCHAR(13),
	nVSC_EG_1 FLOAT,
	nVSC_EG_2 FLOAT,
	nVSC_EG_3 FLOAT,

	nSUS_EG_1 FLOAT,
	nSUS_EG_2 FLOAT,
	nSUS_EG_3 FLOAT,
  nSUS_EG_4 FLOAT,

	nEMB_EG_1 FLOAT,
	nEMB_EG_2 FLOAT,
	nEMB_EG_3 FLOAT,

	nVSC_LG_1 FLOAT,
	nVSC_LG_2 FLOAT,
  nVSC_LG_3 FLOAT,

	nEMB_LG_1 FLOAT,
	nEMB_LG_2 FLOAT,
	nEMB_LG_3 FLOAT,

	nQC_TR_EH_1 FLOAT,
	nQC_TR_EH_2 FLOAT,
  nQC_TR_EH_3 FLOAT,
	nQC_TR_EH_4 FLOAT,

	nVSC_EG FLOAT,
	nVSC_EG_sd FLOAT,
	nVSC_EG_rsd FLOAT,
	nSUS_EG FLOAT,
	nSUS_EG_sd FLOAT,
	nSUS_EG_rsd FLOAT,
  nEMB_EG FLOAT,
	nEMB_EG_sd FLOAT,
	nEMB_EG_rsd FLOAT,
	nVSC_LG FLOAT,
	nVSC_LG_sd FLOAT,
	nVSC_LG_rsd FLOAT,
	nEMB_LG FLOAT,
	nEMB_LG_sd FLOAT,
	nEMB_LG_rsd FLOAT,
  nQC_TR_EH FLOAT,
	nQC_TR_EH_sd FLOAT,
	nQC_TR_EH_rsd FLOAT,

	FC_nVSC_EG_vs_nEMB_EG FLOAT,
	FC_nVSC_EG_vs_nEMB_EG_q FLOAT,
	FC_nSUS_EG_vs_nEMB_EG FLOAT,
	FC_nSUS_EG_vs_nEMB_EG_q FLOAT,
	FC_nVSC_EG_vs_nSUS_EG FLOAT, /* unused */
	FC_nVSC_EG_vs_nSUS_EG_q FLOAT,
	FC_nVSC_LG_vs_nEMB_LG FLOAT,
	FC_nVSC_LG_vs_nEMB_LG_q FLOAT,
	FC_nQC_TR_EH_vs_nEMB_LG FLOAT,
	FC_nQC_TR_EH_vs_nEMB_LG_q FLOAT,
	FC_nQC_TR_EH_vs_nVSC_LG FLOAT, /* unused */
	FC_nQC_TR_EH_vs_nVSC_LG_q FLOAT,
	FC_nEMB_LG_vs_nEMB_EG FLOAT,
	FC_nEMB_LG_vs_nEMB_EG_q FLOAT,
	FC_nVSC_LG_vs_nVSC_EG FLOAT,
	FC_nVSC_LG_vs_nVSC_EG_q FLOAT,
	FC_nQC_TR_EH_vs_nSUS_EG FLOAT,
	FC_nQC_TR_EH_vs_nSUS_EG_q FLOAT,

 	PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'Map1.csv'
  INTO TABLE intact
  IGNORE 1 LINES;

SHOW WARNINGS;