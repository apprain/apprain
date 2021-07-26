-- query
DROP TABLE IF EXISTS app_searchrole;
-- query
CREATE TABLE `app_searchrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2017-02-13 22:45:48',
  `lastmodified` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `fields` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `mode` enum('search-window','link','popup-link') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_searchrole VALUES ('1', '1', '2017-02-13 22:45:48', '2017-04-16 16:36:14', 'admission', '{
    "title":"Search Users",
    "sourcetype":"Model",    
    "sourcename":"admentry", 
    "gridfields": {"header":"First Name,Last Name,Phone No,A/C No","fields":"fname,lname,phoneno,accno"},
    "link":"[BASEURL]/admission/manageentries/[id]",
    "toolbar":[{"link":"Create New|[BASEURL]/admission/quickentry"}],
    "fields":
    [
        {   "name":"entrydate",
             "type":"dateRange",
             "title":"Created "
        },
       {
              "name":"fname",
              "title":"Name",
              "samerowfield":{"name":"lname"}
        },        
        {
             "name":"department",
             "title":"Department",
             "type":"CategorySet",
              "parameters":{"val":"name"}
         }
    ]
}
', 'Active', 'Search Users', 'admission|Register|Search User', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('2', '1', '2017-02-13 22:45:48', '2017-08-06 14:23:44', 'accounts', '{
    "title":"Search Accounts",
    "sourcetype":"Model",    
    "sourcename":"accchart", 
    "gridfields": {"header":"A/C Name,A/C No,Tier,Balance","fields":"name,no,tier,balance"},
    "link":"[BASEURL]/accounts/account/[id]",
    "toolbar":[{"link":"Create New|[BASEURL]/accounts/save/new"}],
    "fields":
    [
        {
             "name":"id",
              "title":"Id"
        },
       {
             "name":"name",
              "title":"Name"
        },
        {
             "name":"no",
             "title":"Account No"
        },
        {
             "name":"tier",
             "title":"Tier"
        },
       {
             "name":"acctype",
             "title":"Accounts Type",
             "type":"InformationSet",
              "parameters":{"val":"name"}
         }
    ]
}
', 'Active', 'Search Accounts', 'accounts|Accounts', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('3', '1', '2017-02-13 22:45:48', '2017-03-03 22:48:38', 'caselist', '{
    "title":"Case List",
    "sourcetype":"Model",    
    "sourcename":"Caselist", 
    "gridfields": {"header":"Subject,Remark,Date","fields":"subject,remark,entrydate"},
    "link":"[BASEURL]/casemanagement/manage/[id]",
    "fields":
    [
        

        {   "name":"entrydate",
             "type":"dateRange",
             "title":"Created "
        },
       {
              "name":"subject",
              "title":"Subject",
              "samerowfield": 
              {
                  "name":"status",
                  "type":"selectTag",
                   "parameters":{"Open":"Open","Closed":"Closed"} 
              }
        },
        {   "name":"description",
             "title":"Description"
        },
       {   "name":"remark",
             "title":"Remark",
              "samerowfield": 
              {
                  "name":"priority",
                  "type":"selectTag",
                   "parameters":{"Normal":"Normal","Moderate":"Moderate","Major":"Major"} 
              }
        }
    ]
}
', 'Active', 'Search Case', 'inventory|Damage Product', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('4', '1', '2017-02-13 22:45:48', '2017-04-28 19:57:53', 'invitem', '{
    "title":"Search Item",
    "sourcetype":"Model",    
    "sourcename":"invitem", 
    "gridfields": {"header":"Name,Size,Color,Bar Code,Sale Price","fields":"name,size,color,barcode,saleprice"},
    "link":"[BASEURL]/inventory/stock/view/[id]",
    "fields":
    [
        {   "name":"name",             
             "title":"Name"
        },
       {
             "name":"company",
             "title":"Company",
             "type":"InformationSet",             
              "parameters":{"val":"name","informationsetname":"invprodcompany"}
         },
        {   "name":"size",             
             "title":"Size"
        },
        {   "name":"color",             
             "title":"Color"
        },
        {   "name":"barcode",
             "title":"Bar Code"
        },
       {   "name":"entrydate",
             "type":"dateRange",
             "title":"Created "
        }
    ]
}
', 'Active', 'Search Item', 'inventory|Manage Items|Search Items', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('5', '1', '2017-02-13 22:45:48', '2017-03-13 16:20:49', 'entrycode', '{
    "title":"Entry Code",
    "sourcetype":"InformationSet",    
    "sourcename":"entrycode", 
    "gridfields": {"header":"Name,Code","fields":"name,code"},
    "link":"[BASEURL]/information/manage/entrycode/view/[id]",
    "fields":
    [
       {
              "name":"name",
              "title":"Name"
        },
        {   "name":"code",
             "title":"Code"
        }
    ]
}
', 'Active', 'Search Entry Code', 'accounts|Entry Code', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('6', '1', '2017-02-13 22:45:48', '2017-03-16 23:54:35', 'invprodcompany', '{
    "title":"Entry Code",
    "sourcetype":"InformationSet",    
    "sourcename":"invprodcompany", 
    "gridfields": {"header":"Name,Address","fields":"name,address"},
    "link":"[BASEURL]/information/manage/invprodcompany/view/[id]",
    "fields":
    [
       {
              "name":"name",
              "title":"Name"
        },
        {   "name":"address",
             "title":"Address"
        }
    ]
}
', 'Active', 'Search Company', 'inventory|Product Companies', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('7', '1', '2017-02-13 22:45:48', '2017-04-19 19:12:40', 'dashboard', '{
    "link":"[BASEURL]/projectbilling/manage"
}
', 'Active', 'Manage Projects', 'dashboard', 'link');
-- query
INSERT INTO app_searchrole VALUES ('8', '1', '2017-02-13 22:45:48', '2017-04-16 15:44:35', 'dashboard', '{
    "link":"[BASEURL]/accounts/inout"
}
', 'Active', 'Transaction Action', 'dashboard', 'popup-link');
-- query
INSERT INTO app_searchrole VALUES ('9', '1', '2017-02-13 22:45:48', '2017-04-16 15:45:12', 'dashboard', '{
    "link":"[BASEURL]//search/accounts"
}
', 'Active', 'Account Chart', 'dashboard', 'popup-link');
-- query
INSERT INTO app_searchrole VALUES ('10', '1', '2017-02-13 22:45:48', '2017-04-16 15:46:21', 'dashboard', '{
    "link":"[BASEURL]/appreport/executor"
}
', 'Active', 'Reports', 'dashboard', 'popup-link');
-- query
INSERT INTO app_searchrole VALUES ('11', '1', '2017-02-13 22:45:48', '2017-04-16 15:51:54', 'dashboard', '{
    "link":"[BASEURL]//accounts/inout/18"
}
', 'Active', 'Petty Cash', 'dashboard', 'popup-link');
-- query
INSERT INTO app_searchrole VALUES ('12', '1', '2017-02-13 22:45:48', '2017-04-22 10:05:53', 'dashboard', '{
    "link":"[BASEURL]/voucher/chequepayment"
}
', 'Active', 'Cash/Cheque Payment', 'dashboard', 'popup-link');
-- query
INSERT INTO app_searchrole VALUES ('13', '1', '2017-02-13 22:45:48', '2017-04-22 11:59:26', 'dashboard', '{
    "link":"[BASEURL]/inventory/invoicelist"
}
', 'Active', 'Invoice', 'dashboard', 'link');
-- query
INSERT INTO app_searchrole VALUES ('14', '1', '2017-02-13 22:45:48', '2017-05-14 01:02:19', 'invoiceitemsrc', '{
    "title":"Search Item",
    "sourcetype":"Model",    
    "sourcename":"invitem", 
    "gridfields": {"header":"Name,Size,Color,Bar Code,Sale Price","fields":"name,size,color,barcode,saleprice"},
    "link":"[BASEURL]/inventory/invoiceadditem/[id]",
    "fields":
    [
        {   "name":"name",             
             "title":"Name"
        },
       {
             "name":"company",
             "title":"Company",
             "type":"InformationSet",             
              "parameters":{"val":"name","informationsetname":"invprodcompany"}
         },
        {   "name":"size",             
             "title":"Size"
        },
        {   "name":"color",             
             "title":"Color"
        },
        {   "name":"barcode",
             "title":"Bar Code"
        },
       {   "name":"entrydate",
             "type":"dateRange",
             "title":"Created "
        }
    ]
}
', 'Active', 'Add Item', 'inventory|xInvoice|Search Items', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('15', '1', '2017-02-13 22:45:48', '2017-06-14 15:00:40', 'invinvoice', '{
    "title":"Invoice",
    "sourcetype":"Model",    
    "sourcename":"Invoice", 
    "gridfields": {"header":"ID,Received,Total,Date,Status,Type","fields":"id,received,total,date,status,type"},
    "link":"[BASEURL]/inventory/invoice/view/[id]",
    "fields":
    [

        {   "name":"id",
             "title":"Invoice ID"
        },
       {   "name":"date",
             "type":"dateRange",
             "title":"Created "
        },
       {
              "name":"type",
               "type":"selectTag",
               "parameters":{"Cash":"Cash","Credit":"Credit"},
               "title":"Status" 
        },
       {
             "name":"client",
             "title":"Client",
             "type":"Model",
              "parameters":{"val":"fname,lname","modelname":"admentry"}
         }
    ]
}
', 'Active', 'Search Invoice', 'inventory|Invoice', 'search-window');
-- query
INSERT INTO app_searchrole VALUES ('16', '1', '2017-02-13 22:45:48', '2017-07-17 17:28:51', 'invordsrc', '{
    "title":"Search Item",
    "sourcetype":"Model",    
    "sourcename":"invorder", 
    "gridfields": {"header":"ID,Created,Status,Total Cost,Paid,Received","fields":"id,createdate,status,totalprice,paid,received"},
    "link":"[BASEURL]/inventory/order/view/[id]",
    "fields":
    [
       {   "name":"id",             
             "title":"Order Id"
        },
       {
              "name":"Status",
               "type":"selectTag",
               "parameters":{"Cash":"Cash","Credit":"Credit"},
               "title":"Status" 
        },
       {
             "name":"supplierid",
             "title":"Supplier",
             "type":"Model",
              "parameters":{"val":"fname,lname","modelname":"admentry"}
         },
        {
             "name":"company",
             "title":"Company",
             "type":"InformationSet",             
              "parameters":{"val":"name","informationsetname":"invprodcompany"}
         },
       {   "name":"createdate",
             "type":"dateRange",
             "title":"Created "
        }
    ]
}
', 'Active', 'Search Order', 'inventory|Manage Supply|Search Orders', 'search-window');
