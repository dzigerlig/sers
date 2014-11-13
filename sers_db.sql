CREATE DATABASE IF NOT EXISTS sers;
 
USE sers;

--
-- Table structure for table `sers_events`
--


CREATE TABLE IF NOT EXISTS `sers_events` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `picture` varchar(300) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `place` varchar(300) NOT NULL,
  `requirements` varchar(10000) NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `registration_until` date NOT NULL,
  `priceSkydive` decimal(50) NOT NULL,
  `pricePax` decimal(50) NOT NULL,
  `slotsSkydive` int(50) NOT NULL,
  `slotsPax` int(50) NULL,
  `postDate` date NOT NULL,
  PRIMARY KEY (`eventId`)
) ENGINE=InnoDB;

--
-- Table structure for table `sers_participants`
--


CREATE TABLE IF NOT EXISTS `sers_participants` (
  `participantsId` int(11) NOT NULL AUTO_INCREMENT,
  `eventId` int(11) NOT NULL,
  `firstName` varchar(300) NOT NULL,
  `lastName` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `pax` tinyint(1) NOT NULL,
  `deleteCode` varchar(300) NOT NULL,
  PRIMARY KEY (participantsId),
  CONSTRAINT fk_eventID FOREIGN KEY (eventId) REFERENCES sers_events(eventId)
  ON DELETE CASCADE
) ENGINE=InnoDB;

**************
INSERT INTO sers_participants (`deleteCode`,`pax`,`phone`,`email`,`lastName`,`firstName`,`eventId`) VALUES ('ab345cz4563uz','1','0796538262','daniel.dux@helvetia.ch','Dux','Daniel','1');
INSERT INTO sers_participants (`deleteCode`,`pax`,`phone`,`email`,`lastName`,`firstName`,`eventId`) VALUES ('ab345cz4563uz','','0796538262','daniel.dux@helvetia.ch','Zigerlig','Daniel','1');
INSERT INTO sers_participants (`deleteCode`,`pax`,`phone`,`email`,`lastName`,`firstName`,`eventId`) VALUES ('ab345cz4563uz','0','0796538262','daniel.dux@helvetia.ch','Hugentobler','Hans','1');
**************
INSERT INTO sers_events (`postDate`,`slotsPax`,`slotsSkydive`,`pricePax`,`priceSkydive`,`registration_until`,`time_end`,`time_start`,`date_end`,`date_start`,`requirements`,`place`,`description`,`picture`,`name`) VALUES ('2014-10-20',2,8,25,30,'2014-10-13','11:22:00','12:34:00','2014-10-13','2014-10-12','nicht viel','Sitterdorf','Geiler Event von uns','nackt.jpg','Nacktsprung');
INSERT INTO sers_events (`postDate`,`slotsPax`,`slotsSkydive`,`pricePax`,`priceSkydive`,`registration_until`,`time_end`,`time_start`,`date_end`,`date_start`,`requirements`,`place`,`description`,`picture`,`name`) VALUES ('2014-10-21',0,10,450,288,'2015-04-13','18:00:00','09:00:00','2015-05-13','2015-05-13','nicht viel','Sitterdorf','7 Sprungplätze in einem Tag.','tour.jpg','Tour de Suisse');





