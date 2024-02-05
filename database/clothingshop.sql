-- phpMyAdmin SQL Dump

-- version 5.2.0

-- https://www.phpmyadmin.net/

--

-- Host: 127.0.0.1

-- Generation Time: Feb 05, 2024 at 01:53 PM

-- Server version: 10.4.24-MariaDB

-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Database: `clothingshop`

--

-- --------------------------------------------------------

--

-- Table structure for table `carts`

--

CREATE TABLE
    `carts` (
        `id` int(8) NOT NULL,
        `user_id` int(8) UNSIGNED NOT NULL,
        `product_id` int(8) UNSIGNED NOT NULL,
        `qty` int(3) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `carts`

--

INSERT INTO
    `carts` (
        `id`,
        `user_id`,
        `product_id`,
        `qty`
    )
VALUES (26, 8, 5, 1);

-- --------------------------------------------------------

--

-- Table structure for table `discounts`

--

CREATE TABLE
    `discounts` (
        `id` int(3) NOT NULL,
        `product_id` int(3) NOT NULL,
        `discount` float NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `discounts`

--

INSERT INTO
    `discounts` (`id`, `product_id`, `discount`)
VALUES (1, 4, 0.8), (2, 8, 0.6), (3, 9, 0.75), (4, 2, 0.5);

-- --------------------------------------------------------

--

-- Table structure for table `master_cards`

--

CREATE TABLE
    `master_cards` (
        `id` int(3) NOT NULL,
        `number_serial` varchar(50) NOT NULL,
        `name` varchar(50) NOT NULL,
        `balance` float NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `master_cards`

--

INSERT INTO
    `master_cards` (
        `id`,
        `number_serial`,
        `name`,
        `balance`
    )
VALUES (
        1,
        '255',
        'Muhammad Cavin Hartono Putra',
        2207000
    ), (
        2,
        '723',
        'Rayhan Fitroh Rhomadhoni Ernanda',
        3177000
    ), (
        3,
        '462',
        'Ruby Nesya Nisrina',
        7000000
    ), (
        4,
        '984',
        'Puspa Ramadhania',
        6000000
    ), (
        5,
        '032',
        'Mochammad Fauzan Zulkarnaen',
        250000
    );

-- --------------------------------------------------------

--

-- Table structure for table `orders`

--

CREATE TABLE
    `orders` (
        `id` int(3) NOT NULL,
        `product_id` int(3) NOT NULL,
        `user_id` int(3) NOT NULL,
        `qty` int(2) NOT NULL,
        `status` enum('pending', 'paid') NOT NULL DEFAULT 'pending',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `date` datetime NOT NULL DEFAULT current_timestamp(),
        `total` float NOT NULL,
        `address` text NOT NULL,
        `payment_type` enum('cod', 'master_card') NOT NULL DEFAULT 'cod',
        `master_card_id` int(3) DEFAULT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `orders`

--

INSERT INTO
    `orders` (
        `id`,
        `product_id`,
        `user_id`,
        `qty`,
        `status`,
        `created_at`,
        `date`,
        `total`,
        `address`,
        `payment_type`,
        `master_card_id`
    )
VALUES (
        1,
        2,
        8,
        3,
        'paid',
        '2024-01-10 00:00:00',
        '2024-01-14 21:59:16',
        540000,
        'Bandung',
        'cod',
        NULL
    ), (
        2,
        2,
        8,
        3,
        'paid',
        '2024-01-10 22:04:04',
        '2024-01-10 16:03:32',
        540000,
        'Bandung',
        'cod',
        NULL
    ), (
        12,
        11,
        8,
        1,
        'paid',
        '2024-01-26 15:43:03',
        '2024-01-29 15:43:03',
        320000,
        'Jakarta',
        'cod',
        NULL
    ), (
        15,
        9,
        8,
        1,
        'paid',
        '2024-01-28 20:40:00',
        '2024-01-31 20:40:00',
        243000,
        'Bandung',
        'cod',
        NULL
    ), (
        16,
        4,
        8,
        1,
        'paid',
        '2024-01-28 21:32:22',
        '2024-01-31 21:32:22',
        203000,
        'Bandung',
        'cod',
        NULL
    ), (
        17,
        9,
        8,
        1,
        'paid',
        '2024-01-30 14:02:27',
        '2024-02-02 14:02:27',
        243000,
        'Bandung',
        'cod',
        NULL
    ), (
        18,
        4,
        8,
        1,
        'paid',
        '2024-01-30 14:11:40',
        '2024-02-02 14:11:40',
        203000,
        'Bandung',
        'cod',
        NULL
    ), (
        22,
        5,
        8,
        1,
        'paid',
        '2024-02-01 08:45:49',
        '2024-02-04 08:45:49',
        123000,
        'Bandung',
        'master_card',
        1
    ), (
        23,
        6,
        8,
        1,
        'paid',
        '2024-02-01 09:03:35',
        '2024-02-04 09:03:35',
        323000,
        'Bandung',
        'master_card',
        2
    );

--

-- Triggers `orders`

--

DELIMITER $$

CREATE TRIGGER `ADD_3_DATE` BEFORE INSERT ON `ORDERS` 
FOR EACH ROW BEGIN 
	SET NEW.date = DATE_ADD(NEW.date, INTERVAL 3 DAY);
	END 
$ 

$ 

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `UPDATE_BALANCE` AFTER INSERT ON `ORDERS` 
FOR EACH ROW BEGIN 
	UPDATE `master_cards`
	SET
	    `balance` = `balance` - NEW.total
	WHERE `id` = NEW.master_card_id;
	END 
$ 

$ 

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `UPDATE_PRODUCTS` AFTER INSERT ON `ORDERS` 
FOR EACH ROW BEGIN 
	UPDATE `products`
	SET `stock` = `stock` - NEW.qty
	WHERE `id` = NEW.product_id;
	END 
$ 

$ 

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `UPDATE_STATUS_TO_PAID` BEFORE INSERT 
ON `ORDERS` FOR EACH ROW BEGIN 
	IF NEW.status = 'pending'
	AND NEW.date <= NOW() THEN
	SET NEW.status = 'paid';
	END IF;
	END 
$ 

$ 

DELIMITER ;

-- --------------------------------------------------------

--

-- Table structure for table `products`

--

CREATE TABLE
    `products` (
        `id` int(8) NOT NULL,
        `name` varchar(50) NOT NULL,
        `src` varchar(50) NOT NULL,
        `price` float NOT NULL,
        `stock` int(3) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `products`

--

INSERT INTO
    `products` (
        `id`,
        `name`,
        `src`,
        `price`,
        `stock`
    )
VALUES (
        2,
        'De White Jacket',
        'product_18.png',
        180000,
        17
    ), (
        4,
        'Product 3',
        'product_15.png',
        250000,
        67
    ), (
        5,
        'Product 4',
        'product_20.png',
        120000,
        89
    ), (
        6,
        'Product 5',
        'product_24.png',
        320000,
        19
    ), (
        7,
        'Product 6',
        'product_14.png',
        250000,
        49
    ), (
        8,
        'Product 7',
        'product_13.png',
        250000,
        39
    ), (
        9,
        'Product 8',
        'product_9.png',
        320000,
        36
    ), (
        10,
        'Product 9',
        'product_5.png',
        250000,
        40
    ), (
        11,
        'Product 10',
        'product_6.png',
        320000,
        59
    );

-- --------------------------------------------------------

--

-- Table structure for table `users`

--

CREATE TABLE
    `users` (
        `id` int(8) NOT NULL,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `phone_number` varchar(50) DEFAULT NULL,
        `address` text NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--

-- Dumping data for table `users`

--

INSERT INTO
    `users` (
        `id`,
        `name`,
        `email`,
        `password`,
        `phone_number`,
        `address`
    )
VALUES (
        8,
        'Cavin Hartono Putra',
        'cavin@gmail.com',
        '$2y$10$bI0RNyMA5Vdligfn./AtkeMhwf9S37PHB8tg4IgXN9GHqM1SyMSzK',
        '083174560653',
        'Bandung'
    ), (
        9,
        'Fauzan',
        'ojan@gmail.com',
        '$2y$10$aCD6tzn6IFqiuSuT1fipKODY4iA4w8knVEq1qv1a1gCQVzWm5OAbi',
        NULL,
        'Surabaya'
    );

--

-- Indexes for dumped tables

--

--

-- Indexes for table `carts`

--

ALTER TABLE `carts`
ADD PRIMARY KEY (`id`),
ADD
    KEY `user_id` (`user_id`),
ADD
    KEY `product_id` (`product_id`);

--

-- Indexes for table `discounts`

--

ALTER TABLE `discounts`
ADD PRIMARY KEY (`id`),
ADD
    KEY `product_id` (`product_id`);

--

-- Indexes for table `master_cards`

--

ALTER TABLE `master_cards` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `orders`

--

ALTER TABLE `orders`
ADD PRIMARY KEY (`id`),
ADD
    KEY `product_id` (`product_id`),
ADD KEY `user_id` (`user_id`);

--

-- Indexes for table `products`

--

ALTER TABLE `products` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `users`

--

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `carts`

--

ALTER TABLE
    `carts` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 27;

--

-- AUTO_INCREMENT for table `discounts`

--

ALTER TABLE
    `discounts` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--

-- AUTO_INCREMENT for table `master_cards`

--

ALTER TABLE
    `master_cards` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--

-- AUTO_INCREMENT for table `orders`

--

ALTER TABLE
    `orders` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 24;

--

-- AUTO_INCREMENT for table `products`

--

ALTER TABLE
    `products` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 12;

--

-- AUTO_INCREMENT for table `users`

--

ALTER TABLE
    `users` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 10;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;