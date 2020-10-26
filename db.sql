CREATE DATABASE `PhilCafe`;

USE `PhilCafe`;

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers`(
	`userID` int(15) AUTO_INCREMENT,
	`customerEmail` varchar(50) NOT NULL,
	`firstName` varchar(50) NOT NULL,
	`middleName` varchar(50) NOT NULL,
	`lastName` varchar(50) NOT NULL,
	`password` varchar(150) NOT NULL,
	`contactNumber` varchar(15) NOT NULL,
	`permanentAddress` varchar(200) NOT NULL,
	`gender` varchar(10) NOT NULL,
	`birthday` date NOT NULL,
	PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `LGU`;

CREATE TABLE `LGU`(
	`LGUID` int(15) AUTO_INCREMENT,
	`LGUEmail` varchar(50) NOT NULL,
	`LGUpassword` varchar(150) NOT NULL,
	PRIMARY KEY (`LGUID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `seller`;

CREATE TABLE `seller`(
	`sellerID` int(15) AUTO_INCREMENT,
	`storeStatus` boolean NOT NULL,
	`storeName` varchar(100) NOT NULL,
	`storeEmail` varchar(50) NOT NULL,
	`storeDescription` text NOT NULL,
	`profilePhoto` longblob NOT NULL,
	PRIMARY KEY (`sellerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



DROP TABLE IF EXISTS `productUnit`;

CREATE TABLE `productUnit`(
	`productUnitID` int(15) AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	PRIMARY KEY (`productUnitID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `productCategory`;

CREATE TABLE `productCategory`(
	`productCategoryID` int(15) AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	PRIMARY KEY (`productCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`(
	`productID` int(15) AUTO_INCREMENT,
	`productName` varchar(150) NOT NULL,
	`description` text NOT NULL,
	`image` longblob NOT NULL,
	`stock` int(15) NOT NULL,
	`price` int(15) NOT NULL,
	`productUnitID` int(15) NOT NULL,
	`productCategory` int(15) NOT NULL,
	`seller` int(15) NOT NULL,
	PRIMARY KEY	(`productID`),
	KEY `productUnitID` (`productUnitID`),
	KEY `productCategory` (`productCategory`),
	KEY `seller` (`seller`),
	CONSTRAINT `product_ibfk_1` FOREIGN KEY (`productUnitID`) REFERENCES `productUnit` (`productUnitID`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `product_ibfk_2` FOREIGN KEY (`productCategory`) REFERENCES `productCategory` (`productCategoryID`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `product_ibfk_3` FOREIGN KEY (`seller`) REFERENCES `seller` (`sellerID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `orderStatus`;

CREATE TABLE `orderStatus`(
	`orderStatusID` int(15) AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	PRIMARY KEY (`orderStatusID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;





DROP TABLE IF EXISTS `productDetail`;

CREATE TABLE `productDetail`(
	`productDetailID` int(15) AUTO_INCREMENT,
	`productID` int(15),
	`quantity` int(10),
	PRIMARY KEY (`productDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `order`;

CREATE TABLE `order`(
	`orderNo` int(15) AUTO_INCREMENT,
	`buyerID` int(15) NOT NULL,
	`shippingAddress` varchar(200) NOT NULL,
	`status` varchar(10) NOT NULL,
	`paymentMethod` varchar(10) NOT NULL,
	`dateOrdered` date NOT NULL,
	`dateCompleted` date NOT NULL,
	`totalAmount` decimal(10,2) NOT NULL,
	`shippingFee` decimal(10,2) NOT NULL,
	`message` text NOT NULL,
	`productDetailID` int(15) NOT NULL,
	PRIMARY KEY (`orderNo`),
	KEY `buyerID` (`buyerID`),
	KEY `shippingAddress` (`shippingAddress`),
	KEY `status` (`status`),
	KEY `productDetailID` (`productDetailID`),
	CONSTRAINT `order_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `customer` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `order_ibfk_2` FOREIGN KEY (`shippingAddress`) REFERENCES `customer` (`permanentAddress`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `order_ibfk_3` FOREIGN KEY (`status`) REFERENCES `orderStatus` (`orderStatusID`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `order_ibfk_4` FOREIGN KEY (`productDetailID`) REFERENCES `productDetail` (`productDetailID`) ON DELETE SET NULL ON UPDATE CASCADE,

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;





DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart`(
	`cartID` int(15) AUTO_INCREMENT,
	`userID` int(15),
	`productDetailID` int(15),
	PRIMARY KEY (`cartID`),
	KEY `userID` (`userID`),
	KEY `productDetailID` (`productDetailID`),
	CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `customer` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productDetailID`) REFERENCES `productDetail` (`productDetailID`) ON DELETE SET NULL ON UPDATE CASCADE,

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


