CREATE DATABASE camagru;
USE camagru;

CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `active` boolean DEFAULT 0,
  `activation_hash` varchar(255) NOT NULL
);

CREATE TABLE `posts` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
);

CREATE TABLE `likes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `owner` int(11) NOT NULL
);

CREATE TABLE `comments` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `content` varchar(255) NOT NULL
);
