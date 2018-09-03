# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.21-0ubuntu0.16.04.1)
# Database: laravelcms
# Generation Time: 2018-09-12 09:18:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(160) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `keywords` varchar(3000) NOT NULL,
  `type` varchar(15) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(30) DEFAULT '0',
  `folder_id` int(10) NOT NULL,
  `user_id` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`category_id`, `title`, `description`, `content`, `keywords`, `type`, `approved`, `trashed`, `parent_id`, `folder_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(67,'test','','','','post',0,0,0,0,33,NULL,NULL),
	(68,'ssss','','','','post',0,0,0,0,33,NULL,NULL),
	(69,'sss','','','','post',0,0,0,0,0,NULL,NULL),
	(70,'Konijntjes','','','','product',0,0,71,0,33,NULL,NULL),
	(71,'Dier','','','','product',0,0,0,0,33,NULL,NULL),
	(72,'Konijn2','','','','product',0,0,70,0,33,NULL,NULL),
	(73,'Hamster','','','','product',0,0,71,0,33,NULL,NULL),
	(74,'Hamster2','','','','product',0,0,73,0,33,NULL,NULL),
	(75,'Hamster3','','','','product',0,0,73,0,33,NULL,NULL),
	(76,'Humor','','','','product',0,0,0,0,33,NULL,NULL),
	(77,'Hello','','','','post',0,0,0,0,0,NULL,NULL),
	(78,'Mens','','','','product',0,0,0,10,33,NULL,NULL);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`comment_id`, `content`, `post_id`, `user_id`, `date`, `approved`, `trashed`)
VALUES
	(1,'Comment 1',1,33,'2017-12-05 14:53:04',1,0),
	(2,'Comment 1',1,33,'2017-12-05 14:52:58',1,0);

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `contact_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varbinary(500) NOT NULL,
  `last_name` varbinary(500) NOT NULL,
  `phone_1` varbinary(500) NOT NULL,
  `phone_2` varbinary(500) NOT NULL,
  `email_1` varbinary(500) NOT NULL,
  `email_2` varbinary(500) NOT NULL,
  `dob` varbinary(500) NOT NULL,
  `street` varbinary(500) NOT NULL,
  `street_num` varbinary(500) NOT NULL,
  `street_num_add` varbinary(500) NOT NULL,
  `zip` varbinary(500) NOT NULL,
  `notes` varbinary(500) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(4) NOT NULL DEFAULT '1',
  `img_path` varbinary(500) NOT NULL,
  `user_id` int(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`contact_id`),
  UNIQUE KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(200) NOT NULL,
  `postal` varchar(12) NOT NULL,
  `country_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table folders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `folders`;

CREATE TABLE `folders` (
  `folder_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` varchar(140) DEFAULT '',
  `parent_id` int(255) unsigned DEFAULT NULL,
  `path` varchar(1000) DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `user_id` int(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`folder_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;

INSERT INTO `folders` (`folder_id`, `name`, `description`, `parent_id`, `path`, `size`, `user_id`, `updated_at`, `created_at`)
VALUES
	(3,'Contacts','',NULL,'contacts',NULL,33,'2018-04-29 17:09:53',NULL),
	(5,'Users','',NULL,'uploads/users',NULL,33,'2018-04-29 17:09:57',NULL),
	(9,'Products','',NULL,'uploads/Products',NULL,33,'2018-04-29 17:10:00',NULL),
	(32,'test','',NULL,NULL,NULL,36,'2018-07-13 11:17:00','2018-07-13 11:17:00'),
	(34,'test','',NULL,'/public/uploads/test',NULL,36,'2018-08-24 19:41:02','2018-08-24 19:41:02');

/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table folders_uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `folders_uploads`;

CREATE TABLE `folders_uploads` (
  `folder_id` int(11) unsigned NOT NULL,
  `upload_id` int(11) unsigned NOT NULL,
  KEY `folder_id` (`folder_id`),
  KEY `upload_id` (`upload_id`),
  CONSTRAINT `folders_uploads_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`folder_id`) ON DELETE CASCADE,
  CONSTRAINT `folders_uploads_ibfk_2` FOREIGN KEY (`upload_id`) REFERENCES `uploads` (`upload_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `folders_uploads` WRITE;
/*!40000 ALTER TABLE `folders_uploads` DISABLE KEYS */;

INSERT INTO `folders_uploads` (`folder_id`, `upload_id`)
VALUES
	(32,11),
	(32,12),
	(32,13),
	(32,14),
	(32,15),
	(32,16),
	(32,17),
	(32,18),
	(32,20);

/*!40000 ALTER TABLE `folders_uploads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table galleries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `gallery_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;

INSERT INTO `galleries` (`gallery_id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'gallery','2018-08-24 19:51:20','2018-08-24 19:51:20'),
	(11,'test','2018-08-24 21:15:40','2018-08-24 21:15:40'),
	(12,'rape','2018-08-24 21:26:17','2018-08-24 21:26:17');

/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table galleries_uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `galleries_uploads`;

CREATE TABLE `galleries_uploads` (
  `gallery_id` int(11) unsigned NOT NULL,
  `upload_id` int(11) unsigned NOT NULL,
  KEY `gallery_id` (`gallery_id`),
  KEY `upload_id` (`upload_id`),
  CONSTRAINT `galleries_uploads_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`gallery_id`) ON DELETE CASCADE,
  CONSTRAINT `galleries_uploads_ibfk_2` FOREIGN KEY (`upload_id`) REFERENCES `uploads` (`upload_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `galleries_uploads` WRITE;
/*!40000 ALTER TABLE `galleries_uploads` DISABLE KEYS */;

INSERT INTO `galleries_uploads` (`gallery_id`, `upload_id`)
VALUES
	(1,13),
	(1,16),
	(1,14),
	(1,11),
	(1,15),
	(1,12);

/*!40000 ALTER TABLE `galleries_uploads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table orders_products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders_products`;

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_id` int(255) NOT NULL AUTO_INCREMENT,
  `slug` varchar(160) NOT NULL DEFAULT '',
  `title` varchar(160) NOT NULL DEFAULT '',
  `description` varchar(160) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `template` varchar(100) DEFAULT NULL,
  `parent_id` int(50) NOT NULL DEFAULT '0',
  `approved` tinyint(10) NOT NULL DEFAULT '0',
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;

INSERT INTO `pages` (`page_id`, `slug`, `title`, `description`, `content`, `template`, `parent_id`, `approved`, `trashed`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'jorn-is-jorn','Jorn','jorn','<p>jorn</p>','',0,1,0,36,'2018-04-28 07:03:21','2018-08-03 14:47:22');

/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `failed` tinyint(1) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;

INSERT INTO `permissions` (`permission_id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'create posts','2017-12-27 15:11:28','2017-12-27 15:11:28'),
	(2,'read posts','2017-12-27 15:11:44','2017-12-27 15:11:44'),
	(3,'update posts','2017-12-27 15:14:24','2017-12-27 15:14:24'),
	(4,'delete posts','2018-01-07 11:01:36','2018-01-07 11:01:36'),
	(5,'create users','2017-12-27 15:11:28','2017-12-27 15:11:28'),
	(6,'read users','2017-12-27 15:11:44','2017-12-27 15:11:44'),
	(7,'update users','2017-12-27 15:14:24','2017-12-27 15:14:24'),
	(8,'delete users','2018-01-07 11:01:36','2018-01-07 11:01:36'),
	(9,'create roles','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(10,'read roles','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(11,'update roles','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(12,'delete roles','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(13,'create permissions','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(14,'read permissions','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(15,'update permissions','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(16,'delete permissions','2018-01-07 11:12:00','2018-01-07 11:12:00'),
	(28,'create page','2018-04-03 17:47:38','2018-04-03 17:47:38'),
	(29,'read page','2018-04-03 17:47:52','2018-04-03 17:47:52'),
	(30,'update page','2018-04-03 17:48:21','2018-04-03 17:48:21'),
	(31,'delete page','2018-04-03 17:48:46','2018-04-03 17:48:46'),
	(32,'approve hide posts',NULL,NULL),
	(33,'trash posts',NULL,NULL),
	(34,'approve hide users',NULL,NULL),
	(35,'trash users',NULL,NULL),
	(36,'approve hide pages',NULL,NULL),
	(38,'trash pages',NULL,NULL);

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `post_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(160) DEFAULT NULL,
  `content` varchar(5000) NOT NULL,
  `keywords` varchar(3000) DEFAULT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `category_id` int(50) DEFAULT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(255) NOT NULL,
  `locked_till` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`post_id`, `title`, `description`, `content`, `keywords`, `approved`, `category_id`, `trashed`, `user_id`, `locked_till`, `created_at`, `updated_at`)
VALUES
	(1,'Good','Good','<p>homo</p>',NULL,1,77,0,33,NULL,NULL,NULL),
	(2,'darcula','','<p>dddddd</p>',NULL,1,68,0,33,NULL,NULL,NULL),
	(3,'Testwwww','test','<p>sss</p>',NULL,1,68,0,36,NULL,NULL,NULL),
	(4,'Bad','Bad','<p>homo</p>',NULL,1,77,0,33,NULL,NULL,NULL),
	(5,'lotte','lotte','<p>test</p>',NULL,0,69,0,36,NULL,NULL,NULL),
	(6,'lotte','lotte','<p>test</p>',NULL,0,69,0,36,NULL,NULL,NULL),
	(7,'lotte','lotte','<p>test</p>',NULL,0,69,0,36,NULL,NULL,NULL),
	(8,'lotte','lotte','<p>test</p>',NULL,0,69,0,36,NULL,NULL,NULL),
	(9,'Floki','nieuw','<p>sdfgsffdg</p>',NULL,0,67,0,36,NULL,NULL,NULL),
	(17,'doeidoei','','<p>sadas</p>',NULL,0,68,0,36,NULL,'2018-07-13 09:11:42','2018-07-13 09:11:42'),
	(18,'juny','','<p>sadas</p>',NULL,0,68,0,36,NULL,'2018-07-13 09:12:16','2018-08-03 13:32:58'),
	(19,'Jorn','test','<p>sssssssssssss</p>',NULL,0,67,0,36,NULL,'2018-07-13 14:53:07','2018-07-13 14:53:07'),
	(20,'Jorn','test','<div class=\"container\">\r\n<div class=\"container\">&nbsp;</div>\r\n<div class=\"container\">\r\n<h1 class=\"my-4 text-center text-lg-left\">Selected Gallery</h1>\r\n<div class=\"row text-center text-lg-left\">\r\n<div class=\"col-lg-3 col-md-4 col-xs-6\"><a class=\"d-block mb-4 h-100\" href=\"/storage/uploads/original/8/b3/360/8b3360dc1045f1f12722625cb36a15a7.jpg\"> <img class=\"img-thumbnail\" src=\"/storage/uploads/thumbnail/8/b3/360/8b3360dc1045f1f12722625cb36a15a7.jpg\" alt=\"\" /> </a></div>\r\n<div class=\"col-lg-3 col-md-4 col-xs-6\"><a class=\"d-block mb-4 h-100\" href=\"/storage/uploads/original/b/28/230/b28230090149a78ecfbd94dc88825509.jpg\"> <img class=\"img-thumbnail\" src=\"/storage/uploads/thumbnail/b/28/230/b28230090149a78ecfbd94dc88825509.jpg\" alt=\"\" /> </a></div>\r\n<div class=\"col-lg-3 col-md-4 col-xs-6\"><a class=\"d-block mb-4 h-100\" href=\"/storage/uploads/original/2/41/e4f/241e4f066de6450eed3acbf2a8811b58.jpg\"> <img class=\"img-thumbnail\" src=\"/storage/uploads/thumbnail/2/41/e4f/241e4f066de6450eed3acbf2a8811b58.jpg\" alt=\"\" /> </a></div>\r\n<div class=\"col-lg-3 col-md-4 col-xs-6\"><a class=\"d-block mb-4 h-100\" href=\"/storage/uploads/original/4/e0/df3/4e0df3261390fce0aa60c4e4560c20e9.jpg\"> <img class=\"img-thumbnail\" src=\"/storage/uploads/thumbnail/4/e0/df3/4e0df3261390fce0aa60c4e4560c20e9.jpg\" alt=\"\" /> </a></div>\r\n<div class=\"col-lg-3 col-md-4 col-xs-6\"><a class=\"d-block mb-4 h-100\" href=\"/storage/uploads/original/7/97/402/79740218dcd1211f7b193d7e5c7f0c45.jpg\"> <img class=\"img-thumbnail\" src=\"/storage/uploads/thumbnail/7/97/402/79740218dcd1211f7b193d7e5c7f0c45.jpg\" alt=\"\" /> </a></div>\r\n</div>\r\n</div>\r\n<h1 class=\"my-4 text-center text-lg-left\"><a href=\"/storage/uploads/original/4/e0/df3/4e0df3261390fce0aa60c4e4560c20e9.jpg\"><img src=\"/storage/uploads/original/4/e0/df3/4e0df3261390fce0aa60c4e4560c20e9.jpg\" width=\"100%\" /></a></h1>\r\n<h1 class=\"my-4 text-center text-lg-left\">&nbsp;</h1>\r\n<div class=\"row text-center text-lg-left\">&nbsp;</div>\r\n</div>',NULL,0,67,0,36,NULL,'2018-07-13 14:55:17','2018-09-03 16:20:40');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `category_id` int(50) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(5000) NOT NULL,
  `discount_price` float NOT NULL,
  `savings` float NOT NULL,
  `tax_percentage` tinyint(2) NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `img_path` varchar(250) NOT NULL,
  `folder_id` int(255) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `trashed` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `quantity` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`product_id`, `name`, `category_id`, `price`, `description`, `discount_price`, `savings`, `tax_percentage`, `tax`, `total`, `img_path`, `folder_id`, `approved`, `trashed`, `date`, `quantity`, `user_id`)
VALUES
	(27,'Joden',70,10,'<p>sssss</p>',0,0,0,0,0,'',171,1,0,'2017-03-04',10,33),
	(28,'Jood',70,10,'<p>sssss</p>',0,0,0,0,0,'',0,1,0,'2017-03-04',10,33),
	(29,'adolf',70,10,'<p>xxxx</p>',0,0,0,0,0,'',174,0,0,'2017-03-04',10,33),
	(32,'Jaap',78,10,'<p>sssss</p>',0,0,0,0,0,'',27,0,0,'2017-10-13',10,33),
	(33,'homo',78,10,'<p>dsfdsfs</p>',0,0,0,0,0,'',28,0,0,'2018-01-06',10,33),
	(34,'lot',78,100,'<p>Hllo</p>',0,0,0,0,0,'',29,0,0,'2018-01-06',100,33);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table replies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `replies`;

CREATE TABLE `replies` (
  `reply_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `comment_id` (`comment_id`),
  CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;

INSERT INTO `replies` (`reply_id`, `content`, `comment_id`, `user_id`, `date`, `approved`, `trashed`, `updated_at`, `created_at`)
VALUES
	(1,'Reply',1,33,'2017-11-26 10:55:28',1,0,NULL,NULL),
	(2,'Reply',1,33,'2017-12-05 15:40:21',0,0,NULL,NULL);

/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`role_id`, `name`, `created_at`, `updated_at`)
VALUES
	(3,'admin','2017-12-18 17:55:34','2017-12-18 17:55:39'),
	(4,'user','2017-12-18 17:55:50','2017-12-18 17:55:57'),
	(5,'author','2017-12-27 15:13:30','2017-12-27 15:13:30');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles_permissions`;

CREATE TABLE `roles_permissions` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `roles_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  CONSTRAINT `roles_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles_permissions` WRITE;
/*!40000 ALTER TABLE `roles_permissions` DISABLE KEYS */;

INSERT INTO `roles_permissions` (`role_id`, `permission_id`)
VALUES
	(5,1),
	(5,3),
	(5,2),
	(4,2),
	(3,1),
	(3,2),
	(3,3),
	(3,4),
	(3,5),
	(3,6),
	(3,7),
	(3,8),
	(3,9),
	(3,10),
	(3,11),
	(3,12),
	(3,13),
	(3,14),
	(3,15),
	(3,16),
	(3,28),
	(3,29),
	(3,30),
	(3,31),
	(3,32),
	(3,33),
	(3,34),
	(3,36),
	(3,35),
	(3,38),
	(4,29),
	(5,14),
	(5,28),
	(5,29),
	(5,30);

/*!40000 ALTER TABLE `roles_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table taggables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `taggables`;

CREATE TABLE `taggables` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `taggable_id` int(11) NOT NULL,
  `taggable_type` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `taggables` WRITE;
/*!40000 ALTER TABLE `taggables` DISABLE KEYS */;

INSERT INTO `taggables` (`tag_id`, `taggable_id`, `taggable_type`)
VALUES
	(1,1,'post'),
	(2,1,'post');

/*!40000 ALTER TABLE `taggables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `tag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`tag_id`, `title`, `type`, `user_id`, `approved`, `created_at`, `updated_at`)
VALUES
	(1,'PHP','post',33,0,NULL,NULL),
	(2,'JS','post',33,0,NULL,NULL);

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `upload_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `thumb_name` varchar(100) DEFAULT '',
  `type` varchar(50) NOT NULL,
  `file_path` varchar(5000) DEFAULT '',
  `thumb_path` varchar(5000) DEFAULT '',
  `folder_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;

INSERT INTO `uploads` (`upload_id`, `name`, `file_name`, `thumb_name`, `type`, `file_path`, `thumb_path`, `folder_id`, `user_id`, `size`, `updated_at`, `created_at`)
VALUES
	(11,'Juny','4e0df3261390fce0aa60c4e4560c20e9.jpg','','jpg','','',9,36,'1721263','2018-08-03 13:31:54','2018-07-13 11:16:50'),
	(12,'juny punny','d0712be61b96e0e0a733cd9cc97c7ba2.jpg','','jpg','','',32,36,'2568760','2018-08-03 13:32:29','2018-07-20 09:46:53'),
	(13,'juny moony','8b3360dc1045f1f12722625cb36a15a7.jpg','','jpg','','',32,36,'2051234','2018-08-24 10:52:16','2018-08-03 13:04:58'),
	(14,'juny spoony','241e4f066de6450eed3acbf2a8811b58.jpg','','jpg','','',32,36,'1573521','2018-08-24 10:52:40','2018-08-24 10:51:56'),
	(15,'juny baloony','79740218dcd1211f7b193d7e5c7f0c45.jpg','','jpg','','',32,36,'2206103','2018-08-24 10:53:02','2018-08-24 10:51:58'),
	(16,'juny macaroony','b28230090149a78ecfbd94dc88825509.jpg','','jpg','','',32,36,'2065212','2018-08-24 10:53:21','2018-08-24 10:51:59'),
	(17,'2015-06-05 08.30.43','5d4e7eb6daee02c3769922632139d7bd.jpg','','jpg','','',32,36,'2645598','2018-08-24 10:51:59','2018-08-24 10:51:59'),
	(18,'2015-06-06 09.09.38','d3defb0b1fb8aa357be5e9d684708e67.jpg','','jpg','','',32,36,'1420352','2018-08-24 10:52:00','2018-08-24 10:52:00'),
	(20,'2018-05-03 17.11.56','1391e172490fd1a7e7a0d767c9489267.jpg','','jpg','','',32,36,'1412574','2018-08-24 17:46:52','2018-08-24 17:46:52');

/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(500) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) DEFAULT '',
  `last_name` varchar(100) DEFAULT '',
  `dob` text,
  `email` text NOT NULL,
  `function` text,
  `img_path` varchar(150) DEFAULT '',
  `album_id` int(55) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `dob`, `email`, `function`, `img_path`, `album_id`, `remember_token`, `created_at`, `updated_at`, `trashed`, `approved`)
VALUES
	(36,'admin','$2y$10$Gjgu2jMBEt0unBOI2ovtG.8yxmQGhyNdhULZNF74gE52FrgYuuFfa','Jorn','Schalkwijk',NULL,'jornschalkwijk@gmail.com','Admin','',NULL,'tfpES4SIa5yZ5shRyEog8DJUlpiz21vD59K1IpBsqfB7KwQcWIS3bzkbq6Ur','2018-04-03 13:18:42','2018-04-03 13:18:42',0,0),
	(37,'jorn','$2y$10$YHmivdTJ69/K.IBEip43seO5IFEb55BxC1EZsRyjgwY4AJpIqjAL6','Jorn','Schalkwijk',NULL,'jorn.schalkwijk01@gmail.com','','',NULL,'','2018-08-04 14:05:21','2018-08-04 14:05:21',0,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_permissions`;

CREATE TABLE `users_permissions` (
  `user_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  KEY `permission_id` (`permission_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `users_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE,
  CONSTRAINT `users_permissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `users_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;

INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES
	(36,3),
	(37,4);

/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
