-- Database: `ajs_blogs`

DROP TABLE IF EXISTS `blog_entries`
CREATE TABLE `blog_entries` (
  `entryID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dateDiscrete` datetime NOT NULL,
  `dateOverride` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uploadinst` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filepath` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `permalink` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `disableComment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`entryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GuestUsers`
CREATE TABLE `GuestUsers` (
  `userID` int(4) NOT NULL AUTO_INCREMENT,
  `userName` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(40) NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emailAdr` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `adminHold` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `emailAdr` (`emailAdr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `blogComments`;
CREATE TABLE `blogComments` (
  `commentID` int(4) NOT NULL AUTO_INCREMENT,
  `entryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` varchar(400) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `saveInst` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;