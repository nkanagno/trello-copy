-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Server: 127.0.0.1
-- Creation time: 25 May 2024 at 17:45:10
-- Server version: 10.4.32-MariaDB
-- PHP version: 8.0.30
USE di_internet_technologies_project;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `form_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasklists`
--
USE di_internet_technologies_project;

DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS tasklists;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    simplepushio_key VARCHAR(255) UNIQUE
);


INSERT INTO users (name, surname, username, password, email, simplepushio_key) VALUES
('John', 'Doe', 'johndoe1', 'password1', 'johndoe1@example.com', 'axdfsd'),
('Nikolas', 'Anagnostopoulos', 'Nkanagno', 'password2', 'janesmith1@example.com', '62uAUL');


CREATE TABLE tasklists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO tasklists (title, user_id) VALUES
('Project-1', 1),
('Project-2', 1),
('Project-3', 2),
('Project-4', 2);


CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    date_time DATETIME,
    status VARCHAR(50) DEFAULT 'Pending',
    assigned_to INT,
    tasklist_id INT,
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (tasklist_id) REFERENCES tasklists(id)
);

INSERT INTO tasks (title, date_time, status, assigned_to, tasklist_id) VALUES
('Task 1', '2024-05-01 09:00:00', 'Pending', 1, 3),
('Task 2', '2024-05-01 10:00:00', 'In progress', 1, 3),
('Task 3', '2024-05-01 11:00:00', 'completed', 2, 2),
('Task 4', '2024-05-02 09:00:00', 'Pending', 1, 3);

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;