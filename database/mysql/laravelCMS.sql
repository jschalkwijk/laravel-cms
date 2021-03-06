-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.7.12-0ubuntu1.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Versie:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Structuur van  tabel cms.albums wordt geschreven
CREATE TABLE IF NOT EXISTS `albums` (
  `album_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` varchar(140) NOT NULL,
  `author` varchar(60) NOT NULL,
  `parent_id` int(255) DEFAULT '0',
  `type` varchar(12) NOT NULL,
  `secured` tinyint(1) NOT NULL,
  `path` varchar(1000) NOT NULL,
  `user_id` int(255) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.albums: ~3 rows (ongeveer)
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` (`album_id`, `name`, `description`, `author`, `parent_id`, `type`, `secured`, `path`, `user_id`) VALUES
	(3, 'Contacts', '', 'admin', 0, '', 0, 'contacts', 26),
	(5, 'Users', '', 'admin', 0, '', 0, 'users', 26),
	(8, 'Products', '', 'admin', 0, '', 0, 'products', 26);
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;


-- Structuur van  tabel cms.categories wordt geschreven
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(160) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `keywords` varchar(3000) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `author` varchar(30) NOT NULL,
  `type` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `parent_id` int(255) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.categories: ~7 rows (ongeveer)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`category_id`, `title`, `description`, `content`, `keywords`, `approved`, `author`, `type`, `date`, `parent_id`, `trashed`) VALUES
	(8, 'Example', 'Hello', ' none', 'ccc', 0, 'admin', 'post\r\n', '2016-10-23', 0, 0),
	(9, 'Dieren', '', '', '', 0, 'admin', 'product', '0000-00-00', 0, 0),
	(10, 'Mensen', 'mensen', '', '', 0, 'Jorn', '', '0000-00-00', 0, 0),
	(54, 'Degoe', '', '', '', 0, '', '', '0000-00-00', 0, 0),
	(62, 'shampoo', '', '', '', 0, '', '', '0000-00-00', 0, 0),
	(63, 'Porn', '', '', '', 0, '', '', '0000-00-00', 0, 0),
	(64, 'jorn', '', '', '', 0, 'admin', 'post', '0000-00-00', 0, 0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Structuur van  tabel cms.contacts wordt geschreven
CREATE TABLE IF NOT EXISTS `contacts` (
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
  PRIMARY KEY (`contact_id`),
  UNIQUE KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.contacts: ~2 rows (ongeveer)
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` (`contact_id`, `first_name`, `last_name`, `phone_1`, `phone_2`, `email_1`, `email_2`, `dob`, `street`, `street_num`, `street_num_add`, `zip`, `notes`, `trashed`, `approved`, `img_path`, `user_id`) VALUES
	(18, _binary 0x6130383931653663636136636231316538663231346563373465656264633435356530386264356432656331356639336661323066373461353766356432323964613236636132653231626533316438633338326533376435396461303761326331653766646564376639623830353531633363616232383962376265623264, _binary 0x6333646138393761306632326163346534373832303735303661323132663263333930623836373763383338333166393237646138323533353961393135666131393430366239303063373638363162353261346439646164393462616632353036343739626337323330323362303861353933386263306237396166653662, _binary 0x6138313334633836386633356339633536356239366166323432636338303331316630333631363366613235626265303161656136653834383661616239373230346166383732376231613562363333323837653135623236613763333432653434613363663164663630613534393335313061323337653030353066383532, _binary 0x6533623266336237666261323735356131353138393065306266383330363437623039656430313737636566313830633961323339613365653636656630326662306439646233313662386633326435643061303964316538633261373039386533346435373434643438366330613361633237313262626666636438303839, _binary 0x3137643263633238396238316562323437333833303531366436636138333665383664373739323866636637333837343031613163346332396662396638363838383966396439646634393461393539643530393831653461313536373431346363336136613731363062303538356439616362653364656331316364306661, _binary 0x6137346563633632313562303632646430336262656365316564373230626561363966613761623466613361663933333334393563396665346333306233653232313234643036306437613035623433323862613835353964303739373731323030393465333566646233386136363235376534393666333538666532323064, _binary 0x3732656538643030633934626138653366363239646435313131616662303165383766666661643462633730363232666133666361343531313337626263396161326663643866643736343861353861383462306533616430626233643537663232383132383638323833643337383731613264633935646565323564613638, _binary 0x3230393766376536653735653561316637636264333764366564636432313931386232366136636162343031343566353333326139616632343337383634633731643234396232373834393661613566346631346132303431666630393739333035343761626630613138653037643736383736303964653361336235633961, _binary 0x6236363531396238343736386366666330343637623032333536343264353630326337316535323766313662663164326436633135633366633136313432373664613265663135313465303732336166656561333963616437376265373236393430366664343566633339393133303365633330343835343161663237623436, _binary 0x3361376230613234383062356235313232623763643137323231656139373163373031613963666332386265366335373334653931643238373738626162633630396139623066366339323964323937303630356338353939376335613432316639653666643536643766333962663735383439326332343764313436363535, _binary 0x6135643564643964326133333037636633306666376362356663313739626535343361386230646139636632653839336666663466663566393561323364386365336637633139666132396237383635653938343834396131663438373563613561396362333638343032306135303362353533323164636233613865383230, _binary 0x3038623733393533643638376432373430393933363637393164626435336632643736363638616462393465383234363636636361333961313063376235356566663531366233343164363537613530366236383635393461663237376466643439326466386161626336393339333661643362303565353630346634613839, 0, 1, _binary 0x66696C65732F7468756D62732F636F6E74616374732F646561642E706E672E7468756D625F35363465646461383361303737362E38303935303431352E706E67, 22),
	(19, _binary 0x3236376139656339303531366664633065306137656233346161393138396635343563343663656538653536313531383538343961343463646334666335653430313235343861383436616466653635623836633635323033636464636436363634306366303933313339653936373538643330366339303235336636626535, _binary 0x3862353036623233623430663064613235303936386134636231323235663734396438313962353136396238643362333733333666396638313636313638346265346533633063643566303531393936633931313563393033623737313963643333353763326566303530323334323132366435356330323534336236306165, _binary 0x3430636635616437343838663264626339303934653766313439616665366533333737353532393961626562303264333838316334323961633065383362373734666263653437626363363633303338366261626237356139326339366139623963636439313436356636343532666233323764623732646530323462666333, _binary 0x3236353939383463373032636533633639356139363162646538306363343032643137346331633938323561643964306535306363643032343837633231343535356662303630376535356531326637356264376435653739323363393166663039623432666232353233653461396538323638346661363965306332623836, _binary 0x3836333133616235316339613234363237363733666339343938383663383139363662316565353133616137313066383535633565613763633766343538376465386165653634396233393035306137623762333035316132383633303533626637366632666637333138613037666165633464323030373262653065396234, _binary 0x3863343766313339666133386666646362376163366130613132333335326331656233646165636466626132663339386237653038646431376665343761383365666335353033623339633562663532666465613038363263626136386535366162313536646436343564623062313166616362353263626562373133626665, _binary 0x6264303666653466643338313539653465626435656665613036373664373634356432353234653735666237366665636339663533623034363133336538303037353938346530633532303738366663313730313066613664636632623264316566623731633630343630616137313165663934666361336236663632346435, _binary 0x6335336135366665666166623663396237356433653331363831623135396363373537623434336435383865363737313965663764386331333539653135646464653338373132303930623037323330666531323734663532316537303530396435396335343532336337366663363134373864616239663765336464663965, _binary 0x3435336662663739633137663561656330363965313130363061383031333035383163353961393966613930333463373033303163663764323566333737663033336665646566383835393030336465373663363339376562333365323366303038613866306364396432393363623161393261353037366437393962346239, _binary 0x6632613965376264663131306235623033316165383037333232656664623364363631323835383963336465366165323564333264373033373061623161373632316438643834303262383265366638393138653339343831393666303866333664393735346361393433333762363736633566653562643635326239636166, _binary 0x6537306138353739656166633763663462346233613363343538326239613139626362376265666566636132643936613162353930653966376563336138616366303135343763363861326336333130386261323436333166666231363830613334353331626665326333326261656332663138636265323434636332306566, _binary 0x3463336532626466373938333538373133643035383362313835366436396636666264333837346466613636306439373366386137353436393263346435383939643936653830316232653535393531623438363838333534383761363361613831383666626663336137653137646634306566376438336635313535333738, 0, 1, _binary 0x66696C65732F7468756D62732F636F6E74616374732F636F6E7669637465642E6A70672E7468756D625F35363631383135306562323833322E38383236303939302E6A7067, 26);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;


-- Structuur van  tabel cms.customers wordt geschreven
CREATE TABLE IF NOT EXISTS `customers` (
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.customers: ~3 rows (ongeveer)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`, `address1`, `address2`, `city`, `postal`, `country_id`, `user_id`) VALUES
	(6, 'Jorn Schalkwijk', 'jornschalkwijk@gmail.com', '620562038', 'Goudplevier 111', '', 'IJsselstein, Utrecht', '3403 AS', 0, 0),
	(7, 'Ivo Schalkwijk', 'ivoschalkwijk@gmail.com', '620562039', 'Goudplevier 111', '', 'IJsselstein, Utrecht', '3403 AS', 0, 0),
	(8, 'Henkie Schalkwijk', 'henkieschalkwijk@gmail.com', '620562038', 'Goudplevier 111', '', 'IJsselstein, Utrecht', '3403 AS', 0, 0);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;


-- Structuur van  tabel cms.downloads wordt geschreven
CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(160) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `keywords` varchar(3000) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `author` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `category` varchar(30) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `demo_url` varchar(1000) NOT NULL,
  `down_url` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.downloads: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;


-- Structuur van  tabel cms.files wordt geschreven
CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `thumb_name` varchar(100) NOT NULL,
  `album_id` int(255) NOT NULL,
  `date` date NOT NULL,
  `secured` tinyint(1) NOT NULL,
  `path` varchar(5000) NOT NULL,
  `thumb_path` varchar(5000) NOT NULL,
  `user_id` int(255) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.files: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;


-- Structuur van  tabel cms.orders wordt geschreven
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.orders: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`order_id`, `hash`, `total`, `paid`, `customer_id`) VALUES
	(80, '94fd0df4dbb6120487502aa987c9532d', 24.2, 0, 6),
	(81, '8aa9b5ac7b46194d774dd062a23f7bdc', 24.2, 0, 7),
	(82, '3a92f316f7bcea122583f403b5a52254', 24.2, 0, 6),
	(83, 'd1d37b69f334b7ddcacfbe6b8493051c', 12.1, 0, 8);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Structuur van  tabel cms.orders_products wordt geschreven
CREATE TABLE IF NOT EXISTS `orders_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.orders_products: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `orders_products` DISABLE KEYS */;
INSERT INTO `orders_products` (`id`, `order_id`, `product_id`, `quantity`) VALUES
	(103, 80, 9, 2),
	(104, 81, 9, 2),
	(109, 82, 9, 2),
	(112, 83, 9, 1);
/*!40000 ALTER TABLE `orders_products` ENABLE KEYS */;


-- Structuur van  tabel cms.pages wordt geschreven
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(160) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `approved` tinyint(10) NOT NULL,
  `author` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `path` varchar(100) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.pages: ~1 rows (ongeveer)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`page_id`, `title`, `description`, `content`, `approved`, `author`, `date`, `category_id`, `trashed`, `path`) VALUES
	(1, 'Jorn', '', 'Hallo Lotte', 1, 'admin', '2015-09-14', '', 0, 'Jorn');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;


-- Structuur van  tabel cms.payments wordt geschreven
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `failed` tinyint(1) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.payments: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;


-- Structuur van  tabel cms.posts wordt geschreven
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(160) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `keywords` varchar(3000) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(50) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.posts: ~10 rows (ongeveer)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`post_id`, `title`, `description`, `content`, `keywords`, `approved`, `user_id`, `date`, `category_id`, `trashed`, `created_at`, `updated_at`) VALUES
	(29, 'Test1', '', '<p>twst</p>', '', 1, 26, '2016-10-27', 8, 0, NULL, '2016-10-29 12:32:52'),
	(30, 'help', '', '<p>nu</p>', '', 1, 26, '2016-10-27', 9, 0, NULL, NULL),
	(31, 'lott', 'test', '<p>hallo lotte</p>', '', 0, 26, '2016-10-27', 10, 0, NULL, NULL),
	(32, 'Floki', 'loki', '9', '', 0, 26, '2016-10-27', 9, 0, NULL, NULL),
	(33, 'ragnar', 'sss', '10', '', 0, 26, '2016-10-27', 0, 0, NULL, NULL),
	(34, 'EDWE', 'dd', '<p>sss</p>', '', 0, 26, '2016-10-27', 63, 0, NULL, NULL),
	(35, 'Jorn', 'Jo4rn', '<p>ddd</p>', '', 0, 26, '2016-10-27', 63, 0, NULL, NULL),
	(36, 'Ivo', 'ivo', '<p>ss</p>', '', 0, 26, '2016-10-27', 10, 0, NULL, NULL),
	(37, 'Fez', 'voe', '<p><a href="http://localhost/cms/admin/files/error/57af33d7272415.47406753.png"><img src="http://localhost/cms/admin/files/error/57af33d7272415.47406753.png" alt="" width="100%" /></a>jorn</p>', '', 0, 26, '2016-10-27', 64, 1, NULL, NULL),
	(38, 'pietje', 'snjj', '<p>ss</p>', '', 0, 26, '2016-10-27', 62, 1, NULL, NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;


-- Structuur van  tabel cms.products wordt geschreven
CREATE TABLE IF NOT EXISTS `products` (
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
  `album_id` int(255) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `trashed` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `author` varchar(100) NOT NULL,
  `quantity` int(255) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.products: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`product_id`, `name`, `category_id`, `price`, `description`, `discount_price`, `savings`, `tax_percentage`, `tax`, `total`, `img_path`, `album_id`, `approved`, `trashed`, `date`, `author`, `quantity`) VALUES
	(8, 'Hamster', 131, 10, '<p>test</p>', 0, 0, 0, 0, 0, '', 132, 0, 0, '0000-00-00', '', 10),
	(9, 'Konijn', 9, 10, '<p>hallo</p>', 0, 0, 0, 0, 0, 'files/thumbs/products/Dieren/Konijn/jemoeder/11707579_10152840908746400_8419897691707416081_n.jpg.thumb_57444b065709c6.34315626.jpg', 133, 0, 0, '0000-00-00', '', 2),
	(10, 'jorn', 9, 100, '<p>xx</p>', 0, 0, 0, 0, 0, '', 151, 1, 0, '0000-00-00', '', 5),
	(11, 'Cindy', 9, 500, '<p>ddfd</p>', 0, 0, 0, 0, 0, 'files/thumbs/products/Dieren/Cindy/1557445_10202875641426277_1385188966_n.jpg.thumb_575187675abce2.65507233.jpg', 152, 1, 0, '0000-00-00', '', 1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Structuur van  tabel cms.profiles wordt geschreven
CREATE TABLE IF NOT EXISTS `profiles` (
  `profile_id` int(30) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(500) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varbinary(500) NOT NULL,
  `last_name` varbinary(500) NOT NULL,
  `dob` varbinary(500) NOT NULL,
  `email` varbinary(500) NOT NULL,
  `function` varbinary(500) NOT NULL,
  `rights` varchar(500) NOT NULL,
  `token` varchar(100) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.profiles: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;


-- Structuur van  tabel cms.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(30) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varbinary(500) DEFAULT NULL,
  `last_name` varbinary(500) DEFAULT NULL,
  `dob` varbinary(500) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `function` varbinary(500) DEFAULT NULL,
  `rights` varbinary(500) NOT NULL,
  `img_path` varchar(150) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `album_id` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel cms.users: ~1 rows (ongeveer)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `dob`, `email`, `function`, `rights`, `img_path`, `remember_token`, `trashed`, `approved`, `album_id`, `created_at`, `updated_at`) VALUES
	(26, 'admin', '$2y$10$MTc1YjI2OTE0ZmVjN2ZlM.srhqkbAPviVPYFMGYeXEGZlIrIaGoQK', NULL, NULL, _binary '', 'jornschalkwijk@gmail.com', NULL, _binary 0x41646D696E, '', 'HzKpvRjVzQCpQ5B4cQvj8U46rMcCi7pPGjJbUwzNS214IKdkZiOIZ435z2cM', 0, 0, 0, NULL, '2016-10-26 15:06:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
