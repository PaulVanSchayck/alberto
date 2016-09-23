/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/intact_create.sql
 */

DROP TABLE IF EXISTS intact_map2 ;

CREATE TABLE intact_map2  (
  gene_agi    VARCHAR(13),
  nILT_16C_1  FLOAT,
  nILT_16C_2  FLOAT,
  nILT_16C_3  FLOAT,

  nEMB_16C_1  FLOAT,
  nEMB_16C_2  FLOAT,
  nEMB_16C_3  FLOAT,

  nVSC_EG_1   FLOAT,
  nVSC_EG_2   FLOAT,
  nVSC_EG_3   FLOAT,
  nVSC_EG_4   FLOAT,

  nGSC_EG_1   FLOAT,
  nGSC_EG_2   FLOAT,
  nGSC_EG_3   FLOAT,
  nGSC_EG_4   FLOAT,

  nSUS_EG_1   FLOAT,
  nSUS_EG_2   FLOAT,
  nSUS_EG_3   FLOAT,

  nEMB_EG_1   FLOAT,
  nEMB_EG_2   FLOAT,
  nEMB_EG_3   FLOAT,
  nEMB_EG_4   FLOAT,

  nVSC_LG_1   FLOAT,
  nVSC_LG_2   FLOAT,
  nVSC_LG_3   FLOAT,
  nVSC_LG_4   FLOAT,

  nGSC_LG_1   FLOAT,
  nGSC_LG_2   FLOAT,
  nGSC_LG_3   FLOAT,

  nSUS_LG_1   FLOAT,
  nSUS_LG_2   FLOAT,
  nSUS_LG_3   FLOAT,

  nQC_LG_1    FLOAT,
  nQC_LG_2    FLOAT,
  nQC_LG_3    FLOAT,

  nEMB_LG_1   FLOAT,
  nEMB_LG_2   FLOAT,
  nEMB_LG_3   FLOAT,
  nEMB_LG_4   FLOAT,

  nILT_16C     FLOAT,
  nILT_16C_sd  FLOAT,
  nILT_16C_rsd FLOAT,
  nEMB_16C     FLOAT,
  nEMB_16C_sd  FLOAT,
  nEMB_16C_rsd FLOAT,

  nVSC_EG      FLOAT,
  nVSC_EG_sd   FLOAT,
  nVSC_EG_rsd  FLOAT,
  nGSC_EG      FLOAT,
  nGSC_EG_sd   FLOAT,
  nGSC_EG_rsd  FLOAT,
  nSUS_EG      FLOAT,
  nSUS_EG_sd   FLOAT,
  nSUS_EG_rsd  FLOAT,
  nEMB_EG      FLOAT,
  nEMB_EG_sd   FLOAT,
  nEMB_EG_rsd  FLOAT,

  nVSC_LG      FLOAT,
  nVSC_LG_sd   FLOAT,
  nVSC_LG_rsd  FLOAT,
  nGSC_LG      FLOAT,
  nGSC_LG_sd   FLOAT,
  nGSC_LG_rsd  FLOAT,
  nSUS_LG      FLOAT,
  nSUS_LG_sd   FLOAT,
  nSUS_LG_rsd  FLOAT,
  nQC_LG       FLOAT,
  nQC_LG_sd    FLOAT,
  nQC_LG_rsd   FLOAT,
  nEMB_LG      FLOAT,
  nEMB_LG_sd   FLOAT,
  nEMB_LG_rsd  FLOAT,

  FC_nILT_16C_vs_nEMB_16C     FLOAT,
  FC_nILT_16C_vs_nEMB_16C_q   FLOAT,

  FC_nVSC_EG_vs_nEMB_EG       FLOAT,
  FC_nVSC_EG_vs_nEMB_EG_q     FLOAT,
  FC_nGSC_EG_vs_nEMB_EG       FLOAT,
  FC_nGSC_EG_vs_nEMB_EG_q     FLOAT,
  FC_nSUS_EG_vs_nEMB_EG       FLOAT,
  FC_nSUS_EG_vs_nEMB_EG_q     FLOAT,

  FC_nVSC_LG_vs_nEMB_LG       FLOAT,
  FC_nVSC_LG_vs_nEMB_LG_q     FLOAT,
  FC_nGSC_LG_vs_nEMB_LG       FLOAT,
  FC_nGSC_LG_vs_nEMB_LG_q     FLOAT,
  FC_nSUS_LG_vs_nEMB_LG       FLOAT,
  FC_nSUS_LG_vs_nEMB_LG_q     FLOAT,
  FC_nQC_LG_vs_nEMB_LG        FLOAT,
  FC_nQC_LG_vs_nEMB_LG_q      FLOAT,

  FC_nEMB_EG_vs_nEMB_16C      FLOAT,
  FC_nEMB_EG_vs_nEMB_16C_q    FLOAT,
  FC_nEMB_LG_vs_nEMB_EG       FLOAT,
  FC_nEMB_LG_vs_nEMB_EG_q     FLOAT,

  FC_nVSC_EG_vs_nILT_16C      FLOAT,
  FC_nVSC_EG_vs_nILT_16C_q    FLOAT,
  FC_nVSC_LG_vs_nVSC_EG       FLOAT,
  FC_nVSC_LG_vs_nVSC_EG_q     FLOAT,

  FC_nGSC_EG_vs_nILT_16C      FLOAT,
  FC_nGSC_EG_vs_nILT_16C_q    FLOAT,
  FC_nGSC_LG_vs_nGSC_EG       FLOAT,
  FC_nGSC_LG_vs_nGSC_EG_q     FLOAT,

  FC_nSUS_LG_vs_nSUS_EG       FLOAT,
  FC_nSUS_LG_vs_nSUS_EG_q     FLOAT,

  FC_nQC_LG_vs_nSUS_EG        FLOAT,
  FC_nQC_LG_vs_nSUS_EG_q      FLOAT,

  PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'Map2.csv'
  INTO TABLE intact_map2
  IGNORE 1 LINES;

SHOW WARNINGS;