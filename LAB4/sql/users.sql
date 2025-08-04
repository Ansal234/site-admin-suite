--AUTHOR: ANSAL MUHAMMED
--ASSIGNMENT 4 : LAB 4
--STUDENT ID: 100881383
--INFT2100


-- CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- DROP SEQUENCE IF EXISTS users_id;
-- CREATE SEQUENCE users_id START 1000;

-- DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users_table
(
    Id SERIAL PRIMARY KEY, 
    EmailAddress VARCHAR(225) UNIQUE,
    Password VARCHAR(225) NOT NULL,
    FirstName VARCHAR(128),
    LastName VARCHAR(128),
    LastAccess TIMESTAMP,
    EnrollDate TIMESTAMP,
    Phone VARCHAR(225),
    UserType VARCHAR(2)
);
-- INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
--     'thomas.turner@durhamcollege.ca', crypt('random_password', gen_salt('bf')), 
--     'Tom', 'Turner', NULL, '2023-09-29', '416-555-5555', 'a'); 
-- INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
--     'jdoe@dcmail.ca', crypt('some_password', gen_salt('bf')), 
--     'John', 'Doe', NULL, '2023-09-29', '416-666-6666', 'a'); 
-- INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
--     'msmith@dcmail.ca', crypt('other_password', gen_salt('bf')), 
--     'Mike', 'Smith', NULL, '2023-09-29', '416-777-7777', 'a'); 

INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
    'thomas.turner@durhamcollege.ca', '$2a$06$cDYdULg8Moogdii9nfdHUOtDP4yE0pmsw7HiDkUigBkGIFfCE3z8a', 
    'Tom', 'Turner', NULL, '2023-09-29', '416-555-5555', 'a'); 
INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
    'jdoe@dcmail.ca', '$2a$06$MXhQi72vSnSzyvn.yft.buDKWfBdmWcU/MDj3sHX2otgp05kaJmxe' 
    'John', 'Doe', NULL, '2023-09-29', '416-666-6666', 'a'); 
INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
    'msmith@dcmail.ca', '$2a$06$N.s4AMBpxHNL4XT9UCMkgu1jZGW/.0BIJTtvO0ykmKeOmyDjIGwbS', 
    'Mike', 'Smith', NULL, '2023-09-29', '416-777-7777', 'a'); 


SELECT * FROM users_table;