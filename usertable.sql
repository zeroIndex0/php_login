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
signup_date DATE,
profile_pic VARCHAR(255),
num_posts INT,
num_likes INT,
user_closed VARCHAR(3),
friend_array TEXT
);