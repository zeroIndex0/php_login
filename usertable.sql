-- a table inside the 'social' database
-- 'social' is just a   CREATE DATABASE social;
-- then                 USE DATABASE social;
-- then copy paste this into the database;

CREATE TABLE users(
id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
first_name VARCHAR(25),
last_name VARCHAR(25),
username VARCHAR(100),
email VARCHAR(100),
password VARCHAR(255),
);