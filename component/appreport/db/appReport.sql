-- query
DROP TABLE IF EXISTS app_appreportcodes;
-- query
CREATE TABLE `app_appreportcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `groups` varchar(100) NOT NULL,
  `code` text NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_appreportcodes VALUES ('7','1','Journal Detail Report','9','1437998385.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('6','1','Journal','9','1437996380.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('8','1','Trial Balance','9','1437998421.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('13','1','Item Wise Sale Report','10','1472652828.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('14','1','Invoice wise Due Payment Report','10','1472652873.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('15','1','Stock Monitoring Report','10','1472652909.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('16','1','Customer Account Balance Report','10','1484677210.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('17','1','Cash Payment Received Report','10','1484727417.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('20','1','Invoice Wise Sale Report','10','1485191429.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('21','1','Damage Product Report','10','1488611084.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('22','1','Invoicewise Actual Profit/Loss Report','10','1489737684.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('23','1','Itemwise Profit/Loss Report','10','1489765182.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('24','1','Present Payable/Receiveable Report','9','1490600626.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('25','1','Company Present Condition of Expense and Asset','9','1491205946.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('26','1','Income Statement','9','1491214894.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('27','1','Present Stock Balance Report','10','1494184323.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('28','1','Item Statistics Report','10','1494690328.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('29','1','Company Balance Sheet Report','9','1496310292.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('30','1','Referal wise Invoice Report','21','1501568578.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('31','1','Referal wise Invoice Report','23','1503083871.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('32','1','Taxt Invoice','10','1504775518.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('33','1','Operator wise Voucher Report','24','1506410116.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('34','1','Supplier Account Statement','10','1510227537.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('35','1','Customer Account Statement','10','1510480988.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('36','1','Representative Wise Trend Analysis','10','1512647308.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('37','1','Daily Cash Reconciliation Report','9','1518508390.arbt','2018-10-02 19:45:11');
-- query
INSERT INTO app_appreportcodes VALUES ('38','1','All Installment Statistics Report','179','1519835753.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('39','1','Check Stock In Report','10','1522324054.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('40','1','Store Wise Stock History Report','10','1522514763.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('41','1','Loan Schedule','179','1523771225.arbt','2015-08-12 14:51:11');
-- query
INSERT INTO app_appreportcodes VALUES ('42','1','Company Balance Sheet Report By Duration','9','1541416978.arbt','2018-11-05 18:22:37');
