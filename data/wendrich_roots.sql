/**
Run like: $ mysql --local-infile -p -U alberto < ~/alberto/data/wendrich_roots.sql
 */

/*
 * PUB25 High value	PUB25 Med value	PUB25 Low value	SPT High value	SPT Med value	SPT Low value
 * TMO5 High value	TMO5 Med value	TMO5 Low value	PUB25 HM fold change_log2	PUB25 HM q value
 * PUB25 ML fold change_log2	PUB25 ML q value	PUB25 HL fold change_log2	PUB25 HL q value
 * SPT HM fold change_log2	SPT HM q value	SPT ML fold change_log2	SPT ML q value
 * SPT HL fold change_log2	SPT HL q value	TMO5 HM fold change_log2	TMO5 HM q value
 * TMO5 ML fold change_log2	TMO5 ML q value	TMO5 HL fold change_log2	TMO5 HL q value
 */

DROP TABLE IF EXISTS rootgradient;

CREATE TABLE rootgradient  (
  gene_agi VARCHAR(13),
  pub25_h FLOAT,
  pub25_m FLOAT,
  pub25_l FLOAT,

  spt_h FLOAT,
  spt_m FLOAT,
  spt_l FLOAT,

  tmo5_h FLOAT,
  tmo5_m FLOAT,
  tmo5_l FLOAT,

  fc_pub25_hm FLOAT,
  fc_pub25_hm_q FLOAT,
  fc_pub25_ml FLOAT,
  fc_pub25_ml_q FLOAT,
  fc_pub25_hl FLOAT,
  fc_pub25_hl_q FLOAT,

  fc_spt_hm FLOAT,
  fc_spt_hm_q FLOAT,
  fc_spt_ml FLOAT,
  fc_spt_ml_q FLOAT,
  fc_spt_hl FLOAT,
  fc_spt_hl_q FLOAT,

  fc_tmo5_hm FLOAT,
  fc_tmo5_hm_q FLOAT,
  fc_tmo5_ml FLOAT,
  fc_tmo5_ml_q FLOAT,
  fc_tmo5_hl FLOAT,
  fc_tmo5_hl_q FLOAT,

  PRIMARY KEY agi (gene_agi)
) ENGINE=MyISAM;

LOAD DATA LOCAL INFILE 'Dataset Jos.csv'
INTO TABLE rootgradient
IGNORE 1 LINES;

SHOW WARNINGS;