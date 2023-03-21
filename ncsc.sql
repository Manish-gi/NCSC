-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2022 at 07:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ncsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowance`
--

CREATE TABLE `allowance` (
  `allow_id` int(11) NOT NULL,
  `aloow_name` text NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allowance`
--

INSERT INTO `allowance` (`allow_id`, `aloow_name`, `description`) VALUES
(5, 'WA', 'Washing Allowance'),
(6, 'CA', ' C Allowance'),
(7, 'SP', 'Special Allowance'),
(8, 'TA', 'Travel Allowance'),
(9, 'Sal_Diff', 'Salary Difference'),
(11, 'Remuneration', 'Remunerations');

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `dedu_id` int(20) NOT NULL,
  `dedu_name` text NOT NULL,
  `dedu_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`dedu_id`, `dedu_name`, `dedu_desc`) VALUES
(3, 'I_Tax', 'Income tax'),
(4, 'Co_Op_Soc', 'C-Operative Society Housing'),
(5, 'Fest_Adv', 'Festival Advance'),
(6, 'Food_Gr', 'Food Group'),
(7, 'PPF', 'Public Provisional Fund'),
(9, 'Sal_Arr', 'Salary Arrears');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(4, 'BCA'),
(5, 'BBA'),
(6, 'B.com');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_un` varchar(255) DEFAULT NULL,
  `emp_pw` varchar(255) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `emp_type` tinyint(4) DEFAULT NULL COMMENT '1Parmanent,2Visiting,3Contractual,4Teaching_asst',
  `tech_non_tech` varchar(255) DEFAULT NULL COMMENT '1Teaching,2Non-Teaching ',
  `pos_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `d_o_j` date DEFAULT NULL COMMENT 'Date Of Joining',
  `d_o_r` date DEFAULT NULL COMMENT 'Date Of Resign',
  `pay_min` bigint(20) DEFAULT NULL,
  `pay_max` bigint(20) DEFAULT NULL,
  `fix_pay` bigint(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `grade_pay` bigint(20) DEFAULT NULL,
  `gender` text DEFAULT NULL COMMENT '1Male,2Female,3Other',
  `m_s` varchar(255) DEFAULT NULL COMMENT 'Marital_status',
  `d_o_b` date DEFAULT NULL COMMENT 'Date Of Birth',
  `access` tinyint(255) DEFAULT NULL COMMENT '1-Admin,2-Clerk,3-employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_un`, `emp_pw`, `dept_id`, `emp_type`, `tech_non_tech`, `pos_id`, `first_name`, `last_name`, `email`, `mobile`, `d_o_j`, `d_o_r`, `pay_min`, `pay_max`, `fix_pay`, `address`, `grade_pay`, `gender`, `m_s`, `d_o_b`, `access`) VALUES
(27, 'Raminik23', 'Raminik23', 4, 1, 'teaching', 1, 'Ramniklal', 'Giltar', 'ramnika@gmail.com', 78963541235, '2022-04-11', '2022-04-11', 15600, 39100, 19810, 'bharuch', 6000, 'Male', 'Married', '2015-01-13', 1),
(28, 'Rathod23', 'Rathod23', 4, 1, 'non_teaching', 2, 'rathod', 'bharat', 'bharat@gmail.com', 12365478945, '2022-04-11', '0000-00-00', 4440, 7440, 8920, 'bharuch', 1400, 'Male', 'Married', '2015-06-18', 1),
(35, 'jatin23', 'jatin23', 4, 3, 'teaching', 6, 'jatin', 'modh', 'jatin@gmail.com', 12365478945, '2022-04-11', '2023-11-30', 0, 0, 66000, 'bharuch', 0, 'Male', 'Married', '2007-06-16', 1),
(36, 'chetan23', 'chetan23', 4, 4, 'teaching', 8, 'chetan', 'parmar', 'chetan23@gmail.com', 4563217895, '2016-06-22', '2026-06-17', 0, 0, 25000, 'Ankleshwar', 0, 'Male', 'Married', '2014-02-12', 1),
(37, 'Anuja23', 'Anuja23', 4, 4, 'teaching', 6, 'Anuja', 'Dani', 'Anuja23@gmail.com', 4521369874, '2021-12-14', '2024-04-25', 0, 0, 20000, 'Ankleshwar', 0, 'Male', 'Married', '1992-06-18', 1),
(38, 'Nisha23', 'Nisha23', 4, 2, 'teaching', 1, 'Nisha', 'Desai', 'Nisha23@gmail.com', 7896541235, '2019-02-20', '2027-05-11', 0, 0, 300, 'Ankleshwar', 0, 'Female', 'Married', '1994-12-13', 1),
(39, 'Nisha23', 'Nisha23', 4, 2, 'teaching', 1, 'Nisha', 'Modi', 'Nisha23@gmail.com', 4521367896, '2017-10-27', '2026-10-20', 0, 0, 300, 'bharuch', 0, 'Female', 'Married', '1989-03-17', 1),
(40, 'Shreya23', 'Shreya23', 4, 2, 'teaching', 1, 'Shreya', 'jain', 'Shreya23@gmail.com', 9563217885, '2019-09-25', '2024-10-24', 0, 0, 300, 'bharuch', 0, 'Female', 'Married', '1990-06-14', 1),
(41, 'Anuja23', 'Anuja23', 4, 1, 'non_teaching', 7, 'Anuja', 'Dani', 'Anuja23@gmail.com', 7896542456, '2014-02-03', '2025-06-28', 15000, 45000, 27130, 'bharuch', 8000, 'Female', 'Married', '1986-09-24', 1),
(42, 'new', 'new', 4, 3, 'teaching', 1, 'manish', 'manish', 'ishan@gmail.com', 3265415897, '2018-06-13', '2022-07-31', 15000, 45000, 25000, 'Ankleshwar', 9000, 'Male', 'Married', '1987-06-10', 1),
(45, 'nair', 'nair', 5, 1, 'teaching', 1, 'Nair', 'Smita', 'nair@gmail.com', 4521369874, '1999-12-13', '0000-00-00', 15600, 39100, 33240, 'Surat', 8000, 'Female', 'Single', '1968-07-24', 3),
(46, 'Vyas', 'Vyas', 5, 1, 'teaching', 1, 'Vyas', 'Rachana', 'Vyas@gmail.com', 4521369874, '1999-12-14', '0000-00-00', 15600, 39100, 33240, 'bharuch', 8000, 'Male', 'Married', '1979-12-12', 3),
(47, 'Saha', 'Saha', 5, 1, 'non_teaching', 7, 'Saha', 'Sapan', 'Saha@gmail.com', 5642389452, '2006-09-15', '0000-00-00', 15600, 39100, 27129, 'Ankleshwar', 8000, 'Male', 'Married', '1988-06-17', 1),
(48, 'Dave', 'Dave', 5, 1, 'non_teaching', 3, 'Himesh', 'Dave', 'dave@gmail.com', 4569871235, '0000-00-00', '0000-00-00', 9300, 34800, 10560, 'bharuch', 4200, 'Male', 'Single', '1977-07-21', 2),
(49, 'Rajeshari', 'Rajeshari', 5, 2, 'teaching', 1, 'Kori', 'Rajeshari', 'rajeshari@gmail.com', 12365478945, '0000-00-00', '0000-00-00', 0, 0, 300, 'Ankleshwar', 0, 'Male', 'Married', '0000-00-00', 1),
(50, 'Jisnesh', 'Jisnesh', 6, 1, 'teaching', 1, 'Jisnesh', 'Trivesh', 'jisnesh@gmail.com', 4521369874, '2017-08-01', '0000-00-00', 15600, 39100, 17610, 'Surat', 6000, 'Male', 'Married', '1988-06-25', 3),
(51, 'Shah', 'Shah', 6, 1, 'non_teaching', 9, 'Shah', 'Vijay', 'shah@gmail.com', 1236547894, '1999-02-06', '0000-00-00', 9300, 34800, 14720, 'bharuch', 4200, 'Male', 'Married', '1984-05-25', 3),
(52, 'Farid', 'Farid', 6, 4, 'teaching', 3, 'Farid', 'Dhanani', 'farid@gmail.com', 4569871235, '2021-08-01', '2022-04-30', 0, 0, 25000, 'Ankleshwar', 0, 'Male', 'Single', '1996-06-26', 3);

-- --------------------------------------------------------

--
-- Table structure for table `emp_acc`
--

CREATE TABLE `emp_acc` (
  `acc_tb_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `acc_no` bigint(20) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `acc_ifsc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_allow`
--

CREATE TABLE `emp_allow` (
  `emp_allow_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `allow_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `type` tinyint(4) NOT NULL,
  `effective_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_allow`
--

INSERT INTO `emp_allow` (`emp_allow_id`, `emp_id`, `allow_id`, `amount`, `type`, `effective_date`) VALUES
(9, 27, 8, 400, 1, '0000-00-00'),
(10, 28, 5, 60, 1, '0000-00-00'),
(12, 45, 8, 400, 1, '0000-00-00'),
(13, 46, 8, 400, 1, '0000-00-00'),
(14, 47, 8, 400, 1, '0000-00-00'),
(15, 48, 6, 50, 1, '0000-00-00'),
(16, 50, 8, 400, 1, '0000-00-00'),
(17, 51, 6, 50, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `emp_dedu`
--

CREATE TABLE `emp_dedu` (
  `emp_dedu_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `dedu_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `type` tinyint(4) NOT NULL,
  `effective_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_dedu`
--

INSERT INTO `emp_dedu` (`emp_dedu_id`, `emp_id`, `dedu_id`, `amount`, `type`, `effective_date`) VALUES
(12, 27, 3, 6500, 1, '0000-00-00'),
(13, 27, 4, 500, 1, '0000-00-00'),
(15, 46, 3, 6000, 1, '0000-00-00'),
(16, 45, 4, 500, 1, '0000-00-00'),
(17, 45, 3, 6500, 1, '0000-00-00'),
(19, 47, 3, 2700, 1, '0000-00-00'),
(23, 50, 3, 1000, 1, '0000-00-00'),
(26, 51, 4, 10650, 2, '2022-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `emp_nominee`
--

CREATE TABLE `emp_nominee` (
  `nominee_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `nominee` text NOT NULL,
  `relation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `entity`
--

CREATE TABLE `entity` (
  `ent_id` int(11) NOT NULL,
  `ent_name` varchar(255) NOT NULL,
  `ent_desc` varchar(255) NOT NULL,
  `ent_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `entity`
--

INSERT INTO `entity` (`ent_id`, `ent_name`, `ent_desc`, `ent_value`) VALUES
(1, 'DA', 'dafjhg', 71),
(2, 'HRA', 'hra', 10),
(3, 'MA', 'ma', 300),
(4, 'EPF', 'employee provisional tax', 12),
(5, 'P.Tax', '<=5999=Nil.\r\n6000-8777=80.\r\n9000-11999=150.\r\n>=12000.\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_stat`
--

CREATE TABLE `log_stat` (
  `emp_log_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `upd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `pos_id` int(11) NOT NULL,
  `pos_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pos_id`, `pos_name`) VALUES
(1, 'Asst Professor'),
(2, 'Peon'),
(3, 'Accountant'),
(6, 'computer head'),
(7, 'Librarian'),
(8, 'Computer Appl'),
(9, 'Clerk');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ename` varchar(512) NOT NULL,
  `tech_non_tech` varchar(255) DEFAULT NULL COMMENT '1Teaching,2Non-Teaching ',
  `pos_name` text NOT NULL,
  `d_o_j` date DEFAULT NULL COMMENT 'Date Of Joining',
  `emp_type` tinyint(4) DEFAULT NULL COMMENT '1Parmanent,2Visiting,3Contractual,4Teaching_asst',
  `dept_name` varchar(255) NOT NULL,
  `pay_scale` varchar(65) DEFAULT NULL,
  `emp_salary_id` int(11) DEFAULT 0,
  `emp_id` int(11),
  `date` date,
  `attend` int(11) DEFAULT 0,
  `fix_pay` bigint(20) DEFAULT 0,
  `grade_pay` int(11) DEFAULT 0,
  `da` bigint(20) DEFAULT 0,
  `hra` bigint(20) DEFAULT 0,
  `ma` bigint(20) DEFAULT 0 COMMENT 'Medical Allowance',
  `epf` bigint(20) DEFAULT 0,
  `ptax` bigint(20) DEFAULT 0 COMMENT 'Professional Tax',
  `WA` bigint(20) DEFAULT 0,
  `CA` bigint(20) DEFAULT 0,
  `SP` bigint(20) DEFAULT 0,
  `TA` bigint(20) DEFAULT 0,
  `Sal_Diff` bigint(20) DEFAULT 0,
  `Remuneration` bigint(20) DEFAULT 0,
  `I_Tax` bigint(20) DEFAULT 0,
  `Co_Op_Soc` bigint(20) DEFAULT 0,
  `Fest_Adv` bigint(20) DEFAULT 0,
  `Food_Gr` bigint(20) DEFAULT 0,
  `PPF` bigint(20) DEFAULT 0,
  `Sal_Arr` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ename`, `tech_non_tech`, `pos_name`, `d_o_j`, `emp_type`, `dept_name`, `pay_scale`, `emp_salary_id`, `emp_id`, `date`, `attend`, `fix_pay`, `grade_pay`, `da`, `hra`, `ma`, `epf`, `ptax`, `WA`, `CA`, `SP`, `TA`, `Sal_Diff`, `Remuneration`, `I_Tax`, `Co_Op_Soc`, `Fest_Adv`, `Food_Gr`, `PPF`, `Sal_Arr`) VALUES
('bharat, rathod', 'non_teaching', 'Peon', '2022-04-11', 1, 'BCA', '4440-7440 GP=1400', 59, 28, '2022-02-28', 28, 8920, 1400, 7327, 1032, 300, 2118, 200, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('bharat, rathod', 'non_teaching', 'Peon', '2022-04-11', 1, 'BCA', '4440-7440 GP=1400', 66, 28, '2022-03-31', 30, 8632, 1355, 7091, 999, 290, 2049, 200, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary_main`
--

CREATE TABLE `salary_main` (
  `emp_salary_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attend` int(11) NOT NULL DEFAULT 0,
  `fix_pay` bigint(20) NOT NULL DEFAULT 0,
  `grade_pay` int(11) NOT NULL DEFAULT 0,
  `da` bigint(20) NOT NULL DEFAULT 0,
  `hra` bigint(20) NOT NULL DEFAULT 0,
  `ma` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Medical Allowance',
  `epf` bigint(20) NOT NULL DEFAULT 0,
  `ptax` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Professional Tax',
  `WA` bigint(20) NOT NULL DEFAULT 0,
  `CA` bigint(20) NOT NULL DEFAULT 0,
  `SP` bigint(20) NOT NULL DEFAULT 0,
  `TA` bigint(20) NOT NULL DEFAULT 0,
  `Sal_Diff` bigint(20) NOT NULL DEFAULT 0,
  `Remuneration` bigint(20) NOT NULL DEFAULT 0,
  `I_Tax` bigint(20) NOT NULL DEFAULT 0,
  `Co_Op_Soc` bigint(20) NOT NULL DEFAULT 0,
  `Fest_Adv` bigint(20) NOT NULL DEFAULT 0,
  `Food_Gr` bigint(20) NOT NULL DEFAULT 0,
  `PPF` bigint(20) NOT NULL DEFAULT 0,
  `Sal_Arr` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary_main`
--

INSERT INTO `salary_main` (`emp_salary_id`, `emp_id`, `date`, `attend`, `fix_pay`, `grade_pay`, `da`, `hra`, `ma`, `epf`, `ptax`, `WA`, `CA`, `SP`, `TA`, `Sal_Diff`, `Remuneration`, `I_Tax`, `Co_Op_Soc`, `Fest_Adv`, `Food_Gr`, `PPF`, `Sal_Arr`) VALUES
(51, 28, '2022-01-31', 31, 8920, 1400, 7327, 1032, 300, 2118, 200, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(52, 27, '2022-01-31', 31, 19810, 6000, 18325, 2581, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1500, 0, 0, 0, 0, 0),
(53, 35, '2022-01-31', 31, 66000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, 36, '2022-01-31', 31, 25000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(55, 41, '2022-01-31', 31, 27130, 8000, 24942, 3513, 300, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(57, 37, '2022-01-31', 24, 15484, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(58, 27, '2022-02-28', 28, 19810, 6000, 18325, 2581, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1500, 0, 0, 0, 0, 0),
(59, 28, '2022-02-28', 28, 8920, 1400, 7327, 1032, 300, 2118, 200, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(60, 35, '2022-02-28', 28, 66000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(61, 36, '2022-02-28', 28, 25000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(62, 37, '2022-02-28', 28, 20000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(63, 40, '2022-02-28', 24, 7200, 0, 0, 0, 0, 0, 80, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(64, 41, '2022-02-28', 28, 27130, 8000, 24942, 3513, 300, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(65, 27, '2022-03-31', 31, 19810, 6000, 18325, 2581, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1500, 0, 0, 0, 0, 0),
(66, 28, '2022-03-31', 30, 8632, 1355, 7091, 999, 290, 2049, 200, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(67, 35, '2022-03-31', 31, 66000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, 35, '2022-03-31', 31, 66000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 41, '2022-03-31', 28, 24505, 7226, 22529, 3173, 271, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(70, 40, '2022-03-31', 31, 9300, 0, 0, 0, 0, 0, 150, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(71, 39, '2022-01-31', 31, 9300, 0, 0, 0, 0, 0, 150, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(72, 46, '2022-01-31', 31, 33240, 8000, 29280, 4124, 300, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(73, 47, '2022-01-31', 31, 27129, 8000, 24942, 3513, 300, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(74, 48, '2022-01-31', 31, 10560, 4200, 10480, 1476, 300, 3029, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(75, 49, '2022-01-31', 39, 11700, 0, 0, 0, 0, 0, 150, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(76, 46, '2022-03-01', 28, 30023, 7226, 26447, 3725, 271, 0, 200, 0, 0, 0, 400, 0, 0, 6000, 7525, 0, 0, 0, 0),
(77, 46, '2022-03-31', 31, 33240, 8000, 29280, 4124, 300, 0, 200, 0, 0, 0, 400, 0, 0, 6000, 0, 0, 0, 0, 0),
(78, 45, '2022-02-28', 28, 33240, 8000, 29280, 4124, 300, 0, 200, 0, 0, 0, 400, 0, 0, 2000, 500, 0, 0, 0, 0),
(79, 45, '2022-03-31', 31, 33240, 8000, 29280, 4124, 300, 0, 200, 0, 0, 0, 400, 0, 0, 6500, 500, 0, 0, 0, 0),
(80, 47, '2022-02-28', 28, 27129, 8000, 24942, 3513, 300, 0, 200, 0, 0, 0, 400, 0, 0, 2700, 17750, 0, 0, 0, 0),
(81, 48, '2022-02-28', 28, 10560, 4200, 10480, 1476, 300, 3029, 200, 0, 50, 0, 0, 0, 0, 0, 3310, 0, 0, 0, 0),
(82, 48, '2022-03-31', 31, 10560, 4200, 10480, 1476, 300, 3029, 200, 0, 50, 0, 0, 0, 0, 0, 3293, 0, 0, 0, 0),
(83, 47, '2022-03-31', 31, 27129, 8000, 24942, 3513, 300, 0, 200, 0, 0, 0, 400, 0, 0, 2700, 17638, 0, 0, 0, 0),
(84, 50, '2022-01-31', 31, 17610, 6000, 16763, 2361, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1000, 0, 0, 0, 0, 0),
(85, 51, '2022-01-31', 31, 14720, 4200, 13433, 1892, 300, 3882, 200, 0, 50, 0, 0, 0, 0, 0, 11550, 0, 0, 0, 0),
(86, 52, '2022-01-31', 31, 25000, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(87, 50, '2022-02-28', 28, 17610, 6000, 16763, 2361, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1000, 0, 0, 0, 0, 0),
(88, 50, '2022-03-31', 31, 17610, 6000, 16763, 2361, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1000, 0, 0, 0, 0, 0),
(89, 51, '2022-02-28', 28, 14720, 4200, 13433, 1892, 300, 3882, 200, 0, 50, 0, 0, 0, 0, 0, 10725, 0, 0, 0, 0),
(90, 50, '2022-03-31', 31, 17610, 6000, 16763, 2361, 300, 0, 200, 0, 0, 0, 400, 0, 0, 1000, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`allow_id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`dedu_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `emp_to_dept` (`dept_id`),
  ADD KEY `emp_to_pos` (`pos_id`);

--
-- Indexes for table `emp_acc`
--
ALTER TABLE `emp_acc`
  ADD PRIMARY KEY (`acc_tb_id`),
  ADD KEY `emp_allow` (`emp_id`);

--
-- Indexes for table `emp_allow`
--
ALTER TABLE `emp_allow`
  ADD PRIMARY KEY (`emp_allow_id`),
  ADD KEY `emp_dedu_deducation_key` (`allow_id`),
  ADD KEY `emp_allow_key` (`emp_id`);

--
-- Indexes for table `emp_dedu`
--
ALTER TABLE `emp_dedu`
  ADD PRIMARY KEY (`emp_dedu_id`),
  ADD KEY `emp_allow_allowance_key` (`dedu_id`),
  ADD KEY `emp_dedu_key` (`emp_id`);

--
-- Indexes for table `emp_nominee`
--
ALTER TABLE `emp_nominee`
  ADD PRIMARY KEY (`nominee_id`),
  ADD KEY `emp_nominee_key` (`emp_id`);

--
-- Indexes for table `entity`
--
ALTER TABLE `entity`
  ADD PRIMARY KEY (`ent_id`);

--
-- Indexes for table `log_stat`
--
ALTER TABLE `log_stat`
  ADD PRIMARY KEY (`emp_log_id`),
  ADD KEY `emp_log_key` (`emp_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `salary_main`
--
ALTER TABLE `salary_main`
  ADD PRIMARY KEY (`emp_salary_id`),
  ADD KEY `emp_salary_key` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowance`
--
ALTER TABLE `allowance`
  MODIFY `allow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `dedu_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `emp_acc`
--
ALTER TABLE `emp_acc`
  MODIFY `acc_tb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emp_allow`
--
ALTER TABLE `emp_allow`
  MODIFY `emp_allow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `emp_dedu`
--
ALTER TABLE `emp_dedu`
  MODIFY `emp_dedu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `emp_nominee`
--
ALTER TABLE `emp_nominee`
  MODIFY `nominee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `entity`
--
ALTER TABLE `entity`
  MODIFY `ent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log_stat`
--
ALTER TABLE `log_stat`
  MODIFY `emp_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salary_main`
--
ALTER TABLE `salary_main`
  MODIFY `emp_salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `emp_to_dept` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_to_pos` FOREIGN KEY (`pos_id`) REFERENCES `position` (`pos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_acc`
--
ALTER TABLE `emp_acc`
  ADD CONSTRAINT `emp_allow` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_allow`
--
ALTER TABLE `emp_allow`
  ADD CONSTRAINT `emp_allow_key` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_dedu_deducation_key` FOREIGN KEY (`allow_id`) REFERENCES `allowance` (`allow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_dedu`
--
ALTER TABLE `emp_dedu`
  ADD CONSTRAINT `emp_allow_allowance_key` FOREIGN KEY (`dedu_id`) REFERENCES `deduction` (`dedu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_dedu_key` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_nominee`
--
ALTER TABLE `emp_nominee`
  ADD CONSTRAINT `emp_nominee_key` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log_stat`
--
ALTER TABLE `log_stat`
  ADD CONSTRAINT `emp_log_key` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salary_main`
--
ALTER TABLE `salary_main`
  ADD CONSTRAINT `emp_salary_key` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
