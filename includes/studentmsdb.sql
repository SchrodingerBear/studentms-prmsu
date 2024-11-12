-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 27, 2024 at 08:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555558, 'admin@gmail.com', 'admin', '2019-10-11 04:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblclass`
--

CREATE TABLE `tblclass` (
  `ID` int(5) NOT NULL,
  `ClassName` varchar(50) DEFAULT NULL,
  `Section` varchar(20) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclass`
--

INSERT INTO `tblclass` (`ID`, `ClassName`, `Section`, `CreationDate`) VALUES
(1, 'BSE- SOCIAL STUDIES', '1', '2024-08-26 06:16:18'),
(2, 'BSE- SOCIAL STUDIES', '2', '2024-08-26 06:16:18'),
(3, 'BSE- SOCIAL STUDIES', '3', '2024-08-26 06:16:18'),
(4, 'BSE- SOCIAL STUDIES', '4', '2024-08-26 06:16:18'),
(5, 'BSCS', '1A', '2024-08-26 06:16:18'),
(6, 'BSCS', '1B', '2024-08-26 06:16:18'),
(7, 'BSCS', '1C', '2024-08-26 06:16:18'),
(8, 'BSCS', '2A', '2024-08-26 06:16:18'),
(9, 'BSCS', '2B', '2024-08-26 06:16:18'),
(10, 'BSCS', '3A', '2024-08-26 06:16:18'),
(11, 'BSCS', '3B', '2024-08-26 06:16:18'),
(12, 'BCS', '4A', '2024-08-26 06:16:18'),
(13, 'Beed', '1', '2024-08-26 06:16:18'),
(14, 'Beed', '2', '2024-08-26 06:16:18'),
(15, 'Beed', '3', '2024-08-26 06:16:18'),
(16, 'Beed', '4', '2024-08-26 06:16:18'),
(17, 'BSE English', '1', '2024-08-26 06:16:18'),
(18, 'BSE English', '2', '2024-08-26 06:16:18'),
(19, 'BSE English', '3', '2024-08-26 06:16:18'),
(20, 'BSE English', '4', '2024-08-26 06:16:18'),
(21, 'BSE math', '1', '2024-08-26 06:16:18'),
(22, 'BSE math', '2', '2024-08-26 06:16:18'),
(23, 'BSE math', '3', '2024-08-26 06:16:18'),
(26, 'BSCS', '3A', '2024-10-25 17:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotice`
--

CREATE TABLE `tblnotice` (
  `ID` int(5) NOT NULL,
  `AnnouncementTitle` mediumtext DEFAULT NULL,
  `ClassId` int(10) DEFAULT NULL,
  `AnnouncementMsg` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblnotice`
--

INSERT INTO `tblnotice` (`ID`, `AnnouncementTitle`, `ClassId`, `AnnouncementMsg`, `CreationDate`) VALUES
(8, 'Test Announcement', 3, 'Test', '2024-09-03 05:55:11'),
(9, 'New', 3, '123', '2024-09-03 05:55:46'),
(10, 'Test', 1, 'te', '2024-09-06 08:29:34'),
(11, 'TEST FOR BSMATH 3', 23, 'HELLO', '2024-09-26 00:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About Us', '<div style=\"text-align: start;\"><b><font color=\"#ffffcc\">HEELO RAMONIANS</font></b></div>', NULL, NULL, NULL),
(2, 'contactus', 'Contact Us', 'Hello', 'infodata@gmail.com', 7896541236, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpublicnotice`
--

CREATE TABLE `tblpublicnotice` (
  `ID` int(5) NOT NULL,
  `AnnouncementTitle` varchar(200) DEFAULT NULL,
  `AnnouncementMessage` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpublicnotice`
--

INSERT INTO `tblpublicnotice` (`ID`, `AnnouncementTitle`, `AnnouncementMessage`, `CreationDate`) VALUES
(1, 'School will re-open', 'Consult your class teacher.', '2022-01-20 09:11:57'),
(2, 'Test Public Announcement', 'This is for Testing\r\n', '2022-02-02 19:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `ID` int(10) NOT NULL,
  `StudentName` varchar(200) DEFAULT NULL,
  `StudentEmail` varchar(200) DEFAULT NULL,
  `StudentClass` varchar(100) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `StuID` varchar(200) DEFAULT NULL,
  `FatherName` mediumtext DEFAULT NULL,
  `MotherName` mediumtext DEFAULT NULL,
  `ContactNumber` bigint(10) DEFAULT NULL,
  `AltenateNumber` bigint(10) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `DateofAdmission` timestamp NULL DEFAULT current_timestamp(),
  `verify` int(11) NOT NULL,
  `isReading` tinyint(1) NOT NULL,
  `last_seen` datetime DEFAULT current_timestamp(),
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`ID`, `StudentName`, `StudentEmail`, `StudentClass`, `Gender`, `DOB`, `StuID`, `FatherName`, `MotherName`, `ContactNumber`, `AltenateNumber`, `Address`, `UserName`, `Password`, `Image`, `DateofAdmission`, `verify`, `isReading`, `last_seen`, `code`) VALUES
(24, 'Bacho, Vinniel C.', 'vinnielbacho22@gmail.com', '12', 'Male', '2024-11-08', '21-1-2-0194', '', '', 9985111612, 9164502731, 'sinbacan', '21-1-2-0194', '$2y$10$LMeB1/uqtKqamRA4NPh7rOlX6gtE04WDpo9UuSHZd1D0H5Saep6fG', 'user/images/profile/10fb15c77258a991b0028080a64fb42d1730007487.png', '2024-10-27 05:38:07', 1, 0, '2024-10-27 13:38:07', 'ocYZxQdOWf'),
(25, 'Vinniel', 'vinnielbacho22@gmail.com', NULL, NULL, '2024-10-27', '21-1-2-0197', 'robert', 'luisa metran', 9164502777, 9164502731, 'sinbacan', '21-1-2-0197', '12345', '21-1-2-0197.png', '0000-00-00 00:00:00', 1, 0, '2024-10-27 15:10:35', 'PuPbJBQJQS');

-- --------------------------------------------------------

--
-- Table structure for table `tblviolations`
--

CREATE TABLE `tblviolations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `violation_date` date NOT NULL,
  `violation_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Sanction` int(11) NOT NULL,
  `penalty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblviolations`
--

INSERT INTO `tblviolations` (`id`, `student_id`, `violation_date`, `violation_type`, `description`, `Sanction`, `penalty`) VALUES
(2, 0, '2024-08-01', 'Major University Offenses', 'Prohibited Drugs - Other drug related offenses', 3, 'Suspension for the rest of the academic year'),
(3, 0, '2024-08-01', 'Major University Offenses', 'Prohibited Drugs - Other offenses', 4, 'Expulsion'),
(4, 0, '2024-08-01', 'Major University Offenses', 'Liquor - Entering the university in a drunken state', 1, '12 hrs. Transformative Experience'),
(6, 0, '2024-08-01', 'Major University Offenses', 'Liquor - Bringing liquor into University Premises', 3, 'Guidance Intervention'),
(9, 0, '2024-08-01', 'Major University Offenses', 'Subversive Activities - Instigating disorder', 3, 'Counseling'),
(10, 0, '2024-08-01', 'Major University Offenses', 'Mass Action - Leading violent rallies', 1, '12 hrs. Transformative Experience'),
(11, 0, '2024-08-01', 'Major University Offenses', 'Mass Action - Violent group actions', 2, '24 hrs. Transformative Experience'),
(12, 0, '2024-08-01', 'Major University Offenses', 'Mass Action - Organizing disruptive groups', 3, 'Counseling'),
(13, 0, '2024-08-01', 'Major University Offenses', 'Extortion - Asking money forcibly', 1, '12 hrs. Transformative Experience'),
(14, 0, '2024-08-01', 'Major University Offenses', 'Extortion - Extorting money', 2, '24 hrs. Transformative Experience'),
(15, 0, '2024-08-01', 'Major University Offenses', 'Extortion - Forcibly asking money', 3, 'Restitution'),
(16, 0, '2024-08-01', 'Major University Offenses', 'Slander/Libel Gossip - Defamatory remarks', 1, 'Guidance Intervention'),
(17, 0, '2024-08-01', 'Major University Offenses', 'Falsification of Documents - Forging documents', 1, 'Guidance Intervention'),
(18, 0, '2024-08-01', 'Major University Offenses', 'Falsification of Documents - Forgery of signatures', 2, '15 days suspension'),
(19, 0, '2024-08-01', 'Major University Offenses', 'Falsification of Documents - Entering with fake ID', 3, 'Guidance Intervention'),
(20, 0, '2024-08-01', 'Major University Offenses', 'Vandalism - Destroying property', 1, 'Guidance Intervention'),
(21, 0, '2024-08-01', 'Major University Offenses', 'Theft - Stealing property', 1, 'Restitution'),
(22, 0, '2024-08-01', 'Major University Offenses', 'Immoral Acts - Lasciviousness', 1, 'Guidance Intervention'),
(23, 0, '2024-08-01', 'Major University Offenses', 'Gambling - Bringing playing cards', 1, 'Written Reprimand'),
(24, 0, '2024-08-01', 'Major University Offenses', 'Gambling - Engaging in gambling', 2, 'Guidance Intervention'),
(25, 0, '2024-08-01', 'Major University Offenses', 'Defalcation of funds', 1, 'Restitution'),
(27, 0, '2024-08-01', 'Major University Offenses', 'Online/Verbal/Physical bullying', 1, 'Guidance Intervention'),
(28, 0, '2024-08-01', 'Major University Offenses', 'Gender-Based Sexual Harassment', 1, 'Guidance Intervention'),
(29, 0, '2024-08-01', 'Major University Offenses', 'Crimes involving Moral Turpitude', 1, 'Counseling'),
(30, 0, '2024-08-01', 'Minor University Offenses', 'Littering in the campus', 1, 'Summon to Parents'),
(31, 0, '2024-08-01', 'Minor University Offenses', 'Posting materials without approval', 1, 'Summon to Parents'),
(32, 0, '2024-08-01', 'Minor University Offenses', 'Viewing indecent material', 1, 'Summon to Parents'),
(33, 0, '2024-08-01', 'Minor University Offenses', 'Entering campus without I.D.', 1, 'Summon to Parents'),
(34, 0, '2024-08-01', 'Minor University Offenses', 'Disturbing peace and order', 1, 'Summon to Parents'),
(37, 0, '2024-08-01', 'Major Academic Offenses', 'Violence in classroom', 1, 'Guidance Intervention'),
(38, 0, '2024-08-01', 'Major Academic Offenses', 'Smoking in classroom', 1, 'Guidance Intervention'),
(39, 0, '2024-08-01', 'Major Academic Offenses', 'Slander/Libel/Gossip - Remarks against faculty', 1, 'Guidance Intervention'),
(40, 0, '2024-08-01', 'Major Academic Offenses', 'Representing university without permission', 1, 'Guidance Intervention'),
(41, 0, '2024-08-01', 'Major Academic Offenses', 'Vandalism - Writing on walls', 1, 'Guidance Intervention'),
(46, 0, '2024-09-03', 'Major University Offenses', 'Mass Action - Leading violent rallies', 1, '12 hrs. Transformative Experience');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `violation_date` date NOT NULL,
  `violation_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `Sanction` int(11) NOT NULL,
  `penalty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`id`, `student_id`, `violation_date`, `violation_type`, `description`, `Sanction`, `penalty`, `created_at`, `updated_at`) VALUES
(44, 24, '2024-10-27', 'Minor University Offenses', 'Falsification of Documents - Entering with fake ID', 3, 'Guidance Intervention', '2024-10-27 05:51:49', '2024-10-27 05:51:49'),
(45, 25, '2024-10-27', 'Major Academic Offenses', 'Vandalism - Destroying property', 1, 'Guidance Intervention', '2024-10-27 06:06:09', '2024-10-27 06:06:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblclass`
--
ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblnotice`
--
ALTER TABLE `tblnotice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpublicnotice`
--
ALTER TABLE `tblpublicnotice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblviolations`
--
ALTER TABLE `tblviolations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblnotice`
--
ALTER TABLE `tblnotice`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpublicnotice`
--
ALTER TABLE `tblpublicnotice`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblviolations`
--
ALTER TABLE `tblviolations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `violations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tblstudent` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
