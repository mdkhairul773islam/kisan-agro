CREATE TABLE `access_info` (
  `user_id` int(10) unsigned NOT NULL,
  `login_period` datetime NOT NULL,
  `logout_period` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `advanced_payment` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `payment_date` date NOT NULL,
  `emp_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adjust_amount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `payment_date` (`payment_date`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `attendance` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `emp_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emp_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `bank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `bank_name` varchar(252) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `bank_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` date NOT NULL,
  `branch_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `holder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `init_balance` decimal(10,2) NOT NULL,
  `pre_balance` decimal(10,2) NOT NULL,
  `showroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `bonus` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `bonus_date` date NOT NULL,
  `emp_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bonus` decimal(10,2) NOT NULL COMMENT 'Bonus  (%)',
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  KEY `bonus_date` (`bonus_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `chalan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `party_code` varchar(41) COLLATE utf8_unicode_ci NOT NULL,
  `chalan_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bags` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `challan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `challan_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `party_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transport_id` int(11) NOT NULL,
  `driver_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehicle_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `engine_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chassis_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_quantity` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `trash` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `challan_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `challan_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `trash` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `product_code` (`product_code`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `closing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `opening` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `income` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cost` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bank_withdraw` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bank_diposit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hand_cash` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `opening_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'auto',
  `showroom` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `commissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(4) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `cost` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `field_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `spend_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `cost_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `cost_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `daily_wages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `emp_id` int(11) NOT NULL,
  `attendance` decimal(10,2) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `trash` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `damage_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `party_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(252) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(10) NOT NULL,
  `unit` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `deduction_structure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fields` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `due_collectio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `previous_paid` decimal(11,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `remission` decimal(10,2) NOT NULL,
  `due` decimal(10,2) NOT NULL,
  `godown_code` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `employee` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `emp_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_group` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_bangla` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `joining_date` date NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `present_address` text COLLATE utf8_unicode_ci NOT NULL,
  `permanent_address` text COLLATE utf8_unicode_ci NOT NULL,
  `employee_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dept` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `employee_salary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `showroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `nid_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `fixed_assate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `field_fixed_assate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `spend_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `fixed_assate_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `field_fixed_assate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `godown_balance` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `showroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `physical_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `godowns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `supervisor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `incentive_structure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fields` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `income` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `showroom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `income_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `income_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `initial_transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `send` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `receive` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `loan` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Bank/Person',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_info` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `loan_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Receive/Paid',
  `amount` decimal(10,2) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `current_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `loan_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Open',
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `loan_transaction` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `loan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trx_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(252) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(252) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'kg',
  `weight` decimal(10,2) NOT NULL,
  `stock_alert` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `dealer_price` decimal(10,2) NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(42) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'available',
  `trash` tinyint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `type` (`type`),
  KEY `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `materials_price` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `trash` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `code` (`code`(250)),
  KEY `type` (`type`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `messages_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `messages_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `messages_mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `messages_text` text COLLATE utf8_unicode_ci NOT NULL,
  `messages_condition` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `monthly_commission_paid` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `party_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trash` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `opening_balance` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `current_balance` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `received_quantity` decimal(10,2) NOT NULL,
  `status` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_code` (`product_code`),
  KEY `trash` (`trash`),
  KEY `status` (`status`),
  KEY `order_no` (`voucher_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `voucher_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pr_no` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `party_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `total_quantity` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `pr_no` (`pr_no`),
  KEY `status` (`status`),
  KEY `trash` (`trash`),
  KEY `party_code` (`party_code`),
  KEY `order_no` (`voucher_no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `overtime` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `emp_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `parties` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `opening` date NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(42) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `client_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initial_balance` decimal(10,2) NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `client_type` (`client_type`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `partybalance` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `initial_balance` decimal(10,2) NOT NULL COMMENT 'positive sign receivable and negative sign payable',
  `balance` decimal(15,2) NOT NULL COMMENT 'positive sign receivable and negative sign payable',
  `credit_limit` decimal(10,2) unsigned NOT NULL COMMENT 'only for client and value goes to positive sign',
  `trash` tinyint(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `partymeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `party_code` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `partytransaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_at` date NOT NULL,
  `change_at` date DEFAULT NULL,
  `party_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `previous_balance` decimal(10,2) NOT NULL COMMENT 'Vendors: +(balance) = Receivable and -(balance) = Payable amount. Client: +(balance) = Payable and -(balance) = Receivable amount',
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `remission` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL COMMENT 'Vendors: +(balance) = Receivable and -(balance) = Payable amount. Client: +(balance) = Payable and -(balance) = Receivable amount',
  `transaction_via` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `relation` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sale transaction format is: ''sale:voucher'' and cash transaction is ''transaction''',
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `party_code` (`party_code`),
  KEY `transaction_at` (`transaction_at`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `partytransactionmeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `pending_recipe` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `category_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `order_time` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_weight` decimal(10,2) NOT NULL,
  `status` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `trash` int(1) NOT NULL DEFAULT 0,
  `date_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `plroduction_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `voucher_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` varbinary(255) NOT NULL,
  `damage_percentage` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `trash` (`trash`),
  KEY `voucher_no` (`voucher_no`),
  KEY `stock_id` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `privilege_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `production_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `voucher_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `batch_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `sale_quantity` decimal(10,2) NOT NULL,
  `waste_percentage` decimal(10,2) NOT NULL,
  `waste_quantity` decimal(10,2) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `trash` (`trash`),
  KEY `voucher_no` (`voucher_no`),
  KEY `product_code` (`product_code`),
  KEY `status` (`status`),
  KEY `batch_no` (`batch_no`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `productions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `voucher_no` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `batch_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_quantity` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_waste` decimal(10,2) NOT NULL COMMENT 'total waste quantity',
  `waste_amount` decimal(10,2) NOT NULL COMMENT 'total waste amount',
  `total_production` decimal(10,2) NOT NULL COMMENT 'total production quantity',
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` tinyint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `trash` (`trash`),
  KEY `voucher_no` (`voucher_no`),
  KEY `batch_no` (`batch_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_cat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subcategory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `unit` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `recipe_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `payment_date` date NOT NULL,
  `emp_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `total_salary` decimal(10,2) NOT NULL,
  `adjust_amount` decimal(10,2) NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `payment_date` (`payment_date`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `salary_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `payment_date` date NOT NULL,
  `emp_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `adjust_amount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `payment_date` (`payment_date`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `salary_structure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `basic` decimal(10,2) NOT NULL,
  `incentive` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `deduction` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `bonus` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sale_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `voucher_no` varchar(252) COLLATE utf8_unicode_ci NOT NULL,
  `client_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `totalQty` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `return_price` decimal(10,2) NOT NULL,
  `return_amount` decimal(10,2) NOT NULL,
  `total_return` decimal(10,2) NOT NULL,
  `trash` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sapitems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sap_at` date NOT NULL,
  `voucher_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `production_item_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `total_weight` decimal(10,3) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `order_quantity` decimal(10,3) NOT NULL,
  `weight` decimal(10,3) NOT NULL,
  `unit` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'kg',
  `discount` decimal(10,2) NOT NULL,
  `order_time` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `sap_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stock_type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sale or purchase',
  `godown_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sapmeta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `saprecords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sap_at` date NOT NULL,
  `change_at` date DEFAULT NULL,
  `voucher_no` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `party_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `party_balance` decimal(10,2) NOT NULL COMMENT 'positive balance => Receivable and negative balance => Payable',
  `total_quantity` int(10) NOT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `transport_cost` decimal(10,2) NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `due` decimal(10,2) NOT NULL,
  `method` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `sap_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sale_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sale or purchase',
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `promise_date` date DEFAULT NULL,
  `godown_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` tinyint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `party_code` (`party_code`),
  KEY `sap_at` (`sap_at`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sapreturn_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `voucher_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `total_weight` decimal(5,3) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trash` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `status` (`status`),
  KEY `product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `sapreturn_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `voucher_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `party_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_info` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Cash client info',
  `party_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `previous_balance` decimal(10,2) NOT NULL,
  `total_quantity` decimal(10,2) NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `remark` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `party_code` (`party_code`),
  KEY `party_type` (`party_type`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  KEY `trash` (`trash`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT 0,
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `showroom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `showroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supervisor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sitemeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `sms_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_date` date NOT NULL,
  `order_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `total_characters` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `total_messages` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_report` text COLLATE utf8_unicode_ci NOT NULL,
  `delivery_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `stock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `weight` decimal(10,3) NOT NULL,
  `quantity` decimal(10,3) NOT NULL DEFAULT 0.000,
  `unit` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Kg',
  `purchase_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `dealer_price` decimal(10,2) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `godown_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `tbl_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(156) COLLATE utf8_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT; 

CREATE TABLE `tbl_formula` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ration` decimal(8,5) NOT NULL,
  `wastage` decimal(8,5) NOT NULL,
  `date` date NOT NULL,
  `trash` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `tbl_packaging` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_quantity` decimal(10,3) NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `created_at` date NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `tbl_packaging_items` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `unit` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `created_at` date NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `product_code` (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `tbl_recipe` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `category_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `flour` decimal(10,2) NOT NULL,
  `total_material` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `total_wastage_ration` decimal(10,2) NOT NULL,
  `total_wastage` decimal(10,2) NOT NULL,
  `total_production` decimal(10,2) NOT NULL,
  `created` date NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `recipe_type` (`category_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `tbl_recipe_item` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `unit` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `material_ration` decimal(10,5) NOT NULL,
  `item_total_material` decimal(10,3) NOT NULL,
  `item_total_cost` decimal(10,2) NOT NULL,
  `wastage_ration` decimal(10,5) NOT NULL,
  `item_total_wastage` decimal(10,2) NOT NULL,
  `item_total_production` decimal(10,2) NOT NULL,
  `created` date NOT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_no` (`voucher_no`),
  KEY `product_code` (`product_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `bank` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `showroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varbinary(255) NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `trash` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `opening` datetime NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `l_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `maritial_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `facecbook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `privilege` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `reset_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE `yearly_commission_paid` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `party_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trash` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
 
INSERT INTO `access_info` ( `user_id`, `login_period`, `logout_period`) VALUES 
('19', '2022-03-03 10:57:16', '2022-03-03 11:01:57'), 
('19', '2022-03-03 11:26:34', '2022-03-03 15:43:47'), 
('19', '2022-03-03 11:39:42', '0000-00-00 00:00:00'), 
('1', '2022-03-03 15:26:38', '0000-00-00 00:00:00'), 
('1', '2022-03-03 15:38:14', '2022-03-03 15:38:46'), 
('19', '2022-03-03 15:38:54', '0000-00-00 00:00:00'), 
('19', '2022-03-03 15:44:01', '0000-00-00 00:00:00'), 
('1', '2022-03-17 14:37:48', '0000-00-00 00:00:00'), 
('1', '2022-03-17 15:29:00', '0000-00-00 00:00:00'), 
('1', '2022-03-17 15:55:08', '0000-00-00 00:00:00'), 
('1', '2022-03-17 17:09:17', '0000-00-00 00:00:00'), 
('1', '2022-03-20 09:01:46', '2022-03-20 09:02:19'), 
('19', '2022-03-20 09:02:22', '2022-03-20 09:04:09'), 
('1', '2022-03-20 09:04:15', '2022-03-20 09:05:44'), 
('18', '2022-03-20 09:05:51', '2022-03-20 09:05:55'), 
('1', '2022-03-20 09:05:58', '0000-00-00 00:00:00'), 
('1', '2022-03-20 09:15:26', '0000-00-00 00:00:00'), 
('1', '2022-03-21 09:04:20', '0000-00-00 00:00:00'), 
('1', '2022-03-22 09:05:10', '0000-00-00 00:00:00'), 
('1', '2022-03-22 16:51:49', '0000-00-00 00:00:00'), 
('1', '2022-03-22 17:30:41', '0000-00-00 00:00:00'), 
('1', '2022-03-23 09:53:01', '0000-00-00 00:00:00'), 
('1', '2022-03-24 10:15:30', '0000-00-00 00:00:00'), 
('1', '2022-03-24 14:21:01', '0000-00-00 00:00:00'), 
('1', '2022-03-25 22:34:59', '2022-03-26 17:33:03'), 
('1', '2022-03-27 11:17:36', '0000-00-00 00:00:00'), 
('1', '2022-03-29 10:53:31', '0000-00-00 00:00:00'), 
('1', '2022-03-29 12:28:30', '0000-00-00 00:00:00'), 
('19', '2022-03-31 10:48:49', '0000-00-00 00:00:00'), 
('19', '2022-04-05 17:51:13', '0000-00-00 00:00:00'), 
('19', '2022-04-06 11:01:45', '2022-04-06 14:48:54'), 
('19', '2022-04-06 14:48:58', '2022-04-07 10:57:20'), 
('19', '2022-04-06 16:14:12', '2022-04-06 16:15:13'), 
('19', '2022-04-06 16:16:49', '2022-04-06 16:21:09'), 
('19', '2022-04-07 10:36:50', '0000-00-00 00:00:00'), 
('19', '2022-04-07 10:57:24', '2022-04-07 11:12:28'), 
('19', '2022-04-07 11:02:39', '2022-04-07 11:11:31'), 
('19', '2022-04-07 11:11:33', '0000-00-00 00:00:00'), 
('19', '2022-04-07 11:12:31', '2022-04-07 12:14:50'), 
('19', '2022-04-07 12:15:29', '0000-00-00 00:00:00'), 
('19', '2022-04-07 12:18:37', '0000-00-00 00:00:00'), 
('19', '2022-04-07 15:25:21', '0000-00-00 00:00:00'), 
('19', '2022-04-09 12:27:16', '2022-04-10 15:04:08'), 
('19', '2022-04-10 16:03:00', '0000-00-00 00:00:00'), 
('19', '2022-04-11 19:40:26', '2022-04-12 14:17:59'), 
('19', '2022-04-12 14:18:02', '2022-04-12 14:19:06'), 
('19', '2022-04-12 14:19:09', '0000-00-00 00:00:00'), 
('19', '2022-04-12 16:11:21', '0000-00-00 00:00:00'), 
('19', '2022-04-13 19:43:06', '0000-00-00 00:00:00'), 
('19', '2022-04-16 11:53:59', '0000-00-00 00:00:00'), 
('19', '2022-04-16 12:02:07', '0000-00-00 00:00:00'), 
('19', '2022-04-16 19:58:02', '2022-04-16 20:47:50'), 
('19', '2022-04-16 20:47:53', '2022-04-16 20:48:25'), 
('19', '2022-04-16 20:48:28', '2022-04-16 20:51:30'), 
('19', '2022-04-16 20:51:33', '2022-04-16 21:00:44'), 
('19', '2022-04-18 12:08:28', '0000-00-00 00:00:00'), 
('19', '2022-04-18 12:28:06', '0000-00-00 00:00:00'), 
('19', '2022-04-18 13:34:04', '0000-00-00 00:00:00'), 
('19', '2022-04-18 15:15:17', '0000-00-00 00:00:00'), 
('19', '2022-04-19 11:47:37', '0000-00-00 00:00:00'), 
('19', '2022-04-19 12:16:40', '2022-04-19 20:58:11'), 
('19', '2022-04-21 10:22:03', '0000-00-00 00:00:00'), 
('19', '2022-04-21 11:09:59', '0000-00-00 00:00:00'), 
('19', '2022-04-21 11:12:01', '2022-04-21 12:27:00'), 
('19', '2022-04-21 11:49:03', '0000-00-00 00:00:00'), 
('19', '2022-04-21 12:42:15', '0000-00-00 00:00:00'), 
('19', '2022-04-21 17:04:38', '2022-04-21 18:00:29'), 
('19', '2022-04-21 18:00:48', '2022-04-21 18:00:53'), 
('19', '2022-04-21 19:44:58', '2022-04-21 21:31:53'), 
('19', '2022-04-23 12:21:45', '0000-00-00 00:00:00'), 
('19', '2022-04-23 22:32:39', '2022-04-23 22:59:58'), 
('19', '2022-04-24 19:45:54', '2022-04-24 23:40:24'), 
('19', '2022-04-25 11:02:54', '0000-00-00 00:00:00'), 
('19', '2022-04-25 11:09:40', '2022-04-25 12:05:28'), 
('19', '2022-04-25 12:05:38', '2022-04-25 12:14:00'), 
('19', '2022-04-25 21:23:12', '2022-04-26 02:16:55'), 
('19', '2022-04-26 12:34:59', '2022-04-26 23:52:56'), 
('19', '2022-04-26 13:14:05', '0000-00-00 00:00:00'), 
('19', '2022-04-27 16:33:42', '2022-04-27 22:17:59'), 
('19', '2022-04-27 22:18:02', '2022-04-27 22:18:30'), 
('19', '2022-04-27 22:29:11', '2022-04-27 22:31:42'), 
('19', '2022-04-27 22:32:19', '2022-04-27 22:38:30'), 
('19', '2022-04-28 10:50:49', '2022-04-28 12:02:38'), 
('19', '2022-04-28 12:02:42', '2022-04-28 12:55:40'), 
('19', '2022-04-28 13:03:36', '2022-04-28 13:18:42'), 
('19', '2022-04-28 13:18:45', '2022-04-28 23:06:30'), 
('19', '2022-04-29 21:44:26', '2022-04-29 22:09:34'), 
('19', '2022-04-30 20:53:15', '2022-04-30 21:05:49'), 
('19', '2022-05-01 19:11:52', '2022-05-01 20:02:12'), 
('19', '2022-05-02 10:55:40', '0000-00-00 00:00:00'), 
('19', '2022-05-07 12:34:35', '2022-05-07 14:31:04'), 
('19', '2022-05-07 15:32:18', '2022-05-07 15:36:15'), 
('19', '2022-05-07 15:42:04', '2022-05-07 15:42:13'), 
('19', '2022-05-08 09:49:34', '2022-05-08 10:18:40'), 
('19', '2022-05-09 14:06:45', '2022-05-09 14:10:41');  



 



 



 



 



 



INSERT INTO `category` ( `id`, `category`, `position`, `trash`) VALUES 
('3', 'Virgin', '0', '0'), 
('4', 'Recycle', '0', '0'), 
('5', 'Virgin &amp; Recycle', '0', '0'), 
('6', 'Rice', '0', '0');  



 



INSERT INTO `challan` ( `id`, `created`, `challan_no`, `voucher_no`, `party_code`, `transport_id`, `driver_name`, `driver_mobile`, `driver_address`, `vehicle_no`, `engine_no`, `chassis_no`, `remarks`, `total_quantity`, `user_id`, `trash`) VALUES 
('1', '2022-04-21', '2205157981', 'S2204000063', '0002', '2', '1', '2', '3', '4', '5', '6', 'Remarks', '0.00', '1001', '1'), 
('2', '2022-04-21', '2205158023', 'S2204000063', '0002', '2', '1', '1', '1', '1', '1', '1', 'tset', '14.00', '1001', '1'), 
('3', '2022-05-19', '2205194312', 'S2205000002', 'tset', '2', '', '', '', '', '', '', '', '10.00', '1001', '1'), 
('4', '2022-05-19', '2205196750', 'S2205000007', '0001', '2', '', '', '', '', '', '', '', '4.00', '1001', '1');  



INSERT INTO `challan_items` ( `id`, `created`, `challan_no`, `item_id`, `product_code`, `purchase_price`, `sale_price`, `quantity`, `trash`) VALUES 
('1', '2022-04-21', '2205157981', '123', '0001', '177.84', '232.05', '4.00', '1'), 
('2', '2022-04-21', '2205157981', '124', '0007', '150.22', '200.20', '4.00', '1'), 
('3', '2022-04-21', '2205157981', '125', '0009', '671.14', '882.70', '6.00', '1'), 
('4', '2022-04-21', '2205158023', '123', '0001', '177.84', '232.05', '4.00', '1'), 
('5', '2022-04-21', '2205158023', '124', '0007', '150.22', '200.20', '4.00', '1'), 
('6', '2022-04-21', '2205158023', '125', '0009', '671.14', '882.70', '6.00', '1'), 
('7', '2022-05-19', '2205194312', '4', '0025', '177.82', '31500.00', '10.00', '1'), 
('8', '2022-05-19', '2205196750', '13', '0025', '177.82', '31500.00', '3.00', '1'), 
('9', '2022-05-19', '2205196750', '15', '0025', '177.82', '31500.00', '1.00', '1');  



 



 



INSERT INTO `cost` ( `id`, `date`, `field_code`, `description`, `amount`, `spend_by`, `trash`) VALUES 
('1', '2022-04-23', '', 'Boguna,Potuakhali', '1550.00', 'Asaur', '0'), 
('2', '2022-04-23', '', 'Afjal Transport
Sufiya Plastic 1200/-
Jewel Plastic 800/-', '2000.00', 'Rakib', '0');  



INSERT INTO `cost_field` ( `id`, `code`, `cost_field`, `trash`) VALUES 
('1', '', 'Transport Bill', '0');  



 



 



 



 



INSERT INTO `due_collectio` ( `id`, `date`, `voucher_no`, `previous_paid`, `paid`, `remission`, `due`, `godown_code`, `trash`) VALUES 
('3', '2022-03-22', 'S2203000007', '0.00', '10.00', '0.00', '719.00', '', '0'), 
('4', '2022-03-22', 'S2203000007', '10.00', '10.00', '0.00', '709.00', '', '1'), 
('5', '2022-03-22', 'S2203000007', '20.00', '9.00', '0.00', '700.00', '', '1');  



INSERT INTO `employee` ( `id`, `date`, `emp_id`, `type`, `emp_group`, `name`, `name_bangla`, `joining_date`, `gender`, `mobile`, `email`, `present_address`, `permanent_address`, `employee_type`, `section`, `father_name`, `mother_name`, `department`, `designation`, `dept`, `employee_salary`, `path`, `showroom_id`, `status`, `nid_no`, `trash`) VALUES 
('1', '2022-04-23', '22001', 'Monthly', '3', 'Md. Rakib Hossain', '', '2022-04-23', 'Male', '01309529163', '', 'Bastohara', 'Bastohara', '', '', 'Md. MOjibor Rahman Dulal', 'Rani Begum', '', 'Manager', 'Office', '10000', 'photo no found!', '', 'active', '', '0'), 
('2', '2022-04-23', '22002', 'Monthly', '3', 'Md. Nazmul Haque Raju', '', '2022-04-23', 'Male', '01835301019', '', 'Bastohara', 'Bastohara', '', '', 'Younus Ahmed', 'Deloara Begum', '', 'Driver', 'Driver', '12000', 'photo no found!', '', 'active', '', '0'), 
('3', '2022-04-23', '22003', 'Monthly', '3', 'Aktarul Islam', '', '2022-04-23', 'Male', '01875571259', '', 'Bastohara', 'Bastohara', '', '', 'Md. Kutub Uddin', 'Mrs. Sefali Begum', '', 'Employee', 'Warehouse', '7000', 'photo no found!', '', 'active', '', '0'), 
('4', '2022-04-23', '22004', 'Monthly', '3', 'Md. Mahabub Hasan', '', '2022-04-23', 'Male', '01879347649', '', 'Bastohara', 'Bastohara', '', '', 'Montu Hawladar', 'Aklima Begum', '', 'Employee', 'Warehouse', '7000', 'photo no found!', '', 'active', '', '0');  



 



 



 



 



 



INSERT INTO `income` ( `id`, `date`, `showroom`, `field`, `description`, `amount`, `income_by`, `trash`) VALUES 
('1', '2022-04-24', '', '0001', '13pcs Drum', '13000.00', 'Rakib', '0');  



INSERT INTO `income_field` ( `id`, `code`, `field`) VALUES 
('1', '0001', 'Dram');  



 



 



 



INSERT INTO `materials` ( `id`, `code`, `name`, `category_id`, `unit`, `weight`, `stock_alert`, `purchase_price`, `sale_price`, `dealer_price`, `type`, `status`, `trash`) VALUES 
('18', '0001', 'Dufee Lub Super Motor Oil 20W-50 API/SL 1L x 12pcs', '3', 'liter', '0.00', '60', '0.00', '255.00', '232.05', 'finish_product', 'unavailable', '0'), 
('19', '0002', 'Dufee Lub Bike 4T 20W-40 API/SL 1L x 12pcs', '3', 'liter', '0.00', '60', '0.00', '300.00', '273.00', 'finish_product', 'available', '0'), 
('20', '0003', 'Dufee Lub Bike 4T 20W-40 API/SL 600ML x 24pcs', '3', 'ml', '0.00', '60', '0.00', '185.00', '168.35', 'finish_product', 'available', '0'), 
('21', '0004', 'Dufee Lub Metal Can 20W-50 API/SN/JASOMA2 1L x 12pcs', '3', 'liter', '0.00', '60', '0.00', '390.00', '354.90', 'finish_product', 'available', '0'), 
('22', '0005', 'Dufee Lub Metal Can (Synthetic) 10W-30 API/SN/JASOMA2 1L x 12pcs', '3', 'liter', '0.00', '60', '0.00', '410.00', '373.10', 'finish_product', 'available', '0'), 
('23', '0006', 'Dufee Lub CNG Special 20W-50 API/SN 2L x 6pcs', '3', 'liter', '0.00', '30', '0.00', '520.00', '473.20', 'finish_product', 'available', '0'), 
('24', '0007', 'Dufee Lub (Engine Oil) SAE-40 API/SC/CC 1L x 12Pcs', '5', 'liter', '0.00', '60', '0.00', '220.00', '200.20', 'finish_product', 'available', '0'), 
('25', '0008', 'Dufee Lub Spark-3 SAE-50 API/SF/CF 3L x 6pcs', '5', 'liter', '0.00', '30', '0.00', '610.00', '555.10', 'finish_product', 'available', '0'), 
('26', '0009', 'Dufee Lub Spark-5 SAE-50 API/SF/CF 5L x 6pcs', '5', 'liter', '0.00', '30', '0.00', '970.00', '882.70', 'finish_product', 'available', '0'), 
('27', '0010', 'Dufee Lub (Engine Oil) Multi 20W-50 API/SL/CF 4L x 6pcs', '3', 'liter', '0.00', '30', '0.00', '1010.00', '919.10', 'finish_product', 'available', '0'), 
('28', '0011', 'Dufee Lub (Engine Oil) HD-50 API/SC/CC 20L x 1 Bucket', '5', 'liter', '0.00', '100', '0.00', '3600.00', '3276.00', 'finish_product', 'available', '0'), 
('29', '0012', 'Dufee Lub (Engine Oil) Red HD-50 API/SC/CC 20L x 1 Bucket', '5', 'liter', '0.00', '100', '0.00', '3650.00', '3321.50', 'finish_product', 'available', '0'), 
('30', '0013', 'Dufee Lub (Engine Oil) HD-40 API/SC/CC 20L x 1 Bucket', '4', 'liter', '0.00', '100', '0.00', '3500.00', '3185.00', 'finish_product', 'available', '0'), 
('31', '0014', 'Dufee Lub (Engine Oil) Multi 20W-50 API/SN/CJ4 20L x 1 Bucket', '3', 'liter', '0.00', '100', '0.00', '4500.00', '4095.00', 'finish_product', 'available', '0'), 
('32', '0015', 'Dufee Lub (Engine Oil) Red Multi 20W-50 API/SN/CJ4 20L x 1 Bucket', '3', 'liter', '0.00', '100', '0.00', '4600.00', '4186.00', 'finish_product', 'available', '0'), 
('33', '0016', 'Dufee Lub Gear Oil EP-140 1L x 12pcs', '4', 'liter', '0.00', '60', '0.00', '220.00', '200.20', 'finish_product', 'available', '0'), 
('34', '0017', 'Dufee Lub Gear Oil EP-140 4L x 6pcs', '4', 'liter', '0.00', '30', '0.00', '800.00', '728.00', 'finish_product', 'available', '0'), 
('35', '0018', 'Dufee Lub Gear Oil EP-140 20L x 1 Bucket', '4', 'liter', '0.00', '100', '0.00', '3600.00', '3276.00', 'finish_product', 'available', '0'), 
('36', '0019', 'Dufee Lub Hydrolic Oil-68 20L x 1 Bucket', '5', 'liter', '0.00', '100', '0.00', '3800.00', '3458.00', 'finish_product', 'available', '0'), 
('37', '0020', 'Dufee Lub Hydrolic Oil-68 (Virgin) 205L x 1 Dram (Flat Rate-34000)', '3', 'liter', '0.00', '1', '0.00', '38000.00', '34000.00', 'finish_product', 'available', '0'), 
('38', '0021', 'Dufee Lub Hydrolic Oil-68  205L x 1 Dram (Flat Rate-29000)', '4', 'liter', '0.00', '1', '0.00', '33000.00', '29000.00', 'finish_product', 'available', '0'), 
('39', '0022', 'Dufee Lub Hydrolic Oil-100 205L x 1 Dram (Flat Rate-35000)', '3', 'liter', '0.00', '1', '0.00', '39000.00', '35000.00', 'finish_product', 'available', '0'), 
('40', '0023', 'Dufee Lub (Engine Oil) Virgin SAE-50 205L x 1 Dram (Flat Rate-34000)', '3', 'liter', '0.00', '1', '0.00', '38000.00', '34000.00', 'finish_product', 'available', '0'), 
('41', '0024', 'Dufee Lub (Engine Oil) HD-50 205L x 1 Dram (Flat Rate-28500)', '4', 'liter', '0.00', '1', '0.00', '32500.00', '28500.00', 'finish_product', 'available', '0'), 
('42', '0025', 'Dufee Lub (Engine Oil) HD-40 205L x 1 Dram (Flat Rate-27500)', '4', 'liter', '0.00', '1', '0.00', '31500.00', '27500.00', 'finish_product', 'available', '0'), 
('43', '0026', 'Dufee Lub (Engine Oil) SAE 20W-50 205L x 1 Dram (Flat Rate-36000)', '3', 'liter', '0.00', '1', '0.00', '40000.00', '36000.00', 'finish_product', 'available', '0'), 
('44', '0027', 'Dufee Lub Gear Oil EP-140 205L x 1 Dram (Flat Rate-30000)', '4', 'liter', '0.00', '1', '0.00', '34000.00', '30000.00', 'finish_product', 'available', '0'), 
('45', '0028', 'Dufee Lub Gear Oil EP-140 205L x 1 Dram (Flat Rate-28000)', '4', 'liter', '0.00', '1', '0.00', '32000.00', '28000.00', 'finish_product', 'available', '0'), 
('46', '0046', 'Sierra Rogers', '', 'liter', '0.00', '10', '50.00', '0.00', '0.00', 'raw', 'available', '1'), 
('47', '0047', 'HD-50 Nasrin Automobile', '', 'liter', '0.00', '410', '112.19', '0.00', '0.00', 'raw', 'available', '0'), 
('48', '0048', 'HD-40 Nasrin Automobile', '', 'liter', '0.00', '410', '107.32', '0.00', '0.00', 'raw', 'available', '0'), 
('49', '0049', 'Spark-5 5L Carton', '', 'pcs', '0.00', '20', '65.00', '0.00', '0.00', 'raw', 'available', '0'), 
('50', '0050', 'Gear Oil EP-140 4L Carton', '', 'pcs', '0.00', '20', '58.00', '0.00', '0.00', 'raw', 'available', '0'), 
('51', '0051', '20W-50 Multi 4L Carton', '', 'pcs', '0.00', '20', '58.00', '0.00', '0.00', 'raw', 'available', '0'), 
('52', '0052', 'Spark-3 3L Carton', '', 'pcs', '0.00', '20', '40.00', '0.00', '0.00', 'raw', 'available', '0'), 
('53', '0053', 'Bike 4T 20W-40 1L Carton', '', 'pcs', '0.00', '20', '43.00', '0.00', '0.00', 'raw', 'available', '0'), 
('54', '0054', '20W-50 Super 1L Carton', '', 'pcs', '0.00', '20', '43.00', '0.00', '0.00', 'raw', 'available', '0'), 
('55', '0055', 'SAE-40 1L Carton', '', 'pcs', '0.00', '20', '44.00', '0.00', '0.00', 'raw', 'available', '0'), 
('56', '0056', 'Gear Oil 1L Carton', '', 'pcs', '0.00', '20', '41.00', '0.00', '0.00', 'raw', 'available', '0'), 
('57', '0057', 'Bike 4T 20W-40 600ML Carton', '', 'pcs', '0.00', '20', '41.00', '0.00', '0.00', 'raw', 'available', '0'), 
('58', '0058', 'CNG Special 20W-50 2L Carton', '', 'pcs', '0.00', '20', '41.00', '0.00', '0.00', 'raw', 'available', '0'), 
('59', '0059', 'SAE-50 205L Dram Mega', '', 'liter', '0.00', '410', '146.34', '0.00', '0.00', 'raw', 'available', '0'), 
('60', '0060', 'SAE-40 205L Dram Mega', '', 'liter', '0.00', '410', '143.90', '0.00', '0.00', 'raw', 'available', '0'), 
('61', '0061', 'Excel-40 205L Dram Mega', '', 'liter', '0.00', '410', '131.71', '0.00', '0.00', 'raw', 'available', '0'), 
('62', '0062', 'Hydraulic Oil-68 205L Dram Mega', '', 'liter', '0.00', '410', '136.59', '0.00', '0.00', 'raw', 'available', '0'), 
('63', '0063', 'HD-50 205L Dram Oriental', '', 'liter', '0.00', '410', '151.22', '0.00', '0.00', 'raw', 'available', '0'), 
('64', '0064', 'HD-40 205L Dram Oriental', '', 'liter', '0.00', '410', '151.22', '0.00', '0.00', 'raw', 'available', '0'), 
('65', '0065', 'Test Product', '4', 'kg', '0.00', '100', '800.00', '1200.00', '1000.00', 'finish_product', 'available', '1'), 
('66', '0066', 'Test product', '', 'kg', '0.00', '100', '80.00', '0.00', '0.00', 'raw', 'available', '0'), 
('67', '0067', 'Strawbarry Flavour', '', 'gram', '0.00', '1000', '2.80', '0.00', '0.00', 'raw', 'available', '0'), 
('68', '0068', 'Kameni Flavour', '', 'gram', '0.00', '1000', '2.00', '0.00', '0.00', 'raw', 'available', '0'), 
('69', '0069', 'CNG Special 2L Plastic Can', '', 'pcs', '0.00', '100', '35.00', '0.00', '0.00', 'raw', 'available', '0'), 
('70', '0070', 'Gear Oil 20L Sticker', '', 'pcs', '0.00', '50', '7.00', '0.00', '0.00', 'raw', 'available', '0'), 
('71', '0071', 'Hydraulic Oil-68 20L Sticker', '', 'pcs', '0.00', '50', '7.00', '0.00', '0.00', 'raw', 'available', '0'), 
('72', '0072', 'SAE-40 1L Sticker', '', 'pcs', '0.00', '100', '3.00', '0.00', '0.00', 'raw', 'available', '0'), 
('73', '0073', 'Gear Oil-140 1L Sticker', '', 'pcs', '0.00', '50', '3.00', '0.00', '0.00', 'raw', 'available', '0'), 
('74', '0074', 'Bike 4T 20W-40 1L Sticker', '', 'pcs', '0.00', '200', '3.00', '0.00', '0.00', 'raw', 'available', '0'), 
('75', '0075', 'Super Oil 20W-50 1L Sticker', '', 'pcs', '0.00', '200', '3.00', '0.00', '0.00', 'raw', 'available', '0'), 
('76', '0076', 'CNG 20W-50 2L Sticker', '', 'pcs', '0.00', '100', '3.00', '0.00', '0.00', 'raw', 'available', '0'), 
('77', '0077', 'Spark-3 SAE-50 3L Sticker', '', 'pcs', '0.00', '50', '4.75', '0.00', '0.00', 'raw', 'available', '0'), 
('78', '0078', 'Multi 20W-50 4L Sticker', '', 'pcs', '0.00', '100', '5.00', '0.00', '0.00', 'raw', 'available', '0'), 
('79', '0079', 'Gear Oil-140 4L Sticker', '', 'pcs', '0.00', '100', '5.00', '0.00', '0.00', 'raw', 'available', '0'), 
('80', '0080', 'Spark-5 SAE-50 5L Sticker', '', 'pcs', '0.00', '100', '5.00', '0.00', '0.00', 'raw', 'available', '0'), 
('81', '0081', 'Bike 4T 20W-40 600ML Sticker', '', 'pcs', '0.00', '200', '2.25', '0.00', '0.00', 'raw', 'available', '0'), 
('82', '0082', '20L Bucket Grey(Hydraulic Oil & Gear Oil)', '', 'pcs', '0.00', '50', '220.00', '0.00', '0.00', 'raw', 'available', '0'), 
('83', '0083', '20L Bucket 20W-50 Multi Green', '', 'pcs', '0.00', '50', '240.00', '0.00', '0.00', 'raw', 'available', '0'), 
('84', '0084', '20L Bucket HD-40 White', '', 'pcs', '0.00', '50', '240.00', '0.00', '0.00', 'raw', 'available', '0'), 
('85', '0085', '20L Bucket HD-50 RED', '', 'pcs', '0.00', '50', '240.00', '0.00', '0.00', 'raw', 'available', '0'), 
('86', '0086', 'Spark-5 SAE-50 5L Plastic Can Silver ', '', 'pcs', '0.00', '100', '63.00', '0.00', '0.00', 'raw', 'available', '0'), 
('87', '0087', 'Multi 20W-50 & Gear Oil-140 4L Plastic Can Red', '', 'pcs', '0.00', '100', '58.00', '0.00', '0.00', 'raw', 'available', '0'), 
('88', '0088', 'Spark-3 SAE-50 3L Plastic Can Silver', '', 'pcs', '0.00', '100', '43.00', '0.00', '0.00', 'raw', 'available', '0'), 
('89', '0089', 'Super Oil 20W-50 1L Plastic Can Red', '', 'pcs', '0.00', '200', '21.00', '0.00', '0.00', 'raw', 'available', '0'), 
('90', '0090', 'Bike 4T 20W-40 1L Plastic Can Silver', '', 'pcs', '0.00', '200', '21.00', '0.00', '0.00', 'raw', 'available', '0'), 
('91', '0091', 'SAE-40 1L Plastic Can Golden', '', 'pcs', '0.00', '200', '18.00', '0.00', '0.00', 'raw', 'available', '0'), 
('92', '0092', 'Bike 4T 20W-40 600ML White', '', 'pcs', '0.00', '200', '12.00', '0.00', '0.00', 'raw', 'available', '0'), 
('93', '0093', 'Gear Oil-140 1L Plastic Can Red', '', 'pcs', '0.00', '100', '21.00', '0.00', '0.00', 'raw', 'available', '0'), 
('94', '0094', 'HD-50 Target 205L Dram Nasrin Automobile', '', 'liter', '0.00', '410', '121.95', '0.00', '0.00', 'raw', 'available', '0'), 
('95', '0095', 'Gear Oil-140 205L Dram Nasrin Automobile', '', 'liter', '0.00', '410', '112.20', '0.00', '0.00', 'raw', 'available', '0'), 
('96', '0096', 'Hydraulic Oil-68 205L Dram Nasrin Automobile', '', 'liter', '0.00', '410', '112.20', '0.00', '0.00', 'raw', 'available', '0'), 
('97', '0097', 'Aditive 1Kg Nasrin Automobile', '', 'kg', '0.00', '50', '566.00', '0.00', '0.00', 'raw', 'available', '0'), 
('98', '0098', 'Test Product', '', 'pcs', '0.00', '10', '50.00', '0.00', '0.00', 'raw', 'available', '1'), 
('99', '0099', 'test0000', '3', 'pcs', '0.00', '10', '10.00', '12.00', '12.00', 'finish_product', 'available', '1'), 
('100', '0100', 'Test 00', '', 'pcs', '0.00', '1', '10.00', '0.00', '0.00', 'raw', 'available', '0'), 
('101', '0101', 'Macey Martinez', '3', 'ml', '0.00', '30', '114.00', '874.00', '449.00', 'finish_product', 'available', '0'), 
('102', '0102', 'Test raw', '', 'kg', '0.00', '500', '20.00', '0.00', '0.00', 'raw', 'available', '0'), 
('103', '0103', 'Test Product', '6', 'liter', '50.00', '500', '0.00', '2300.00', '2250.00', 'finish_product', 'available', '0');  



 



 



 



 



INSERT INTO `order_items` ( `id`, `voucher_no`, `product_code`, `purchase_price`, `quantity`, `received_quantity`, `status`, `trash`) VALUES 
('1', 'OR2205182943', '0047', '112.19', '100.00', '100.00', 'complete', '0'), 
('2', 'OR2205182943', '0048', '107.32', '100.00', '100.00', 'complete', '0'), 
('3', 'OR2205182943', '0049', '65.00', '100.00', '100.00', 'complete', '0'), 
('4', 'OR2205243400', '0051', '58.00', '50.00', '50.00', 'complete', '0'), 
('5', 'OR2205243400', '0096', '112.20', '100.00', '100.00', 'complete', '0'), 
('6', 'OR2205243400', '0102', '20.00', '1050.00', '1050.00', 'complete', '0'), 
('7', 'OR2205244790', '0047', '100.00', '10.00', '10.00', 'complete', '0');  



INSERT INTO `orders` ( `id`, `created`, `voucher_no`, `pr_no`, `party_code`, `total_bill`, `total_quantity`, `remarks`, `status`, `trash`) VALUES 
('1', '2022-05-18', 'OR2205182943', '', '001', '28451.00', '300.00', '', 'complete', '0'), 
('2', '2022-05-24', 'OR2205243400', '', '009', '35120.00', '1200.00', '', 'complete', '0'), 
('3', '2022-05-24', 'OR2205244790', '', '001', '1000.00', '10.00', 'tset', 'complete', '0');  



 



INSERT INTO `parties` ( `id`, `opening`, `code`, `company`, `name`, `contact_person`, `mobile`, `address`, `type`, `client_type`, `initial_balance`, `status`, `trash`) VALUES 
('1', '2022-04-09', '001', '', 'Nasrin Automobile', 'Tuhin Bhai', '01763400377', 'Hemayetpur,Savar,Dhaka', 'supplier', '', '0.00', 'active', '0'), 
('2', '2022-04-09', '002', '', 'Mega Lubricant Bangladesh', 'Sahin Bhai', '01817788145', 'Feni', 'supplier', '', '0.00', 'active', '0'), 
('3', '2022-04-09', '003', '', 'Oriental Bangladesh', 'Ismail Bhai', '01908411548', 'Goalkhali', 'supplier', '', '0.00', 'active', '0'), 
('4', '2022-04-09', '004', '', 'Sufiya Plastic', 'Abul Hossain', '01721344650', 'Kamrangichor', 'supplier', '', '0.00', 'active', '0'), 
('5', '2022-04-09', '005', '', 'Erebus Plastic IndustriesLTD.', 'Sobuj Bhai', '01890191878', '', 'supplier', '', '0.00', 'active', '0'), 
('6', '2022-04-10', '006', '', 'N.N Enterprise', 'Walid', '01858888940', ' Savar,Dhaka', 'supplier', '', '0.00', 'active', '0'), 
('7', '2022-04-10', '007', '', 'Soudi Perfumery & Atur House', 'Manik', '01920340492', '56,Yousuf Mansion, Mitford Road, Dhaka-1100', 'supplier', '', '0.00', 'active', '0'), 
('8', '2022-04-10', '008', '', 'Lahore Perfumery House', 'Sayed Anower', '01711619848', '5No,Mitford Road, Mitford Tower,Dhaka-1100', 'supplier', '', '0.00', 'active', '0'), 
('9', '2022-04-12', '009', '', 'Test Supplier', '', '01612345678', '', 'supplier', '', '0.00', 'active', '0'), 
('10', '2022-04-13', '010', '', 'Hasan Polymer Industries', 'Ataur', '01711591270', 'Ward no-55,House no-04,Road no-04, Kamrangirchar,Dhaka 12/11', 'supplier', '', '0.00', 'active', '0'), 
('11', '2022-04-13', '011', '', 'Al-Aksha Printing & Packaging Accesories LTD.', 'Yeasin Arafat', '01611272914', 'Plot no-223,Gadurchar Hemayetpur,Savar,Dhaka-1340', 'supplier', '', '0.00', 'active', '0'), 
('12', '2022-04-13', '0001', '', 'Nurunnahar Enterprise', 'Linkon Khan', '01535172596', 'Fire Service Road, Ward no-09,Baufol,Potuakhali', 'client', '', '0.00', 'active', '0'), 
('13', '2022-04-13', '0002', '', 'Kazi Enterprise ', 'Ataur Rahman', '01716138153', 'Bagherhat, Bus Stand', 'client', '', '0.00', 'active', '0'), 
('14', '2022-04-18', '012', '', 'Test Supplier', '', '01612345678', '', 'supplier', '', '0.00', 'active', '1'), 
('15', '2022-04-21', '0003', '', 'M/S Sumona Enterprise', 'Bodiur Rahman', '01712246496', 'Fokhirhat', 'client', '', '0.00', 'active', '0'), 
('16', '2022-04-21', '0004', '', 'Abid Traders', 'Rashed', '01842390441', 'Hemayetur,Savar,Dhaka', 'client', '', '0.00', 'active', '0'), 
('17', '2022-04-23', '013', '', 'M/S Mariyam Teders', 'Manik', '01719938093', 'Puran Bazer, Potuakhali Sador', 'supplier', '', '0.00', 'active', '1'), 
('18', '2022-04-23', '014', '', 'M/S Hossian Traders', 'Anser Mia', '01954007015/01725499608', 'Sador Road,Ukil Patty,Barguna', 'supplier', '', '0.00', 'active', '1'), 
('19', '2022-04-23', '0005', '', 'M/S Mariyam Teders', 'Md. Manik', '01719938093', 'Puran Bazer, Potuakhali Sador', 'client', '', '0.00', 'active', '0'), 
('20', '2022-04-23', '0006', '', 'M/S Hossian Traders', 'Anser Mia', '01954007015/01725499608', 'Sador Road,Ukil Patty,Barguna', 'client', '', '0.00', 'active', '0'), 
('21', '2022-04-25', '0007', '', 'M/S Gazi Enterprise', 'Md. Nizam Uddin', '01314589958', 'Ward No.7,Hospital Road,Amtoli', 'client', '', '0.00', 'active', '0'), 
('22', '2022-04-25', '015', '', 'Ismail Plastic', 'Jewel Bhai', '01918434186', '30/6,Debidas Ghat,Kamalbag,Dhaka-1211', 'supplier', '', '0.00', 'active', '0'), 
('23', '2022-04-28', '0008', '', 'M/S Afia Automobile', 'Md.Samim', '01913011994', 'Holding No.00,Masimpur ,New Bus Stand,Pirozpur (Main Road)', 'client', '', '0.00', 'active', '0'), 
('24', '2022-05-19', '0009', '', 'Cynthia Ryan', 'Placeat error tempo', 'Esse voluptatem dol', 'Et dolores duis a su', 'client', '', '-77.00', 'active', '0');  



 



 



INSERT INTO `partytransaction` ( `id`, `transaction_at`, `change_at`, `party_code`, `previous_balance`, `debit`, `credit`, `paid`, `remission`, `commission`, `current_balance`, `transaction_via`, `relation`, `remark`, `status`, `comment`, `trash`) VALUES 
('1', '0000-00-00', '', '001', '0.00', '0.00', '28451.00', '0.00', '0.00', '0.00', '-28451.00', 'cash', 'P2205000001', 'purchase', 'purchase', '', '0'), 
('2', '0000-00-00', '', 'tset', '0.00', '315000.00', '0.00', '0.00', '0.00', '0.00', '315000.00', 'cash', 'S2205000002', 'sale', 'sale', '', '1'), 
('3', '0000-00-00', '', '', '0.00', '315000.00', '0.00', '0.00', '0.00', '0.00', '315000.00', 'cash', 'S2205000003', 'sale', 'sale', '', '1'), 
('4', '0000-00-00', '', '0001', '0.00', '158600.00', '0.00', '0.00', '0.00', '0.00', '158600.00', 'cash', 'S2205000004', 'sale', 'sale', '', '1'), 
('5', '2022-05-19', '2022-05-19', 'tset', '0.00', '63000.00', '0.00', '0.00', '0.00', '0.00', '63000.00', 'cash', 'S2205000005', 'sale', 'sale', '', '1'), 
('6', '2022-05-19', '2022-05-19', '', '0.00', '63440.00', '0.00', '0.00', '0.00', '0.00', '63440.00', 'cash', 'S2205000006', 'sale', 'sale', '', '1'), 
('7', '2022-05-19', '2022-05-19', '0001', '0.00', '126000.00', '0.00', '0.00', '0.00', '0.00', '126000.00', 'cash', 'S2205000007', 'sale', 'sale', '', '0'), 
('8', '0000-00-00', '', '', '0.00', '189000.00', '0.00', '0.00', '0.00', '0.00', '189000.00', 'cash', 'S2205000008', 'sale', 'sale', '', '0'), 
('9', '0000-00-00', '', '009', '0.00', '0.00', '34120.00', '0.00', '0.00', '0.00', '-34120.00', 'cash', 'P2205000009', 'purchase', 'purchase', '', '1'), 
('10', '0000-00-00', '', '009', '0.00', '0.00', '35120.00', '0.00', '0.00', '0.00', '-35120.00', 'cash', 'P2205000010', 'purchase', 'purchase', '', '0'), 
('11', '2022-05-24', '', '009', '-35120.00', '0.00', '11000.00', '0.00', '0.00', '0.00', '-46120.00', 'cash', 'P2205000011', 'purchase', 'purchase', '', '0'), 
('12', '2022-05-24', '', '009', '-46120.00', '0.00', '10500.00', '0.00', '0.00', '0.00', '-56620.00', 'cash', 'P2205000012', 'purchase', 'purchase', '', '0'), 
('13', '2022-05-24', '', '009', '-56620.00', '0.00', '11500.00', '0.00', '0.00', '0.00', '-68120.00', 'cash', 'P2205000013', 'purchase', 'purchase', '', '0'), 
('14', '2022-05-24', '', '001', '-28451.00', '0.00', '1121.90', '0.00', '0.00', '0.00', '-29572.90', 'cash', 'P2205000014', 'purchase', 'purchase', '', '0'), 
('15', '2022-05-24', '', '', '0.00', '0.00', '1120.00', '0.00', '0.00', '0.00', '-1120.00', 'cash', 'P2205000015', 'purchase', 'purchase', '', '0'), 
('16', '0000-00-00', '', '001', '-29572.90', '0.00', '1000.00', '0.00', '0.00', '0.00', '-30572.90', 'cash', 'P2205000016', 'purchase', 'purchase', '', '0'), 
('17', '2022-05-24', '', '001', '-30572.90', '0.00', '1000.00', '0.00', '0.00', '0.00', '-31572.90', 'cash', 'P2205000017', 'purchase', 'purchase', '', '0'), 
('18', '2022-05-25', '', '001', '-31572.90', '109.12', '0.00', '0.00', '0.00', '0.00', '31463.78', '0', 'PR2205000001', 'purchase_return', 'purchase_return', '', '0');  



 



 



 



INSERT INTO `privileges` ( `id`, `date`, `privilege_name`, `module_name`, `access`, `user_id`) VALUES 
('1', '2021-02-10', 'admin', '', '{"dashboard":["todays_sale","todays_purchase","supplier_pay","supplier_due","total_supplier","raw_stock_alert"],"row_material_menu":["add","all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return"]}', '9'), 
('2', '2021-02-10', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"cost_menu":["field","new","all"],"product_menu":["add-new","all"],"category_menu":["add-new","all"],"sale_menu":["add-new","all","wise","multi-return","multi-return-all","product_rank"],"fixed_assate_menu":["field","new","all"]}', '10'), 
('3', '2021-10-19', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"row_material_menu":["all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return","product_report"],"packaging_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"machinery_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"cost_menu":["new","all","all"],"product_menu":["all"],"category_menu":["all"],"recipe_menu":["all-formula","make-recipe","pending-recipe","pending-recipe-list","all-recipe"],"order_menu":["add-order","all-order","production","all-delivery-order","wise","order_product_rank"],"factory_menu":["add-order","all-order","production","stock-production","all-stock-order","wise","order_product_rank"],"sale_menu":["add-new","all","wise","multi-return","multi-return-all","product_rank"],"fixed_assate_menu":["field","new","all","field","new","all"],"damages_menu":["add-new","all"],"product_stock_menu":[],"supplier-menu":["all","transaction","all-transaction"],"client_menu":["all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"report_menu":["cash_book","product_wise_order","product_wise_sale","product_wise_order_sale","purchase_report","sales_report","cost_report","profit_loss","balance_sheet"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":[],"bank_menu":["add-bank","add-new","all-acc","add","all","ledger"],"employee_menu":["all","advanced_salary_history","report"],"sms_menu":["send-sms","sms-report"],"backup_menu":[]}', '11'), 
('4', '2022-02-16', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"row_material_menu":["all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return","product_report"],"packaging_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"machinery_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"cost_menu":["new","all","add-new","all"],"product_menu":["all"],"category_menu":["all"],"recipe_menu":["all-formula","make-recipe","pending-recipe","pending-recipe-list","all-recipe"],"production_menu":["createProduction","allProduction"],"order_menu":["add-order","all-order","production","all-delivery-order","wise","order_product_rank"],"factory_menu":["add-order","all-order","production","stock-production","all-stock-order","wise","order_product_rank"],"sale_menu":["add-new","all","wise","multi-return","multi-return-all","product_rank"],"income_menu":["new","all"],"damages_menu":["add-new","all"],"product_stock_menu":[],"supplier-menu":["all","transaction","all-transaction"],"client_menu":["all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"report_menu":["cash_book","production_ledger","product_wise_order","product_wise_sale","product_wise_order_sale","purchase_report","production_report","sales_report","cost_report","profit_loss","balance_sheet"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":["add-new","all","trans","alltrans"],"bank_menu":["all-acc","add","all","ledger"],"employee_menu":["add-new","all","salary","advanced_salary","advanced_salary_history","report"],"fixed_assate_menu":["field","new","all"],"sms_menu":["send-sms","custom-sms","sms-report"],"backup_menu":[]}', '12'), 
('5', '2022-02-16', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier"],"row_material_menu":["all"],"product_menu":["all"],"production_menu":["createProduction","allProduction"],"order_menu":["add-order","all-order"],"income_menu":["field","new","all"],"ledger_menu":["company-ledger","client-ledger"],"fixed_assate_menu":["field","new","all"]}', '6'), 
('6', '2021-10-19', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"row_material_menu":["add","all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return","product_report"],"packaging_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"machinery_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"cost_menu":["field","new","all","add-new","all"],"product_menu":["add-new","all","deactive"],"category_menu":["add-new","all"],"recipe_menu":["make-formula","all-formula","make-recipe","pending-recipe","pending-recipe-list","all-recipe"],"order_menu":["add-order","all-order","production","all-delivery-order","wise","order_product_rank"],"factory_menu":["add-order","all-order","production","stock-production","all-stock-order","wise","order_product_rank"],"fixed_assate_menu":["field","new","all","field","new","all"],"damages_menu":["add-new","all"],"product_stock_menu":[],"client_menu":["add","all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"report_menu":["cash_book","product_wise_order","product_wise_sale","product_wise_order_sale","purchase_report","sales_report","cost_report","profit_loss","balance_sheet"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":["add-new","all","trans","alltrans"],"bank_menu":["add-bank","add-new","all-acc","add","all","ledger"],"employee_menu":["add-new","all","salary","advanced_salary","advanced_salary_history","bonus","report"],"sms_menu":["send-sms","custom-sms","sms-report"],"theme_menu":[],"backup_menu":[]}', '15'), 
('7', '2021-10-19', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"row_material_menu":["add","all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return","product_report"],"packaging_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"machinery_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"cost_menu":["field","new","all","add-new","all"],"product_menu":["add-new","all","deactive"],"category_menu":["add-new","all"],"recipe_menu":["make-formula","all-formula","make-recipe","pending-recipe","pending-recipe-list","all-recipe"],"order_menu":["add-order","all-order","production","all-delivery-order","wise","order_product_rank"],"factory_menu":["add-order","all-order","production","stock-production","all-stock-order","wise"],"sale_menu":["add-new","all","wise","multi-return","multi-return-all","product_rank"],"fixed_assate_menu":["field","new","all","field","new","all"],"damages_menu":["add-new","all"],"product_stock_menu":[],"supplier-menu":["add","all","transaction","all-transaction"],"client_menu":["add","all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"report_menu":["cash_book","product_wise_order","product_wise_sale","product_wise_order_sale","purchase_report","sales_report","cost_report","profit_loss","balance_sheet"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":["add-new","all","trans","alltrans"],"bank_menu":["add-bank","add-new","all-acc","add","all","ledger"],"employee_menu":["add-new","all","salary","advanced_salary","advanced_salary_history","bonus","report"],"sms_menu":["send-sms","custom-sms","sms-report"],"privilege-menu":[],"theme_menu":[],"backup_menu":[]}', '14'), 
('8', '2021-10-19', 'user', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit\n                                    ","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"row_material_menu":["all"],"purchase_menu":["add-new","all","wise","stock","add-packaging","all-packaging","item_wise_used","return","all_return","product_report"],"packaging_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"machinery_menu":["add-purchase","all-purchase","item-wise","stock","add-new","show","item_wise_used"],"cost_menu":["new","all","all"],"product_menu":["all"],"category_menu":["all"],"recipe_menu":["all-formula","make-recipe","pending-recipe","pending-recipe-list","all-recipe"],"order_menu":["add-order","all-order","production","all-delivery-order","wise","order_product_rank"],"factory_menu":["add-order","all-order","production","stock-production","all-stock-order","wise","order_product_rank"],"sale_menu":["add-new","all","wise","multi-return","multi-return-all","product_rank"],"fixed_assate_menu":["field","new","all","field","new","all"],"damages_menu":["add-new","all"],"product_stock_menu":[],"supplier-menu":["all","transaction","all-transaction"],"client_menu":["all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"report_menu":["cash_book","product_wise_order","product_wise_sale","product_wise_order_sale","purchase_report","sales_report","cost_report","profit_loss","balance_sheet"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":["all"],"bank_menu":["all-acc","ledger"],"employee_menu":["all","advanced_salary_history","report"],"sms_menu":["send-sms","custom-sms","sms-report"]}', '13'), 
('9', '2022-02-20', 'user', '', '{}', '18'), 
('10', '2022-05-15', 'admin', '', '{"dashboard":["todays_sale","todays_client_pay","total_client_due","raw_mat_stock","todays_purchase","supplier_pay","todays_expenses","total_exp_pay","supplier_due","finish_stock","bank_deposit","bank_withdraw","total_bank_balance","total_supplier","total_client","cash_in_hand","raw_stock_alert","finish_stock_alert"],"purchase_menu":["material","createOrder","allOrder","add-new","all","wise","stock","return","all_return"],"product_menu":["add-new","all","deactive","category"],"production_menu":["createProduction","allProduction"],"sale_menu":["add-new","all","allChallan","wise","multi-return","multi-return-all"],"product_stock_menu":[],"supplier-menu":["add","all","transaction","all-transaction"],"client_menu":["add","all","transaction","all-transaction"],"ledger_menu":["company-ledger","client-ledger"],"damages_menu":["add-new","all"],"rawdamage_menu":["add-new","all"],"income_menu":["field","new","all"],"cost_menu":["field","new","all"],"due_list_menu":["cash","collection-list","credit","supplier"],"loan-menu":["add-new","all","trans","alltrans"],"bank_menu":["add-bank","add-new","all-acc","add","all","ledger"],"report_menu":["cash_book","product_wise_sale","purchase_report","sales_report","client_wise_report","cost_report","profit_loss","balance_sheet"],"employee_menu":["add-new","all","activeAll"],"salary_menu":["advanced","payment","all_payment","dueSalary"],"fixed_assate_menu":["field","new","all"],"sms_menu":["send-sms","custom-sms","sms-report"],"theme_menu":[],"backup_menu":[]}', '19');  



INSERT INTO `production_items` ( `id`, `created`, `voucher_no`, `batch_no`, `product_code`, `quantity`, `sale_quantity`, `waste_percentage`, `waste_quantity`, `purchase_price`, `sale_price`, `status`, `trash`) VALUES 
('1', '2022-05-18', 'PRO2205186065', '1', '0048', '50.00', '0.00', '0.00', '0.00', '107.32', '0.00', 'from', '1'), 
('2', '2022-05-18', 'PRO2205186065', '1', '0047', '50.00', '0.00', '0.00', '0.00', '112.19', '0.00', 'from', '1'), 
('3', '2022-05-18', 'PRO2205186065', '1', '0049', '50.00', '0.00', '0.00', '0.00', '65.00', '0.00', 'from', '1'), 
('4', '2022-05-18', 'PRO2205186065', '1', '0025', '100.00', '0.00', '0.00', '0.00', '142.25', '31500.00', 'to', '1'), 
('5', '2022-05-18', 'PRO2205188899', '2', '0048', '10.00', '0.00', '5.00', '0.50', '107.32', '0.00', 'from', '1'), 
('6', '2022-05-18', 'PRO2205188899', '2', '0047', '10.00', '0.00', '5.00', '53.66', '112.19', '0.00', 'from', '1'), 
('7', '2022-05-18', 'PRO2205188899', '2', '0049', '10.00', '0.00', '5.00', '0.50', '65.00', '0.00', 'from', '1'), 
('8', '2022-05-18', 'PRO2205188899', '2', '0025', '8.00', '0.00', '0.00', '0.00', '355.64', '31500.00', 'to', '1'), 
('9', '2022-05-18', 'PRO2205183195', '3', '0048', '50.00', '0.00', '10.00', '5.00', '107.32', '0.00', 'from', '0'), 
('10', '2022-05-18', 'PRO2205183195', '3', '0047', '50.00', '0.00', '10.00', '536.60', '112.19', '0.00', 'from', '0'), 
('11', '2022-05-18', 'PRO2205183195', '3', '0049', '50.00', '0.00', '10.00', '5.00', '65.00', '0.00', 'from', '0'), 
('12', '2022-05-18', 'PRO2205183195', '3', '0025', '80.00', '10.00', '0.00', '0.00', '177.82', '31500.00', 'to', '0'), 
('13', '2022-05-19', 'PRO2205196484', '4', '0048', '10.00', '0.00', '0.00', '0.00', '107.32', '0.00', 'from', '0'), 
('14', '2022-05-19', 'PRO2205196484', '4', '0047', '10.00', '0.00', '0.00', '0.00', '112.19', '0.00', 'from', '0'), 
('15', '2022-05-19', 'PRO2205196484', '4', '0049', '10.00', '0.00', '0.00', '0.00', '65.00', '0.00', 'from', '0'), 
('16', '2022-05-19', 'PRO2205196484', '4', '0007', '10.00', '0.00', '0.00', '0.00', '284.51', '220.00', 'to', '0'), 
('17', '2022-05-24', 'PRO2205244296', '5', '0102', '800.00', '0.00', '0.00', '0.00', '22.00', '0.00', 'from', '0'), 
('18', '2022-05-24', 'PRO2205244296', '5', '0103', '700.00', '0.00', '0.00', '0.00', '25.14', '2300.00', 'to', '0'), 
('19', '2022-05-24', 'PRO2205241545', '6', '0102', '1000.00', '0.00', '0.00', '0.00', '22.00', '0.00', 'from', '0'), 
('20', '2022-05-24', 'PRO2205241545', '6', '0103', '600.00', '0.00', '0.00', '0.00', '36.67', '2300.00', 'to', '0');  



INSERT INTO `productions` ( `id`, `created`, `voucher_no`, `batch_no`, `total_quantity`, `total_amount`, `total_waste`, `waste_amount`, `total_production`, `remarks`, `trash`) VALUES 
('1', '2022-05-18', 'PRO2205186065', '1', '150.00', '14225.50', '0.00', '0.00', '100.00', '0', '1'), 
('2', '2022-05-18', 'PRO2205188899', '2', '30.00', '2845.10', '1.50', '142.25', '8.00', '0', '1'), 
('3', '2022-05-18', 'PRO2205183195', '3', '150.00', '14225.50', '15.00', '1422.55', '80.00', '0', '0'), 
('4', '2022-05-19', 'PRO2205196484', '4', '30.00', '2845.10', '0.00', '0.00', '10.00', '0', '0'), 
('5', '2022-05-24', 'PRO2205244296', '5', '800.00', '17600.00', '0.00', '0.00', '700.00', '0', '0'), 
('6', '2022-05-24', 'PRO2205241545', '6', '1000.00', '22000.00', '0.00', '0.00', '600.00', '0', '0');  



 



 



INSERT INTO `salary` ( `id`, `created`, `payment_date`, `emp_id`, `total_salary`, `adjust_amount`, `trash`) VALUES 
('1', '2022-04-23', '2022-03-31', '22001', '10000.00', '0.00', '0'), 
('2', '2022-04-23', '2022-03-31', '22002', '12000.00', '0.00', '0'), 
('3', '2022-04-23', '2022-03-31', '22003', '7000.00', '500.00', '0'), 
('4', '2022-04-23', '2022-03-31', '22004', '7000.00', '0.00', '0');  



INSERT INTO `salary_records` ( `id`, `created`, `payment_date`, `emp_id`, `adjust_amount`, `amount`, `remarks`, `trash`) VALUES 
('1', '2022-04-23', '2022-03-31', '22001', '0.00', '10000.00', 'Salary Paid', '0'), 
('2', '2022-04-23', '2022-03-31', '22002', '0.00', '12000.00', 'Salary Paid', '0'), 
('3', '2022-04-23', '2022-03-31', '22003', '0.00', '6500.00', 'Salary Paid', '0'), 
('4', '2022-04-23', '2022-03-31', '22004', '0.00', '7000.00', 'Salary Paid', '0');  



 



 



INSERT INTO `sapitems` ( `id`, `sap_at`, `voucher_no`, `product_code`, `order_item_id`, `production_item_id`, `quantity`, `total_weight`, `purchase_price`, `sale_price`, `order_quantity`, `weight`, `unit`, `discount`, `order_time`, `remark`, `sap_type`, `stock_type`, `status`, `godown_code`, `trash`) VALUES 
('1', '2022-05-18', 'P2205000001', '0047', '1', '', '100.000', '0.000', '112.19', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('2', '2022-05-18', 'P2205000001', '0048', '2', '', '100.000', '0.000', '107.32', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('3', '2022-05-18', 'P2205000001', '0049', '3', '', '100.000', '0.000', '65.00', '0.00', '0.000', '0.000', 'pcs', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('4', '2022-05-19', 'S2205000002', '0025', '', '12', '10.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('5', '2022-05-19', 'S2205000003', '0025', '', '12', '10.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('6', '2022-05-19', 'S2205000004', '0025', '', '12', '5.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '1'), 
('7', '2022-05-19', 'S2205000004', '0007', '', '16', '5.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '1'), 
('8', '2022-05-19', 'S2205000005', '0025', '', '12', '2.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('9', '2022-05-19', 'S2205000005', '0007', '', '16', '2.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('10', '2022-05-19', 'S2205000006', '0025', '', '12', '2.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('11', '2022-05-19', 'S2205000006', '0007', '', '16', '2.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('12', '2022-05-19', 'S2205000006', '0007', '', '16', '2.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '1'), 
('13', '2022-05-19', 'S2205000007', '0025', '', '12', '3.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '0'), 
('14', '2022-05-19', 'S2205000007', '0007', '', '16', '1.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '1'), 
('15', '2022-05-19', 'S2205000007', '0025', '', '12', '1.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '0'), 
('16', '2022-05-19', 'S2205000007', '0007', '', '16', '2.000', '0.000', '284.51', '220.00', '0.000', '0.000', 'liter', '0.00', '', '', 'credit', '', 'sale', '', '1'), 
('17', '2022-05-19', 'S2205000008', '0025', '', '12', '6.000', '0.000', '177.82', '31500.00', '0.000', '0.000', 'liter', '0.00', '', '', 'cash', '', 'sale', '', '0'), 
('18', '2022-05-24', 'P2205000009', '0051', '4', '', '50.000', '0.000', '58.00', '0.00', '0.000', '0.000', 'pcs', '0.00', '', '', 'raw', '', 'purchase', '', '1'), 
('19', '2022-05-24', 'P2205000009', '0096', '5', '', '100.000', '0.000', '112.20', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '1'), 
('20', '2022-05-24', 'P2205000009', '0102', '6', '', '1000.000', '0.000', '20.00', '0.00', '0.000', '0.000', 'kg', '0.00', '', '', 'raw', '', 'purchase', '', '1'), 
('21', '2022-05-24', 'P2205000010', '0051', '4', '', '50.000', '0.000', '58.00', '0.00', '0.000', '0.000', 'pcs', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('22', '2022-05-24', 'P2205000010', '0096', '5', '', '100.000', '0.000', '112.20', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('23', '2022-05-24', 'P2205000010', '0102', '6', '', '1050.000', '0.000', '20.00', '0.00', '0.000', '0.000', 'kg', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('24', '2022-05-24', 'P2205000011', '0102', '', '', '500.000', '0.000', '22.00', '0.00', '0.000', '0.000', 'kg', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('25', '2022-05-24', 'P2205000012', '0102', '', '', '500.000', '0.000', '21.00', '0.00', '0.000', '0.000', 'kg', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('26', '2022-05-24', 'P2205000013', '0102', '', '', '500.000', '0.000', '23.00', '0.00', '0.000', '0.000', 'kg', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('27', '2022-05-24', 'P2205000014', '0047', '', '', '10.000', '0.000', '112.19', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('28', '2022-05-24', 'P2205000015', '0047', '', '', '10.000', '0.000', '112.00', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('29', '2022-05-24', 'P2205000016', '0047', '7', '', '10.000', '0.000', '100.00', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0'), 
('30', '2022-05-24', 'P2205000017', '0047', '', '', '10.000', '0.000', '100.00', '0.00', '0.000', '0.000', 'liter', '0.00', '', '', 'raw', '', 'purchase', '', '0');  



INSERT INTO `sapmeta` ( `id`, `voucher_no`, `meta_key`, `meta_value`, `trash`) VALUES 
('1', 'P2205000001', 'purchase_by', 'Freelance IT Lab', '0'), 
('2', 'S2205000002', 'sale_by', 'Freelance IT Lab', '1'), 
('3', 'S2205000003', 'sale_by', 'Freelance IT Lab', '1'), 
('4', 'S2205000004', 'sale_by', 'Freelance IT Lab', '1'), 
('5', 'S2205000005', 'sale_by', 'Freelance IT Lab', '1'), 
('6', 'S2205000006', 'sale_by', 'Freelance IT Lab', '1'), 
('7', 'S2205000007', 'sale_by', 'Freelance IT Lab', '0'), 
('8', 'S2205000008', 'sale_by', 'Freelance IT Lab', '0'), 
('9', 'P2205000009', 'purchase_by', 'Freelance IT Lab', '0'), 
('10', 'P2205000010', 'purchase_by', 'Freelance IT Lab', '0'), 
('11', 'P2205000011', 'purchase_by', 'Freelance IT Lab', '0'), 
('12', 'P2205000012', 'purchase_by', 'Freelance IT Lab', '0'), 
('13', 'P2205000013', 'purchase_by', 'Freelance IT Lab', '0'), 
('14', 'P2205000014', 'purchase_by', 'Freelance IT Lab', '0'), 
('15', 'P2205000015', 'purchase_by', 'Freelance IT Lab', '0'), 
('16', 'P2205000016', 'purchase_by', 'Freelance IT Lab', '0'), 
('17', 'P2205000017', 'purchase_by', 'Freelance IT Lab', '0');  



INSERT INTO `saprecords` ( `id`, `sap_at`, `change_at`, `voucher_no`, `order_no`, `party_code`, `client_info`, `party_balance`, `total_quantity`, `total_discount`, `transport_cost`, `total_bill`, `paid`, `due`, `method`, `payment_status`, `remark`, `sap_type`, `sale_type`, `status`, `comment`, `promise_date`, `godown_code`, `trash`) VALUES 
('1', '2022-05-18', '', 'P2205000001', 'OR2205182943', '001', '', '0.00', '300', '0.00', '0.00', '28451.00', '0.00', '28451.00', '', '', '', 'raw', 'order_purchase', 'purchase', '', '', '', '0'), 
('2', '2022-05-19', '', 'S2205000002', '', 'tset', '{"mobile":"set","address":"set"}', '0.00', '10', '0.00', '0.00', '315000.00', '0.00', '315000.00', 'cash', 'due', 'sale', 'cash', '', 'sale', '', '', '', '1'), 
('3', '2022-05-19', '', 'S2205000003', '', '', '{"mobile":"","address":""}', '0.00', '10', '0.00', '0.00', '315000.00', '0.00', '315000.00', 'cash', 'due', 'sale', 'cash', '', 'sale', '', '', '', '1'), 
('4', '2022-05-19', '', 'S2205000004', '', '0001', '', '0.00', '10', '0.00', '0.00', '158600.00', '0.00', '158600.00', 'cash', '', 'sale', 'credit', '', 'sale', '', '', '', '1'), 
('5', '2022-05-19', '', 'S2205000005', '', 'tset', '{"mobile":"","address":""}', '0.00', '2', '0.00', '0.00', '63000.00', '0.00', '63000.00', 'cash', 'due', 'sale', 'cash', '', 'sale', '', '', '', '1'), 
('6', '2022-05-19', '', 'S2205000006', '', '', '{"mobile":"","address":""}', '0.00', '4', '0.00', '0.00', '63440.00', '0.00', '63440.00', 'cash', 'due', 'sale', 'cash', '', 'sale', '', '', '', '1'), 
('7', '2022-05-19', '', 'S2205000007', '', '0001', '', '0.00', '4', '0.00', '0.00', '126000.00', '0.00', '126000.00', 'cash', '', 'sale', 'credit', '', 'sale', '', '', '', '0'), 
('8', '2022-05-19', '', 'S2205000008', '', '', '{"mobile":"","address":""}', '0.00', '6', '0.00', '0.00', '189000.00', '0.00', '189000.00', 'cash', 'due', 'sale', 'cash', '', 'sale', '', '', '', '0'), 
('9', '2022-05-24', '', 'P2205000009', 'OR2205243400', '009', '', '0.00', '1150', '0.00', '0.00', '34120.00', '0.00', '34120.00', '', '', '', 'raw', 'order_purchase', 'purchase', '', '', '', '1'), 
('10', '2022-05-24', '', 'P2205000010', 'OR2205243400', '009', '', '0.00', '1200', '0.00', '0.00', '35120.00', '0.00', '35120.00', '', '', '', 'raw', 'order_purchase', 'purchase', '', '', '', '0'), 
('11', '2022-05-24', '', 'P2205000011', '', '009', '', '-35120.00', '500', '0.00', '0.00', '11000.00', '0.00', '11000.00', '', '', '', 'raw', '', 'purchase', '', '', '', '0'), 
('12', '2022-05-24', '', 'P2205000012', '', '009', '', '-46120.00', '500', '0.00', '0.00', '10500.00', '0.00', '10500.00', '', '', '', 'raw', '', 'purchase', '', '', '', '0'), 
('13', '2022-05-24', '', 'P2205000013', '', '009', '', '-56620.00', '500', '0.00', '0.00', '11500.00', '0.00', '11500.00', '', '', '', 'raw', '', 'purchase', '', '', '', '0'), 
('14', '2022-05-24', '', 'P2205000014', '', '001', '', '-28451.00', '10', '0.00', '0.00', '1121.90', '0.00', '1121.90', '', '', '', 'raw', '', 'purchase', 'test', '', '', '0'), 
('15', '2022-05-24', '', 'P2205000015', '', '', '', '0.00', '10', '0.00', '0.00', '1120.00', '0.00', '1120.00', '', '', '', 'raw', '', 'purchase', 'tset', '', '', '0'), 
('16', '2022-05-24', '', 'P2205000016', 'OR2205244790', '001', '', '-29572.90', '10', '0.00', '0.00', '1000.00', '0.00', '1000.00', '', '', '', 'raw', 'order_purchase', 'purchase', 'tset', '', '', '0'), 
('17', '2022-05-24', '', 'P2205000017', '', '001', '', '-30572.90', '10', '0.00', '0.00', '1000.00', '0.00', '1000.00', '', '', '', 'raw', '', 'purchase', '', '', '', '0');  



INSERT INTO `sapreturn_items` ( `id`, `created_at`, `voucher_no`, `product_code`, `purchase_price`, `sale_price`, `quantity`, `total_weight`, `status`, `trash`) VALUES 
('1', '2022-05-25', 'PR2205000001', '0047', '109.12', '0.00', '1.000', '0.000', 'purchase_return', '0');  



INSERT INTO `sapreturn_records` ( `id`, `created_at`, `voucher_no`, `party_code`, `client_info`, `party_type`, `payment_method`, `previous_balance`, `total_quantity`, `total_bill`, `paid`, `remark`, `status`, `trash`) VALUES 
('1', '2022-05-25', 'PR2205000001', '001', '', 'supplier', '', '-31572.90', '1.00', '109.12', '0.00', '', 'purchase_return', '0');  



INSERT INTO `sessions` ( `session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES 
('0aa5c752a5b001e3cf3a4e1d7f7e5be0', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653389148', 'a:12:{s:9:"user_data";s:0:"";s:7:"user_id";i:1001;s:12:"login_period";s:22:"2022-05-24 16:45:59 pm";s:4:"name";s:16:"Freelance IT Lab";s:5:"email";s:19:"mrskuet08@gmail.com";s:8:"username";s:14:"freelanceitlab";s:6:"mobile";s:11:"01937476716";s:9:"privilege";s:5:"super";s:5:"image";s:27:"private/images/pic-male.png";s:6:"branch";s:1:"1";s:6:"holder";s:5:"super";s:8:"loggedin";b:1;}'), 
('13d1386d0b199068b46ff873c8a723e6', '52.114.14.71', 'Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5 skype-url-preview@microsoft.com', '1653455926', ''), 
('16a2f78087e3dcdbe52bad5497e5c946', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653390721', ''), 
('22a83dca8d3bfb656b61410a7048f2b4', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653454907', ''), 
('46796d9cb35a802c241b59b2e7c5825b', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653455328', ''), 
('4f2a6b18f53403b23d2d8ee94b3e932c', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653455327', ''), 
('63720bf5faab846e541fe29a932dcb96', '52.114.14.71', 'Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5 skype-url-preview@microsoft.com', '1653361564', ''), 
('6a02e3ca80cc7601f2fdf2767fe130ab', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653454907', ''), 
('8afe0171cbe2cd70e17de1fd2d14a344', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36', '1653388599', 'a:12:{s:9:"user_data";s:0:"";s:7:"user_id";i:1001;s:12:"login_period";s:22:"2022-05-24 16:36:57 pm";s:4:"name";s:16:"Freelance IT Lab";s:5:"email";s:19:"mrskuet08@gmail.com";s:8:"username";s:14:"freelanceitlab";s:6:"mobile";s:11:"01937476716";s:9:"privilege";s:5:"super";s:5:"image";s:27:"private/images/pic-male.png";s:6:"branch";s:1:"1";s:6:"holder";s:5:"super";s:8:"loggedin";b:1;}'), 
('8fb3985853661331931341ac1728a7e8', '52.114.14.71', 'Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5 skype-url-preview@microsoft.com', '1653361565', ''), 
('bc238724b58ee42d2f1500543734454b', '207.46.13.184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b', '1653387487', ''), 
('c7de5707bacdebf290430984e421c3a6', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653448016', 'a:12:{s:9:"user_data";s:0:"";s:7:"user_id";i:1001;s:12:"login_period";s:22:"2022-05-25 09:07:05 am";s:4:"name";s:16:"Freelance IT Lab";s:5:"email";s:19:"mrskuet08@gmail.com";s:8:"username";s:14:"freelanceitlab";s:6:"mobile";s:11:"01937476716";s:9:"privilege";s:5:"super";s:5:"image";s:27:"private/images/pic-male.png";s:6:"branch";s:1:"1";s:6:"holder";s:5:"super";s:8:"loggedin";b:1;}'), 
('caa2569d4ccae9210aebb3a05d59d1ec', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653390721', ''), 
('d36d850b672fd6be146f2427501ed9d2', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653454934', ''), 
('d3ea2bafeb939ef370b6b4aa5bcf210c', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653454934', ''), 
('e55cb9d641b91baf4d39371e5b6842e6', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36', '1653362242', 'a:12:{s:9:"user_data";s:0:"";s:7:"user_id";i:1001;s:12:"login_period";s:22:"2022-05-24 09:17:41 am";s:4:"name";s:16:"Freelance IT Lab";s:5:"email";s:19:"mrskuet08@gmail.com";s:8:"username";s:14:"freelanceitlab";s:6:"mobile";s:11:"01937476716";s:9:"privilege";s:5:"super";s:5:"image";s:27:"private/images/pic-male.png";s:6:"branch";s:1:"1";s:6:"holder";s:5:"super";s:8:"loggedin";b:1;}'), 
('e809eaac7e682ad1a737c257a680d8c7', '207.46.13.184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b', '1653387487', ''), 
('f3701e90e78179926e3a4d2ee81a1fd9', '203.89.120.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0', '1653454751', 'a:12:{s:9:"user_data";s:0:"";s:7:"user_id";i:1001;s:12:"login_period";s:22:"2022-05-25 10:59:39 am";s:4:"name";s:16:"Freelance IT Lab";s:5:"email";s:19:"mrskuet08@gmail.com";s:8:"username";s:14:"freelanceitlab";s:6:"mobile";s:11:"01937476716";s:9:"privilege";s:5:"super";s:5:"image";s:27:"private/images/pic-male.png";s:6:"branch";s:1:"1";s:6:"holder";s:5:"super";s:8:"loggedin";b:1;}'), 
('fbd1137dc8b2bf00bf7e096d5e5225d5', '52.114.14.71', 'Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5 skype-url-preview@microsoft.com', '1653455926', '');  



 



 



INSERT INTO `sms_record` ( `id`, `delivery_date`, `order_time`, `mobile`, `message`, `total_characters`, `total_messages`, `delivery_report`, `delivery_time`) VALUES 
('1', '2022-04-07', '', '01937476716', 'Thanks,A transaction is completed. Paid: 35000 Tk, Current Balance: -930 Tk, ( Advanced ) Regards, Arab Feed Mills Ltd', '118', '1', '1', '0000-00-00 00:00:00'), 
('2', '2022-04-23', '', '01309529163', 'Dear Employee, Salary Tk - 10000 has been given. Regards, Charu Press.', '70', '1', '1', '0000-00-00 00:00:00'), 
('3', '2022-04-23', '', '01835301019', 'Dear Employee, Salary Tk - 12000 has been given. Regards, Charu Press.', '70', '1', '1', '0000-00-00 00:00:00'), 
('4', '2022-04-23', '', '01875571259', 'Dear Employee, Salary Tk - 6500 has been given. Regards, Charu Press.', '69', '1', '1', '0000-00-00 00:00:00'), 
('5', '2022-04-23', '', '01879347649', 'Dear Employee, Salary Tk - 7000 has been given. Regards, Charu Press.', '69', '1', '1', '0000-00-00 00:00:00'), 
('6', '2022-04-27', '', '01763400377', 'Thanks,A transaction is completed. Paid: 100000 Tk, Current Balance: 102749.8 Tk, ( Due ) Regards, Arab Feed Mills Ltd', '118', '1', '1', '0000-00-00 00:00:00');  



INSERT INTO `stock` ( `id`, `code`, `name`, `category_id`, `weight`, `quantity`, `unit`, `purchase_price`, `sell_price`, `dealer_price`, `type`, `godown_code`) VALUES 
('1', '0047', 'HD-50 Nasrin Automobile', '', '0.000', '79.000', 'liter', '109.12', '0.00', '0.00', 'raw', ''), 
('2', '0048', 'HD-40 Nasrin Automobile', '', '0.000', '40.000', 'liter', '107.32', '0.00', '0.00', 'raw', ''), 
('3', '0049', 'Spark-5 5L Carton', '', '0.000', '40.000', 'pcs', '65.00', '0.00', '0.00', 'raw', ''), 
('4', '0051', '20W-50 Multi 4L Carton', '', '0.000', '50.000', 'pcs', '58.00', '0.00', '0.00', 'raw', ''), 
('5', '0096', 'Hydraulic Oil-68 205L Dram Nasrin Automobile', '', '0.000', '100.000', 'liter', '112.20', '0.00', '0.00', 'raw', ''), 
('6', '0102', 'Test raw', '', '0.000', '750.000', 'kg', '22.00', '0.00', '0.00', 'raw', '');  



INSERT INTO `tbl_config` ( `id`, `config_key`, `config_value`) VALUES 
('1', 'site_name', 'Kishan Udyog Ltd'), 
('2', 'site_address', 'Narail, Khulna'), 
('3', 'site_mobile', '01937476716'), 
('4', 'site_email', 'kishanudyogltd@gmail.com'), 
('5', 'print_header_style', 'text'), 
('6', 'site_logo', 'public/upload/config/img-165190384415490.png'), 
('7', 'fave_icon', 'public/upload/config/img-165190384916527.png'), 
('8', 'print_banner', 'public/upload/config/img-1575706988970.jpg');  



 



 



 



 



 



 



INSERT INTO `transport` ( `id`, `created`, `company_name`, `name`, `mobile`, `email`, `address`, `remarks`, `trash`) VALUES 
('1', '2022-05-14', 'test', 'test', 'test', 'test@mailinator.com', 'test', 'test', '1'), 
('2', '2022-05-14', 'Kennedy and Green Associates', 'Mari Jarvis', 'Ab quaerat qui qui n', 'bylabyf@mailinator.com', 'Reprehenderit in vol', 'Totam aliqua Qui au', '0'), 
('3', '2022-05-13', 'Meadows and Kennedy Traders', 'Hunter Sloan', 'Esse consectetur qu', 'pakyr@mailinator.com', 'Molestiae a sed qui ', 'Nam fuga In maiores', '0');  



INSERT INTO `users` ( `id`, `opening`, `name`, `l_name`, `gender`, `birthday`, `maritial_status`, `position`, `about`, `website`, `facecbook`, `twitter`, `email`, `username`, `password`, `privilege`, `image`, `mobile`, `branch`, `reset_code`) VALUES 
('19', '2022-03-03 09:55:43', 'Kishan Udyog Ltd', '', '', '', '', '', '', '', '', '', 'kishanudyogltd@gmail.com', 'kishan124', '44c6d6b57ae7140c305b179eceaf0ce8', 'admin', 'public/profiles/kishan124.png', '01719920908', '1', '');  



