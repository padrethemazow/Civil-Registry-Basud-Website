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
-- Database: `mbdis_phcris`
--

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `ID` int(11) NOT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `ProvinceId` int(11) DEFAULT NULL,
  `MunicipalityId` int(11) DEFAULT NULL,
  `BookNum` varchar(20) DEFAULT NULL,
  `PageNum` varchar(20) DEFAULT NULL,
  `RegistryNum` varchar(50) DEFAULT NULL,
  `DocumentTimeCreated` datetime DEFAULT NULL,
  `DocumentTimeUpdated` datetime DEFAULT NULL,
  `DocumentTimeTransmitted` datetime DEFAULT NULL,
  `DocumentWasPrinted` datetime DEFAULT NULL,
  `DocumentStatus` varchar(50) DEFAULT NULL,
  `DocumentLocation` text DEFAULT NULL,
  `DocumentEncodedBy` varchar(100) DEFAULT NULL,
  `DocumentUpdatedIn` varchar(100) DEFAULT NULL,
  `DocumentUpdatedBy` varchar(100) DEFAULT NULL,
  `DocumentPsocVersion` varchar(50) DEFAULT NULL,
  `DocumentPsgcVersion` varchar(50) DEFAULT NULL,
  `DocumentCoding` text DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Province` varchar(100) DEFAULT NULL,
  `Municipality` varchar(100) DEFAULT NULL,
  `CFirstName` varchar(100) DEFAULT NULL,
  `CMiddleName` varchar(100) DEFAULT NULL,
  `CLastName` varchar(100) DEFAULT NULL,
  `CSexId` int(11) DEFAULT NULL,
  `CDeathDate` date DEFAULT NULL,
  `CBirthDate` date DEFAULT NULL,
  `CAge` int(11) DEFAULT NULL,
  `CAgeYears` int(11) DEFAULT NULL,
  `CAgeDays` int(11) DEFAULT NULL,
  `CAgeHours` int(11) DEFAULT NULL,
  `CAgeMinutes` int(11) DEFAULT NULL,
  `CDeathAddress` text DEFAULT NULL,
  `CDeathBarangay` varchar(100) DEFAULT NULL,
  `CDeathMunicipality` varchar(100) DEFAULT NULL,
  `CDeathProvince` varchar(100) DEFAULT NULL,
  `CDeathCountry` varchar(100) DEFAULT NULL,
  `CCivilStatusId` int(11) DEFAULT NULL,
  `CReligionId` int(11) DEFAULT NULL,
  `CCitizenshipId` int(11) DEFAULT NULL,
  `CResidenceAddress` text DEFAULT NULL,
  `CResidenceBarangay` varchar(100) DEFAULT NULL,
  `CResidenceMunicipality` varchar(100) DEFAULT NULL,
  `CResidenceProvince` varchar(100) DEFAULT NULL,
  `CResidenceCountry` varchar(100) DEFAULT NULL,
  `COccupationId` int(11) DEFAULT NULL,
  `FFirstName` varchar(100) DEFAULT NULL,
  `FMiddleName` varchar(100) DEFAULT NULL,
  `FLastName` varchar(100) DEFAULT NULL,
  `MFirstName` varchar(100) DEFAULT NULL,
  `MMiddleName` varchar(100) DEFAULT NULL,
  `MLastName` varchar(100) DEFAULT NULL,
  `CCauseImmediate` text DEFAULT NULL,
  `CCauseAntecedent` text DEFAULT NULL,
  `CCauseUnderlying` text DEFAULT NULL,
  `CCauseOther` text DEFAULT NULL,
  `CExternalCauseManner` text DEFAULT NULL,
  `CExternalCausePlace` text DEFAULT NULL,
  `CAutopsyId` int(11) DEFAULT NULL,
  `AttendantId` int(11) DEFAULT NULL,
  `AttendantDescription` text DEFAULT NULL,
  `AttendantAttendedFrom` date DEFAULT NULL,
  `AttendantAttendedTo` date DEFAULT NULL,
  `CDeathTime` time DEFAULT NULL,
  `AttendantName` varchar(150) DEFAULT NULL,
  `AttendantTitle` varchar(100) DEFAULT NULL,
  `AttendantAddress` text DEFAULT NULL,
  `AttendantDate` date DEFAULT NULL,
  `ReviewerName` varchar(150) DEFAULT NULL,
  `ReviewerDate` date DEFAULT NULL,
  `CCorpseDisposalId` int(11) DEFAULT NULL,
  `CBurialPermitNumber` varchar(100) DEFAULT NULL,
  `CBurialPermitDateIssued` date DEFAULT NULL,
  `CTransferPermitNumber` varchar(100) DEFAULT NULL,
  `CTransferPermitDateIssued` date DEFAULT NULL,
  `CCemeteryName` varchar(200) DEFAULT NULL,
  `CCemeteryAddress` text DEFAULT NULL,
  `InformantName` varchar(150) DEFAULT NULL,
  `InformantTitle` varchar(100) DEFAULT NULL,
  `InformantAddress` text DEFAULT NULL,
  `InformantDate` date DEFAULT NULL,
  `PreparerName` varchar(150) DEFAULT NULL,
  `PreparerTitle` varchar(100) DEFAULT NULL,
  `PreparerDate` date DEFAULT NULL,
  `ReceiverName` varchar(150) DEFAULT NULL,
  `ReceiverTitle` varchar(100) DEFAULT NULL,
  `DateReceived` date DEFAULT NULL,
  `RegistrarName` varchar(150) DEFAULT NULL,
  `RegistrarTitle` varchar(100) DEFAULT NULL,
  `DateRegistered` date DEFAULT NULL,
  `Remark1` text DEFAULT NULL,
  `Remark2` text DEFAULT NULL,
  `Remark3` text DEFAULT NULL,
  `Remark4` text DEFAULT NULL,
  `Remark5` text DEFAULT NULL,
  `Remark6` text DEFAULT NULL,
  `IMotherAge` int(11) DEFAULT NULL,
  `IDeliveryMethodId` int(11) DEFAULT NULL,
  `IPregnancyLength` int(11) DEFAULT NULL,
  `IBirthTypeId` int(11) DEFAULT NULL,
  `IChildWasId` int(11) DEFAULT NULL,
  `PostmortemName` varchar(150) DEFAULT NULL,
  `PostmortemDate` date DEFAULT NULL,
  `PostmortemTitle` varchar(100) DEFAULT NULL,
  `PostmortemAddress` text DEFAULT NULL,
  `EmbalmerName` varchar(150) DEFAULT NULL,
  `EmbalmerAddress` text DEFAULT NULL,
  `EmbalmerLicenseNumber` varchar(100) DEFAULT NULL,
  `EmbalmerLicenseDate` date DEFAULT NULL,
  `EmbalmerLicensePlace` varchar(100) DEFAULT NULL,
  `EmbalmerLicenseExpiryDate` date DEFAULT NULL,
  `ZAffiantName` varchar(150) DEFAULT NULL,
  `ZAffiantAddress` text DEFAULT NULL,
  `ZCName` varchar(150) DEFAULT NULL,
  `ZCDeathDate` date DEFAULT NULL,
  `ZCDeathPlace` text DEFAULT NULL,
  `ZCCemeteryAddress` text DEFAULT NULL,
  `ZCBurialDate` date DEFAULT NULL,
  `ZCAttendantName` varchar(150) DEFAULT NULL,
  `ZCCauseImmediate` text DEFAULT NULL,
  `ZDelayReason` text DEFAULT NULL,
  `ZAffiantDate` date DEFAULT NULL,
  `ZAffiantPlace` text DEFAULT NULL,
  `ZAffiantPrintedName` varchar(150) DEFAULT NULL,
  `ZSDate` date DEFAULT NULL,
  `ZSPlace` text DEFAULT NULL,
  `ZSCtcNum` varchar(100) DEFAULT NULL,
  `ZSCtcDate` date DEFAULT NULL,
  `ZSCtcPlace` text DEFAULT NULL,
  `ZSName` varchar(150) DEFAULT NULL,
  `ZSTitle` varchar(100) DEFAULT NULL,
  `ZSAddress` text DEFAULT NULL,
  `CTraditionalName` varchar(150) DEFAULT NULL,
  `COtherName` varchar(150) DEFAULT NULL,
  `CSpouse1` varchar(150) DEFAULT NULL,
  `CSpouse2` varchar(150) DEFAULT NULL,
  `CSpouse3` varchar(150) DEFAULT NULL,
  `CSpouse4` varchar(150) DEFAULT NULL,
  `CEthnicity` varchar(100) DEFAULT NULL,
  `BurialRitesName` varchar(150) DEFAULT NULL,
  `BurialRitesTitle` varchar(100) DEFAULT NULL,
  `BurialRitesAddress` text DEFAULT NULL,
  `BurialRitesDate` date DEFAULT NULL,
  `ImageFilePage1` text DEFAULT NULL,
  `ImageFilePage2` text DEFAULT NULL,
  `ImageFileAttachment1` text DEFAULT NULL,
  `ImageFileAttachment2` text DEFAULT NULL,
  `ImagePage1` text DEFAULT NULL,
  `ImagePage2` text DEFAULT NULL,
  `ImageAttachment1` text DEFAULT NULL,
  `ImageAttachment2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `death`
--

INSERT INTO `death` (`ID`, `CountryId`, `ProvinceId`, `MunicipalityId`, `BookNum`, `PageNum`, `RegistryNum`, `DocumentTimeCreated`, `DocumentTimeUpdated`, `DocumentTimeTransmitted`, `DocumentWasPrinted`, `DocumentStatus`, `DocumentLocation`, `DocumentEncodedBy`, `DocumentUpdatedIn`, `DocumentUpdatedBy`, `DocumentPsocVersion`, `DocumentPsgcVersion`, `DocumentCoding`, `Country`, `Province`, `Municipality`, `CFirstName`, `CMiddleName`, `CLastName`, `CSexId`, `CDeathDate`, `CBirthDate`, `CAge`, `CAgeYears`, `CAgeDays`, `CAgeHours`, `CAgeMinutes`, `CDeathAddress`, `CDeathBarangay`, `CDeathMunicipality`, `CDeathProvince`, `CDeathCountry`, `CCivilStatusId`, `CReligionId`, `CCitizenshipId`, `CResidenceAddress`, `CResidenceBarangay`, `CResidenceMunicipality`, `CResidenceProvince`, `CResidenceCountry`, `COccupationId`, `FFirstName`, `FMiddleName`, `FLastName`, `MFirstName`, `MMiddleName`, `MLastName`, `CCauseImmediate`, `CCauseAntecedent`, `CCauseUnderlying`, `CCauseOther`, `CExternalCauseManner`, `CExternalCausePlace`, `CAutopsyId`, `AttendantId`, `AttendantDescription`, `AttendantAttendedFrom`, `AttendantAttendedTo`, `CDeathTime`, `AttendantName`, `AttendantTitle`, `AttendantAddress`, `AttendantDate`, `ReviewerName`, `ReviewerDate`, `CCorpseDisposalId`, `CBurialPermitNumber`, `CBurialPermitDateIssued`, `CTransferPermitNumber`, `CTransferPermitDateIssued`, `CCemeteryName`, `CCemeteryAddress`, `InformantName`, `InformantTitle`, `InformantAddress`, `InformantDate`, `PreparerName`, `PreparerTitle`, `PreparerDate`, `ReceiverName`, `ReceiverTitle`, `DateReceived`, `RegistrarName`, `RegistrarTitle`, `DateRegistered`, `Remark1`, `Remark2`, `Remark3`, `Remark4`, `Remark5`, `Remark6`, `IMotherAge`, `IDeliveryMethodId`, `IPregnancyLength`, `IBirthTypeId`, `IChildWasId`, `PostmortemName`, `PostmortemDate`, `PostmortemTitle`, `PostmortemAddress`, `EmbalmerName`, `EmbalmerAddress`, `EmbalmerLicenseNumber`, `EmbalmerLicenseDate`, `EmbalmerLicensePlace`, `EmbalmerLicenseExpiryDate`, `ZAffiantName`, `ZAffiantAddress`, `ZCName`, `ZCDeathDate`, `ZCDeathPlace`, `ZCCemeteryAddress`, `ZCBurialDate`, `ZCAttendantName`, `ZCCauseImmediate`, `ZDelayReason`, `ZAffiantDate`, `ZAffiantPlace`, `ZAffiantPrintedName`, `ZSDate`, `ZSPlace`, `ZSCtcNum`, `ZSCtcDate`, `ZSCtcPlace`, `ZSName`, `ZSTitle`, `ZSAddress`, `CTraditionalName`, `COtherName`, `CSpouse1`, `CSpouse2`, `CSpouse3`, `CSpouse4`, `CEthnicity`, `BurialRitesName`, `BurialRitesTitle`, `BurialRitesAddress`, `BurialRitesDate`, `ImageFilePage1`, `ImageFilePage2`, `ImageFileAttachment1`, `ImageFileAttachment2`, `ImagePage1`, `ImagePage2`, `ImageAttachment1`, `ImageAttachment2`) VALUES
(1, 0, 0, 0, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', 'deadsba', 'n', 'mazo', 1, '0000-00-00', '0000-00-00', 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '00:00:00', '', '', '', '0000-00-00', '', '0000-00-00', 0, '', '0000-00-00', '', '0000-00-00', '', '', '', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '0000-00-00', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `phbirth`
--

CREATE TABLE `phbirth` (
  `ID` int(11) NOT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `ProvinceId` int(11) DEFAULT NULL,
  `MunicipalityId` int(11) DEFAULT NULL,
  `BookNum` varchar(50) DEFAULT NULL,
  `PageNum` varchar(50) DEFAULT NULL,
  `RegistryNum` varchar(100) DEFAULT NULL,
  `DocumentTimeCreated` datetime DEFAULT NULL,
  `DocumentTimeUpdated` datetime DEFAULT NULL,
  `DocumentTimeTransmitted` datetime DEFAULT NULL,
  `DocumentWasPrinted` datetime DEFAULT NULL,
  `DocumentStatus` varchar(20) DEFAULT NULL,
  `DocumentLocation` text DEFAULT NULL,
  `DocumentEncodedIn` varchar(100) DEFAULT NULL,
  `DocumentEncodedBy` varchar(100) DEFAULT NULL,
  `DocumentUpdatedIn` varchar(100) DEFAULT NULL,
  `DocumentUpdatedBy` varchar(100) DEFAULT NULL,
  `DocumentPsocVersion` varchar(50) DEFAULT NULL,
  `DocumentPsgcVersion` varchar(50) DEFAULT NULL,
  `DocumentCoding` text DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Province` varchar(100) DEFAULT NULL,
  `Municipality` varchar(100) DEFAULT NULL,
  `BReN` varchar(100) DEFAULT NULL,
  `CFirstName` varchar(100) DEFAULT NULL,
  `CMiddleName` varchar(100) DEFAULT NULL,
  `CLastName` varchar(100) DEFAULT NULL,
  `CSex` varchar(10) DEFAULT NULL,
  `CSexId` int(11) DEFAULT NULL,
  `CBirthDate` date DEFAULT NULL,
  `CBirthAddress` text DEFAULT NULL,
  `CBirthBarangay` varchar(150) DEFAULT NULL,
  `CBirthBarangayId` int(11) DEFAULT NULL,
  `CBirthMunicipality` varchar(150) DEFAULT NULL,
  `CBirthMunicipalityId` int(11) DEFAULT NULL,
  `CBirthProvince` varchar(150) DEFAULT NULL,
  `CBirthProvinceId` int(11) DEFAULT NULL,
  `CBirthCountry` varchar(150) DEFAULT NULL,
  `CBirthCountryId` int(11) DEFAULT NULL,
  `CBirthType` varchar(50) DEFAULT NULL,
  `CBirthTypeId` int(11) DEFAULT NULL,
  `CChildWas` varchar(50) DEFAULT NULL,
  `CChildWasId` int(11) DEFAULT NULL,
  `CBirthOrder` varchar(50) DEFAULT NULL,
  `CBirthOrderId` int(11) DEFAULT NULL,
  `CWeight` decimal(5,2) DEFAULT NULL,
  `MFirstName` varchar(100) DEFAULT NULL,
  `MMiddleName` varchar(100) DEFAULT NULL,
  `MLastName` varchar(100) DEFAULT NULL,
  `MCitizenship` varchar(100) DEFAULT NULL,
  `MCitizenshipId` int(11) DEFAULT NULL,
  `MReligion` varchar(100) DEFAULT NULL,
  `MReligionId` int(11) DEFAULT NULL,
  `MBornAlive` int(11) DEFAULT NULL,
  `MStillLiving` int(11) DEFAULT NULL,
  `MNowDead` int(11) DEFAULT NULL,
  `MOccupation` varchar(100) DEFAULT NULL,
  `MOccupationId` int(11) DEFAULT NULL,
  `MOccupationIdCris2` int(11) DEFAULT NULL,
  `MAge` int(11) DEFAULT NULL,
  `MAddress` text DEFAULT NULL,
  `MBarangay` varchar(150) DEFAULT NULL,
  `MBarangayId` int(11) DEFAULT NULL,
  `MMunicipality` varchar(150) DEFAULT NULL,
  `MMunicipalityId` int(11) DEFAULT NULL,
  `MProvince` varchar(150) DEFAULT NULL,
  `MProvinceId` int(11) DEFAULT NULL,
  `MCountry` varchar(150) DEFAULT NULL,
  `MCountryId` int(11) DEFAULT NULL,
  `FFirstName` varchar(100) DEFAULT NULL,
  `FMiddleName` varchar(100) DEFAULT NULL,
  `FLastName` varchar(100) DEFAULT NULL,
  `FCitizenship` varchar(100) DEFAULT NULL,
  `FCitizenshipId` int(11) DEFAULT NULL,
  `FReligion` varchar(100) DEFAULT NULL,
  `FReligionId` int(11) DEFAULT NULL,
  `FOccupation` varchar(100) DEFAULT NULL,
  `FOccupationId` int(11) DEFAULT NULL,
  `FOccupationIdCris2` int(11) DEFAULT NULL,
  `FAge` int(11) DEFAULT NULL,
  `FAddress` text DEFAULT NULL,
  `FBarangay` varchar(150) DEFAULT NULL,
  `FBarangayId` int(11) DEFAULT NULL,
  `FMunicipality` varchar(150) DEFAULT NULL,
  `FMunicipalityId` int(11) DEFAULT NULL,
  `FProvince` varchar(150) DEFAULT NULL,
  `FProvinceId` int(11) DEFAULT NULL,
  `FCountry` varchar(150) DEFAULT NULL,
  `FCountryId` int(11) DEFAULT NULL,
  `MarriageDate` date DEFAULT NULL,
  `MarriageMunicipality` varchar(150) DEFAULT NULL,
  `MarriageMunicipalityId` int(11) DEFAULT NULL,
  `MarriageProvince` varchar(150) DEFAULT NULL,
  `MarriageProvinceId` int(11) DEFAULT NULL,
  `MarriageCountry` varchar(150) DEFAULT NULL,
  `MarriageCountryId` int(11) DEFAULT NULL,
  `AttendantId` int(11) DEFAULT NULL,
  `AttendantDescription` varchar(200) DEFAULT NULL,
  `CBirthTime` varchar(20) DEFAULT NULL,
  `AttendantStatus` varchar(50) DEFAULT NULL,
  `AttendantName` varchar(150) DEFAULT NULL,
  `AttendantTitle` varchar(100) DEFAULT NULL,
  `AttendantAddress` text DEFAULT NULL,
  `AttendantDate` date DEFAULT NULL,
  `InformantName` varchar(150) DEFAULT NULL,
  `InformantTitle` varchar(100) DEFAULT NULL,
  `InformantAddress` text DEFAULT NULL,
  `InformantDate` date DEFAULT NULL,
  `PreparerName` varchar(150) DEFAULT NULL,
  `PreparerTitle` varchar(100) DEFAULT NULL,
  `PreparerDate` date DEFAULT NULL,
  `ReceiverName` varchar(150) DEFAULT NULL,
  `ReceiverTitle` varchar(100) DEFAULT NULL,
  `DateReceived` date DEFAULT NULL,
  `RegistrarName` varchar(150) DEFAULT NULL,
  `RegistrarTitle` varchar(100) DEFAULT NULL,
  `DateRegistered` date DEFAULT NULL,
  `Remark1` text DEFAULT NULL,
  `Remark2` text DEFAULT NULL,
  `Remark3` text DEFAULT NULL,
  `Remark4` text DEFAULT NULL,
  `Remark5` text DEFAULT NULL,
  `Remark6` text DEFAULT NULL,
  `FEthnicity` varchar(100) DEFAULT NULL,
  `FEthnicityId` int(11) DEFAULT NULL,
  `FEthnicityIdCris2` int(11) DEFAULT NULL,
  `MEthnicity` varchar(100) DEFAULT NULL,
  `MEthnicityId` int(11) DEFAULT NULL,
  `MEthnicityIdCris2` int(11) DEFAULT NULL,
  `CStatus` varchar(10) DEFAULT NULL,
  `ImageFilePage1` text DEFAULT NULL,
  `ImageFilePage2` text DEFAULT NULL,
  `ImageFileAttachment1` text DEFAULT NULL,
  `ImageFileAttachment2` text DEFAULT NULL,
  `ImagePage1` text DEFAULT NULL,
  `ImagePage2` text DEFAULT NULL,
  `ImageAttachment1` text DEFAULT NULL,
  `ImageAttachment2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `phbirth`
--

INSERT INTO `phbirth` (`ID`, `CountryId`, `ProvinceId`, `MunicipalityId`, `BookNum`, `PageNum`, `RegistryNum`, `DocumentTimeCreated`, `DocumentTimeUpdated`, `DocumentTimeTransmitted`, `DocumentWasPrinted`, `DocumentStatus`, `DocumentLocation`, `DocumentEncodedIn`, `DocumentEncodedBy`, `DocumentUpdatedIn`, `DocumentUpdatedBy`, `DocumentPsocVersion`, `DocumentPsgcVersion`, `DocumentCoding`, `Country`, `Province`, `Municipality`, `BReN`, `CFirstName`, `CMiddleName`, `CLastName`, `CSex`, `CSexId`, `CBirthDate`, `CBirthAddress`, `CBirthBarangay`, `CBirthBarangayId`, `CBirthMunicipality`, `CBirthMunicipalityId`, `CBirthProvince`, `CBirthProvinceId`, `CBirthCountry`, `CBirthCountryId`, `CBirthType`, `CBirthTypeId`, `CChildWas`, `CChildWasId`, `CBirthOrder`, `CBirthOrderId`, `CWeight`, `MFirstName`, `MMiddleName`, `MLastName`, `MCitizenship`, `MCitizenshipId`, `MReligion`, `MReligionId`, `MBornAlive`, `MStillLiving`, `MNowDead`, `MOccupation`, `MOccupationId`, `MOccupationIdCris2`, `MAge`, `MAddress`, `MBarangay`, `MBarangayId`, `MMunicipality`, `MMunicipalityId`, `MProvince`, `MProvinceId`, `MCountry`, `MCountryId`, `FFirstName`, `FMiddleName`, `FLastName`, `FCitizenship`, `FCitizenshipId`, `FReligion`, `FReligionId`, `FOccupation`, `FOccupationId`, `FOccupationIdCris2`, `FAge`, `FAddress`, `FBarangay`, `FBarangayId`, `FMunicipality`, `FMunicipalityId`, `FProvince`, `FProvinceId`, `FCountry`, `FCountryId`, `MarriageDate`, `MarriageMunicipality`, `MarriageMunicipalityId`, `MarriageProvince`, `MarriageProvinceId`, `MarriageCountry`, `MarriageCountryId`, `AttendantId`, `AttendantDescription`, `CBirthTime`, `AttendantStatus`, `AttendantName`, `AttendantTitle`, `AttendantAddress`, `AttendantDate`, `InformantName`, `InformantTitle`, `InformantAddress`, `InformantDate`, `PreparerName`, `PreparerTitle`, `PreparerDate`, `ReceiverName`, `ReceiverTitle`, `DateReceived`, `RegistrarName`, `RegistrarTitle`, `DateRegistered`, `Remark1`, `Remark2`, `Remark3`, `Remark4`, `Remark5`, `Remark6`, `FEthnicity`, `FEthnicityId`, `FEthnicityIdCris2`, `MEthnicity`, `MEthnicityId`, `MEthnicityIdCris2`, `CStatus`, `ImageFilePage1`, `ImageFilePage2`, `ImageFileAttachment1`, `ImageFileAttachment2`, `ImagePage1`, `ImagePage2`, `ImageAttachment1`, `ImageAttachment2`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Carmilla baby baby', '', 'Mazo', 'Female', 0, '0000-00-00', 'Paracale', '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, 0.00, '', '', '', '', 0, '', 0, 0, 0, 0, '', 0, 0, 0, '', '', 0, '', 0, '', 0, '', 0, '', '', '', '', 0, '', 0, '', 0, 0, 0, '', '', 0, '', 0, '', 0, '', 0, '0000-00-00', '', 0, '', 0, '', 0, 0, '', '', '', '', '', '', '0000-00-00', '', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', 0, 0, '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `phmarriage`
--

CREATE TABLE `phmarriage` (
  `ID` int(11) NOT NULL,
  `PlaceOfMarriage` text DEFAULT NULL,
  `DateOfMarriage` date DEFAULT NULL,
  `TimeOfMarriage` time DEFAULT NULL,
  `HusbandName` varchar(150) DEFAULT NULL,
  `WifeName` varchar(150) DEFAULT NULL,
  `HasMarriageSettlement` tinyint(1) DEFAULT NULL,
  `MarriageSettlementDate` date DEFAULT NULL,
  `WithMarriageLicense` tinyint(1) DEFAULT NULL,
  `MarriageLicenseNumber` varchar(100) DEFAULT NULL,
  `MarriageLicenseDateIssued` date DEFAULT NULL,
  `MarriageLicensePlaceIssued` text DEFAULT NULL,
  `ExecutiveOrderNo209` tinyint(1) DEFAULT NULL,
  `HasEO209` tinyint(1) DEFAULT NULL,
  `PresidentialDecree1083` tinyint(1) DEFAULT NULL,
  `SolemnizingOfficerName` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerTitle` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerAddress` text DEFAULT NULL,
  `SolemnizingOfficerReligiousSect` tinyint(1) DEFAULT NULL,
  `RegistryNumber` varchar(100) DEFAULT NULL,
  `ExpirationDate` date DEFAULT NULL,
  `HasWitness` tinyint(1) DEFAULT NULL,
  `ReceiverName` varchar(150) DEFAULT NULL,
  `ReceiverTitle` varchar(100) DEFAULT NULL,
  `DateReceived` date DEFAULT NULL,
  `RegistrarName` varchar(150) DEFAULT NULL,
  `RegistrarTitle` varchar(100) DEFAULT NULL,
  `DateRegistered` date DEFAULT NULL,
  `DelayedOrCorrected` text DEFAULT NULL,
  `Witness1Name` varchar(150) DEFAULT NULL,
  `Witness2Name` varchar(150) DEFAULT NULL,
  `Witness3Name` varchar(150) DEFAULT NULL,
  `Witness4Name` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerReligiousSectName` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerReligiousSectAddress` text DEFAULT NULL,
  `CHusbandName` varchar(150) DEFAULT NULL,
  `CWifeName` varchar(150) DEFAULT NULL,
  `SectionD` text DEFAULT NULL,
  `SectionE` text DEFAULT NULL,
  `CeremonyDate` date DEFAULT NULL,
  `CeremonyPlace` text DEFAULT NULL,
  `SignatureOfSolemnizingOfficer` text DEFAULT NULL,
  `PrintedNameOfSolemnizingOfficer` varchar(150) DEFAULT NULL,
  `DateSigned1` date DEFAULT NULL,
  `DateSigned2` date DEFAULT NULL,
  `LocationSigned` text DEFAULT NULL,
  `CommunityTaxCert` varchar(100) DEFAULT NULL,
  `CommunityTaxCertDate` date DEFAULT NULL,
  `CommunityTaxCertPlace` text DEFAULT NULL,
  `AdminOfficerSignature` text DEFAULT NULL,
  `AdminOfficerName` varchar(150) DEFAULT NULL,
  `AdminOfficerTitle` varchar(150) DEFAULT NULL,
  `AdminOfficerAddress` text DEFAULT NULL,
  `AffiantName` varchar(150) DEFAULT NULL,
  `AffiantSingle` tinyint(1) DEFAULT NULL,
  `AffiantMarried` tinyint(1) DEFAULT NULL,
  `AffiantDivorced` tinyint(1) DEFAULT NULL,
  `AffiantWidowed` tinyint(1) DEFAULT NULL,
  `AffiantWidower` tinyint(1) DEFAULT NULL,
  `AffiantAddress` text DEFAULT NULL,
  `IfMy` text DEFAULT NULL,
  `HasSpouse` tinyint(1) DEFAULT NULL,
  `MarriagePlace` text DEFAULT NULL,
  `MarriageDate` date DEFAULT NULL,
  `MarriageOf` text DEFAULT NULL,
  `MarriageHusbandName` varchar(150) DEFAULT NULL,
  `MarriageWifeName` varchar(150) DEFAULT NULL,
  `MarriagePlaceRepeat` text DEFAULT NULL,
  `MarriageDateRepeat` date DEFAULT NULL,
  `MarriageSolemnizingOfficerName` varchar(150) DEFAULT NULL,
  `ReligiousCeremony` tinyint(1) DEFAULT NULL,
  `CivilCeremony` tinyint(1) DEFAULT NULL,
  `MuslimRites` tinyint(1) DEFAULT NULL,
  `TribalRites` tinyint(1) DEFAULT NULL,
  `MarriageLicenseMarker` text DEFAULT NULL,
  `MarriageLicenseNumberRepeat` varchar(100) DEFAULT NULL,
  `MarriageLicenseDateIssuedRepeat` date DEFAULT NULL,
  `MarriageLicensePlaceIssuedRepeat` text DEFAULT NULL,
  `IsExecutiveOrder209` tinyint(1) DEFAULT NULL,
  `ArticleNumber` varchar(50) DEFAULT NULL,
  `AffiantCountry` varchar(100) DEFAULT NULL,
  `SpouseCountry` varchar(100) DEFAULT NULL,
  `WifeCountry` varchar(100) DEFAULT NULL,
  `HusbandCountry` varchar(100) DEFAULT NULL,
  `ReasonForDelayedRegistration` text DEFAULT NULL,
  `AffiantSignedDate` date DEFAULT NULL,
  `AffiantSignedPlace` text DEFAULT NULL,
  `AffiantPrintedName` varchar(150) DEFAULT NULL,
  `DateSubscribed` date DEFAULT NULL,
  `PlaceSubscribed` text DEFAULT NULL,
  `CTCNumber` varchar(100) DEFAULT NULL,
  `CTCDateIssued` date DEFAULT NULL,
  `CTCPlaceIssued` text DEFAULT NULL,
  `SolemnizingOfficerNameRepeat` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerTitleRepeat` varchar(150) DEFAULT NULL,
  `SolemnizingOfficerAddressRepeat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phmarriage`
--

INSERT INTO `phmarriage` (`ID`, `PlaceOfMarriage`, `DateOfMarriage`, `TimeOfMarriage`, `HusbandName`, `WifeName`, `HasMarriageSettlement`, `MarriageSettlementDate`, `WithMarriageLicense`, `MarriageLicenseNumber`, `MarriageLicenseDateIssued`, `MarriageLicensePlaceIssued`, `ExecutiveOrderNo209`, `HasEO209`, `PresidentialDecree1083`, `SolemnizingOfficerName`, `SolemnizingOfficerTitle`, `SolemnizingOfficerAddress`, `SolemnizingOfficerReligiousSect`, `RegistryNumber`, `ExpirationDate`, `HasWitness`, `ReceiverName`, `ReceiverTitle`, `DateReceived`, `RegistrarName`, `RegistrarTitle`, `DateRegistered`, `DelayedOrCorrected`, `Witness1Name`, `Witness2Name`, `Witness3Name`, `Witness4Name`, `SolemnizingOfficerReligiousSectName`, `SolemnizingOfficerReligiousSectAddress`, `CHusbandName`, `CWifeName`, `SectionD`, `SectionE`, `CeremonyDate`, `CeremonyPlace`, `SignatureOfSolemnizingOfficer`, `PrintedNameOfSolemnizingOfficer`, `DateSigned1`, `DateSigned2`, `LocationSigned`, `CommunityTaxCert`, `CommunityTaxCertDate`, `CommunityTaxCertPlace`, `AdminOfficerSignature`, `AdminOfficerName`, `AdminOfficerTitle`, `AdminOfficerAddress`, `AffiantName`, `AffiantSingle`, `AffiantMarried`, `AffiantDivorced`, `AffiantWidowed`, `AffiantWidower`, `AffiantAddress`, `IfMy`, `HasSpouse`, `MarriagePlace`, `MarriageDate`, `MarriageOf`, `MarriageHusbandName`, `MarriageWifeName`, `MarriagePlaceRepeat`, `MarriageDateRepeat`, `MarriageSolemnizingOfficerName`, `ReligiousCeremony`, `CivilCeremony`, `MuslimRites`, `TribalRites`, `MarriageLicenseMarker`, `MarriageLicenseNumberRepeat`, `MarriageLicenseDateIssuedRepeat`, `MarriageLicensePlaceIssuedRepeat`, `IsExecutiveOrder209`, `ArticleNumber`, `AffiantCountry`, `SpouseCountry`, `WifeCountry`, `HusbandCountry`, `ReasonForDelayedRegistration`, `AffiantSignedDate`, `AffiantSignedPlace`, `AffiantPrintedName`, `DateSubscribed`, `PlaceSubscribed`, `CTCNumber`, `CTCDateIssued`, `CTCPlaceIssued`, `SolemnizingOfficerNameRepeat`, `SolemnizingOfficerTitleRepeat`, `SolemnizingOfficerAddressRepeat`) VALUES
(1, NULL, NULL, NULL, 'Lolomopo mazo', 'Lolamo mazo', 0, NULL, 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, 'hehehehehe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `phbirth`
--
ALTER TABLE `phbirth`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `phmarriage`
--
ALTER TABLE `phmarriage`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phbirth`
--
ALTER TABLE `phbirth`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phmarriage`
--
ALTER TABLE `phmarriage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
