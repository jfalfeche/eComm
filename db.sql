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
	KEY `permanentAddress` (`permanentAddress`),
	PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `LGU`;

CREATE TABLE `LGU`(
	`LGUID` int(15) AUTO_INCREMENT,
	`LGUEmail` varchar(50) NOT NULL,
	`LGUpassword` varchar(150) NOT NULL,
	PRIMARY KEY (`LGUID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




DROP TABLE IF EXISTS `sellers`;

CREATE TABLE `sellers`(
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
	`productCategory` int(15),
	`seller` int(15) NOT NULL,
	PRIMARY KEY	(`productID`),
	KEY `productUnitID` (`productUnitID`),
	KEY `productCategory` (`productCategory`),
	KEY `seller` (`seller`),
	CONSTRAINT `product_ibfk_1` FOREIGN KEY (`productUnitID`) REFERENCES `productUnit` (`productUnitID`),
	CONSTRAINT `product_ibfk_2` FOREIGN KEY (`productCategory`) REFERENCES `productCategory` (`productCategoryID`),
	CONSTRAINT `product_ibfk_3` FOREIGN KEY (`seller`) REFERENCES `sellers` (`sellerID`)
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
	`status` int(15) NOT NULL,
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
	CONSTRAINT `order_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `customers` (`userID`),
	CONSTRAINT `order_ibfk_2` FOREIGN KEY (`shippingAddress`) REFERENCES `customers` (`permanentAddress`),
	CONSTRAINT `order_ibfk_3` FOREIGN KEY (`status`) REFERENCES `orderStatus` (`orderStatusID`),
	CONSTRAINT `order_ibfk_4` FOREIGN KEY (`productDetailID`) REFERENCES `productDetail` (`productDetailID`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;





DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart`(
	`cartID` int(15) AUTO_INCREMENT,
	`userID` int(15),
	`productDetailID` int(15),
	PRIMARY KEY (`cartID`),
	KEY `userID` (`userID`),
	KEY `productDetailID` (`productDetailID`),
	CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `customers` (`userID`),
	CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productDetailID`) REFERENCES `productDetail` (`productDetailID`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


