-- Table structure for table `category_list` --
CREATE TABLE IF NOT EXISTS `category_list` (
`category_id` int(11) NOT NULL AUTO_INCREMENT,
`category_name` varchar(100) NOT NULL ,
`description` text NULL ,
PRIMARY KEY (`category_id`)
);

-- Data for table `category_list` --
INSERT INTO `category_list` VALUES ('1', 'Saree', 'asas');
INSERT INTO `category_list` VALUES ('2', 'Kurta', 'Hello World lorem ipsum dolor shit hello Hello World lorem ipsum dolor shit hello Hello World lorem ipsum dolor shit hello');

-- Table structure for table `color_list` --
CREATE TABLE IF NOT EXISTS `color_list` (
`color_id` int(11) NOT NULL AUTO_INCREMENT,
`color_name` varchar(100) NOT NULL ,
`color_code` varchar(50) NOT NULL ,
PRIMARY KEY (`color_id`)
);

-- Data for table `color_list` --
INSERT INTO `color_list` VALUES ('3', 'Pink', '#ff33da');
INSERT INTO `color_list` VALUES ('4', 'Red', '#ff0000');
INSERT INTO `color_list` VALUES ('5', 'Blue', '#0034ad');
INSERT INTO `color_list` VALUES ('6', 'as', '#000000');
INSERT INTO `color_list` VALUES ('7', 'as', '#ce1c1c');
INSERT INTO `color_list` VALUES ('8', 'as', '#ff0000');
INSERT INTO `color_list` VALUES ('9', 'as', '#af1212');

-- Table structure for table `contact_queries` --
CREATE TABLE IF NOT EXISTS `contact_queries` (
`query_id` int(11) NOT NULL AUTO_INCREMENT,
`full_name` varchar(100) NOT NULL ,
`mobile_no` varchar(15) NOT NULL ,
`email` varchar(100) NOT NULL ,
`subject` varchar(255) NOT NULL ,
`query` text NOT NULL ,
`status` tinyint(4) NOT NULL DEFAULT 0,
`response` text NULL ,
`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
`updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (`query_id`)
);

-- Table structure for table `item_images` --
CREATE TABLE IF NOT EXISTS `item_images` (
`image_id` int(11) NOT NULL AUTO_INCREMENT,
`item_id` int(11) NOT NULL ,
`image_url` varchar(255) NOT NULL ,
`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
`priority` int(10) unsigned NULL DEFAULT 0,
PRIMARY KEY (`image_id`)
);

-- Data for table `item_images` --
INSERT INTO `item_images` VALUES ('244', '624', 'SLKSAREEA2020ODDSD-5dca477752fc50226595c6a93528eaf3297dbcf8_20240325093856.jpeg', '2024-03-25 21:38:56', '0');
INSERT INTO `item_images` VALUES ('246', '624', 'SLKSAREEA2020ODDSD-5dca477752fc50226595c6a93528eaf3297dbcf8_20240325093906.jpeg', '2024-03-25 21:39:06', '0');
INSERT INTO `item_images` VALUES ('247', '624', 'SLKSAREEA2020ODDSD-5dca477752fc50226595c6a93528eaf3297dbcf8_20240325113101.jpeg', '2024-03-25 23:31:01', '0');

-- Table structure for table `item_list` --
CREATE TABLE IF NOT EXISTS `item_list` (
`item_id` int(11) NOT NULL AUTO_INCREMENT,
`category_id` int(11) NOT NULL ,
`product_id` int(11) NOT NULL ,
`color_id` int(11) NOT NULL ,
`size_id` int(11) NOT NULL ,
`mrp` int(10) unsigned NOT NULL ,
`price` int(10) unsigned NOT NULL ,
`visible` tinyint(1) NOT NULL DEFAULT 0,
`priority` int(10) unsigned NULL ,
PRIMARY KEY (`item_id`)
);

-- Data for table `item_list` --
INSERT INTO `item_list` VALUES ('624', '1', '8', '3', '1', '12', '12', '1', '13');
INSERT INTO `item_list` VALUES ('626', '2', '12', '5', '2', '12', '12', '0', '0');

-- Table structure for table `product_list` --
CREATE TABLE IF NOT EXISTS `product_list` (
`product_id` int(11) NOT NULL AUTO_INCREMENT,
`category_id` int(11) NOT NULL ,
`created_at` datetime NOT NULL DEFAULT current_timestamp(),
`updated_at` datetime NOT NULL DEFAULT current_timestamp(),
`product_code` varchar(50) NOT NULL ,
`product_name` varchar(100) NOT NULL ,
`description` text NULL ,
`keywords` varchar(255) NULL ,
`gender` char(2) NOT NULL ,
`visible` tinyint(1) NOT NULL DEFAULT 1,
`priority` int(10) unsigned NULL ,
PRIMARY KEY (`product_id`)
);

-- Data for table `product_list` --
INSERT INTO `product_list` VALUES ('8', '1', '2024-03-25 01:11:19', '2024-03-25 21:32:33', 'SLKSAREEA2020ODDSD', '32', '12', '3123', 'f', '0', '1');
INSERT INTO `product_list` VALUES ('12', '2', '2024-03-25 21:29:15', '2024-03-25 21:29:19', 'SLKSAREE2020ODD', 'qwwe', 'eqvqw qw qw vq r', 'qweqweqeqw e rwewe we ert e rtr', 'f', '1', '3');

-- Table structure for table `product_specifications` --
CREATE TABLE IF NOT EXISTS `product_specifications` (
`specification_id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL ,
`value` varchar(255) NOT NULL ,
`product_id` int(11) NOT NULL ,
`priority` int(10) unsigned NULL ,
PRIMARY KEY (`specification_id`)
);

-- Table structure for table `size_list` --
CREATE TABLE IF NOT EXISTS `size_list` (
`size_id` int(11) NOT NULL AUTO_INCREMENT,
`size_name` varchar(100) NOT NULL ,
`size_code` varchar(20) NOT NULL ,
PRIMARY KEY (`size_id`)
);

-- Data for table `size_list` --
INSERT INTO `size_list` VALUES ('1', 'Small', 'S');
INSERT INTO `size_list` VALUES ('2', 'Medium', 'M');
INSERT INTO `size_list` VALUES ('3', 'Extra Small', 'XS');
INSERT INTO `size_list` VALUES ('4', 'Large', 'L');

-- Table structure for table `stock` --
CREATE TABLE IF NOT EXISTS `stock` (
`stock_id` int(11) NOT NULL AUTO_INCREMENT,
`item_id` int(11) NOT NULL ,
`location` varchar(100) NOT NULL ,
`quantity` int(11) NOT NULL ,
`remark` text NOT NULL ,
`updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (`stock_id`)
);

-- Data for table `stock` --
INSERT INTO `stock` VALUES ('1', '624', 'Bhuj', '10', '10', '2024-03-25 22:38:14');

