-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 08:16 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaintremark`
--

CREATE TABLE `complaintremark` (
  `id` int(11) NOT NULL,
  `complaintNumber` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` mediumtext,
  `remarkDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaintremark`
--

INSERT INTO `complaintremark` (`id`, `complaintNumber`, `status`, `remark`, `remarkDate`) VALUES
(12, 2, 'in process', 'i decide for leave', '2025-03-21 16:39:57'),
(13, 6, 'closed', 'not applicable', '2025-03-22 15:17:53'),
(14, 1, 'in process', 'your complaint is in progress', '2025-03-22 15:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`, `submitted_at`) VALUES
(8, 'viranchi', 'savaliya', 'VSavaliya1510@gmail.com', '9876543212', 'I want to apply for company', '2025-03-22 09:58:00'),
(9, 'rajvi', 'patel', 'rajvi@gmail.com', '7635326726337', 'rhjerejhrherjer', '2025-04-01 02:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `empattendance`
--

CREATE TABLE `empattendance` (
  `id` int(12) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in_time` time DEFAULT '00:00:00',
  `check_out_time` time DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `empattendance`
--

INSERT INTO `empattendance` (`id`, `employee_id`, `attendance_date`, `check_in_time`, `check_out_time`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(21, 109, '2025-03-21', '08:00:21', '22:00:29', 'On Time', 'Punctual', '2025-03-21 16:30:21', '2025-03-21 16:31:20'),
(22, 103, '2025-03-21', '22:12:53', NULL, 'Late', 'Late Arrival', '2025-03-21 16:42:53', '2025-03-21 16:42:53'),
(23, 115, '2025-03-21', '22:59:33', '22:59:39', 'Checked Out', 'Checked Out', '2025-03-21 17:29:33', '2025-03-21 17:29:39'),
(24, 151, '2025-03-22', '17:56:38', '17:56:43', 'Checked Out', 'Checked Out', '2025-03-22 12:26:38', '2025-03-22 12:26:43'),
(25, 117, '2025-03-22', '17:58:03', '17:58:09', 'Late', 'Arrived late to work', '2025-03-22 12:28:03', '2025-03-22 12:45:28'),
(27, 134, '2025-03-22', '23:01:38', '23:01:49', 'Checked Out', 'Checked Out', '2025-03-22 17:31:38', '2025-03-22 17:31:49'),
(29, 123, '2025-03-31', '23:55:40', NULL, 'Late', 'Late Arrival', '2025-03-31 18:25:40', '2025-03-31 18:25:40'),
(30, 101, '2025-04-01', '01:16:40', '01:17:43', 'Checked Out', 'Checked Out', '2025-03-31 19:46:40', '2025-03-31 19:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `stateName` varchar(255) DEFAULT NULL,
  `stateDescription` tinytext,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `stateName`, `stateDescription`, `postingDate`, `updationDate`) VALUES
(3, 'Uttar Pradesh', 'Uttar Pradesh-UP', '2023-09-28 11:26:56', '2023-10-01 05:00:30'),
(4, 'Punjab', 'Punjab-PB', '2023-09-28 11:26:56', '2023-10-01 05:00:33'),
(5, 'Haryana', 'Haryana-HR', '2023-09-28 11:26:56', '2023-10-01 05:00:36'),
(6, 'Delhi', 'Delhi-DL', '2023-09-28 11:26:56', '2023-10-01 05:00:40'),
(7, 'Bangalore', 'Bangalore', '2025-03-21 12:43:39', NULL),
(8, 'Pune', 'pune', '2025-03-21 12:43:39', NULL),
(9, 'Delhi', 'Delhi', '2025-03-21 12:44:15', NULL),
(10, 'Haydrabad', 'Haydrabad', '2025-03-21 12:44:15', NULL);

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
  `AdminRegdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555558, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-03-05 04:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblbankdetails`
--

CREATE TABLE `tblbankdetails` (
  `BankID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `BankName` varchar(255) NOT NULL,
  `AccountNumber` varchar(50) NOT NULL,
  `IFSC` varchar(20) NOT NULL,
  `Branch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbankdetails`
--

INSERT INTO `tblbankdetails` (`BankID`, `EmpID`, `BankName`, `AccountNumber`, `IFSC`, `Branch`) VALUES
(3, 134, 'ICICI', '9876543213432', 'ABCD9812345', 'MG Road'),
(4, 109, 'BOB', '38436363642628', 'PQRS9876543', 'Mota varachha'),
(5, 103, 'Bank of india', '87273684246464', 'SUVW6543432', 'Katargam'),
(6, 115, 'TJSB', '763654336343', 'QRST1232344', 'Katargam'),
(7, 151, 'TJSB', '722872323273', 'ABCD9875342', 'Vesu'),
(8, 117, 'HDFC', '7343478343743', 'PQRS5465543', 'Mumbai'),
(9, 123, 'kotak', '213232324343434343', 'LUCA1238765', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomplaints`
--

CREATE TABLE `tblcomplaints` (
  `complaintNumber` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `complaintType` varchar(255) DEFAULT NULL,
  `issuetype` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `noc` varchar(255) DEFAULT NULL,
  `complaintDetails` mediumtext,
  `complaintFile` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT NULL,
  `lastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcomplaints`
--

INSERT INTO `tblcomplaints` (`complaintNumber`, `employeeId`, `department`, `complaintType`, `issuetype`, `state`, `noc`, `complaintDetails`, `complaintFile`, `regDate`, `status`, `lastUpdationDate`) VALUES
(1, 134, 3, 'Technical Issues', 'Software Issues', 'Bangalore', 'Software crash during use', 'Software crash during use', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-21 12:48:31', 'in process', '2025-03-22 15:23:09'),
(2, 109, 2, 'Payroll & Salary', 'Salary Discrepancy', 'Pune', 'Related to salary', 'Related to salary', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-21 16:38:39', 'in process', '2025-03-21 16:39:57'),
(3, 103, 5, 'Security Issues', 'Security Concern', 'Delhi', 'In testing issue', 'In testing issue', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-21 17:12:57', NULL, NULL),
(4, 115, 13, 'Technical Issues', 'Network Problems', 'Haydrabad', 'Technical', 'Network problems', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-21 17:37:44', NULL, NULL),
(5, 151, 15, 'Technical Issues', 'Network Problems', 'Bangalore', 'cyber security', 'complaint related to the network', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-22 12:24:53', NULL, NULL),
(6, 117, 14, 'Facility Management', 'Air Conditioning Issue', 'Delhi', 'UI/UX designer', 'UI/UX designer', '90cf12d88b992da34b82ae278a6a6ab8.png', '2025-03-22 12:31:11', 'closed', '2025-03-22 15:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `ID` int(5) NOT NULL,
  `DepartmentName` varchar(250) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`ID`, `DepartmentName`, `CreationDate`) VALUES
(2, 'Logistics', '2024-03-10 06:59:06'),
(3, 'Technical', '2024-03-10 06:59:06'),
(4, 'Accounts', '2024-03-10 06:59:06'),
(5, 'Testing', '2024-03-10 06:59:06'),
(13, 'IT Department', '2025-01-11 01:54:40'),
(14, 'UI/UX Designer', '2025-03-21 10:39:54'),
(15, 'CyberSecurity', '2025-03-21 10:40:34'),
(16, 'HR', '2025-03-22 11:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `ID` int(5) NOT NULL,
  `DepartmentID` int(5) DEFAULT NULL,
  `EmpId` int(11) DEFAULT NULL,
  `EmpName` varchar(200) DEFAULT NULL,
  `EmpEmail` varchar(200) DEFAULT NULL,
  `Gender` varchar(10) NOT NULL,
  `EmpContactNumber` bigint(10) DEFAULT NULL,
  `Designation` varchar(200) DEFAULT NULL,
  `EmpDateofbirth` date DEFAULT NULL,
  `EmpAddress` varchar(250) DEFAULT NULL,
  `EmpDateofjoining` date DEFAULT NULL,
  `Description` mediumtext,
  `Password` varchar(200) DEFAULT NULL,
  `ProfilePic` varchar(250) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `qrcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`ID`, `DepartmentID`, `EmpId`, `EmpName`, `EmpEmail`, `Gender`, `EmpContactNumber`, `Designation`, `EmpDateofbirth`, `EmpAddress`, `EmpDateofjoining`, `Description`, `Password`, `ProfilePic`, `CreationDate`, `UpdationDate`, `qrcode`) VALUES
(25, 3, 134, 'viranchi', 'viranchi@gmail.com', 'Female', 9876543212, 'Software Engineer', '2005-02-16', 'Bangalore', '2024-03-01', 'Responsible for maintaining and optimizing backend services and APIs', '7bb951dd2dd348c6f696bfadddb671e1', 'viranchi.jpeg', '2025-03-21 10:45:20', '2025-03-21 11:13:58', 'qjxe2LQkrt'),
(26, 2, 109, 'Hasti', 'hasti@gmail.com', 'Female', 8934376374, 'Logistics Assistant', '2004-01-13', 'Pune', '2025-03-01', 'Senior developer leading the software development team.', 'a0b5d584b9cadd343eae0c741e3d7aad', 'Hasti.jpeg', '2025-03-21 11:04:42', '2025-03-21 11:14:10', 'RmGTvQ2JoZ'),
(27, 5, 103, 'Princy', 'princy@gmail.com', 'Female', 2635323523, 'Performance Test Engineer', '2005-03-26', 'Mumbai', '2024-12-27', 'Intern assigned to assist with QA testing and bug tracking', '9150ec3c9d42b3b4cb2373a9207a992e', 'princy.jpeg', '2025-03-21 11:08:00', '2025-03-21 11:15:33', 'n5fxtGanAo'),
(28, 13, 115, 'Denisha', 'Denisha@gmail.com', 'Female', 8877654543, 'Full stack devloper', '2004-07-07', 'Haydrabad', '2025-03-01', 'Joins as a fresher with a focus on full stack development training', 'bc0271db97de519c651ba9a11af6716f', 'denisha.jpeg', '2025-03-21 11:09:25', '2025-03-21 11:15:09', 'KclQr7jZkY'),
(29, 15, 151, 'Charmi', 'charmi@gmail.com', 'Female', 8364635463, 'Network Security Engineer', '2005-11-23', 'Kolkata', '2023-02-01', 'Handles database design, optimization, and maintenance tasks.', '6d1675606e57e20d460b04db67ebcbb0', 'charmi.jpeg', '2025-03-21 11:13:19', '2025-03-21 11:15:52', 'EPEoEXzCC2'),
(30, 4, 117, 'Rajvi', 'rajvi@gmail.com', 'Female', 9872346453, 'Accounts Manager', '2004-06-09', 'Delhi', '2023-07-01', 'Team lead responsible for sprint planning and code review.', 'd4c7b8f18b6d52c4f4a8d6a4c6e49205', 'rajvi.jpeg', '2025-03-21 11:18:28', NULL, 'AnxCVC7PCh'),
(31, 13, 123, 'Luca Bennett', 'Lucabennett@gmail.com', 'Male', 7823462663, 'HR Manager', '2003-06-10', 'Chennai', '2022-06-21', 'HR manager that handel all the data', '426d8166a1cf619f353c16a24972c10c', '97e81538d96d4e7fd2b70b265cef82731743445081.jpg', '2025-03-21 11:27:51', '2025-03-31 18:21:32', 'ztKWPcVPj4'),
(32, 14, 987, 'Leo Anders', 'Leoanders@gmail.com', 'Male', 9835472635, 'Senior UI/UX Designer', '2004-05-03', 'Kochi', '2025-03-01', 'UI/UX designer', '174d043765650e05017e6059c6c0d99c', 'male2.jpg', '2025-03-21 11:30:48', NULL, 'XKAwXtrzym'),
(34, 3, 101, 'vihan', 'vihan@gmail.com', 'Male', 9876543453, 'Full stack devloper', '2000-01-11', 'USA', '2025-02-04', 'efefefef', '2c2ed629fb8a55eb10a787af708b32d5', 'male3.jpg', '2025-03-31 19:44:02', NULL, 'dd3ZdV6moR');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `LeaveType` varchar(110) DEFAULT NULL,
  `ToDate` varchar(120) DEFAULT NULL,
  `FromDate` varchar(120) DEFAULT NULL,
  `Description` mediumtext,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` mediumtext,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `IsRead` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `empid`, `LeaveType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`) VALUES
(45, 134, 'Casual Leaves', '2025-03-31', '2025-03-28', 'Casual leave for personal reasons.', '2025-03-21 12:41:20', 'Approve leave', '2025-03-21 21:00:40 ', 1, 1),
(46, 109, 'Earned Leaves', '2025-03-27', '2025-03-22', ' Paid leave earned by the employee for each month of service, used for planned time off.\r\n\r\n', '2025-03-21 16:35:37', 'eedede', '2025-04-01 8:22:14 ', 2, 1),
(47, 103, ' Half-Day Leave', '2025-03-23', '2025-03-22', 'I want to half day leave', '2025-03-21 17:11:39', NULL, NULL, 0, 0),
(48, 115, 'Sick Leaves', '2025-03-31', '2025-03-22', 'sick leaves', '2025-03-21 17:32:06', 'Approve leave', '2025-03-21 23:03:45 ', 1, 1),
(49, 115, 'Earned Leaves', '2025-04-02', '2025-03-31', 'earned leave', '2025-03-21 17:35:42', 'approved', '2025-04-01 11:26:07 ', 1, 1),
(50, 151, 'Examination Leave', '2025-03-26', '2025-03-23', 'I want to leave for the exam', '2025-03-22 12:23:08', 'not approved leave', '2025-03-22 18:02:04 ', 2, 1),
(51, 117, 'Earned Leaves', '2025-03-31', '2025-03-23', 'earned leaves', '2025-03-22 12:30:21', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(1, 'Casual Leaves', 'Casual Leaves', '2024-09-01 09:22:22'),
(2, 'Earned Leaves', 'Earned Leaves', '2024-09-01 09:22:22'),
(3, 'Sick Leaves', 'Sick Leaves', '2024-09-01 09:22:22'),
(4, 'RH (Restricted Leaves)', 'Restricted Leaves', '2024-09-01 09:22:22'),
(17, 'Compensatory Leave (Comp-Off)', 'Given when an employee works on weekends or holidays.', '2025-03-13 05:36:32'),
(18, ' Half-Day Leave', 'mployee takes leave for half a day (morning or evening).', '2025-03-13 05:39:52'),
(21, 'Examination Leave', 'For pursuing higher studies or exams.', '2025-03-22 12:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext,
  `PageDescription` mediumtext,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL,
  `Timing` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `Timing`) VALUES
(1, 'aboutus', 'About Us', 'Employee Task Management System\r\nWelcome to about Us page', NULL, NULL, NULL, ''),
(2, 'contactus', 'Contact Us', '890,Sector 62, Gyan Sarovar, GAIL Noida(Delhi/NCR)', 'taskinfo@gmail.com', 7896541239, NULL, '10:30 am to 7:30 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblsalary`
--

CREATE TABLE `tblsalary` (
  `SalaryID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `BasicSalary` decimal(10,2) NOT NULL DEFAULT '0.00',
  `OvertimeHours` int(11) DEFAULT '0',
  `OvertimePay` decimal(10,2) DEFAULT '0.00',
  `Bonus` decimal(10,2) DEFAULT '0.00',
  `Deductions` decimal(10,2) DEFAULT '0.00',
  `NetSalary` decimal(10,2) AS (`BasicSalary` + `OvertimePay` + `Bonus` - `Deductions`) VIRTUAL,
  `PaymentStatus` enum('Pending','Paid') DEFAULT 'Pending',
  `PaymentDate` timestamp NULL DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsalary`
--

INSERT INTO `tblsalary` (`SalaryID`, `EmpID`, `BasicSalary`, `OvertimeHours`, `OvertimePay`, `Bonus`, `Deductions`, `PaymentStatus`, `PaymentDate`, `CreatedAt`, `UpdatedAt`) VALUES
(22, 134, '90000.00', 2, '1000.00', '2000.00', '1000.00', 'Paid', '2025-03-20 18:30:00', '2025-03-21 12:49:02', '2025-03-21 12:59:36'),
(23, 109, '80000.00', 2, '2000.00', '200.00', '1000.00', 'Pending', '0000-00-00 00:00:00', '2025-03-21 12:58:27', '2025-03-21 12:58:27'),
(24, 115, '75000.00', 3, '900.00', '4000.00', '200.00', 'Paid', '2025-03-20 18:30:00', '2025-03-21 12:59:10', '2025-03-21 17:38:57'),
(25, 103, '89000.00', 3, '900.00', '1000.00', '300.00', 'Pending', NULL, '2025-03-21 17:19:01', '2025-03-22 16:19:23'),
(26, 151, '95000.00', 3, '2000.00', '3000.00', '100.00', 'Pending', '0000-00-00 00:00:00', '2025-03-22 16:00:34', '2025-03-22 16:00:34'),
(27, 134, '20000.00', 2, '1200.00', '900.00', '200.00', 'Pending', '0000-00-00 00:00:00', '2025-03-30 15:40:09', '2025-03-30 15:40:09'),
(28, 134, '20000.00', 2, '1200.00', '900.00', '200.00', 'Pending', '0000-00-00 00:00:00', '2025-03-30 15:40:28', '2025-03-30 15:40:28'),
(30, 987, '20000.00', 200, '3.00', '98.00', '222.00', 'Pending', '0000-00-00 00:00:00', '2025-03-30 15:48:32', '2025-03-30 15:48:32'),
(31, 117, '2000.00', 20, '200.00', '10000.00', '100.00', 'Pending', '0000-00-00 00:00:00', '2025-03-30 15:49:17', '2025-03-30 15:49:17'),
(32, 123, '89000.00', 2, '3000.00', '300.00', '400.00', 'Pending', '0000-00-00 00:00:00', '2025-03-31 18:36:33', '2025-03-31 18:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbltask`
--

CREATE TABLE `tbltask` (
  `ID` int(5) NOT NULL,
  `DeptID` int(5) DEFAULT NULL,
  `AssignTaskto` int(5) DEFAULT NULL,
  `TaskPriority` varchar(100) DEFAULT NULL,
  `TaskTitle` varchar(250) DEFAULT NULL,
  `TaskDescription` mediumtext,
  `TaskEnddate` date DEFAULT NULL,
  `TaskAssigndate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `taskFile` varchar(255) DEFAULT NULL,
  `Status` varchar(200) DEFAULT NULL,
  `WorkCompleted` varchar(250) DEFAULT NULL,
  `Remark` varchar(250) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltask`
--

INSERT INTO `tbltask` (`ID`, `DeptID`, `AssignTaskto`, `TaskPriority`, `TaskTitle`, `TaskDescription`, `TaskEnddate`, `TaskAssigndate`, `taskFile`, `Status`, `WorkCompleted`, `Remark`, `UpdationDate`) VALUES
(29, 3, 25, 'Medium', 'Handling technical support tickets or issues.', 'Handling technical support tickets or issues.', '2025-03-25', '2025-03-21 12:16:16', NULL, 'Inprogress', '40', 'My task is in the progress i will try to complete fast.', NULL),
(30, 2, 26, 'Urgent', 'Perform code reviews', 'Perform code reviews', '2025-03-28', '2025-03-21 12:17:06', NULL, 'Inprogress', '60', 'In progress my task i will try to fast to complete', NULL),
(31, 5, 27, 'Most Urgent', 'Perform data backups and recovery', 'Perform data backups and recovery', '2025-03-22', '2025-03-21 12:18:00', NULL, 'Completed', '100', 'comelete the task', NULL),
(32, 13, 28, 'Normal', 'Fix bugs or issues reported by QA or users', 'Fix bugs or issues reported by QA or users', '2025-03-31', '2025-03-21 12:18:47', NULL, 'Completed', '100', 'complete task', NULL),
(33, 15, 29, 'Medium', 'Perform testing on user dashboard', 'Perform testing on user dashboard', '2025-03-28', '2025-03-21 12:20:05', NULL, NULL, NULL, NULL, NULL),
(34, 4, 30, 'Most Urgent', 'Check DataSheets', 'Check DataSheets', '2025-03-22', '2025-03-21 12:20:59', NULL, NULL, NULL, NULL, NULL),
(36, 3, 25, 'Medium', 'Integrate APIs (e.g., payment gateway, Google Maps)', 'Integrate APIs (e.g., payment gateway, Google Maps)', '2025-03-22', '2025-03-21 12:55:55', NULL, 'Completed', '100', 'cpmpleted', NULL),
(37, 3, 25, 'Normal', 'Solve the Bug', 'solve Bug ', '2025-03-25', '2025-03-22 11:17:33', NULL, 'Completed', '100', 'completed', NULL),
(38, 4, 30, 'Urgent', 'Production planning', 'sasamsa,sas,asas', '2025-04-18', '2025-04-09 15:44:15', NULL, NULL, NULL, NULL, NULL),
(39, 3, 25, 'Urgent', 'Production planning', 'sssqsqsqs', '2025-04-22', '2025-04-09 15:47:03', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbltasktracking`
--

CREATE TABLE `tbltasktracking` (
  `ID` int(10) NOT NULL,
  `TaskID` int(10) DEFAULT NULL,
  `Remark` varchar(250) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `WorkCompleted` varchar(200) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltasktracking`
--

INSERT INTO `tbltasktracking` (`ID`, `TaskID`, `Remark`, `Status`, `WorkCompleted`, `UpdationDate`) VALUES
(1, 1, 'inteview started', 'Inprogress', '50', '2024-09-19 15:40:04'),
(2, 1, 'Android develop Hired', 'Completed', '100', '2024-09-20 01:41:07'),
(3, 2, 'Work Started', 'Inprogress', '10', '2024-09-20 01:48:16'),
(4, 2, 'Task COmpleted', 'Completed', '100', '2024-09-20 01:48:38'),
(5, 3, 'aaaaaa', 'Completed', '60', '2025-01-04 06:42:13'),
(6, 8, 'wss', 'Completed', '11', '2025-03-11 08:43:17'),
(7, 9, 'gh', 'Inprogress', '4', '2025-03-11 08:46:58'),
(8, 9, 't', 'Completed', '60', '2025-03-11 08:47:17'),
(9, 23, 'sssssssssssss', 'Inprogress', '1', '2025-03-11 09:04:04'),
(10, 25, 'dww', 'Inprogress', '60', '2025-03-12 18:40:36'),
(11, 29, 'My task is in the progress i will try to complete fast.', 'Inprogress', '40', '2025-03-21 12:22:06'),
(12, 35, 'I completed my task', 'Completed', '100', '2025-03-21 12:54:51'),
(13, 36, 'half task done', 'Inprogress', '80', '2025-03-21 12:56:23'),
(14, 36, 'cpmpleted', 'Completed', '100', '2025-03-21 12:56:45'),
(15, 30, 'In progress my task i will try to fast to complete', 'Inprogress', '60', '2025-03-21 16:32:49'),
(16, 32, 'complete task', 'Completed', '100', '2025-03-22 11:24:13'),
(17, 31, 'comelete the task', 'Completed', '100', '2025-03-22 11:25:16'),
(18, 37, 'inprogress', 'Inprogress', '60', '2025-03-22 17:51:26'),
(19, 37, 'completed', 'Completed', '100', '2025-04-01 05:59:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblteam`
--

CREATE TABLE `tblteam` (
  `TeamId` int(11) NOT NULL,
  `TaskId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `LeaderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblteam`
--

INSERT INTO `tblteam` (`TeamId`, `TaskId`, `StartDate`, `EndDate`, `LeaderId`) VALUES
(5, 29, '2025-03-22', '2025-03-31', 134),
(6, 33, '2025-03-25', '2025-03-31', 123),
(8, 29, '2025-04-02', '2025-04-04', 101);

-- --------------------------------------------------------

--
-- Table structure for table `tblteammembers`
--

CREATE TABLE `tblteammembers` (
  `Id` int(11) NOT NULL,
  `TeamId` int(11) NOT NULL,
  `MemberId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblteammembers`
--

INSERT INTO `tblteammembers` (`Id`, `TeamId`, `MemberId`) VALUES
(10, 5, 134),
(11, 5, 109),
(12, 5, 103),
(13, 6, 115),
(14, 6, 151),
(15, 6, 117),
(27, 8, 134),
(28, 8, 115),
(29, 8, 123);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `tbl_faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`tbl_faq_id`, `question`, `answer`) VALUES
(15, 'What is the Employee Management System (EMS)??', 'The Employee Management System is a digital platform used to manage employee data, tasks, attendance, leaves, performance, and more, all in one place.\r\nedfeede\r\n'),
(18, 'How do I log in to the system?', 'Use your registered email or username and password to log in. If you\'re an admin, use the admin login panel.'),
(19, ' How can I update my personal details?', 'Go to your profile section after logging in and click on \"Edit Profile\" to update your contact information, address, etc.'),
(20, 'How can I apply for leave?', 'Navigate to the \"Leave Request\" section, select your leave type, dates, and reason, then click \"Submit.\" You’ll be notified once it\'s approved.\r\n\r\n'),
(21, 'How can I see my assigned tasks?', 'Click on the \"Tasks\" or \"My Tasks\" tab from the dashboard to view tasks assigned to you along with deadlines and priority.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaintremark`
--
ALTER TABLE `complaintremark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empattendance`
--
ALTER TABLE `empattendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblbankdetails`
--
ALTER TABLE `tblbankdetails`
  ADD PRIMARY KEY (`BankID`),
  ADD KEY `EmpID` (`EmpID`);

--
-- Indexes for table `tblcomplaints`
--
ALTER TABLE `tblcomplaints`
  ADD PRIMARY KEY (`complaintNumber`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EmpId` (`EmpId`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsalary`
--
ALTER TABLE `tblsalary`
  ADD PRIMARY KEY (`SalaryID`),
  ADD KEY `EmpID` (`EmpID`);

--
-- Indexes for table `tbltask`
--
ALTER TABLE `tbltask`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbltasktracking`
--
ALTER TABLE `tbltasktracking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblteam`
--
ALTER TABLE `tblteam`
  ADD PRIMARY KEY (`TeamId`),
  ADD KEY `TaskId` (`TaskId`),
  ADD KEY `LeaderId` (`LeaderId`);

--
-- Indexes for table `tblteammembers`
--
ALTER TABLE `tblteammembers`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `TeamId` (`TeamId`),
  ADD KEY `MemberId` (`MemberId`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`tbl_faq_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaintremark`
--
ALTER TABLE `complaintremark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `empattendance`
--
ALTER TABLE `empattendance`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbankdetails`
--
ALTER TABLE `tblbankdetails`
  MODIFY `BankID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcomplaints`
--
ALTER TABLE `tblcomplaints`
  MODIFY `complaintNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblsalary`
--
ALTER TABLE `tblsalary`
  MODIFY `SalaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbltask`
--
ALTER TABLE `tbltask`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbltasktracking`
--
ALTER TABLE `tbltasktracking`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblteam`
--
ALTER TABLE `tblteam`
  MODIFY `TeamId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblteammembers`
--
ALTER TABLE `tblteammembers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `tbl_faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `empattendance`
--
ALTER TABLE `empattendance`
  ADD CONSTRAINT `empattendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `tblemployee` (`EmpId`);

--
-- Constraints for table `tblbankdetails`
--
ALTER TABLE `tblbankdetails`
  ADD CONSTRAINT `tblbankdetails_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `tblemployee` (`EmpId`);

--
-- Constraints for table `tblcomplaints`
--
ALTER TABLE `tblcomplaints`
  ADD CONSTRAINT `tblcomplaints_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `tblemployee` (`EmpId`);

--
-- Constraints for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD CONSTRAINT `tblemployee_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `tbldepartment` (`ID`);

--
-- Constraints for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD CONSTRAINT `tblleaves_ibfk_1` FOREIGN KEY (`empid`) REFERENCES `tblemployee` (`EmpId`);

--
-- Constraints for table `tblsalary`
--
ALTER TABLE `tblsalary`
  ADD CONSTRAINT `tblsalary_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `tblemployee` (`EmpId`);

--
-- Constraints for table `tblteam`
--
ALTER TABLE `tblteam`
  ADD CONSTRAINT `tblteam_ibfk_1` FOREIGN KEY (`TaskId`) REFERENCES `tbltask` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblteam_ibfk_2` FOREIGN KEY (`LeaderId`) REFERENCES `tblemployee` (`EmpId`) ON DELETE CASCADE;

--
-- Constraints for table `tblteammembers`
--
ALTER TABLE `tblteammembers`
  ADD CONSTRAINT `tblteammembers_ibfk_1` FOREIGN KEY (`TeamId`) REFERENCES `tblteam` (`TeamId`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblteammembers_ibfk_2` FOREIGN KEY (`MemberId`) REFERENCES `tblemployee` (`EmpId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
