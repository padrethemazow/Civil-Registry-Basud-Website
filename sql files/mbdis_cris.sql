-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 04:45 PM
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
-- Database: `mbdis_cris`
--

-- --------------------------------------------------------

--
-- Table structure for table `birth`
--

CREATE TABLE `birth` (
  `ID` int(11) NOT NULL,
  `CT` tinyint(4) DEFAULT NULL COMMENT 'Certificate Type: 1 = Marriage, 2 = Birth, 3 = Death',
  `PLACE` int(11) DEFAULT NULL COMMENT 'Place Code (16014 = BASUD) — Refer to Place Code',
  `FOL` varchar(10) DEFAULT NULL COMMENT 'Book Number',
  `PAGE` varchar(10) DEFAULT NULL COMMENT 'Page Number (Of Book Number)',
  `FIRST` varchar(100) DEFAULT NULL COMMENT 'First Name (Child)',
  `MI` char(1) DEFAULT NULL COMMENT 'Middle Initial (Child)',
  `LAST` varchar(100) DEFAULT NULL COMMENT 'Last Name (Child)',
  `MFIRST` varchar(100) DEFAULT NULL COMMENT 'Mother''s First Name',
  `MMI` char(1) DEFAULT NULL COMMENT 'Mother''s Middle Initial',
  `MLAST` varchar(100) DEFAULT NULL COMMENT 'Mother''s Last Name',
  `FFIRST` varchar(100) DEFAULT NULL COMMENT 'Father''s First Name',
  `FMI` char(1) DEFAULT NULL COMMENT 'Father''s Middle Initial',
  `FLAST` varchar(100) DEFAULT NULL COMMENT 'Father''s Last Name',
  `PRN` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `LCR` varchar(50) DEFAULT NULL COMMENT 'LCR No./Registry Number',
  `RSTAT` tinyint(4) DEFAULT NULL COMMENT 'Registration Status: 1 = Timely, 2 = Delayed',
  `SEX` tinyint(4) DEFAULT NULL COMMENT 'Sex: 1 = Male, 2 = Female',
  `DATE` date DEFAULT NULL COMMENT 'Date of Birth (MM/DD/YYYY)',
  `BOC` int(11) DEFAULT NULL COMMENT 'Birth Order',
  `WGT` decimal(5,2) DEFAULT NULL COMMENT 'Weight on Birth (kg)',
  `MNATL` tinyint(4) DEFAULT NULL COMMENT 'Mother''s Nationality: 1 = Filipino',
  `TNC` int(11) DEFAULT NULL COMMENT 'Total No. of Children Born Alive',
  `TNAC` int(11) DEFAULT NULL COMMENT 'No. of Children still living including this birth',
  `TNDC` int(11) DEFAULT NULL COMMENT 'No. of Children born alive but are now dead',
  `MOCCP` varchar(50) DEFAULT NULL COMMENT 'Mother''s Occupation — Refer to Work Code Sheet',
  `MAGE` int(11) DEFAULT NULL COMMENT 'Mother''s Age',
  `RESIDE` varchar(255) DEFAULT NULL COMMENT 'Mother''s Residence',
  `FNATL` tinyint(4) DEFAULT NULL COMMENT 'Father''s Nationality: 1=Filipino, 2=Chinese, 3=American, 4=Spanish, 5=Japanese, 6=Australian, 7=Iranian, 8=German, 9=NOT STATED, 0=OTHERS',
  `FOCCP` varchar(50) DEFAULT NULL COMMENT 'Father''s Occupation — Refer to Work Code Sheet',
  `FAGE` int(11) DEFAULT NULL COMMENT 'Father''s Age',
  `ATTD` varchar(50) DEFAULT NULL COMMENT 'Attendant at Birth',
  `TBIRTH` tinyint(4) DEFAULT NULL COMMENT 'Type of Birth: 1=Single, 2=Twin, 3=Triplet, etc.',
  `MRELI` tinyint(4) DEFAULT NULL COMMENT 'Mother''s Religion: 1=Roman Catholic, 2=Aglipay, 3=Islam, 4=Iglesia Ni Kristo, 5=United Churches of Christ, 6=Buddhist, 7=Latter Day Saints, 8=Jehovah''s Witness, 9=Not Stated, 10=Others',
  `FRELI` tinyint(4) DEFAULT NULL COMMENT 'Father''s Religion: same as MRELI codes',
  `CSTAT` tinyint(4) DEFAULT NULL COMMENT 'Civil Status of Parents: 1=Married, 2=Not Married',
  `IND` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `PLACEMAR` varchar(255) DEFAULT NULL COMMENT 'Place of Marriage of Parents',
  `DATEMAR` date DEFAULT NULL COMMENT 'Date of Marriage of Parents',
  `DREG` date DEFAULT NULL COMMENT 'Date Registered (MM/DD/YYYY)',
  `USER` varchar(100) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `DATEMOD` datetime DEFAULT NULL COMMENT 'Date Modified — Not Displayed/Used',
  `MODE` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `birth`
--

INSERT INTO `birth` (`ID`, `CT`, `PLACE`, `FOL`, `PAGE`, `FIRST`, `MI`, `LAST`, `MFIRST`, `MMI`, `MLAST`, `FFIRST`, `FMI`, `FLAST`, `PRN`, `LCR`, `RSTAT`, `SEX`, `DATE`, `BOC`, `WGT`, `MNATL`, `TNC`, `TNAC`, `TNDC`, `MOCCP`, `MAGE`, `RESIDE`, `FNATL`, `FOCCP`, `FAGE`, `ATTD`, `TBIRTH`, `MRELI`, `FRELI`, `CSTAT`, `IND`, `PLACEMAR`, `DATEMAR`, `DREG`, `USER`, `DATEMOD`, `MODE`) VALUES
(1, 0, 0, '', '', 'Marco', 'C', 'Mazo', 'Elvira', 'C', 'Mazo', 'na', '*', 'na', '', '', 0, 0, '0000-00-00', 0, 0.00, 0, 0, 0, 0, '', 0, '', 0, '', 0, '', 0, 0, 0, 0, '', '', '0000-00-00', '0000-00-00', '', '2025-11-20 20:16:36', '');

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `ID` int(11) NOT NULL,
  `CT` tinyint(4) DEFAULT NULL COMMENT 'Certificate Type: 1 = Marriage, 2 = Birth, 3 = Death',
  `PLACE` int(11) DEFAULT NULL COMMENT 'Place Code (16014 = BASUD) — Refer to Place Code',
  `FOLIO_NO` varchar(10) DEFAULT NULL COMMENT 'Book Number',
  `PAGE_NO` varchar(10) DEFAULT NULL COMMENT 'Page Number (Of Book Number)',
  `FIRST` varchar(100) DEFAULT NULL COMMENT 'First Name of the Deceased',
  `MI` char(1) DEFAULT NULL COMMENT 'Middle Initial of the Deceased',
  `LAST` varchar(100) DEFAULT NULL COMMENT 'Last Name of the Deceased',
  `PRN` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `LCR_NO` varchar(50) DEFAULT NULL COMMENT 'LCR No./Registry Number',
  `REG_STAT` tinyint(4) DEFAULT NULL COMMENT 'Registration Status: 1 = Timely, 2 = Delayed',
  `SEX` tinyint(4) DEFAULT NULL COMMENT 'Sex: 1 = Male, 2 = Female',
  `RELIG` tinyint(4) DEFAULT NULL COMMENT 'Religion: 1=Roman Catholic, 2=Aglipay, 3=Islam, 4=Iglesia Ni Kristo, 5=United Churches of Christ, 6=Buddhist, 7=Latter Day Saints, 8=Jehovah’s Witness, 9=Not Stated, 10=Others',
  `AGE` int(11) DEFAULT NULL COMMENT 'Age at the time of death',
  `DATEX` date DEFAULT NULL COMMENT 'Date of Death (MM/DD/YYYY)',
  `NATLTY` varchar(50) DEFAULT NULL COMMENT 'Nationality',
  `URES` varchar(255) DEFAULT NULL COMMENT 'Usual Residence of the Deceased',
  `CS` tinyint(4) DEFAULT NULL COMMENT 'Civil Status: 1 = Single, 2 = Married, 3 = Widowed',
  `UOCC` varchar(100) DEFAULT NULL COMMENT 'Usual Occupation of Deceased — Refer to Work Code Sheet',
  `CAUSEX` varchar(255) DEFAULT NULL COMMENT 'Cause of Death — Refer to Cause of Death Code Sheet (Not Displayed)',
  `MED_ATT` tinyint(4) DEFAULT NULL COMMENT 'Medical Attendant: 1=Private Physician, 2=Public Health Officer, 3=Hospital Authority, 4=None, 5=Others',
  `MAGE` int(11) DEFAULT NULL COMMENT 'Mother’s Age at the time of death (Used if Fetal Death, Not Displayed)',
  `METHOD` tinyint(4) DEFAULT NULL COMMENT 'Method of Delivery (Used if Fetal Death): 1=Normal, 2=Others',
  `LENGTH` varchar(50) DEFAULT NULL COMMENT 'Length of Pregnancy (Used if Fetal Death, Not Displayed)',
  `TYPE` tinyint(4) DEFAULT NULL COMMENT 'Type of Delivery (Used if Fetal Death): 1=Single, 2=Twin, 3=Triplets, etc.',
  `CAUSE1` varchar(255) DEFAULT NULL COMMENT 'Not Displayed',
  `CAUSE2` varchar(255) DEFAULT NULL COMMENT 'Not Displayed',
  `IND` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `DREG` date DEFAULT NULL COMMENT 'Date Registered (MM/DD/YYYY)',
  `USER` varchar(100) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `DATEMOD` datetime DEFAULT NULL COMMENT 'Date Modified — Not Displayed/Used',
  `MODE` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `death`
--

INSERT INTO `death` (`ID`, `CT`, `PLACE`, `FOLIO_NO`, `PAGE_NO`, `FIRST`, `MI`, `LAST`, `PRN`, `LCR_NO`, `REG_STAT`, `SEX`, `RELIG`, `AGE`, `DATEX`, `NATLTY`, `URES`, `CS`, `UOCC`, `CAUSEX`, `MED_ATT`, `MAGE`, `METHOD`, `LENGTH`, `TYPE`, `CAUSE1`, `CAUSE2`, `IND`, `DREG`, `USER`, `DATEMOD`, `MODE`) VALUES
(1, NULL, NULL, '', '', 'marco', 'c', 'mazo', NULL, '', NULL, 1, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `marriage`
--

CREATE TABLE `marriage` (
  `ID` int(11) NOT NULL,
  `CT` tinyint(4) DEFAULT NULL COMMENT 'Certificate Type: 1 = Marriage, 2 = Birth, 3 = Death',
  `PLACE` int(11) DEFAULT NULL COMMENT 'Place Code (16014 = BASUD) — Refer to Place Code',
  `FOL` varchar(10) DEFAULT NULL COMMENT 'Book Number',
  `PAGE` varchar(10) DEFAULT NULL COMMENT 'Page Number (Of Book Number)',
  `G_FNAME` varchar(100) DEFAULT NULL COMMENT 'Groom First Name',
  `G_MI` char(1) DEFAULT NULL COMMENT 'Groom Middle Initial',
  `G_LNAME` varchar(100) DEFAULT NULL COMMENT 'Groom Last Name',
  `W_FNAME` varchar(100) DEFAULT NULL COMMENT 'Wife First Name',
  `W_MI` char(1) DEFAULT NULL COMMENT 'Wife Middle Initial',
  `W_LNAME` varchar(100) DEFAULT NULL COMMENT 'Wife Last Name',
  `G_FFIRST` varchar(100) DEFAULT NULL COMMENT 'Groom Father First Name',
  `G_FMI` char(1) DEFAULT NULL COMMENT 'Groom Father Middle Initial',
  `G_FLAST` varchar(100) DEFAULT NULL COMMENT 'Groom Father Last Name',
  `W_FFIRST` varchar(100) DEFAULT NULL COMMENT 'Wife Father First Name',
  `W_FMI` char(1) DEFAULT NULL COMMENT 'Wife Father Middle Initial',
  `W_FLAST` varchar(100) DEFAULT NULL COMMENT 'Wife Father Last Name',
  `G_MFIRST` varchar(100) DEFAULT NULL COMMENT 'Groom Mother First Name',
  `G_MMI` char(1) DEFAULT NULL COMMENT 'Groom Mother Middle Initial',
  `G_MLAST` varchar(100) DEFAULT NULL COMMENT 'Groom Mother Last Name',
  `W_MFIRST` varchar(100) DEFAULT NULL COMMENT 'Wife Mother First Name',
  `W_MMI` char(1) DEFAULT NULL COMMENT 'Wife Mother Middle Initial',
  `W_MLAST` varchar(100) DEFAULT NULL COMMENT 'Wife Mother Last Name',
  `G_PRN` varchar(50) DEFAULT NULL COMMENT 'Groom PRN — Not Displayed',
  `W_PRN` varchar(50) DEFAULT NULL COMMENT 'Wife PRN — Not Displayed',
  `LCR` varchar(50) DEFAULT NULL COMMENT 'Registry Number',
  `REGST` tinyint(4) DEFAULT NULL COMMENT 'Registration Status: 1=On Time, 2=Delayed',
  `G_AGE` int(11) DEFAULT NULL COMMENT 'Groom Age',
  `W_AGE` int(11) DEFAULT NULL COMMENT 'Wife Age',
  `G_CITI` varchar(50) DEFAULT NULL COMMENT 'Groom Citizenship',
  `W_CITI` varchar(50) DEFAULT NULL COMMENT 'Wife Citizenship',
  `G_RESI` varchar(255) DEFAULT NULL COMMENT 'Groom Residence',
  `W_RESI` varchar(255) DEFAULT NULL COMMENT 'Wife Residence',
  `G_RELI` tinyint(4) DEFAULT NULL COMMENT 'Groom Religion',
  `W_RELI` tinyint(4) DEFAULT NULL COMMENT 'Wife Religion',
  `G_STATUS` varchar(50) DEFAULT NULL COMMENT 'Groom Civil Status before Marriage',
  `W_STATUS` varchar(50) DEFAULT NULL COMMENT 'Wife Civil Status before Marriage',
  `DATE` date DEFAULT NULL COMMENT 'Date of Marriage (MM/DD/YYYY)',
  `CEREMONY` varchar(255) DEFAULT NULL COMMENT 'Place of Marriage',
  `IND` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `DREG` date DEFAULT NULL COMMENT 'Date Registered (MM/DD/YYYY)',
  `USER` varchar(100) DEFAULT NULL COMMENT 'Not Displayed/Used',
  `DATEMOD` datetime DEFAULT NULL COMMENT 'Date Modified — Not Displayed/Used',
  `MODE` varchar(50) DEFAULT NULL COMMENT 'Not Displayed/Used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marriage`
--

INSERT INTO `marriage` (`ID`, `CT`, `PLACE`, `FOL`, `PAGE`, `G_FNAME`, `G_MI`, `G_LNAME`, `W_FNAME`, `W_MI`, `W_LNAME`, `G_FFIRST`, `G_FMI`, `G_FLAST`, `W_FFIRST`, `W_FMI`, `W_FLAST`, `G_MFIRST`, `G_MMI`, `G_MLAST`, `W_MFIRST`, `W_MMI`, `W_MLAST`, `G_PRN`, `W_PRN`, `LCR`, `REGST`, `G_AGE`, `W_AGE`, `G_CITI`, `W_CITI`, `G_RESI`, `W_RESI`, `G_RELI`, `W_RELI`, `G_STATUS`, `W_STATUS`, `DATE`, `CEREMONY`, `IND`, `DREG`, `USER`, `DATEMOD`, `MODE`) VALUES
(1, NULL, 0, NULL, NULL, 'Papamo', 'c', 'Mazo', 'Mamamo', 'C', 'Mazo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-21 19:59:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `birth`
--
ALTER TABLE `birth`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `marriage`
--
ALTER TABLE `marriage`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `birth`
--
ALTER TABLE `birth`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marriage`
--
ALTER TABLE `marriage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
