

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `medicine` (
  `ID` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `dosage_quantity` int(11) NOT NULL,
  `dosage_unit` varchar(10) NOT NULL,
  `milligram_quantity` int(11) NOT NULL,
  `milligram_unit` varchar(10) NOT NULL,
  `frequency_quantity` int(11) NOT NULL,
  `frequency_unit` varchar(25) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE `tbl_dosages` (
  `dosage_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_taken` varchar(20) NOT NULL,
  `time_taken` varchar(10) NOT NULL,
  `date_inputted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `userregister` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `UserPassword` varchar(200) NOT NULL,
  `DateRegistered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



ALTER TABLE `medicine`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Medicine_User` (`user_ID`);


ALTER TABLE `tbl_dosages`
  ADD PRIMARY KEY (`dosage_id`),
  ADD KEY `FK_Dosage_Medicine` (`medicine_id`),
  ADD KEY `FK_Dosage_User` (`user_id`);


ALTER TABLE `userregister`
  ADD PRIMARY KEY (`UserID`);


ALTER TABLE `medicine`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `tbl_dosages`
  MODIFY `dosage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `userregister`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `medicine`
  ADD CONSTRAINT `FK_Medicine_User` FOREIGN KEY (`user_ID`) REFERENCES `userregister` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `tbl_dosages`
  ADD CONSTRAINT `FK_Dosage_Medicine` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Dosage_User` FOREIGN KEY (`user_id`) REFERENCES `userregister` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


